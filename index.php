<?php
/**
 * The main template file
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php
				$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
				$sticky = get_option( 'sticky_posts' );

				//首页 第二页开始 文章列表前 Google 广告2
				if ( is_paged() && check_ad_enabled() && ox_get_option( 'google_ad_info_index_paged' ) ) {
					echo '<div class="google_ads_index_paged">'.ox_get_option( 'google_ad_info_index_paged' ).'</div>';
				}

				//主循环参数
				if ( ox_get_option( 'home_exclude_cat' ) && ox_get_option( 'home_exclude_tag' ) ){
					$nocat = explode( ',', ox_get_option( 'home_exclude_cat' ) );
					$notag = explode( ',', ox_get_option( 'home_exclude_tag' ) );
					$args = array(
						'category__not_in'	=> $nocat,
						'tag__not_in'		=> $notag,
						'post_status'		=> 'publish',
						'paged' => $paged
					);
				} else if ( ox_get_option( 'home_exclude_cat' )  ){
					$nocat = explode( ',', ox_get_option( 'home_exclude_cat' ) );
					$args = array(
						'category__not_in'	=> $nocat,
						'post_status'		=> 'publish',
						'paged' => $paged
					);
				} else if ( ox_get_option( 'home_exclude_tag' ) ){
					$notag = explode( ',', ox_get_option( 'home_exclude_tag' ) );
					$args = array(
						'tag__not_in'		=> $notag,
						'post_status'		=> 'publish',
						'paged' => $paged
					);
				} else {
					$args = array(
						'post_status'	   => 'publish',
						//'post__not_in' => $sticky,
						'paged' => $paged
					);
				}
				$wp_query = new WP_Query($args);

				//第一篇文章下 插入指定分类文章
				$wp_query_set = theme_wp_cache_get( 'wp_query_set_'.$paged.':'.md5(maybe_serialize(get_lastpostmodified())), 'wp_query_set' );
				if( $wp_query_set === false ){
					if ( ox_get_option( 'home_set_cat' ) ){
						$cat_set = explode( ',', ox_get_option( 'home_set_cat' ) );
						$args_set = array(
							'category__in'	 => $cat_set,
							'post_status'	 => 'publish',
							'order'			 => 'DESC',
							'post__not_in'   => $sticky,
							'orderby'		 => 'modified',
							'posts_per_page' => 2,
							'paged'			 => $paged	
						);
						$wp_query_set = new WP_Query( $args_set );
						wp_reset_postdata();
						theme_wp_cache_set( 'wp_query_set_'.$paged.':'.md5(maybe_serialize(get_lastpostmodified())), $wp_query_set, 'wp_query_set', DAY_IN_SECONDS );//缓存一天
					}
				}

				if ( $wp_query->have_posts() ) {
					while ( $wp_query->have_posts() ) : $wp_query->the_post();
						get_template_part( 'content', get_post_format() );
						if ( $wp_query->current_post == 0 ){
							if ( $wp_query_set != false ){
								while ( $wp_query_set->have_posts() ) : $wp_query_set->the_post(); 
									get_template_part( 'content', get_post_format() );
								endwhile;
								wp_reset_postdata();
							}
							//首页 特定分类文章下 或 首页第1篇文章下 Google 广告1
							if ( check_ad_enabled() && ox_get_option( 'google_ad_info_index' ) ) {
								echo '<div class="google_ads_index">'.ox_get_option( 'google_ad_info_index' ).'</div>';
							}
						}
					endwhile;
				} else {
					get_template_part( 'content', 'none' );
				}
			?>
		</div><!-- #content -->
		
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

		<?php wp_reset_postdata(); ?>
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
