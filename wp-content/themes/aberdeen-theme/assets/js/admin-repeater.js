/**
 * Aberdeen Programmes - React Admin Metabox
 * Built with @wordpress/element (React)
 * Handles Academic Details & Content Sections Repeater
 */

(function () {
	'use strict';

	// Check if WordPress element is available
	if (!window.wp || !window.wp.element) {
		console.warn('Aberdeen Programmes: wp.element is not available.');
		return;
	}

	const { createElement: el, useState, useEffect } = window.wp.element;
	const initialData = window.aberdeenMetaboxData || {};

	// Helper to create Dashicon element
	const Icon = ({ name }) => el('span', { className: `dashicons dashicons-${name}`, style: { fontSize: '18px', width: '18px', height: '18px', lineHeight: '18px' } });

	// Main React Component
	function AberdeenProgramMetabox() {
		// State for Academic Details
		const [academicYear, setAcademicYear] = useState(initialData.academicYear || '');
		const [duration, setDuration] = useState(initialData.duration || '');

		// State for Repeater Sections
		const parsedSections = Array.isArray(initialData.contentSections)
			? initialData.contentSections.map((item, idx) => ({
					id: item.id || `section_${Date.now()}_${idx}`,
					title: item.title || '',
					description: item.description || '',
					image_id: item.image_id || '',
					image_url: item.image_url || '',
					isExpanded: false,
			  }))
			: [];

		const [sections, setSections] = useState(parsedSections);

		// Synchronize state with hidden form inputs for standard WP save
		useEffect(() => {
			const yearInput = document.getElementById('aberdeen_academic_year_field');
			if (yearInput) yearInput.value = academicYear;

			const durationInput = document.getElementById('aberdeen_duration_field');
			if (durationInput) durationInput.value = duration;

			const sectionsInput = document.getElementById('aberdeen_content_sections_json_field');
			if (sectionsInput) {
				const sanitizedData = sections.map(({ id, title, description, image_id, image_url }) => ({
					id,
					title,
					description,
					image_id,
					image_url,
				}));
				sectionsInput.value = JSON.stringify(sanitizedData);
			}
		}, [academicYear, duration, sections]);

		// Add new section
		const handleAddSection = () => {
			const newSection = {
				id: `sec_${Date.now()}_${Math.random().toString(36).substr(2, 5)}`,
				title: '',
				description: '',
				image_id: '',
				image_url: '',
				isExpanded: true,
			};
			setSections([...sections, newSection]);
		};

		// Remove section
		const handleRemoveSection = (index, e) => {
			e.stopPropagation();
			if (window.confirm('Are you sure you want to remove this section?')) {
				const updated = sections.filter((_, i) => i !== index);
				setSections(updated);
			}
		};

		// Move section up
		const handleMoveUp = (index, e) => {
			e.stopPropagation();
			if (index === 0) return;
			const updated = [...sections];
			const temp = updated[index - 1];
			updated[index - 1] = updated[index];
			updated[index] = temp;
			setSections(updated);
		};

		// Move section down
		const handleMoveDown = (index, e) => {
			e.stopPropagation();
			if (index === sections.length - 1) return;
			const updated = [...sections];
			const temp = updated[index + 1];
			updated[index + 1] = updated[index];
			updated[index] = temp;
			setSections(updated);
		};

		// Toggle section expand/collapse
		const handleToggleExpand = (index) => {
			const updated = sections.map((sec, i) => {
				if (i === index) {
					return { ...sec, isExpanded: !sec.isExpanded };
				}
				return sec;
			});
			setSections(updated);
		};

		// Update section field value
		const handleUpdateSection = (index, field, value) => {
			const updated = [...sections];
			updated[index] = { ...updated[index], [field]: value };
			setSections(updated);
		};

		// Open WordPress Media Library Modal
		const handleSelectMedia = (index, e) => {
			e.preventDefault();
			e.stopPropagation();

			if (!window.wp || !window.wp.media) {
				alert('WordPress Media Library is not available.');
				return;
			}

			const frame = window.wp.media({
				title: 'Select or Upload Section Image',
				button: { text: 'Use this image' },
				multiple: false,
				library: { type: 'image' },
			});

			frame.on('select', () => {
				const attachment = frame.state().get('selection').first().toJSON();
				const imageUrl = attachment.sizes && attachment.sizes.medium
					? attachment.sizes.medium.url
					: attachment.url;

				const updated = [...sections];
				updated[index] = {
					...updated[index],
					image_id: attachment.id,
					image_url: imageUrl,
				};
				setSections(updated);
			});

			frame.open();
		};

		// Remove section image
		const handleRemoveMedia = (index, e) => {
			e.preventDefault();
			e.stopPropagation();
			const updated = [...sections];
			updated[index] = {
				...updated[index],
				image_id: '',
				image_url: '',
			};
			setSections(updated);
		};

		return el(
			'div',
			{ className: 'aberdeen-admin-metabox' },

			// CARD 1: Academic Key Details
			el(
				'div',
				{ className: 'aberdeen-admin-card' },
				el(
					'div',
					{ className: 'aberdeen-card-header' },
					el(
						'h3',
						{ className: 'aberdeen-card-title' },
						el(Icon, { name: 'welcome-learn-more' }),
						' Programme Key Specifications'
					)
				),
				el('p', { className: 'aberdeen-card-desc' }, 'Define the academic duration and intake session year displayed on cards and single program pages.'),
				el(
					'div',
					{ className: 'aberdeen-form-grid' },
					// Academic Year Field
					el(
						'div',
						{ className: 'aberdeen-form-group' },
						el('label', { className: 'aberdeen-label', htmlFor: 'ab-academic-year' }, 'Academic Year'),
						el('input', {
							id: 'ab-academic-year',
							type: 'text',
							className: 'aberdeen-input',
							placeholder: 'e.g. 2025-26',
							value: academicYear,
							onChange: (e) => setAcademicYear(e.target.value),
						}),
						el('span', { className: 'aberdeen-help' }, 'Format: YYYY-YY (e.g. 2025-26)')
					),
					// Duration Field
					el(
						'div',
						{ className: 'aberdeen-form-group' },
						el('label', { className: 'aberdeen-label', htmlFor: 'ab-duration' }, 'Duration'),
						el('input', {
							id: 'ab-duration',
							type: 'text',
							className: 'aberdeen-input',
							placeholder: 'e.g. 3 Years or 2 Years Full Time',
							value: duration,
							onChange: (e) => setDuration(e.target.value),
						}),
						el('span', { className: 'aberdeen-help' }, 'Study period (e.g. 3 Years, 4 Years, 18 Months)')
					)
				)
			),

			// CARD 2: Content Sections Repeater
			el(
				'div',
				{ className: 'aberdeen-admin-card' },
				el(
					'div',
					{ className: 'aberdeen-card-header' },
					el(
						'h3',
						{ className: 'aberdeen-card-title' },
						el(Icon, { name: 'list-view' }),
						' Programme Content Sections (Repeater)'
					),
					el(
						'button',
						{
							type: 'button',
							className: 'btn-aberdeen-add',
							onClick: handleAddSection,
						},
						el(Icon, { name: 'plus-alt2' }),
						' Add Section'
					)
				),
				el('p', { className: 'aberdeen-card-desc' }, 'Add rich structured content sections (Overview, Curriculum, Careers, Facilities). You can reorder, expand/collapse, and attach media.'),

				// Repeater Items List or Empty state
				sections.length === 0
					? el(
							'div',
							{ className: 'empty-repeater-notice' },
							el(Icon, { name: 'info' }),
							el('p', { style: { margin: '8px 0 0' } }, 'No content sections added yet. Click "+ Add Section" above to add your first section.')
					  )
					: el(
							'div',
							{ className: 'aberdeen-repeater-list' },
							sections.map((section, index) =>
								el(
									'div',
									{
										key: section.id,
										className: `aberdeen-repeater-item ${section.isExpanded ? 'is-expanded' : ''}`,
									},
									// Accordion Header
									el(
										'div',
										{
											className: 'aberdeen-repeater-header',
											onClick: () => handleToggleExpand(index),
										},
										el(
											'div',
											{ className: 'repeater-header-left' },
											el('span', { className: 'repeater-badge' }, `#${index + 1}`),
											el(
												'span',
												{ className: 'repeater-item-title-preview' },
												section.title ? section.title : el('em', { style: { color: '#94a3b8' } }, 'Untitled Section')
											)
										),
										el(
											'div',
											{ className: 'repeater-header-controls' },
											// Move Up
											el(
												'button',
												{
													type: 'button',
													className: 'btn-icon',
													title: 'Move Up',
													disabled: index === 0,
													onClick: (e) => handleMoveUp(index, e),
												},
												el(Icon, { name: 'arrow-up-alt2' })
											),
											// Move Down
											el(
												'button',
												{
													type: 'button',
													className: 'btn-icon',
													title: 'Move Down',
													disabled: index === sections.length - 1,
													onClick: (e) => handleMoveDown(index, e),
												},
												el(Icon, { name: 'arrow-down-alt2' })
											),
											// Expand/Collapse Toggle
											el(
												'button',
												{
													type: 'button',
													className: 'btn-icon',
													title: section.isExpanded ? 'Collapse' : 'Expand',
													onClick: (e) => {
														e.stopPropagation();
														handleToggleExpand(index);
													},
												},
												el(Icon, { name: section.isExpanded ? 'arrow-up' : 'arrow-down' })
											),
											// Delete
											el(
												'button',
												{
													type: 'button',
													className: 'btn-icon btn-delete',
													title: 'Delete Section',
													onClick: (e) => handleRemoveSection(index, e),
												},
												el(Icon, { name: 'trash' })
											)
										)
									),

									// Accordion Body
									section.isExpanded &&
										el(
											'div',
											{ className: 'aberdeen-repeater-body' },
											// Title
											el(
												'div',
												{ className: 'aberdeen-form-group' },
												el('label', { className: 'aberdeen-label' }, 'Section Title'),
												el('input', {
													type: 'text',
													className: 'aberdeen-input',
													placeholder: 'e.g. Programme Overview, Course Highlights, Career Paths',
													value: section.title,
													onChange: (e) => handleUpdateSection(index, 'title', e.target.value),
												})
											),
											// Description
											el(
												'div',
												{ className: 'aberdeen-form-group' },
												el('label', { className: 'aberdeen-label' }, 'Section Content / Description'),
												el('textarea', {
													className: 'aberdeen-textarea',
													placeholder: 'Write descriptive content for this section...',
													value: section.description,
													onChange: (e) => handleUpdateSection(index, 'description', e.target.value),
												})
											),
											// Image Uploader
											el(
												'div',
												{ className: 'aberdeen-form-group' },
												el('label', { className: 'aberdeen-label' }, 'Section Image (Optional)'),
												el(
													'div',
													{ className: 'aberdeen-media-box' },
													el(
														'div',
														{ className: 'media-preview-wrap' },
														section.image_url
															? el('img', {
																	src: section.image_url,
																	alt: 'Preview',
																	className: 'media-preview-img',
															  })
															: el(Icon, { name: 'format-image' })
													),
													el(
														'div',
														{ className: 'media-controls' },
														el(
															'button',
															{
																type: 'button',
																className: 'btn-aberdeen-media',
																onClick: (e) => handleSelectMedia(index, e),
															},
															section.image_url ? 'Replace Image' : 'Choose / Upload Image'
														),
														section.image_url &&
															el(
																'button',
																{
																	type: 'button',
																	className: 'btn-aberdeen-remove-media',
																	onClick: (e) => handleRemoveMedia(index, e),
																},
																'Remove Image'
															)
													)
												)
											)
										)
								)
							)
					  ),

				// Bottom Add Section Button when items exist
				sections.length > 0 &&
					el(
						'div',
						{ style: { marginTop: '14px', textAlign: 'right' } },
						el(
							'button',
							{
								type: 'button',
								className: 'btn-aberdeen-add',
								onClick: handleAddSection,
							},
							el(Icon, { name: 'plus-alt2' }),
							' Add Another Section'
						)
					)
			)
		);
	}

	// Mount the React Application
	function initMetabox() {
		const rootElement = document.getElementById('aberdeen-program-metabox-root');
		if (!rootElement) return;

		if (window.wp.element.createRoot) {
			const root = window.wp.element.createRoot(rootElement);
			root.render(el(AberdeenProgramMetabox));
		} else if (window.wp.element.render) {
			window.wp.element.render(el(AberdeenProgramMetabox), rootElement);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initMetabox);
	} else {
		initMetabox();
	}
})();
