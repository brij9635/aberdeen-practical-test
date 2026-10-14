<?php
/**
 * Lead Form Popup Modal & Thank You Banner (Exact Figma Match)
 *
 * @package Aberdeen_Theme
 */

// Fetch all published programs for the dropdown
$all_programs_query = get_posts( array(
	'post_type'      => 'program',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'orderby'        => 'title',
	'order'          => 'ASC',
) );
?>
<div class="aberdeen-modal" id="lead-form-modal" role="dialog" aria-modal="true" aria-labelledby="figma-modal-title" hidden>
	<div class="modal-overlay" data-close-modal></div>
	
	<div class="modal-dialog figma-modal-dialog">
		
		<!-- Modal Header: Figma Exact Title & Close Button -->
		<div class="figma-modal-header">
			<h2 class="figma-modal-title" id="figma-modal-title">Register your interest</h2>
			<button type="button" class="figma-modal-close" data-close-modal aria-label="<?php esc_attr_e( 'Close', 'aberdeen-theme' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		</div>

		<!-- 1. Form Container (Figma Exact Fields) -->
		<div class="modal-body" id="lead-form-container">
			<form id="aberdeen-lead-form" class="figma-lead-form" method="post">
				
				<!-- Row 1: I am enquiring as -->
				<div class="figma-form-group full-width">
					<label for="lead-enquiring-as">
						I am enquiring as <span class="req-star">*</span>
					</label>
					<div class="select-wrapper">
						<select name="enquiring_as" id="lead-enquiring-as" required class="figma-select">
							<option value="" disabled selected>Select an option</option>
							<option value="Student">Student</option>
							<option value="Parent / Guardian">Parent / Guardian</option>
							<option value="Education Agent">Education Agent</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>

				<!-- Row 2: Level of interest & Programme of interest -->
				<div class="figma-form-row">
					<div class="figma-form-group col-half">
						<label for="lead-level-interest">
							Level of interest <span class="req-star">*</span>
						</label>
						<div class="select-wrapper">
							<select name="level_of_interest" id="lead-level-interest" required class="figma-select">
								<option value="" disabled selected>Select an option</option>
								<option value="Undergraduate">Undergraduate</option>
								<option value="Postgraduate">Postgraduate</option>
							</select>
						</div>
					</div>

					<div class="figma-form-group col-half">
						<label for="lead-programme-interest">
							Programme of interest <span class="req-star">*</span>
						</label>
						<div class="select-wrapper">
							<select name="programme_of_interest" id="lead-programme-interest" required class="figma-select">
								<option value="" disabled selected>Select an option</option>
								<?php if ( ! empty( $all_programs_query ) ) : ?>
									<?php foreach ( $all_programs_query as $prog ) : 
										$terms = wp_get_post_terms( $prog->ID, 'program-type', array( 'fields' => 'slugs' ) );
										$term_type = ! empty( $terms ) ? $terms[0] : '';
									?>
										<option value="<?php echo esc_attr( $prog->post_title ); ?>" data-type="<?php echo esc_attr( $term_type ); ?>">
											<?php echo esc_html( $prog->post_title ); ?>
										</option>
									<?php endforeach; ?>
								<?php else : ?>
									<option value="Bachelor of Computer Applications (BCA)">Bachelor of Computer Applications (BCA)</option>
									<option value="Bachelor of Engineering (B.E.)">Bachelor of Engineering (B.E.)</option>
									<option value="Master of Computer Applications (MCA)">Master of Computer Applications (MCA)</option>
									<option value="Master of Engineering (M.E.)">Master of Engineering (M.E.)</option>
								<?php endif; ?>
							</select>
						</div>
					</div>
				</div>

				<!-- Row 3: First name & Last name -->
				<div class="figma-form-row">
					<div class="figma-form-group col-half">
						<label for="lead-first-name">
							First name <span class="req-star">*</span>
						</label>
						<input type="text" name="first_name" id="lead-first-name" required class="figma-input">
					</div>

					<div class="figma-form-group col-half">
						<label for="lead-last-name">
							Last name <span class="req-star">*</span>
						</label>
						<input type="text" name="last_name" id="lead-last-name" required class="figma-input">
					</div>
				</div>

				<!-- Row 4: Country & City -->
				<div class="figma-form-row">
					<div class="figma-form-group col-half">
						<label for="lead-country">
							Country <span class="req-star">*</span>
						</label>
						<div class="select-wrapper">
							<select name="country" id="lead-country" required class="figma-select">
								<option value="" disabled selected>Select an option</option>
								<option value="India">India</option>
								<option value="United Kingdom">United Kingdom</option>
								<option value="United States">United States</option>
								<option value="Canada">Canada</option>
								<option value="Australia">Australia</option>
								<option value="United Arab Emirates">United Arab Emirates</option>
								<option value="Singapore">Singapore</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>

					<div class="figma-form-group col-half">
						<label for="lead-city">
							City <span class="req-star">*</span>
						</label>
						<div class="select-wrapper">
							<select name="city" id="lead-city" required class="figma-select">
								<option value="" disabled selected>Select an option</option>
								<option value="Mumbai">Mumbai</option>
								<option value="Delhi / NCR">Delhi / NCR</option>
								<option value="Bengaluru">Bengaluru</option>
								<option value="Hyderabad">Hyderabad</option>
								<option value="Pune">Pune</option>
								<option value="Chennai">Chennai</option>
								<option value="Kolkata">Kolkata</option>
								<option value="Ahmedabad">Ahmedabad</option>
								<option value="Jaipur">Jaipur</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>
				</div>

				<!-- Row 5: Phone number & Email -->
				<div class="figma-form-row">
					<div class="figma-form-group col-half">
						<label for="lead-phone">
							Phone number <span class="req-star">*</span>
						</label>
						<input type="tel" name="phone" id="lead-phone" value="+91" required class="figma-input">
					</div>

					<div class="figma-form-group col-half">
						<label for="lead-email">
							Email <span class="req-star">*</span>
						</label>
						<input type="email" name="email" id="lead-email" required class="figma-input">
					</div>
				</div>

				<!-- Disclaimer & Consent Text (Figma Exact) -->
				<div class="figma-disclaimer-wrapper">
					<p class="figma-disclaimer-text">
						By clicking the button below, you agree to receive communications via Email/Call/WhatsApp/SMS about this academic program and other academic programs from University of Aberdeen or its trusted third-party partners and service providers. 
						<a href="<?php echo esc_url( home_url( '/privacy' ) ); ?>" class="figma-privacy-link" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
					</p>
				</div>

				<!-- Submit Button -->
				<div class="figma-submit-wrapper">
					<button type="submit" class="btn-figma-submit" <?php echo program_track_attr( 'button', 'submit-lead-form', 'lead-form-popup', 'componentButton' ); ?>>
						<span class="btn-text">Submit</span>
						<span class="btn-loader" style="display:none;">⏳</span>
					</button>
				</div>
			</form>
		</div>

		<!-- 2. Thank You Success Screen (Figma Exact Match) -->
		<div class="modal-body" id="lead-thank-you-screen" style="display:none;">
			<div class="figma-success-banner">
				<div class="figma-success-icon">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="10"></circle>
						<path d="M8 12l2.5 2.5L16 9"></path>
					</svg>
				</div>
				<div class="figma-success-content">
					<h3 class="figma-success-title">Thank you for registering your interest</h3>
					<p class="figma-success-desc" id="thank-you-message">
						We'll send you helpful information and updates about this programme, the application process, and more.
					</p>
				</div>
			</div>
		</div>

	</div>
</div>
