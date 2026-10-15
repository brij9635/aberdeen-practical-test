<?php
/**
 * Taxonomy Template: Programme Type Archive (Figma Exact "Desktop P2" Match)
 * Handles /programmes/undergraduate and /programmes/postgraduate dynamically
 *
 * @package Aberdeen_Theme
 */

get_header();

// Determine whether we are rendering Undergraduate or Postgraduate
$program_type = get_query_var( 'program-type' );
if ( empty( $program_type ) ) {
	$req_uri      = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$program_type = ( strpos( $req_uri, 'postgraduate' ) !== false ) ? 'postgraduate' : 'undergraduate';
}

$term_obj   = get_term_by( 'slug', $program_type, 'program-type' );
$page_title = $term_obj ? ( $term_obj->name . ' Programmes' ) : ( ucfirst( $program_type ) . ' Programmes' );
?>

<!-- =========================================================================
     1. Banner Section: Exact Figma Dark Blue Background with Gold Heading
     ========================================================================= -->
<section class="p2-banner-section" id="p2-banner">
	<div class="aberdeen-container">
		<h1 class="p2-banner-title"><?php echo esc_html( $page_title ); ?></h1>
		<div class="p2-banner-bar"></div>
	</div>
</section>

<!-- =========================================================================
     2. Content Section: White Background with Centered Subtitle & 2-Col Cards
     ========================================================================= -->
<section class="p2-content-section" id="p2-content">
	<div class="aberdeen-container">
		<p class="p2-section-subtitle">
			Discover a campus that blends Scottish heritage with Indian innovation. A global education awaits!
		</p>

		<div class="p2-cards-grid">
			<?php
			$p2_query = new WP_Query( array(
				'post_type'      => 'program',
				'posts_per_page' => -1,
				'tax_query'      => array(
					array(
						'taxonomy' => 'program-type',
						'field'    => 'slug',
						'terms'    => $program_type,
					),
				),
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
			) );

			if ( $p2_query->have_posts() ) :
				$card_index = 0;
				while ( $p2_query->have_posts() ) :
					$p2_query->the_post();
					$card_index++;
					$post_id   = get_the_ID();
					$permalink = get_permalink();
					$title     = get_the_title();
					$excerpt   = get_the_excerpt();
					if ( empty( $excerpt ) ) {
						$excerpt = wp_trim_words( get_the_content(), 20 );
					}

					// Fallback images matching Figma assets
					$fallback_img = ( $card_index % 2 === 1 )
						? get_template_directory_uri() . '/assets/images/program_img2.jpg'
						: get_template_directory_uri() . '/assets/images/program_img.jpg';

					$img_url = has_post_thumbnail() ? get_the_post_thumbnail_url( $post_id, 'large' ) : $fallback_img;
					?>
					<div class="p2-card" id="program-p2-card-<?php echo esc_attr( $post_id ); ?>">
						<div class="p2-card-img-wrap">
							<a href="<?php echo esc_url( $permalink ); ?>" class="p2-card-media-link" <?php echo program_track_attr( 'link', sanitize_title( $title ), 'programme-p2-card', 'componentCard' ); ?>>
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="p2-card-img">
							</a>
						</div>
						<div class="p2-card-body">
							<h2 class="p2-card-title">
								<a href="<?php echo esc_url( $permalink ); ?>" class="p2-title-link" <?php echo program_track_attr( 'link', sanitize_title( $title ), 'programme-p2-card', 'componentCard' ); ?>>
									<?php echo esc_html( $title ); ?>
								</a>
							</h2>
							<div class="p2-card-divider"></div>
							<p class="p2-card-desc">
								<?php echo esc_html( $excerpt ); ?>
							</p>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p class="text-center" style="grid-column: 1 / -1; font-size: 1.1rem; color: #64748b;">
					<?php esc_html_e( 'No programmes found in this category.', 'aberdeen-theme' ); ?>
				</p>
				<?php
			endif;
			?>
		</div>
	</div>
</section>

<?php
get_footer();

