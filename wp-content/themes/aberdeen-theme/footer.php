<?php
/**
 * Aberdeen Theme Footer
 *
 * @package Aberdeen_Theme
 */
?>
</main><!-- #primary -->

<footer class="site-footer" id="site-footer">
	<div class="aberdeen-container footer-widgets">
		<!-- Column 1: Brand Info -->
		<div class="footer-col col-brand">
			<div class="brand-crest-footer">
				<span class="crest-icon">🎓</span>
				<span class="brand-title">UNIVERSITY OF ABERDEEN</span>
			</div>
			<p class="footer-desc">
				<?php echo esc_html( get_theme_mod( 'aberdeen_footer_address', "University of Aberdeen, King's College, Aberdeen, AB24 3FX, Scotland" ) ); ?>
			</p>
			<p class="footer-contact-item">
				<strong>Email:</strong> <a href="mailto:<?php echo esc_attr( get_theme_mod( 'aberdeen_footer_email', 'admissions@abdn.ac.uk' ) ); ?>"><?php echo esc_html( get_theme_mod( 'aberdeen_footer_email', 'admissions@abdn.ac.uk' ) ); ?></a>
			</p>
		</div>

		<!-- Column 2: Quick Links -->
		<div class="footer-col col-links">
			<h4 class="footer-heading"><?php esc_html_e( 'Quick Links', 'aberdeen-theme' ); ?></h4>
			<ul class="footer-nav">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-home', 'footer-links', 'componentLink' ); ?>>Home</a></li>
				<li><a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-programmes', 'footer-links', 'componentLink' ); ?>>Our Programmes</a></li>
				<li><a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-undergrad', 'footer-links', 'componentLink' ); ?>>Undergraduate Study</a></li>
				<li><a href="<?php echo esc_url( home_url( '/programmes/postgraduate' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-postgrad', 'footer-links', 'componentLink' ); ?>>Postgraduate Study</a></li>
			</ul>
		</div>

		<!-- Column 3: Programmes -->
		<div class="footer-col col-programmes">
			<h4 class="footer-heading"><?php esc_html_e( 'Study With Us', 'aberdeen-theme' ); ?></h4>
			<ul class="footer-nav">
				<li><a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-bca', 'footer-links', 'componentLink' ); ?>>Computer Applications (BCA)</a></li>
				<li><a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-be', 'footer-links', 'componentLink' ); ?>>Engineering (B.E.)</a></li>
				<li><a href="<?php echo esc_url( home_url( '/programmes/postgraduate' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-mca', 'footer-links', 'componentLink' ); ?>>Computer Applications (MCA)</a></li>
				<li><a href="<?php echo esc_url( home_url( '/programmes/postgraduate' ) ); ?>" <?php echo program_track_attr( 'link', 'footer-me', 'footer-links', 'componentLink' ); ?>>Engineering (M.E.)</a></li>
			</ul>
		</div>

		<!-- Column 4: CTA & Social -->
		<div class="footer-col col-cta">
			<h4 class="footer-heading"><?php esc_html_e( 'Have Questions?', 'aberdeen-theme' ); ?></h4>
			<p class="footer-help-text"><?php esc_html_e( 'Speak directly with our dedicated admissions advisors.', 'aberdeen-theme' ); ?></p>
			<button type="button" class="btn btn-gold btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'footer-enquire-now', 'footer-cta', 'componentButton' ); ?>>
				<?php esc_html_e( 'Enquire Now', 'aberdeen-theme' ); ?>
			</button>
		</div>
	</div>

	<!-- Bottom Copyright -->
	<div class="footer-bottom">
		<div class="aberdeen-container bottom-inner">
			<p class="copyright-text">
				<?php echo esc_html( get_theme_mod( 'aberdeen_copyright_text', '© 2026 University of Aberdeen. All Rights Reserved.' ) ); ?>
			</p>
			<div class="footer-legal">
				<a href="#" <?php echo program_track_attr( 'link', 'privacy-policy', 'footer-legal', 'componentLink' ); ?>>Privacy Policy</a>
				<span class="sep">•</span>
				<a href="#" <?php echo program_track_attr( 'link', 'terms-conditions', 'footer-legal', 'componentLink' ); ?>>Terms of Service</a>
			</div>
		</div>
	</div>
</footer>

<!-- Include Lead Form Popup Modal -->
<?php get_template_part( 'template-parts/modal-lead-form' ); ?>

<?php wp_footer(); ?>
</body>
</html>
