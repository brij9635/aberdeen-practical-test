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
					<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
						<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
					</svg>
				</a>
				<a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Instagram" <?php echo program_track_attr( 'link', 'social-instagram', 'footer-social', 'componentLink' ); ?>>
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
						<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
						<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
						<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
					</svg>
				</a>
				<a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="LinkedIn" <?php echo program_track_attr( 'link', 'social-linkedin', 'footer-social', 'componentLink' ); ?>>
					<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
						<path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
					</svg>
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
