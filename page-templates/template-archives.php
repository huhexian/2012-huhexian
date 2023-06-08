<?php
/*
Template Name: 文章归档
*/
?>
<?php get_header(); ?>

	<div id="primary" class="site-content">
        <div class="breadcrumb">
            <?php the_crumbs(); ?>
		</div>
        <div id="content" class="site-main template-archives" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>

                    <div class="archives-meta">
                        <?php
                                $count_posts = wp_count_posts();
                                $comments_count = wp_count_comments();
                                echo '站点统计：'.$count_posts->publish.' 篇文章、'.
                                wp_count_terms('category').' 个分类、'.
                                wp_count_terms('post_tag').' 个标签、'.
                                //$wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments").' 条留言、'.
                                $comments_count->total_comments.' 条留言、'.
                                get_totalviews($display = false).' 次访问、'.
                                '站点最后更新于：'.date( 'Y年n月j日', strtotime( get_lastpostmodified() ) );
                        ?>
                    </div>
                    <div class="clear"></div>

                    <h3 class="archives-title">文章归档</h3>
                        <?php zww_archives_list(); ?>
                        <?php //echo get_mosted( $year = 2021 );?>

                    <div class="clear"></div>

                    <footer class="entry-meta-single">
                        <?php  if (function_exists('the_views')) : ?>
                            <span class="views">
                                <?php the_views($display = true, $prefix = '浏览:&nbsp;', $postfix = '', $always = false); ?>
                            </span>
                        <?php endif; ?>
                    </footer><!-- .entry-meta -->

				</article><!-- #page -->

			<?php endwhile;?>

		</div><!-- #content -->
    </div><!-- #primary -->

<script type="text/javascript">
(function ($, window) {
    $(function() {
        var $a = $('#archives'),
            $m = $('.al_mon', $a),
            $l = $('.al_post_list', $a),
            $l_f = $('.al_post_list:first', $a);
        //$l.hide();
        //$l_f.show();
        $m.css('cursor', 's-resize').on('click', function(){
            $(this).next().slideToggle("fast");
        });
        var animate = function(index, status, s) {
            if (index > $l.length) {
                return;
            }
            if (status == 'up') {
                $l.eq(index).slideUp(s, function() {
                    animate(index+1, status, (s-10<1)?0:s-10);
                });
            } else {
                $l.eq(index).slideDown(s, function() {
                    animate(index+1, status, (s-10<1)?0:s-10);
                });
            }
        };
        $('#al_expand_collapse').on('click', function(e){
            e.preventDefault();
            if ( $(this).data('s') ) {
                $(this).data('s', '');
                animate(0, 'down', 10);//10 改 100 展开收缩速度更慢
            } else {
                $(this).data('s', 1);
                animate(0, 'up', 10);
            }
        });
    });
})(jQuery, window);
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>