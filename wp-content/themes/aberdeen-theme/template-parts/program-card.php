<?php
/**
 * Reusable Program Card Component (Task 5)
 * Displays only: Image, Title, Academic year (meta), Duration (meta)
 *
 * @package Aberdeen_Theme
 */

$card_post_id = ! empty( $args['post_id'] ) ? absint( $args['post_id'] ) : get_the_ID();

if ( ! $card_post_id ) {
	return;
}

$title         = get_the_title( $card_post_id );
$permalink     = get_permalink( $card_post_id );
$academic_year = get_post_meta( $card_post_id, 'academic_year', true );
if ( empty( $academic_year ) ) {
	$academic_year = get_post_meta( $card_post_id, '_program_academic_year', true );
}

$duration = get_post_meta( $card_post_id, 'duration', true );
if ( empty( $duration ) ) {
	$duration = get_post_meta( $card_post_id, '_program_duration', true );
}

// Fallbacks for display
if ( empty( $academic_year ) ) {
	$academic_year = '2025-26';
}
if ( empty( $duration ) ) {
	$duration = '3 Years Full Time';
}
?>
<article class="program-card" id="program-card-<?php echo esc_attr( $card_post_id ); ?>">
	<div class="card-media">
		<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true" <?php echo program_track_attr( 'link', sanitize_title( $title ) . '-img', 'programme-card', 'componentCard' ); ?>>
			<?php if ( has_post_thumbnail( $card_post_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $card_post_id, 'medium_large', array(
					'alt'   => esc_attr( $title ),
					'class' => 'card-img',
				) ); ?>
			<?php else : ?>
				<div class="card-placeholder-img">
					<span><i class="fa-solid fa-graduation-cap"></i> <?php echo esc_html( $title ); ?></span>
				</div>
			<?php endif; ?>
		</a>
	</div>

	<div class="card-body">
		<!-- Badges: Academic Year & Duration -->
		<div class="card-meta">
			<span class="badge badge-year" aria-label="<?php esc_attr_e( 'Academic Year', 'aberdeen-theme' ); ?>">
				<?php echo esc_html( $academic_year ); ?>
			</span>
			<span class="badge badge-duration" aria-label="<?php esc_attr_e( 'Duration', 'aberdeen-theme' ); ?>">
				<?php echo esc_html( $duration ); ?>
			</span>
		</div>

		<!-- Program Title (accessible link with tracking) -->
		<h3 class="card-title">
			<a href="<?php echo esc_url( $permalink ); ?>" class="card-link" <?php echo program_track_attr( 'link', sanitize_title( $title ), 'programme-card', 'componentCard' ); ?>>
				<?php echo esc_html( $title ); ?>
			</a>
		</h3>
	</div>
</article>
