<?php
/**
 * Page Template
 *
 * @package Aberdeen_Theme
 */

get_header();

aberdeen_breadcrumbs();
?>

<div class="page-banner">
	<div class="aberdeen-container">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</div>
</div>

<div class="aberdeen-container section-padding">
	<?php
	while ( have_posts() ) :
		the_post();
	?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php
	endwhile;
	?>
</div>

<?php
get_footer();
