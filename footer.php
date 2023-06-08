<?php
/**
 * The template for displaying the footer
 * https://xuv.cc/1
 * Contains footer content and the closing of the #main and #page div elements.
 *
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			<?php if ( ox_get_option( 'footerinfo_first' ) ) { echo ox_get_option( 'footerinfo_first' ); } ?>
			<p>版权所有 &copy; (2018 - <?php echo date( "Y" ); ?>)  <a href="https://zuofei.net">今是昨非</a>│<a href="https://zuofei.net/wp-sitemap.xml">网站地图</a>│服务器提供商: <a href="https://app.cloudcone.com/?ref=9587">CloudCone </a>.<br>程序：WordPress│主题：Twenty Twelve│本站禁止任何形式的文章转载<br><?php echo allwords(); ?>
</p>
		</div><!-- .site-info -->
		<?php if ( ox_get_option( 'footerinfo' ) ) : ?>
			<div class="footerinfo">
				<?php echo ox_get_option( 'footerinfo' ); ?>
				
			</div>
		<?php endif ?>
		<script async src="https://umami.eirms.com/script.js" data-website-id="9eddb39a-b5ee-4326-a4d3-7e0fd9ab42a9"></script>
	</footer><!-- #colophon -->

	<ul id="scroll">
		<li><a class="scroll-t" title="返回顶部"><i class="icon-up-big"></i></a></li>
		<li><a class="scroll-b" title="转到底部" ><i class="icon-down-big"></i></a></li>
		<?php
			if ( comments_open() && ( is_single() || is_page() ) ) {
				echo '<li><a class="scroll-c" title="留言评论"><i class="icon-chat"></i></a></li>';
			}
			if ( ox_get_option( 'darkmode' ) ){ //开启 夜间模式
				echo '<li><a class="darkmode" href="javascript:applyCustomDarkModeSettings(toggleCustomDarkMode());" title="暗黑模式切换"><i class="icon-adjust"></i></a></li>';
			}
		?>
	</ul>


	<?php
		// CDN、开缓存wp-config.php开启缓存
		//http://cn.voidcc.com/question/p-rymvrgdr-rc.html
		if( ! is_user_logged_in() && ox_get_option( 'post_views_fastcgi_cache' ) ):  ?>
			<script type= "text/javascript" >
				function GetCookie(sName) {
					var arr = document.cookie.match(new RegExp("(^| )"+sName+"=([^;]*)(;|$)"));
					if(arr !=null){return unescape(arr[2])};
					return null;
				}
				
				var postviews_cook=GetCookie("postviews-<?php the_ID();?>");
				var regexp=/\.(google|bing|baidu|sogou|soso|youdao|yahoo|yisou|sm|mj12bot|so|yandex|biso|gougou|ifeng|ivc|sooule|niuhu|biso|360|ia_archiver|msn|tomato)(\.[a-z0-9\-]+){1,2}\//ig;
				var where=document.referrer;
				
				if ( postviews_cook == null && (!regexp.test(where)) ){
					jQuery.ajax({ type:'POST', url: "<?php echo admin_url('admin-ajax.php');?>" , data:"postviews_id=<?php the_ID();?>&action=postviews",
					cache:false,success: function(postviews_count){ document.cookie="postviews-<?php the_ID();?>=" + postviews_count;} }); 
				};
			</script>
	<?php endif; ?>

	<script>
		var clipboardatext = new ClipboardJS('.clipboard');
		clipboardatext.on('success', function(e) {
			e.clearSelection();
		});
	</script>
</div><!-- #page -->

<?php wp_footer(); ?>

<?php
	//Google Analytics 统计代码
	if ( ! is_user_logged_in() && ox_get_option( 'analyticscode' ) ){
		echo ox_get_option( 'analyticscode' );
	}
?>

<?php 
	if ( current_user_can('administrator') ){
		global $wpdb;
		echo '<!--<pre>';
		print_r($wpdb->queries);//配合 wp-config.php 添加 define('SAVEQUERIES', true);输出当前页面SQL查询
		wp_reset_postdata();
		echo '</pre>-->';
	}
?>
</body>
</html>
