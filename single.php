<?php
/**
 * The Template for displaying all single posts
 *
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div class="breadcrumb">
            <?php the_crumbs(); ?>
		</div>
		<div id="content" role="main">

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php if ( is_active_sidebar( 'sidebar-single' ) ): //文章小工具 ?>
					<div id="single-widget" class="link_clr">
						<?php dynamic_sidebar( 'sidebar-single' ); ?>
						<div class="clear"></div>
					</div>
				<?php endif; ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // End of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
