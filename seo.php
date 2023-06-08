<?php 
	global $page, $paged;
	echo '<title>';
	if ( is_home() || is_front_page() ) {
		if( !is_paged() ){
			bloginfo('name');echo ' | ';bloginfo('description'); 
		}
		else {
			bloginfo('name');
		}
	}
	if ( is_search() ) { 
		echo '搜索结果';
	} 
	if ( is_singular() ) { //is_single() + is_page()
		echo trim(wp_title('',0));
		//if ( is_page_template('pages/template-blog.php') && ( $paged >= 2 || $page >= 2 ) ) echo ' - '.sprintf( __( '第%s页' ), max( $paged, $page ) );
	}
	if ( is_category() ) {
		echo '分类归档：';single_cat_title();
	}
	if ( is_year() ) { 
		the_time('Y年'); echo '所有文章';
	}
	if ( is_month() ) { 
		the_time('F'); echo '份所有文章';
	}
	if ( is_day() ) {
		the_time('Y年n月j日'); echo '所有文章';
	}
	if ( is_author() ) {
		wp_title( ''); echo '发表的所有文章';
	} 
	if ( is_404() ) {
		echo '404 - Page not found ！';
	}
	if (function_exists('is_tag')) { 
		if ( is_tag() ) {
			echo '标签归档：';single_tag_title("", true);
		}
	}
	if ( ! is_single() && ! is_home() && ! is_category() && ! is_search() ) {
		if ( has_post_format( 'aside' ) ) {
			echo get_post_format_string( 'aside' );
		}
		if ( has_post_format( 'image' ) ) {
			echo get_post_format_string( 'image' );
		}
	}
	if (  $paged >= 2 || $page >= 2 ) {
		if ( is_home() ){
			echo ' - '.sprintf( __( '第%s页' ), max( $paged, $page ) );echo ' | ';bloginfo('description');
		} else {
			echo ' - '.sprintf( __( '第%s页' ), max( $paged, $page ) );
		}
	}
	if ( ! ( is_home() || is_front_page() ) ) { 
		echo ' | ';bloginfo('name');
	}
	echo '</title>';
?>

<?php
	if( is_single() || is_page() ) {
	    if( function_exists('get_query_var') ) {
	        $cpage = intval(get_query_var('cpage'));
	        $commentPage = intval(get_query_var('comment-page'));
	    }
	    if( !empty($cpage) || !empty($commentPage) ) {
	        echo '<meta name="robots" content="noindex, nofollow" />';
	        echo "\n";
	    }
	}
		
	if (!function_exists('utf8Substr')) {
		 function utf8Substr($str, $from, $len) {
			return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
				'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
				'$1',$str);
		}
	}

	echo "\n";

	if ( is_single() || ( is_page() && !(is_front_page()) ) ) {
		if ($post->post_excerpt) {
			$description  = $post->post_excerpt;
	    } else {
			if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,"<p>")),$result)){
				$post_content = $result['1'];
			} else {
				$post_content_r = explode("\n",trim(strip_tags($post->post_content)));
				$post_content = $post_content_r['0'];
			}
			$description = utf8Substr($post_content,0,138);
		} 
	    $tag_keywords = "";
	    $tags = wp_get_post_tags($post->ID);
	    foreach ($tags as $tag ) {
	        $tag_keywords = $tag_keywords . $tag->name . ",";
	    }

	    $description = get_post_meta( $post->ID, 'description', true ) ?: $description;
	    $keywords = get_post_meta( $post->ID, 'keywords', true ) ?: '';

	    echo '<meta name="description" content="'.trim($description).'" />';
	    echo "\n";
		echo '<meta name="og:description" content="'.trim($description).'" />';
		echo "\n";
		echo '<meta name="keywords" content="'.trim( $tag_keywords.$keywords, ',' ).'" />';
	}
	
	if ( is_category() ) {
		echo '<meta name="description" content="'.category_description().'" />';
		echo "\n";
		echo '<meta name="og:description" content="'.category_description().'" />';
		echo "\n";
		echo '<meta name="keywords" content="'.single_cat_title( '', false ).','.category_description().'" />';
	}
	if ( is_tag() ) {
		echo '<meta name="description" content="'.trim(strip_tags(tag_description())).'" />';
		echo "\n";
		echo '<meta name="og:description" content="'.trim(strip_tags(tag_description())).'" />';
		echo "\n";
		echo '<meta name="keywords" content="'.single_tag_title( '', false ).','.trim(strip_tags(tag_description())).'" />';
	}
	if ( is_home() || is_front_page() ) {
		$home_description	= ox_get_option( 'home_description' ) ?: get_bloginfo('description');
		$home_keywords		= ox_get_option( 'home_keywords' ) ?: get_bloginfo('description');
		 if (  $paged >= 2 || $page >= 2 ) {
		 	$home_description .=sprintf( __( '第%s页' ), max( $paged, $page ) );
		 }
		echo '<meta name="twitter:card" content="summary_large_image" />';
		echo "\n";
		echo '<meta name="twitter:site" content="@huhexian" />';
		echo "\n";
		echo '<meta name="twitter:creator" content="@huhexian" />';
		echo "\n";
		echo '<meta property="twitter:image" content="'.get_bloginfo("template_directory").'/images/default_first_img.png" />';
		echo "\n";
		echo '<meta name="description" content="'.$home_description.'" />';
		echo "\n";
		echo '<meta name="og:description" content="'.$home_description.'" />';
		echo "\n";
		echo '<meta name="keywords" content="'.$home_keywords.'" />';
		echo "\n";
		echo '<meta property="og:url" content="'.get_bloginfo( "url" ).'" />';
		echo "\n";
		echo '<meta property="og:image" content="'.get_bloginfo("template_directory").'/images/default_first_img.png" />';
	}
?>

<meta property="og:site_name" content="<?php bloginfo('name');?>" />
<meta property="og:type" content="article" />

<?php if( is_singular() ): ?>	
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@huhexian" />
<meta name="twitter:creator" content="@huhexian" />
<meta name="twitter:title" content="<?php the_title(); ?>" />
<meta name="twitter:image" content="<?php echo get_content_first_image( get_the_content() ); ?>" />
<meta property="og:author" content="<?php echo get_the_author_meta('display_name', $post->post_author).'-'.get_bloginfo( 'name' ); ?>" />
<meta property="bytedance:published_time" content="<?php the_time('Y-n-d\TH:i:s+08:00'); ?>" />
<meta property="bytedance:updated_time" content="<?php the_modified_time('Y-n-d\TH:i:s+08:00'); ?>" />
<meta property="bytedance:lrDate_time" content="<?php echo theme_the_post_latest_comment_time( get_the_ID() ); ?>" />
<meta property="og:title" content="<?php the_title(); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:image" content="<?php echo get_content_first_image( get_the_content() ); ?>" />
<?php endif; ?>

<?php
	if ( ox_get_option( 'custom_favicon' ) ) {
		echo ox_get_option( 'custom_favicon' );
	} else {
		echo '<link rel="shortcut icon" href="'.get_bloginfo('template_directory').'/images/favicon.ico">
			<link rel="apple-touch-icon" sizes="180x180" href="'.get_bloginfo('template_directory').'/images/apple-touch-icon.png">
			<link rel="icon" type="image/png" sizes="32x32" href="'.get_bloginfo('template_directory').'/images/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="16x16" href="'.get_bloginfo('template_directory').'/images/favicon-16x16.png">
			<meta name="apple-mobile-web-app-title" content="'.get_bloginfo( 'name' ).'">
			<meta name="application-name" content="'.get_bloginfo( 'name' ).'">
			<meta name="theme-color" content="#ffffff">';
	}
