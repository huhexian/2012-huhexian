<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 */
?>

	<article itemscope itemtype="http://schema.org/Article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
			<meta itemprop="name" content="<?php bloginfo('name'); ?>">
			<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
				<meta itemprop="url" content="<?php echo get_template_directory_uri() . '/img/g_logo_112.png'; ?>">
				<meta itemprop="width" content="112px">
				<meta itemprop="height" content="112px">
			</div>
		</div>
		<meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>">
		<meta itemprop="dateModified" content="<?php the_modified_time('c');?>">
		<meta itemprop="inLanguage" content="zh-CN">
		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<p class="meta"><!--文章页标题下标签-->
				Auth:<?php the_author_nickname(); ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				Date:<?php echo the_time('Y/m/j'); ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				Cat:<?php the_category('、'); ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				Word:<?php echo zm_count_words($text); ?>
			</p>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
			<div class="single-meta-info gray">
				<?php if ( is_sticky() ) : //置顶 ?>
					<span class="newsnticky">置顶</span>
					<span class="dot"></span>
				<?php elseif ( current_time('timestamp') - get_the_time('U') < 60*60*24*3 ) : //3天内文章显示 新 ?>
					<span class="newsnticky">新</span>
					<span class="dot"></span>
				<?php endif; ?>
				
				
					<span itemprop="author" itemscope itemtype="http://schema.org/Person">
						<meta itemprop="url" content="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						
					</span>
				</a>
				<span class="comment anchor-fix"><?php comments_popup_link( '<meta itemprop="interactionCount" content="UserComments:0"/>暂无评论', '<meta itemprop="interactionCount" content="UserComments:1"/>1条评论', '<meta itemprop="interactionCount" content="UserComments:%"/>%条评论', '', '已关闭评论' ); ?></span>
			</div>
		</header><!-- .entry-header -->

		<?php if ( is_search() || is_category() || is_archive() || is_home() ) : //Display Excerpts for Search category archive home ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( '继续阅读 <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
			<?php wp_link_pages(array('before' => '<div class="page-links">', 'after' => '</div>', 'next_or_number' => 'number')); ?>
		</div><!-- .entry-content -->
		<?php
			//文章结尾插入指定内容
			if ( ox_get_option( 'article_info_foot' ) ) {
				echo '<div class="article_info_foot">'.ox_get_option( 'article_info_foot' ).'</div>';
			}
		?>
		<?php endif; ?>

		<?php if ( is_single() ) : ?>
            <?php if ( has_tag() ) : ?> <!--文章有标签才显示页脚-->
                <footer class="content-foot"><!--文章页脚部显示修改-->
                    <?php the_tags('⚑Tags：','、'); ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                </footer><!-- .content-foot -->
            <?php endif;  // has_tag() ?>
		<?php else : ?>
			<footer class="home-foot"><!--除文章页脚部显示修改-->
				◷<?php echo the_time('Y/m/j'); ?>&nbsp&nbsp
				@<?php the_author_nickname(); ?>&nbsp&nbsp
				▤<?php the_category('、'); ?>&nbsp&nbsp
				⚑<?php the_tags('','、'); ?>
			</footer><!-- .entry-meta -->
		<?php endif;  // is_single() ?>
	</article><!-- #post -->
