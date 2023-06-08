<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<div class="page-links">', 'after' => '</div>', 'next_or_number' => 'number')); ?>
		</div><!-- .entry-content -->

		<div class="clear"></div>

        <?php
            //文章结尾插入指定内容
            if ( ox_get_option( 'article_info_foot' ) ) {
                echo '<div class="article_info_foot">'.ox_get_option( 'article_info_foot' ).'</div>';
            }
        ?>

        <div class="clear"></div>
                
        <footer class="entry-meta-single">
            <?php  if (function_exists('the_views')) : ?>
                <span class="views">
                    <?php the_views($display = true, $prefix = '浏览:&nbsp;', $postfix = '', $always = false); ?>
                </span>
            <?php endif; ?>
        </footer><!-- .entry-meta -->
	</article><!-- #post -->
