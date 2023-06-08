<?php
/**
 * The template for displaying Search Results pages
 *
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div class="breadcrumb">
            <?php the_crumbs(); ?>
		</div>
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php
				if( ox_get_option( 'archive_ad_info' ) ){
					echo '<div class="archive_list_info">'.ox_get_option( 'archive_ad_info' ).'</div>';
				}
			?>

			<header class="page-header">
				<h1 class="page-title">
				<?php
				/* translators: %s: Search query. */
				printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' );
				?>
				</h1>
			</header>

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();
				get_template_part( 'content', get_post_format() );
				//首页 特定分类文章下 或 首页第1篇文章下 Google 广告1
				if ( $wp_query->current_post == 0 ){
					if ( check_ad_enabled() && ox_get_option( 'google_ad_info_index' ) ) {
						echo '<div class="google_ads_index">'.ox_get_option( 'google_ad_info_index' ).'</div>';
					}
				}
			endwhile;
			?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

		</div><!-- #content -->

		<?php
			if ( check_ad_enabled() && ox_get_option( 'google_ad_info_index_nav' ) ) {
				echo '<div class="google_ads_index_nav">'.ox_get_option( 'google_ad_info_index_nav' ).'</div>';//首页分页导航前 Google 广告
			}
		?>

		<div class="posts-nav">
			<?php //自带分页导航
				echo paginate_links(array(
					'prev_next'			=> 1,
					'prev_text'          => __('<'),
					'next_text'          => __('>'),
					'before_page_number' => '<div>',
					'after_page_number' => '</div>',
					'mid_size'           => 1,
					'total' => $wp_query->max_num_pages,
				));
			?>
		</div>

	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
