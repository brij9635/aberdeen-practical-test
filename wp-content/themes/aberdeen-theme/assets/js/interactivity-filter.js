/**
 * Aberdeen Programmes Filter - WordPress Interactivity API Module (Task 7)
 * Implements client-side reactive filtering for /programmes (All / Undergraduate / Postgraduate)
 * without full page reloads, updates browser history (pushState), manages loading and empty states,
 * and fetches program cards via REST API.
 */
import { store, getElement } from '@wordpress/interactivity';

const { state } = store( 'programsFilter', {
	state: {
		filter: 'all',
		isLoading: false,
		isEmpty: false,
		get isAllActive() {
			return state.filter === 'all';
		},
		get isUndergraduateActive() {
			return state.filter === 'undergraduate';
		},
		get isPostgraduateActive() {
			return state.filter === 'postgraduate';
		},
	},
	actions: {
		*filterProgrammes( event ) {
			event.preventDefault();

			const { ref } = getElement();
			const targetFilter = ref.getAttribute( 'data-filter' ) || 'all';
			const targetHref = ref.getAttribute( 'href' );

			if ( state.filter === targetFilter && ! state.isLoading ) {
				return;
			}

			state.filter = targetFilter;
			state.isLoading = true;
			state.isEmpty = false;

			// Synchronize browser history / URL without page reload
			if ( targetHref && window.history && window.history.pushState ) {
				window.history.pushState( { filter: targetFilter }, '', targetHref );
			}

			// Bonus: Fetch fresh cards markup via REST API
			const restEndpoint = `/wp-json/programs/v1/filter?type=${targetFilter}`;

			try {
				const response = yield fetch( restEndpoint );
				if ( response.ok ) {
					const data = yield response.json();
					const container = document.getElementById( 'programs-groups-wrapper' );
					const emptyState = document.getElementById( 'programs-empty-state' );

					if ( container ) {
						container.innerHTML = data.html || '';
						container.style.display = data.count > 0 ? 'block' : 'none';
					}

					if ( emptyState ) {
						emptyState.style.display = data.count === 0 ? 'block' : 'none';
					}

					state.isEmpty = ( data.count === 0 );
				}
			} catch ( err ) {
				console.error( 'Interactivity API: Failed to filter programmes', err );
			} finally {
				state.isLoading = false;
			}
		},
	},
	callbacks: {
		init() {
			// Initialize filter from current URL
			const pathname = window.location.pathname.toLowerCase();
			if ( pathname.includes( '/undergraduate' ) ) {
				state.filter = 'undergraduate';
			} else if ( pathname.includes( '/postgraduate' ) ) {
				state.filter = 'postgraduate';
			} else {
				state.filter = 'all';
			}

			// Handle browser back and forward navigation
			window.addEventListener( 'popstate', function () {
				const currentPath = window.location.pathname.toLowerCase();
				let popFilter = 'all';
				if ( currentPath.includes( '/undergraduate' ) ) {
					popFilter = 'undergraduate';
				} else if ( currentPath.includes( '/postgraduate' ) ) {
					popFilter = 'postgraduate';
				}

				const targetTab = document.querySelector( `.filter-link[data-filter="${popFilter}"]` );
				if ( targetTab ) {
					targetTab.click();
				}
			} );
		},
	},
} );
