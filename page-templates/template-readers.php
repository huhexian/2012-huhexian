<?php
/*
Template Name: 读者墙
*/
?>
<?php get_header(); ?>

<div id="primary" class="site-content">
    <div class="breadcrumb">
        <?php the_crumbs(); ?>
	</div>
    <div id="content" class="site-main template-readers" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
                   
                <div class="clear"></div>

                <div class="all-readers">
                    <ol class="all-readers-ol">
                        <?php if(function_exists('allreaders_cy')) allreaders_cy(); ?>
                    </ol>
                </div>
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
		    </article><!-- #page -->

		<?php endwhile;?>

        <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template( '', true );
            endif;
        ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>