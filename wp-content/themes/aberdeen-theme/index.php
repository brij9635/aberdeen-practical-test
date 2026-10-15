<?php
/**
 * Main Index Template
 *
 * @package Aberdeen_Theme
 */

get_header();
?>

<div class="aberdeen-container section-padding">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
	?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-article' ); ?>>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php
		endwhile;
	endif;
	?>
</div>

<?php
get_footer();
