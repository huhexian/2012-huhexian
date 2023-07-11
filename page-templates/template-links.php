<?php
/*
Template Name: 友情链接
*/
?>
<?php get_header(); ?>

<div id="primary" class="site-content">
    <div class="breadcrumb">
        <?php the_crumbs(); ?>
	</div>
    <div id="content" class="site-main template-links" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<div class="single-content link_clr">
						<?php the_content(); ?>
						
						<div>
<?php
$bookmarks = get_bookmarks('title_li=&orderby=rand'); //全部链接随机输出
if ( !empty($bookmarks) ){
    echo '<ul class="link-content clearfix">';
    foreach ($bookmarks as $bookmark) {
        $friendimg = $bookmark->link_image;
        if(empty($friendimg)){
           echo '<li><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >'. get_avatar($bookmark->link_notes,64) . '<span class="sitename">'. $bookmark->link_name .'</span></a></li>';
        } else {
           echo '<li><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >'. '<img src="'. $bookmark->link_image. '" />' . '<span class="sitename">'. $bookmark->link_name .'</span></a></li>';
        }
    }
    echo '</ul>';
}
?>
</div>
						<div class="clear"></div>
					</div> <!-- .single-content -->
					<div class="clear"></div>
				</div><!-- .entry-content -->

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
		<?php endwhile; ?>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template( '', true ); ?>
		<?php endif; ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
