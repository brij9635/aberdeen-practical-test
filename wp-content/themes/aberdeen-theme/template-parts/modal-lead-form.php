<?php
/**
 * Lead Form Popup Modal & Thank You Alert (Figma Design)
 *
 * @package Aberdeen_Theme
 */
?>
<div class="aberdeen-modal" id="lead-form-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title" hidden>
	<div class="modal-overlay" data-close-modal></div>
	<div class="modal-dialog">
		<button type="button" class="modal-close" data-close-modal aria-label="<?php esc_attr_e( 'Close', 'aberdeen-theme' ); ?>">&times;</button>
		
		<!-- Lead Form Container -->
		<div class="modal-content" id="lead-form-container">
			<div class="modal-header">
				<h2 class="modal-title" id="modal-title">
					<?php echo esc_html( get_theme_mod( 'aberdeen_modal_title', 'Register your Interest' ) ); ?>
				</h2>
				<p class="modal-desc"><?php esc_html_e( 'Take the first step towards your international career. Fill in your details below.', 'aberdeen-theme' ); ?></p>
			</div>

			<form id="aberdeen-lead-form" class="aberdeen-form" method="post">
				<div class="form-group">
					<label for="lead-fullname"><?php esc_html_e( 'Full Name *', 'aberdeen-theme' ); ?></label>
					<input type="text" id="lead-fullname" name="fullname" required placeholder="e.g. John Doe">
				</div>

				<div class="form-row">
					<div class="form-group col-6">
						<label for="lead-email"><?php esc_html_e( 'Email Address *', 'aberdeen-theme' ); ?></label>
						<input type="email" id="lead-email" name="email" required placeholder="john@example.com">
					</div>
					<div class="form-group col-6">
						<label for="lead-phone"><?php esc_html_e( 'Phone Number', 'aberdeen-theme' ); ?></label>
						<input type="tel" id="lead-phone" name="phone" placeholder="+91 98765 43210">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-6">
						<label for="lead-program"><?php esc_html_e( 'Level of Study', 'aberdeen-theme' ); ?></label>
						<select id="lead-program" name="program">
							<option value="Undergraduate"><?php esc_html_e( 'Undergraduate Programmes', 'aberdeen-theme' ); ?></option>
							<option value="Postgraduate"><?php esc_html_e( 'Postgraduate Programmes', 'aberdeen-theme' ); ?></option>
						</select>
					</div>
					<div class="form-group col-6">
						<label for="lead-city"><?php esc_html_e( 'City', 'aberdeen-theme' ); ?></label>
						<input type="text" id="lead-city" name="city" placeholder="e.g. Mumbai, New Delhi">
					</div>
				</div>

				<div class="form-group consent-group">
					<label class="checkbox-label">
						<input type="checkbox" name="consent" required checked>
						<span><?php esc_html_e( 'I agree to receive communications regarding my application from the University of Aberdeen.', 'aberdeen-theme' ); ?></span>
					</label>
				</div>

				<div class="form-submit">
					<button type="submit" class="btn btn-gold btn-block" <?php echo program_track_attr( 'button', 'submit-lead-form', 'lead-form-popup', 'componentButton' ); ?>>
						<span class="btn-text"><?php esc_html_e( 'Submit Registration', 'aberdeen-theme' ); ?></span>
						<span class="btn-loader" style="display:none;">⏳</span>
					</button>
				</div>
			</form>
		</div>

		<!-- Thank You Screen (Figma Design) -->
		<div class="modal-content thank-you-screen" id="lead-thank-you-screen" style="display:none;">
			<div class="thank-you-alert">
				<div class="alert-icon">✓</div>
				<h3><?php esc_html_e( 'Registration Received!', 'aberdeen-theme' ); ?></h3>
				<p id="thank-you-message">
					<?php echo esc_html( get_theme_mod( 'aberdeen_thank_you_message', 'Thank you for registering your interest! Our admissions team will review your application and contact you shortly.' ) ); ?>
				</p>
				<button type="button" class="btn btn-navy" data-close-modal <?php echo program_track_attr( 'button', 'close-thank-you', 'lead-form-popup', 'componentButton' ); ?>>
					<?php esc_html_e( 'Close', 'aberdeen-theme' ); ?>
				</button>
			</div>
		</div>

	</div>
</div>
