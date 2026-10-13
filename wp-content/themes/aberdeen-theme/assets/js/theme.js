/**
 * Aberdeen Theme JavaScript
 * Handles Navigation, Interactive Hero Slider (No Page Reload),
 * Lead Form Popup (Figma), and Click Event Tracking (Task 8)
 */
document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	// ==========================================
	// 1. Mobile Menu Toggle
	// ==========================================
	const menuToggle = document.getElementById('mobile-menu-toggle');
	const nav = document.getElementById('main-navigation');

	if (menuToggle && nav) {
		menuToggle.addEventListener('click', function () {
			nav.classList.toggle('nav-open');
			menuToggle.classList.toggle('active');
		});
	}

	// ==========================================
	// 2. Interactive Hero Slider (No Page Reload)
	// ==========================================
	const slides = document.querySelectorAll('.hero-slide');
	const dots = document.querySelectorAll('.hero-dot');
	const prevBtn = document.getElementById('hero-prev');
	const nextBtn = document.getElementById('hero-next');
	let currentSlide = 0;
	let sliderInterval = null;

	function goToSlide(index) {
		if (slides.length === 0) return;

		// Normalize index
		if (index < 0) {
			currentSlide = slides.length - 1;
		} else if (index >= slides.length) {
			currentSlide = 0;
		} else {
			currentSlide = index;
		}

		// Update slides classes
		slides.forEach(function (slide, i) {
			if (i === currentSlide) {
				slide.classList.add('active');
			} else {
				slide.classList.remove('active');
			}
		});

		// Update dots classes
		dots.forEach(function (dot, i) {
			if (i === currentSlide) {
				dot.classList.add('active');
			} else {
				dot.classList.remove('active');
			}
		});
	}

	function startAutoPlay() {
		stopAutoPlay();
		sliderInterval = setInterval(function () {
			goToSlide(currentSlide + 1);
		}, 6000);
	}

	function stopAutoPlay() {
		if (sliderInterval) {
			clearInterval(sliderInterval);
			sliderInterval = null;
		}
	}

	if (slides.length > 0) {
		// Arrow navigation
		if (prevBtn) {
			prevBtn.addEventListener('click', function (e) {
				e.preventDefault();
				goToSlide(currentSlide - 1);
				startAutoPlay();
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', function (e) {
				e.preventDefault();
				goToSlide(currentSlide + 1);
				startAutoPlay();
			});
		}

		// Dots navigation
		dots.forEach(function (dot) {
			dot.addEventListener('click', function (e) {
				e.preventDefault();
				const targetIndex = parseInt(dot.getAttribute('data-index'), 10);
				goToSlide(targetIndex);
				startAutoPlay();
			});
		});

		// Pause on hover
		const sliderContainer = document.getElementById('hero-slider-section');
		if (sliderContainer) {
			sliderContainer.addEventListener('mouseenter', stopAutoPlay);
			sliderContainer.addEventListener('mouseleave', startAutoPlay);
		}

		// Start autoplay
		startAutoPlay();
	}

	// ==========================================
	// 3. Modal (Lead Form & Thank You Screen)
	// ==========================================
	const modals = document.querySelectorAll('.aberdeen-modal');

	function openModal(modalId) {
		const modal = document.getElementById(modalId);
		if (modal) {
			modal.removeAttribute('hidden');
			document.body.style.overflow = 'hidden';
		}
	}

	function closeModal(modal) {
		if (modal) {
			modal.setAttribute('hidden', '');
			document.body.style.overflow = '';
		}
	}

	// Open modal buttons
	document.addEventListener('click', function (e) {
		const openBtn = e.target.closest('.btn-open-modal');
		if (openBtn) {
			e.preventDefault();
			const modalId = openBtn.getAttribute('data-modal') || 'lead-form-modal';
			openModal(modalId);
		}

		// Close modal trigger
		if (e.target.matches('[data-close-modal]') || e.target.closest('[data-close-modal]')) {
			const activeModal = e.target.closest('.aberdeen-modal');
			closeModal(activeModal);
		}
	});

	// Close on Escape key
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			modals.forEach(closeModal);
		}
	});

	// ==========================================
	// 4. Lead Form AJAX Handler
	// ==========================================
	const leadForm = document.getElementById('aberdeen-lead-form');
	const formContainer = document.getElementById('lead-form-container');
	const thankYouScreen = document.getElementById('lead-thank-you-screen');
	const thankYouMsg = document.getElementById('thank-you-message');

	if (leadForm && typeof window.aberdeenData !== 'undefined') {
		leadForm.addEventListener('submit', function (e) {
			e.preventDefault();

			const submitBtn = leadForm.querySelector('button[type="submit"]');
			const btnText = submitBtn.querySelector('.btn-text');
			const btnLoader = submitBtn.querySelector('.btn-loader');

			if (btnText) btnText.style.display = 'none';
			if (btnLoader) btnLoader.style.display = 'inline';
			submitBtn.disabled = true;

			const formData = new FormData(leadForm);
			formData.append('action', 'aberdeen_submit_lead');
			formData.append('security', window.aberdeenData.leadNonce);

			fetch(window.aberdeenData.ajaxUrl, {
				method: 'POST',
				body: formData,
			})
				.then(function (res) { return res.json(); })
				.then(function (data) {
					if (data.success) {
						if (formContainer) formContainer.style.display = 'none';
						if (thankYouScreen) thankYouScreen.style.display = 'block';
						if (thankYouMsg && data.data && data.data.message) {
							thankYouMsg.textContent = data.data.message;
						}
						leadForm.reset();
					} else {
						alert(data.data && data.data.message ? data.data.message : 'Submission failed. Please try again.');
					}
				})
				.catch(function () {
					alert('An unexpected error occurred. Please try again.');
				})
				.finally(function () {
					if (btnText) btnText.style.display = 'inline';
					if (btnLoader) btnLoader.style.display = 'none';
					submitBtn.disabled = false;
				});
		});
	}

	// ==========================================
	// 5. Click Tracking Data Layer (Task 8)
	// Uses Event Delegation + navigator.sendBeacon / fetch(keepalive)
	// ==========================================
	document.addEventListener('click', function (e) {
		const trackElement = e.target.closest('[data-track]');
		if (!trackElement) {
			return;
		}

		const rawData = trackElement.getAttribute('data-track');
		if (!rawData) {
			return;
		}

		let payload;
		try {
			payload = JSON.parse(rawData);
		} catch (err) {
			// Ignore invalid JSON safely without breaking navigation
			return;
		}

		if (!payload || typeof payload !== 'object') {
			return;
		}

		// Attach context: page URL
		const trackingBody = JSON.stringify({
			page_url: window.location.pathname + window.location.search,
			payload: payload,
		});

		const restEndpoint = (window.aberdeenData && window.aberdeenData.restUrl)
			? window.aberdeenData.restUrl
			: '/wp-json/programs/v1/track';

		// Transmit via navigator.sendBeacon if available, fallback to fetch with keepalive: true
		if (navigator.sendBeacon) {
			const blob = new Blob([trackingBody], { type: 'application/json' });
			navigator.sendBeacon(restEndpoint, blob);
		} else if (window.fetch) {
			fetch(restEndpoint, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: trackingBody,
				keepalive: true,
			}).catch(function () {
				// Suppress network errors silently
			});
		}
	});
});
