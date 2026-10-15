<?php
/**
 * Aberdeen Theme Footer
 *
 * @package Aberdeen_Theme
 */
?>
</main><!-- #primary -->

<footer class="site-footer" id="site-footer">
	<div class="aberdeen-container footer-main-wrapper">
		<!-- Left Column: Branding, Address, Contact -->
		<div class="footer-left-col">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-link" <?php echo program_track_attr( 'link', 'footer-logo', 'footer-main', 'componentLink' ); ?>>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo_image.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="footer-logo-img">
			</a>

			<div class="footer-address-block">
				<p class="footer-address-line">The University of Aberdeen</p>
				<p class="footer-address-line">India Location,</p>
				<p class="footer-address-line">Mumbai</p>
			</div>

			<p class="footer-contact-tel">
				Tel: <a href="tel:+911212121212" class="tel-number" <?php echo program_track_attr( 'link', 'footer-tel', 'footer-main', 'componentLink' ); ?>>+91-1212121212</a>
			</p>

			<div class="footer-action-links">
				<p><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="footer-gold-link" <?php echo program_track_attr( 'link', 'footer-contact-us', 'footer-main', 'componentLink' ); ?>>Contact Us</a></p>
				<p><a href="<?php echo esc_url( home_url( '/student-policies' ) ); ?>" class="footer-gold-link" <?php echo program_track_attr( 'link', 'footer-student-policies', 'footer-main', 'componentLink' ); ?>>Student Policies</a></p>
			</div>
		</div>

		<!-- Right Column: Connect With Us -->
		<div class="footer-right-col">
			<h4 class="footer-social-title">Connect With Us</h4>
			<div class="footer-social-icons">
				<a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="X (Twitter)" <?php echo program_track_attr( 'link', 'social-twitter', 'footer-social', 'componentLink' ); ?>>
					<i class="fa-brands fa-x-twitter"></i>
				</a>
				<a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Instagram" <?php echo program_track_attr( 'link', 'social-instagram', 'footer-social', 'componentLink' ); ?>>
					<i class="fa-brands fa-instagram"></i>
				</a>
				<a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="LinkedIn" <?php echo program_track_attr( 'link', 'social-linkedin', 'footer-social', 'componentLink' ); ?>>
					<i class="fa-brands fa-linkedin-in"></i>
				</a>
			</div>
		</div>
	</div>

	<!-- Bottom Sub-Footer Bar -->
	<div class="footer-bottom-bar">
		<div class="aberdeen-container bottom-bar-inner">
			<div class="footer-policy-links">
				<a href="<?php echo esc_url( home_url( '/privacy' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-privacy', 'footer-legal', 'componentLink' ); ?>>Privacy</a>
				<a href="<?php echo esc_url( home_url( '/accessibility' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-accessibility', 'footer-legal', 'componentLink' ); ?>>Accessibility</a>
				<a href="<?php echo esc_url( home_url( '/cookies' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-cookies', 'footer-legal', 'componentLink' ); ?>>Cookies</a>
			</div>
			<p class="footer-copyright-text">
				&copy; <?php echo esc_html( date( 'Y' ) ); ?> University of Aberdeen
			</p>
		</div>
	</div>
</footer>

<!-- Include Lead Form Popup Modal -->
<?php get_template_part( 'template-parts/modal-lead-form' ); ?>

<?php wp_footer(); ?>
</body>
</html>
