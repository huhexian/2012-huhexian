<?php
// 主题版本 万年不变
define( 'Theme_Ver', '1.0.2.4' );

//OptionsFramework_引入
if (!function_exists('optionsframework_init')) {
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/options/');
	require_once dirname(__FILE__) . '/options/options-framework.php';
	$optionsfile = locate_template( 'options.php' );
	load_template( $optionsfile );
}

add_filter( 'optionsframework_menu', 'ox_options_menu_filter' );
function ox_options_menu_filter( $menu ) {
	$menu['mode'] = 'menu';
	$menu['page_title'] = __( '主题选项', 'ox' );
	$menu['menu_title'] = __( '主题选项', 'ox' );
	$menu['menu_slug'] = 'ox-theme';
	return $menu;
}

add_action('admin_init','ox_optionscheck_change_santiziation', 100);
function ox_optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'ox_custom_sanitize_textarea' );
}
function ox_custom_sanitize_textarea($input) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	} else {
		$output = wp_kses_post( $input );
	}
	return $output;
}
//OptionsFramework_引入 -End
//引入文件
require get_template_directory () . '/postviews.php';//文章浏览数
require get_template_directory () . '/widgets.php';//侧栏
require get_template_directory () . '/quotes.php';//格言

/**
 * Twenty Twelve setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 */
function twentytwelve_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentytwelve
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwelve' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Register sidebars. 注册侧栏小工具
 */
function twentytwelve_widgets_init() {
	if (function_exists('register_sidebar')){
		register_sidebar( array(
			'name'          => '所有页面上侧边栏',
			'id'            => 'sidebar-top',
			'description'   => '显示在所有页面侧边栏上面',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '<div class="clear"></div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => '首页侧边栏',
			'id'            => 'sidebar-home-t',
			'description'   => '显示在首页侧边栏上面',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '<div class="clear"></div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => '单页侧边栏',
			'id'            => 'sidebar-single-t',
			'description'   => '显示在单页侧边栏上面',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '<div class="clear"></div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => '所有页面侧边栏(在底部)',
			'id'            => 'sidebar-all',
			'description'   => '显示在所有页面侧边栏下面',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '<div class="clear"></div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => '正文底部小工具',
			'id'            => 'sidebar-single',
			'description'   => '显示在正文底部',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '<div class="clear"></div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( !function_exists( 'base64url_encode' ) ) {
	function base64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
}

if ( !function_exists( 'base64url_decode' ) ) {
	function base64url_decode($data) {
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}
}

//wp_cache 区分登录用户 与 访客
if ( !function_exists( 'theme_wp_cache_get' ) ) {
	function theme_wp_cache_get( $key, $group ) {
		if( is_user_logged_in() ){
			return wp_cache_get( $key.'-admin', $group);
		} else {
			return wp_cache_get( $key.'-visitor', $group);
		}
	}
}

if ( !function_exists( 'theme_wp_cache_set' ) ) {
	function theme_wp_cache_set( $key, $data, $group , $expire ) {
		if( is_user_logged_in() ){
			wp_cache_set( $key.'-admin', $data, $group , $expire );
		} else {
			wp_cache_set( $key.'-visitor', $data, $group , $expire );
		}
	}
}

if ( !function_exists( 'theme_wp_cache_delete' ) ) {
	function theme_wp_cache_delete( $key, $group ) {
		if( is_user_logged_in() ){
			wp_cache_delete( $key.'-admin', $group );
		} else {
			wp_cache_delete( $key.'-visitor', $group );
		}
	}
}

//去除 br 留下 p
//https://wordpress.stackexchange.com/questions/178322/wpautop-disable-br-tags-keep-p-tags
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'only_remove_br' , 12);
function only_remove_br( $content ) {
	global $post;
	$br = false;
	return wpautop( $content, $br );
}

add_shortcode ( "addbr", 'addbr_content' );
function addbr_content($atts, $content = null) {
	return '<blockquote>'.wpautop( $content ).'</blockquote>';
}

/**
 * WordPress 禁止UA为空或含有PHP的请求 By 张戈博客
 * 原文地址：https://zhang.ge/5101.html https://zhang.ge/4458.html
**/
if(!is_admin()) {
	add_action('init', 'deny_mirrored_request', 0);
}
function deny_mirrored_request()
{
	//获取UA信息
	$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

	//将恶意USER_AGENT存入数组
	$now_ua = array('BOT/0.1 (BOT for JCE)','CrawlDaddy','Java','UniversalFeedParser','ApacheBench','Swiftbot','ZmEu','Indy Library','oBot','jaunty','YandexBot','AhrefsBot','MJ12bot','WinHttp','EasouSpider','HttpClient','Microsoft URL Control','jaunty','Python-urllib','lightDeckReports Bot');

	//禁止 USER_AGENT
	if( preg_match('/PHP/i', $ua) ) { //empty( $ua ) ) || 会误伤隐私模式
		header("Content-type: text/html; charset=utf-8");
		wp_die('请勿采集本站，谢谢。刷新网页即可正常访问，祝您生活愉快！');
	} else {
		foreach($now_ua as $value ) {
			//判断是否是数组中存在的UA
			if( preg_match( '~'.$value.'~i', $ua) ) {
				header("Content-type: text/html; charset=utf-8");
				wp_die('请勿采集本站，谢谢。刷新网页即可正常访问，祝您生活愉快！');
			}
		}
	}
}
// http://php.net/manual/zh/function.bin2hex.php url 字符串转 十六进制
if ( !function_exists( 'str2hex_encode' ) ) {
	function str2hex_encode($data) {
		$data = "\\x" . substr(chunk_split(bin2hex($data),2,"\\x"),0,-2);
		return $data;
	}
}

/**
* 网站被恶意镜像 http://www.ilxtx.com/mirrored-website.html 最后更新时间：2020-05-16 archive.org
*/
add_action('wp_footer','theme_deny_mirrored_websites');
function theme_deny_mirrored_websites(){
	echo '<div style="display:none;"><img src="" onerror=\'setTimeout(function(){if(!/('.non_www_domain( home_url('/') ).'|google.com|googleusercontent.com|archive.org|sogoucdn.com|bingj.com|bing.com|baiducontent.com|baidu.com|360webcache.com)$/.test(window.location.hostname)){window.location.href="'.str2hex_encode(esc_url( get_permalink() )).'"}},2200);\'></div>';
}

// 加载脚本及样式
function the_theme_scripts() {
	wp_enqueue_script('jquery');
	
	wp_enqueue_style( 'style', get_stylesheet_uri(), array() , filemtime(get_stylesheet_directory().'/style.css'));

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20141205', true );

	wp_enqueue_script( 'clipboard.min', get_template_directory_uri().'/js/clipboard.min.js', array(), filemtime(get_stylesheet_directory().'/js/clipboard.min.js') , false );
	wp_enqueue_script( 'script', get_template_directory_uri().'/js/script.js', array(), filemtime(get_stylesheet_directory().'/js/script.js') , true );
	wp_localize_script( 'script', 'domain2js', array( 'domain_url'   => non_www_domain( home_url('/') ), ) );//记住评论者信息域名传入js文件

	// ajax 提交评论
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		//wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script( 'ajax-comment', get_template_directory_uri() . '/js/ajax-comment.js', array( 'jquery' ), filemtime(get_stylesheet_directory().'/js/ajax-comment.js') , true );
        wp_localize_script( 'ajax-comment', 'ajaxcomment', array(
            'ajax_url'   => admin_url('admin-ajax.php'),
            'order' => get_option('comment_order'),
            'formpostion' => 'bottom', //默认为bottom，如果你的表单在顶部则设置为top。
        ) );//ajax 提交评论
	}
	//图片灯箱
	if ( is_singular() ) {
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/fancybox.js', array(), '3.5.7', true );
	}
}
add_action( 'wp_enqueue_scripts', 'the_theme_scripts' );

//获取文章第一张图片地址 seo中使用
function get_content_first_image( $content ){
	if ( $content === false ) $content = get_the_content(); 

	preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $images);

	if( isset( $images[1][0] ) && $images[1][0] != '' ){
		$srcinfo = parse_url( $images[1][0] );
		if( isset( $srcinfo['scheme'] ) ){  
			return $images[1][0];  
		} else {
			return get_bloginfo( 'url').$images[1][0];
		}
	} else {
		return get_bloginfo('template_directory').'/images/default_first_img.png';
	}
}
//提取裸域 域名提取
if( !function_exists("non_www_domain") ) {
    function non_www_domain( $url ) {
        $only_domain = parse_url(esc_url( $url ), PHP_URL_HOST);//提取裸域 域名提取
		$only_domain = preg_replace("/^www\./", "", $only_domain);
		return $only_domain; //返回域名，如 0xo.net
    }
}

// gravatar头像调用 secure.gravatar.com cn.gravatar.com  详见：get_avatar_data
function get_ssl_avatar( $avatar ) {
	if ( ox_get_option( 'cn_avatar_url' ) ){
		$avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com", "secure.gravatar.com"), ox_get_option( 'cn_avatar_url' ), $avatar);
	}
	return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');

// 面包屑导航
function the_crumbs() {

// Check if is front/home page, return
  if ( is_front_page() ) {
    return;
  }
  // Define
  global $post;
  $custom_taxonomy  = ''; // If you have custom taxonomy place it here
  $defaults = array(
    'seperator'   =>  ' / ',
    'id'          =>  'breadcrumb',
    'classes'     =>  'breadcrumb',
    'home_title'  =>  esc_html__( '⚐ Home', '' )
  );
  $sep  = '<li class="seperator">'. esc_html( $defaults['seperator'] ) .'</li>';
  // Start the breadcrumb with a link to your homepage
  echo '<ul id="'. esc_attr( $defaults['id'] ) .'" class="'. esc_attr( $defaults['classes'] ) .'">';
  // Creating home link
  echo '<li class="item"><a href="'. get_home_url() .'">'. esc_html( $defaults['home_title'] ) .'</a></li>' . $sep;
  if ( is_single() ) {
    // Get posts type
    $post_type = get_post_type();
    // If post type is not post
    if( $post_type != 'post' ) {
      $post_type_object   = get_post_type_object( $post_type );
      $post_type_link     = get_post_type_archive_link( $post_type );
      echo '<li class="item item-cat"><a href="'. $post_type_link .'">'. $post_type_object->labels->name .'</a></li>'. $sep;
    }
    // Get categories
    $category = get_the_category( $post->ID );
    // If category not empty
    if( !empty( $category ) ) {
      // Arrange category parent to child
      $category_values      = array_values( $category );
      $get_last_category    = end( $category_values );
      // $get_last_category    = $category[count($category) - 1];
      $get_parent_category  = rtrim( get_category_parents( $get_last_category->term_id, true, ',' ), ',' );
      $cat_parent           = explode( ',', $get_parent_category );
      // Store category in $display_category
      $display_category = '';
      foreach( $cat_parent as $p ) {
        $display_category .=  '<li class="item item-cat">'. $p .'</li>' . $sep;
      }
    }
    // If it's a custom post type within a custom taxonomy
    $taxonomy_exists = taxonomy_exists( $custom_taxonomy );
    if( empty( $get_last_category ) && !empty( $custom_taxonomy ) && $taxonomy_exists ) {
      $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
      $cat_id         = $taxonomy_terms[0]->term_id;
      $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
      $cat_name       = $taxonomy_terms[0]->name;
    }
    // Check if the post is in a category
    if( !empty( $get_last_category ) ) {
      echo $display_category;
      echo '<li class="item item-current">'. get_the_title() .'</li>';
    } else if( !empty( $cat_id ) ) {
      echo '<li class="item item-cat"><a href="'. $cat_link .'">'. $cat_name .'</a></li>' . $sep;
      echo '<li class="item-current item">'. get_the_title() .'</li>';
    } else {
      echo '<li class="item-current item">'. get_the_title() .'</li>';
    }
  } else if( is_archive() ) {
    if( is_tax() ) {
      // Get posts type
      $post_type = get_post_type();
      // If post type is not post
      if( $post_type != 'post' ) {
        $post_type_object   = get_post_type_object( $post_type );
        $post_type_link     = get_post_type_archive_link( $post_type );
        echo '<li class="item item-cat item-custom-post-type-' . $post_type . '"><a href="' . $post_type_link . '">' . $post_type_object->labels->name . '</a></li>' . $sep;
      }
      $custom_tax_name = get_queried_object()->name;
      echo '<li class="item item-current">'. $custom_tax_name .'</li>';
    } else if ( is_category() ) {
      $parent = get_queried_object()->category_parent;
      if ( $parent !== 0 ) {
        $parent_category = get_category( $parent );
        $category_link   = get_category_link( $parent );
        echo '<li class="item"><a href="'. esc_url( $category_link ) .'">'. $parent_category->name .'</a></li>' . $sep;
      }
      echo '<li class="item item-current">'. single_cat_title( '', false ) .'</li>';
    } else if ( is_tag() ) {
      // Get tag information
      $term_id        = get_query_var('tag_id');
      $taxonomy       = 'post_tag';
      $args           = 'include=' . $term_id;
      $terms          = get_terms( $taxonomy, $args );
      $get_term_name  = $terms[0]->name;
      // Display the tag name
      echo '<li class="item-current item">'. $get_term_name .'</li>';
    } else if( is_day() ) {
      // Day archive
      // Year link
      echo '<li class="item-year item"><a href="'. get_year_link( get_the_time('Y') ) .'">'. get_the_time('Y') . '年</a></li>' . $sep;
      // Month link
      echo '<li class="item-month item"><a href="'. get_month_link( get_the_time('Y'), get_the_time('m') ) .'">'. get_the_time('M') .'</a></li>' . $sep;
      // Day display
      echo '<li class="item-current item">'. get_the_time('jS') .' '. get_the_time('M'). '</li>';
    } else if( is_month() ) {
      // Month archive
      // Year link
      echo '<li class="item-year item"><a href="'. get_year_link( get_the_time('Y') ) .'">'. get_the_time('Y') . '年</a></li>' . $sep;
      // Month Display
      echo '<li class="item-month item-current item">'. get_the_time('M') .'</li>';
    } else if ( is_year() ) {
      // Year Display
      echo '<li class="item-year item-current item">'. get_the_time('Y') .'年</li>';
    } else if ( is_author() ) {
      // Auhor archive
      // Get the author information
      global $author;
      $userdata = get_userdata( $author );
      // Display author name
      echo '<li class="item-current item">'. 'Author: '. $userdata->display_name . '</li>';
    } else {
      echo '<li class="item item-current">'. post_type_archive_title() .'</li>';
    }
  } else if ( is_page() ) {
    // Standard page
    if( $post->post_parent ) {
      // If child page, get parents
      $anc = get_post_ancestors( $post->ID );
      // Get parents in the right order
      $anc = array_reverse( $anc );
      // Parent page loop
      if ( !isset( $parents ) ) $parents = null;
      foreach ( $anc as $ancestor ) {
        $parents .= '<li class="item-parent item"><a href="'. get_permalink( $ancestor ) .'">'. get_the_title( $ancestor ) .'</a></li>' . $sep;
      }
      // Display parent pages
      echo $parents;
      // Current page
      echo '<li class="item-current item">'. get_the_title() .'</li>';
    } else {
      // Just display current page if not parents
      echo '<li class="item-current item">'. get_the_title() .'</li>';
    }
  } else if ( is_search() ) {
    // Search results page
    echo '<li class="item-current item">Search results for: '. get_search_query() .'</li>';
  } else if ( is_404() ) {
    // 404 page
    echo '<li class="item-current item">' . 'Error 404' . '</li>';
  }
  // End breadcrumb
  echo '</ul>';
}

// 文字展开
add_shortcode ( "s", 'show_more' );
add_shortcode ( "p", 'section_content' );

function show_more($atts, $content = null) {
return '<span class="showmore" title="文字折叠，点击展开/折叠"><span>▼展开</span></span>';
}

function section_content($atts, $content = null) {
return '<div class="section-content">'.do_shortcode($content).'</div>';
}
// 文字展开 end

// 登录可见
add_shortcode("login", "login_to_read");
function login_to_read($atts, $content = null) {
	extract( shortcode_atts( array("notice" =>''), $atts ) );
	if (is_user_logged_in()) {
		return '<div class="reply-to-read-content"><blockquote><b>以下为登录可见内容：</b><br />'.do_shortcode( $content ).'</blockquote></div>';
	} else {
		return '';
	}
}

// 加密内容
add_shortcode("password", "secret");
function secret($atts, $content=null){
	$arg = shortcode_atts( array(
		'key' => '10086',
		'tips' => '开门大吉',
	), $atts );
	$qr_name = ox_get_option( 'post-secret-name' ) ?: 'TwentyTwelve';
	$qr_url = ox_get_option( 'post-secret-qrcode' ) ?: get_template_directory_uri().'/images/post-secret-qr-120.png';
	if ( current_user_can('level_10') ) {
		return '<div class="reply-to-read-content"><blockquote><b>以下为加密内容：</b><br />'.do_shortcode( $content ).'</blockquote></div>';
	}
	if( isset($_POST['secret_key']) && ( ( $_POST['secret_key']==$arg['key'] && $arg['key'] !='' ) || $_POST['secret_key'] == ox_get_option('post-secret-code') ) ){
		return '<div class="reply-to-read-content"><blockquote><b>以下为加密内容：</b><br />'.do_shortcode( $content ).'</blockquote></div>';
	} else {
		return '
		<form class="post-password-form" action="'.get_permalink().'" method="post">
			<img class="post-secret-qr" src="'.$qr_url.'" />
			<div class="post-secret">以下为加密内容，请输入密码查看！</div>
			<p>
				<input id="pwbox" type="password" placeholder="请输入密码点击查看" name="secret_key">
				<input type="submit" value="查看" name="Submit">
			</p>
			<div class="post-secret-notice">关注公众号「<b id = "green">'.$qr_name.'</b>」，回复「<b id = "red">'.$arg["tips"].'</b>」，免费获取密码。</div>
		</form>
		';
	}  
}
//煎蛋评论图片地址自动转化为图片 https://fatesinger.com/74330
//多张图片地址要分开 ; ALLOW_POSTS为允许自动贴图的文章，多篇文章用,隔开即可，如需所有文章则定义为空即可。
define('ALLOW_POSTS', '');
function m_comment_image( $comment ) {
    $post_ID = $comment["comment_post_ID"];
    $allow_posts = ALLOW_POSTS ? explode(',', ALLOW_POSTS) : array();
    if(in_array($post_ID,$allow_posts) || empty($allow_posts) ){
        global $allowedtags;
        $content = $comment["comment_content"];
        $content = preg_replace('/(https?:\/\/\S+\.(?:jpg|png|jpeg|gif))+/','<img src="$0" />',$content);
        $allowedtags['img'] = array('src' => array (), 'alt' => array ());
        $comment["comment_content"] = $content;
    }
    return $comment;
}
add_filter('preprocess_comment', 'm_comment_image');

// 垃圾评论处理开始
// 禁止无中文留言 黑名单 、日文 等非Ajax无刷新评论的话要把函数里的err替换为wp_die 老用户不禁止
function refused_spam_comments( $comment_data ) {
    $pattern = '/[一-龥]/u';
    $jpattern ='/[ぁ-ん]+|[ァ-ヴ]+/u';
    $authorblacklist = explode(',', ox_get_option( 'comments_name_blacklist' ) );
    $author = trim(strtolower( $comment_data['comment_author'] ));
    $cau = $comment_data['comment_author'] ;
	$email = trim(strtolower( $comment_data['comment_author_email'] ));
	$authoremailblacklist = explode(',', ox_get_option( 'comments_email_blacklist' ) );
	$cem = $comment_data['comment_author_email'] ;
	$comment_data['comment_author_IP'] = preg_replace( '/[^0-9a-fA-F:., ]/', "",$_SERVER['REMOTE_ADDR'] );
   	$comment_data['comment_agent'] = isset($_SERVER['HTTP_USER_AGENT'] ) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 254 ) : "";
	global $wpdb;
    $ok_to_comment = $wpdb->get_var("SELECT comment_approved FROM $wpdb->comments WHERE comment_author = '$cau' AND comment_author_email = '$cem' and comment_approved = '1' LIMIT 1");
	if(0 == $ok_to_comment) {
		foreach( $authorblacklist as $p ){
			if( !empty( $p ) ){
				if(strpos($author, $p) !== false){
						err("错误：抱歉，昵称中不允许包含“{$p}”字符，请更换重试。");
				}
			}
		}
		if( !is_email($email) ){
			err("错误：抱歉，您的邮件地址不正确，请更换重试。");
		}
		if( in_array($email, $authoremailblacklist) ){
			err("错误：抱歉，当前邮件地址存在于黑名单中，请更换重试。");
		}
	    if( !preg_match($pattern,$comment_data['comment_content']) ) { // 禁止无中文评论
	        err( __('错误：抱歉，评论必须含中文！You should type some Chinese word (like “你好”) in your comment to pass the spam-check！') );
	    }
	    if( preg_match($jpattern, $comment_data['comment_content']) ){  // 禁止带日文评论
	    	err( __('错误：抱歉，评论不能包含日文！') );
		}
		if ( version_compare( $GLOBALS['wp_version'], '5.5.0', '>=' ) ) {
			//WordPress 5.5.0 版本起，使用 wp_check_comment_disallowed_list() 替换 wp_blacklist_check
			if( wp_check_comment_disallowed_list($comment_data['comment_author'],$comment_data['comment_author_email'],$comment_data['comment_author_url'], $comment_data['comment_content'], $comment_data['comment_author_IP'], $comment_data['comment_agent'] ) ){
		    	err( __('错误：抱歉，您提交的评论内容/Email/昵称/URL/IP包含黑名单内容，请检查！') );// 禁止黑名单提交评论 
			}
		} else {
			if( wp_blacklist_check( $comment_data['comment_author'],$comment_data['comment_author_email'],$comment_data['comment_author_url'], $comment_data['comment_content'], $comment_data['comment_author_IP'], $comment_data['comment_agent'] ) ){
		    	err( __('错误：抱歉，您提交的评论内容/Email/昵称/URL/IP包含黑名单内容，请检查！') );// 禁止黑名单提交评论 
			}
		}
	}
	return( $comment_data );
}
// 垃圾评论只针对未登录访客进行处理
if ( !is_user_logged_in() ) {
	add_filter('preprocess_comment','refused_spam_comments');	
}
// 垃圾评论处理结束

//根据 email 获取评论者评论数
function theme_comment_count_byemail( $email = null ){
	return get_comments(array(
		'author_email' => $email,
		'count' => true,
	));
}

//获取文章父评论数
function theme_parent_comment_counter( $id ){
	$c_counts = theme_wp_cache_get( 'c_counts_'.$id, 'c_counts' );
	if( $c_counts === false ){
		global $wpdb;
		$query = "SELECT COUNT(comment_post_id) AS count FROM $wpdb->comments WHERE `comment_approved` = 1 AND `comment_post_ID` = $id AND `comment_parent` = 0";
		$parents = $wpdb->get_row($query);
		$c_counts = $parents->count;
		theme_wp_cache_set( 'c_counts_'.$id, $c_counts, 'c_counts', 2 * HOUR_IN_SECONDS );
	}
	return $c_counts;
}

//根据 评论者评论数 个性化显示等级
function theme_comment_count_lv( $author_count = 0 ){
	if( $author_count>=10 && $author_count<20 ){
		return '<a class="badge vip1" title="评论之星 LV.1">LV1</a>';
	} else if( $author_count>=20 && $author_count<40 ){
		return '<a class="badge vip2" title="评论之星 LV.2">LV2</a>';
	} else if( $author_count>=40 && $author_count<80 ){
		return '<a class="badge vip3" title="评论之星 LV.3">LV3</a>';
	} else if( $author_count>=80 && $author_count<160 ){
		return '<a class="badge vip4" title="评论之星 LV.4">LV4</a>';
	} else if( $author_count>=160 && $author_count<320 ){
		return '<a class="badge vip5" title="评论之星 LV.5">LV5</a>';
	} else if( $author_count>=320 && $author_count<640 ){
		return '<a class="badge vip6" title="评论之星 LV.6">LV6</a>';
	} else if( $author_count>=640 && $author_count<40 ){
		return '<a class="badge vip7" title="评论之星 LV.7">LV7</a>';
	}
}

//检查评论者链接是否友情链接
function theme_check_comment_url_in_bookmarks( $comment_author_url = null ){
	$bookmarks = get_bookmarks( array(
		'category'  => '480'
	) );

	foreach ( $bookmarks as $bookmark ) {
		if ( ( preg_replace( "/^www\./", "", parse_url(esc_url( $bookmark->link_url ), PHP_URL_HOST) ) ) == ( preg_replace( "/^www\./", "", parse_url(esc_url( $comment_author_url ), PHP_URL_HOST) ) ) ){
			return '<a class="badge heart" target="_blank" href="/friends.html/" title="友情链接认证"><i class="icon-heart"></i></a>';
		}
	}
}

// 评论链接跳转内链-外链跳转
function commentauthor($comment_ID = 0) {
	global $post;
	$adminEmail		= get_bloginfo('admin_email');
	$comment_temp	= get_comment( $comment_ID ); 
	$author			= $comment_temp->comment_author;
	$url			= $comment_temp->comment_author_url ;
	$email			= $comment_temp->comment_author_email;
	$cmuserid		= $comment_temp->user_id;
	echo '<cite>';
	if( $cmuserid === $post->post_author ){
		echo "<b class='fn'><a href='$url' rel='me' target='_blank' class='url'>$author</a></b>";
		echo '<span class="badge lv-admin">文章作者</span>';
	} else if( $cmuserid > 0 && $email == $adminEmail ) {
		echo "<b class='fn'><a href='$url' rel='me' target='_blank' class='url'>$author</a></b>";
		echo '<span class="badge lv-admin">管理员</span>';
	} else if ( $cmuserid > 0  ) {
		echo "<b class='fn'><a href='$url' rel='me' target='_blank' class='url'>$author</a></b>";
	} else if ( empty( $url ) || 'http://' == $url ) {
		echo "<b class='fn'>".$author."</b>";
	} else {
		if ( !is_user_logged_in() ) {
			echo "<b class='fn'><a href='".get_template_directory_uri()."/r.php?".base64url_encode( $url )."' rel='nofollow noopener noreferrer' target='_blank' title='".$url."' class='url'>$author</a></b>".theme_comment_count_lv( theme_comment_count_byemail( $comment_temp->comment_author_email )).theme_check_comment_url_in_bookmarks( $url );
		} else {
			echo "<b class='fn'><a href='".$url."' rel='nofollow noopener noreferrer' target='_blank' title='".$url."' class='url'>$author</a></b>".theme_comment_count_lv( theme_comment_count_byemail( $comment_temp->comment_author_email )).theme_check_comment_url_in_bookmarks( $url );
		}
	}
	echo '</cite>';
}

//文章外链跳转伪静态版
add_filter( 'the_content', 'link_jump', 999 );
function link_jump( $content ){
	if ( is_singular() && !is_user_logged_in() ) {
		global $post;
		preg_match_all( '/<a(.*?)href="(.*?)"(.*?)rel="(.*?)"(.*?)>/', $content, $matches );
		if($matches){
		    foreach( $matches[2] as $key => $val ){
				if( strpos($val, '://' ) !==false && !preg_match( '/\.(jpg|jepg|png|ico|bmp|gif|tiff)/i', $val ) ){
					if( preg_match( '/nofollow/i', $matches[4][$key] ) ) {
						$content = str_replace( "href=\"$val\"", "href=\"".get_template_directory_uri()."/r.php?".base64url_encode( $val )."\" title=\"$post->post_title $val\" target=\"_blank\" rel=\"nofollow noopener\"", $content );	
			       	} else if( strpos( $val, home_url() ) === false ){
						$content = str_replace( "href=\"$val\"", "href=\"".$val."\" title=\"$post->post_title $val\" target=\"_blank\" rel=\"noopener noreferrer\"", $content );	
					}
				}
			}
		}
	}
	return $content;
}
//文章内容替换，如 z701.com->545c.com
add_filter( 'the_content', 'ctfile_replace', 5 );
function ctfile_replace( $content ){
	$rules = explode( ',' , ox_get_option( 'text_ctfile_replace' ) );
	foreach( $rules as $rule ) {
		$word = explode('->', trim( $rule ));
		if(isset($word[1])) {
			$content = str_replace(trim($word[0]), trim($word[1]), $content);
		}
	}
	return $content;
}

//名称：WordPress 评论 内容自动替换 外链跳转 露兜 http://www.ludou.org/
function text_content_replace($content) {
	$rules = explode( ',' , ox_get_option( 'text_content_replace' ) );
	foreach($rules as $rule) {
		$word = explode('->', trim($rule));
		if(isset($word[1])) {
			$content = str_replace(trim($word[0]), trim($word[1]), $content);
		}
	}
	//外链转内链
	preg_match_all('/<a(.*?)href="(.*?)"(.*?)rel="(.*?)"(.*?)>/',$content,$matches);
	if( $matches ){
		foreach( $matches[2] as $key => $val ){
			if( strpos($val,'://')!==false && strpos($val,home_url())===false && !preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff)/i',$val) ){
				if( preg_match( '/nofollow/i', $matches[4][$key] ) ) {
					$content=str_replace("href=\"$val\"", "href=\"".get_template_directory_uri()."/r.php?".base64url_encode( $val )."\" title=\"$val\" target=\"_blank\" rel=\"nofollow noopener\"",$content);
				} else {
					$content=str_replace("href=\"$val\"", "href=\"$val\" title=\"$val\" target=\"_blank\" rel=\"nofollow noopener\"",$content);
				}
			}
		}
	}
    return $content;
}
add_filter( 'comment_text', 'text_content_replace' );//评论
add_filter( 'comment_text_rss', 'text_content_replace' );

// 添加按钮
if ( is_admin() ) {
add_action('after_wp_tiny_mce', 'bolo_after_wp_tiny_mce');
}
function bolo_after_wp_tiny_mce($mce_settings) {
?>
<script type="text/javascript">
	QTags.addButton( 'outlink', '链', "<a href=\"\" target=\"_blank\" rel=\"noopener\">", "</a>" );
	QTags.addButton( 'nflink', '外', "<a href=\"\" target=\"_blank\" rel=\"nofollow\">", "</a>" );
	QTags.addButton( 'link_blue', '蓝链', "<a class=\"button button_blue\" href=\"\" target=\"_blank\" rel=\"nofollow\"><i class=\"icon-link-ext\"></i>", "</a>" );
	QTags.addButton( 'link_orange', '橙链', "<a class=\"button button_orange\" href=\"\" target=\"_blank\" rel=\"nofollow\"><i class=\"icon-link-ext\"></i>", "</a>" );
	QTags.addButton( 'text-align-center', '中对齐', "<p class=\"align_center\">", "</p>" );
	QTags.addButton( 'precode', '代码', "<pre><code>", "</code></pre>" );
    QTags.addButton( 'blockquote', '引用', "<blockquote>", "</blockquote>" );
	QTags.addButton( 'addbr', '加BR', "[addbr]", "[/addbr]" );
	QTags.addButton( 'hr', 'hr', "<hr />", "" );
    QTags.addButton( 'h1', 'h1', "<h1>", "</h1>" );
    QTags.addButton( 'h2', 'h2', "<h2>", "</h2>" );
    QTags.addButton( 'h3', 'h3', "<h3>", "</h3>" );
    QTags.addButton( 'h4', 'h4', "<h4>", "</h4>" );
    QTags.addButton( 'h5', 'h5', "<h5>", "</h5>" );
    QTags.addButton( 'br', 'br', "<br />", "" );
    QTags.addButton( 'red', '红', "<b id = \"red\">", "</b>" );
	QTags.addButton( 'purple', '紫', "<b id = \"purple\">", "</b>" );
    QTags.addButton( 'blue', '蓝', "<b id = \"blue\">", "</b>" );
    QTags.addButton( 'green', '绿', "<b id = \"green\">", "</b>" );
    QTags.addButton( 'underline', '下划线', "<span style = \"text-decoration: underline;\">", "</span>" );
    QTags.addButton( 'text-align-right', '右对齐', "<p class=\"align_right\">", "</p>" );
    QTags.addButton( 'wp_page', '分页', "<!--nextpage-->", "" );
    QTags.addButton( 'addlinkimg', '灯箱', "<a href=\"/wp-content/uploads/<?php echo date("Y"); ?>/<?php echo date("m"); ?>/.png\"><img src=\"/wp-content/uploads/<?php echo date("Y"); ?>/<?php echo date("m"); ?>/", ".png\" /></a>" );
	QTags.addButton( 'addscreen', '截图', "<a href=\"/wp-content/uploads/<?php echo date("Y"); ?>/<?php echo date("m"); ?>/", ".png\">截图</a>" );
	QTags.addButton( 'album', '相册', "<p class=\"imglist\">", "</p>" );
    QTags.addButton( 'addimg', '图片', "<img loading=\"lazy\" src=\"/wp-content/uploads/<?php echo date("Y"); ?>/<?php echo date("m"); ?>/", ".png\" />" );
	QTags.addButton( 'hidecontent', '内容折叠', "[s]\n[p]", "[/p]" );
	QTags.addButton( 'login_to_read', '登录可见', "[login]", "[/login]" );
	QTags.addButton( 'secret', '密码查看', "[password key=\"10086\" tips=\"开门大吉\"]", "[/password]" );
	QTags.addButton( 'fks', '「」', "「", "」" );
	QTags.addButton( 'coupon_copy', '优惠码复制', "<a class=\"clipboard art\" data-clipboard-text=\"", "\" target=\"_blank\" title=\"点击复制优惠码并直达下单\" rel=\"noopener\" href=\"https://<?php echo non_www_domain( home_url('/') ); ?>/\"><i class=\"icon-scissors\"></i></a>" );
	QTags.addButton( 'theme_tags_posts', '指定标签文章', "[tags_posts tags=", "]" );
	QTags.addButton( 'insert_block', '插入段落', "[theme_insert_content_block ids=", "]" );
function bolo_QTnextpage_arg1() {
}
</script>
<?php }



// lightbox 图片灯箱 fancyBox v3 https://fancyapps.com/fancybox/3/
add_filter('the_content', 'pirobox_auto', 99);
add_filter('the_excerpt', 'pirobox_auto', 99);
function pirobox_auto($content) {
	global $post;
	$pattern = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>/i";
	//$replacement = '<a$1href=$2$3$4$5$6 class="fancybox" data-fancybox-group="button" '.$post->ID.'>';
	$replacement = '<a$1href=$2$3$4$5$6 loading="lazy" rel="sponsored" data-fancybox="gallery">';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}

//强制替换添加图片 alt 和 title 属性
function image_alttitle( $content ){
	global $post;
	$btitle = get_bloginfo('name');
	$imgtitle = $post->post_title;
	$imgUrl = "<img\s[^>]*src=(\"??)([^\" >]*?)\\1[^>]*>";
	if(preg_match_all("/$imgUrl/siU",$content,$matches,PREG_SET_ORDER)){
		if( !empty($matches) ){
			for ($i=0; $i < count($matches); $i++){
				$tag = $url = $matches[$i][0];
				$j=$i+1;
				$url = preg_replace( '/(title|alt)="\d*"\s/', "", $url );
                $altURL = ' alt="'.$imgtitle.' - 第'.$j.'张图片" title="'.$imgtitle.' - 第'.$j.'张图片 | '.$btitle.'" ';
				$url = rtrim($url,'>');
				$url .= $altURL.'>';
				$content = str_replace($tag,$url,$content);
			}
		}
	}
	return $content;
}
add_filter( 'the_content','image_alttitle', 98);

function theme_category( $separator = ', ' ) {
	$categories = get_the_category();
	$separator = $separator ? $separator : ', ';
	$output = '';
	if ( ! empty( $categories ) ) {
	    foreach( $categories as $category ) {
	        $output .= '<span itemprop="articleSection"><a href="' . esc_url( get_category_link( $category->term_id ) ) .'" target="_blank">' .  esc_html( $category->name ) . '</a></span>' . $separator;
	    }
	    echo trim( $output, $separator );
	}
}

// 文章归档| 2016 http://zww.me
function zww_archives_list() {
	$output = theme_wp_cache_get( get_the_ID().':'.md5(maybe_serialize(get_lastpostmodified())), 'archives_list' );
	if( $output === false ){
		$output = '<div id="archives" class="link_clr"><p><a id="al_expand_collapse" href="#">全部展开/收缩</a> <em>(注: 点击月份可以展开)</em></p>';
		$args = array(
			'post_type' => array('archives', 'post'),
			'posts_per_page' => -1, //全部 posts
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1 //忽略 sticky posts
		);
		$the_query = new WP_Query( $args );
		$posts_rebuild = array();
		$year = $mon = 0;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$post_year = get_the_time('Y');
			$post_mon = get_the_time('m');
			$post_day = get_the_time('d');
			$com_nums = '';
			if ( get_comments_number() ){
				$com_nums = '留言&nbsp;'.get_comments_number().'、';
			}
			if ($year != $post_year) $year = $post_year;
			if ($mon != $post_mon) $mon = $post_mon;
			if (function_exists('the_views')) {
				$posts_rebuild[$year][$mon][] = '<li>'. get_the_time('d日: ') .get_the_ID().'-<a href="'. get_permalink() .'" target="_blank">'. get_the_title() .'</a> <em>（&nbsp;<a href="'.get_permalink().'?amp=1" title="Google AMP 移动加速版本" target="_blank" rel="amp" >AMP版本</a>、'. $com_nums .the_views($display = false, $prefix = '浏览&nbsp;', $postfix = '', $always = false).'&nbsp;）</em></li>';
			} else {
				$posts_rebuild[$year][$mon][] = '<li>'. get_the_time('d日: ') .get_the_ID().'-<a href="'. get_permalink() .'" target="_blank">'. get_the_title() .'</a> <em>（&nbsp;<a href="'.get_permalink().'?amp=1" title="Google AMP 移动加速版本" target="_blank" rel="amp" >AMP版本</a>、'. $com_nums .'&nbsp;）</em></li>';
			}
		endwhile;
		wp_reset_postdata();

		foreach ($posts_rebuild as $key_y => $y) {
			$y_i = 0; $y_output = '';
			foreach ($y as $key_m => $m) {
				$posts = ''; $i = 0;
				foreach ($m as $p) {
					++$i; ++$y_i;
					$posts .= $p;
				}
				$y_output .= '<li><span class="al_mon">'. $key_m .' 月 <em>( '. $i .' 篇文章 )</em></span><ul class="al_post_list">'; //输出月份
				$y_output .= $posts; //输出 posts
				$y_output .= '</ul></li>';
			}
			$output .= '<h3 class="al_year">'. $key_y .' 年 <em>( '. $y_i .' 篇文章 )</em></h3><ul class="al_mon_list">'; //输出年份
			$output .= $y_output;
			$output .= '</ul>';
		}

		$output .= '</div>';
		theme_wp_cache_set( get_the_ID().':'.md5(maybe_serialize(get_lastpostmodified())), $output, 'archives_list',  24 * HOUR_IN_SECONDS );
	}
	echo $output;
}

add_filter ( 'category_description', 'deletehtml' );

// 链接管理
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

/* 读者墙函数 - 数据库缓存方式版 */
function allreaders_cy() {
	$mostactive = theme_wp_cache_get( 'mostactivecache_key','mostactive');
    if( $mostactive === false ){
        global $wpdb;
        $noneurl = esc_url( home_url('/') );
		$admin_email = get_option('admin_email');
        $counts = $wpdb->get_results("
            SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url, comment_author_email
            FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
            ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID)
            WHERE comment_author_email != '$admin_email'
				AND user_id = '0'
                AND post_password=''
                AND comment_approved='1'
                AND comment_type='comment') AS tempcmt
            GROUP BY comment_author_email
            ORDER BY cnt DESC,comment_date_gmt DESC
        ");
        $mostactive = '';
        if(empty($counts)) {
            $mostactive .= '<li class="active-item">none data.</li><div class="clear"></div>';
        } else {
            foreach ($counts as $count) {
                $c_url = $count->comment_author_url;
                if ($c_url == '') $c_url = $noneurl;
                $title_alt = $count->comment_author . ' ('. $count->cnt. ' 条评论)';
                $mostactive .= '<li class="all-readers-info">' . '<a target="_blank" rel="nofollow" href="'.$c_url.'" title="' .$title_alt
                . ' - '.$c_url.'">'.$count->comment_author.'</a></li>';
            }
        }
        theme_wp_cache_set('mostactivecache_key', $mostactive, 'mostactive', 21600);//缓存6小时
    }

    if( !is_user_logged_in() ){
		//外链转内链
		preg_match_all( '/<a(.*?)href="(.*?)"(.*?)rel="(.*?)"(.*?)>/', $mostactive, $matches );
		if( $matches ){
			foreach( $matches[2] as $key => $val ){
				if( strpos($val,'://')!==false && strpos($val,home_url())===false && !preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff)/i',$val) && !preg_match('/(ed2k|thunder|Flashget|flashget|qqdl):\/\//i',$val )){
					if( preg_match( '/nofollow/i', $matches[4][$key] ) ) {
						$mostactive = str_replace( "href=\"$val\"", "href=\"".get_template_directory_uri()."/r.php?".base64url_encode( $val )."\" title=\"$val\" target=\"_blank\" rel=\"nofollow noopener\"", $mostactive );
					} else {
						$mostactive = str_replace( "href=\"$val\"", "href=\"$val\" title=\"$val\" target=\"_blank\" rel=\"nofollow noopener\"", $mostactive );
					}
				}
			}
		}
	}
    echo $mostactive;
}
function clear_mostactive() {
	theme_wp_cache_delete( 'mostactivecache_key', 'mostactive' ); // 清空 mostactive
	theme_wp_cache_delete( 'widget_active_friends_key', 'widget_active_friends' );//清空侧栏读者墙
}
add_action('comment_post', 'clear_mostactive'); // 新评论发生时
add_action('edit_comment', 'clear_mostactive'); // 评论被编辑过
add_action('wp_set_comment_status', 'clear_mostactive');

//最近评论/访客 https://fatesinger.com/75054
if(!function_exists("deep_in_array")) {
    function deep_in_array($value, $array) { // 返还数组序号
        $i = -1;
        foreach($array as $item => $v) {
            $i++;
            if($v["email"] == $value){
                return $i;
            }
        }
        return -1;
    }
}

function get_active_friends($num = null,$size = null,$days = null,$order = null) {
	$num = $num ? $num : 12;
	$size = $size ? $size : 24;
	$days = $days ? $days : 30;
	$order = $order ? $order :'';
	$array = array();
	$comments = get_comments( array('status' => 'approve','author__not_in'=>'1,2','date_query'=>array('after' => $days . ' days ago')) );
	if(!empty($comments)) {
	    foreach($comments as $comment){
	        $email = $comment->comment_author_email;
	        $author = $comment->comment_author;
	        //$url = $comment->comment_author_url;
	        $url = get_permalink( $comment->comment_post_ID ).'#comment-'.$comment->comment_ID;
	        $data = $comment->comment_date;
	        if($email!=""){
	            $index = deep_in_array($email, $array);
	            if( $index > -1){
	                $array[$index]["number"] +=1;
	            }else{
	                array_push($array, array(
	                    "email" => $email,
	                    "author" => $author,
	                    "url" => $url,
	                    "date" => $data,
	                    "number" => 1
	                ));
	            }
	        }
	    }

	    if( $order ) {
		    foreach ($array as $k => $v) {
				$edition[] = $v['number'];
			}
			array_multisort($edition, SORT_DESC, $array); // 数组倒序排列
	    }
	}
	$active_friends = '<div class="readers-avatar">';
	if(empty($array)) {
	    $active_friends .= '<li>none data.</li>';
	} else {
		$max = ( count($array) > $num ) ? $num : count($array);
	        
	    for($o=0;$o < $max;$o++) {
	        $v = $array[$o];
	        $active_avatar = get_avatar($v["email"],$size);
	        $active_url = $v["url"] ? $v["url"] : "javascript:;";
	        $active_alt = $v["author"] . ' - 共 '. $v["number"]. ' 条评论，最后评论于'. $v["date"].'。';
	        $active_friends .= '<li class="active-item"><a target="_blank" rel="nofollow" title="'.$active_alt.'" href="'.$active_url.'">'.$active_avatar.'</a></li>';
	    }
	        
	}
	$active_friends .= '</div>';
	return  $active_friends;
}

// 最近 30 天更新文章 Recently Updated Posts by zwwooooo | zww.me
function recently_updated_posts( $num=6, $daysat=7, $daysin=60, $cat_ID='' ){
	$recent_updated_posts = '';
	if( $cat_ID != '' ){
		$args = array(
			'cat'			=> $cat_ID,
			'post_status'	=> 'publish',
			'orderby'		=> 'modified',
			'order'			=> 'DESC',
			'posts_per_page'=> -1,
			'paged'			=> -1
		);
	} else if ( ox_get_option( 'home_exclude_cat' ) ){
		$notcat = explode( ',', ox_get_option( 'home_exclude_cat' ) );
		$args = array(
			'category__not_in' => $notcat,
			'post_status' => 'publish',
			'orderby' => 'modified',
			'posts_per_page' => -1,
			'ignore_sticky_posts' => 1
		);
	} else {
		$args = array(
			'post_status' => 'publish',
			'orderby' => 'modified',
			'posts_per_page' => -1,
			'ignore_sticky_posts' => 1
		);
	}

	$the_query = new WP_Query( $args );

	$i=0;

	while ( $the_query->have_posts() && $i<$num ) : $the_query->the_post();
		if ( ( ( get_the_modified_time('U') - get_the_time('U') ) > (60*60*24*$daysat) ) && ( ( current_time('timestamp') - get_the_modified_time('U') ) < ( 60*60*24*$daysin))) {
			$i++;
			$the_title_value=get_the_title();
			$recent_updated_posts.='<li><a target="_blank" href="'.get_permalink().'" title="'.$the_title_value.' - 修改时间: '.get_the_modified_time('Y.m.d').'">'
			.$the_title_value.'</a></li>';
		}
	endwhile;

	wp_reset_postdata();

	$recent_updated_posts=($recent_updated_posts == '') ? '<li>最近没有更新文章.</li>' : $recent_updated_posts;

	return $recent_updated_posts;
}

/* ajax 提交评论  20151224*/
if(!function_exists('err')) :
	function err($a) {
	    header('HTTP/1.0 500 Internal Server Error');
	    header('Content-Type: text/plain;charset=UTF-8');
	    echo $a;
	    exit;
	}
endif;

if(!function_exists('fa_ajax_comment_callback')) :
    function fa_ajax_comment_callback(){
        $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
        if ( is_wp_error( $comment ) ) {
            $data = $comment->get_error_data();
            if ( ! empty( $data ) ) {
            	err($comment->get_error_message());
            } else {
                exit;
            }
		}
		function theme_get_comment_depth( $comment_id ) {
			$depth_level = 0;
			while( $comment_id > 0  ) { // if you have ideas how we can do it without a loop, please, share it with us in comments
				$comment = get_comment( $comment_id );
				$comment_id = $comment->comment_parent;
				$depth_level++;
			}
			return $depth_level;
		}
        //$user = wp_get_current_user();
        //do_action('set_comment_cookies', $comment, $user);
		$GLOBALS['comment'] = $comment;
		$depth_ajax = theme_get_comment_depth( get_comment_ID() );
	?>
        <!-- Your comments here  edit start //这里修改成你的评论结构 -->
	    <li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44, '', get_bloginfo("name").'-'.get_comment_author() );
					//commentauthor();
					echo '<cite><b class="fn">'.get_comment_author_link().'</b></cite>';
					//printf(
					//	'<cite><b class="fn">%1$s</b> %2$s</cite>',
					//	get_comment_author_link(),
					//	// If current post author is also comment author, make it known visually.
					//	( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					//);
					printf(
						'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: Date, 2: Time. */
						sprintf( __( '%1$s %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
				?>
				</header><!-- .comment-meta -->

				<?php
				$commenter = wp_get_current_commenter();
				if ( $commenter['comment_author_email'] ) {
					$moderation_note = __( 'Your comment is awaiting moderation.', 'twentytwelve' );
				} else {
					$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'twentytwelve' );
				}
				?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php echo $moderation_note; ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
				<?php comment_text(); ?>
				</section><!-- .comment-content -->

			</article><!-- #comment-## -->
	    <!-- edit end -->
        <?php die();
    }
endif;
add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');


//文章段落block插入
function theme_insert_content_block( $atts, $content = null ){
    extract( shortcode_atts( array(
        'ids' => ''
    ),$atts ) );

    if( ox_get_option( 'content_block_text' ) ) {
		$content_block = explode( '|', ox_get_option( 'content_block_text' ) );
		$content .= '<p class="content_block">'.$content_block[$ids-1].'</p>';
	} else {
		$content .= '<p>优惠码：<a class="clipboard art" data-clipboard-text="BWH34QMFYT2R" target="_blank" title="点击复制优惠码并直达下单" rel="noopener noreferrer" href="https://0xo.net/b/0"><i class="icon-scissors"></i>BWH34QMFYT2R</a>，省 6.38%，全场通用！</p>';
	}
    return $content;
}
add_shortcode('theme_insert_content_block', 'theme_insert_content_block');

// 获取指定标签文章
function theme_tags_posts( $atts, $content = null ){
	extract( shortcode_atts( array('tags' => ''), $atts ) );
	global $post;
	$content = theme_wp_cache_get( get_the_ID().':'.md5(maybe_serialize(get_lastpostmodified())),'taged-posts' );
	if( $content === false ){
		$content = '';
		$tags =  explode(',', $tags);
		$args = array(
			'tag__in' => $tags,
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$tags_query = new WP_Query($args);
		if ( $tags_query->have_posts() ) {
			$content .= '<ul>';
			while ( $tags_query->have_posts() ) {
				$tags_query->the_post();
				$content .= '<li><a href="'.get_permalink().'" target="_blank" title="'.get_the_title().'">'.get_the_title().'</a>('.get_comments_number().')</li>';
			}
			$content .= '</ul>';
		} else {
			$content .= '<ul>没有相关文章</ul>';
		}
		theme_wp_cache_set( get_the_ID().':'.md5(maybe_serialize(get_lastpostmodified())), $content, 'taged-posts', 24 * HOUR_IN_SECONDS );
	}
    wp_reset_postdata();
    return $content;
}
add_shortcode('tags_posts', 'theme_tags_posts');

/**
 * 新文章自动使用ID作为别名postname
 * 作用：即使你设置固定连接结构为 %postname% ，仍旧自动生成 ID 结构的链接
 * http://www.wpdaxue.com/wordpress-using-post-id-as-slug.html
 */
add_action( 'save_post', 'using_id_as_slug', 10, 3 );
function using_id_as_slug($post_id, $post, $update){
	if( ! ( wp_is_post_revision( $post ) || is_preview() || $post->post_status == 'draft' ) ) {
		$id = intval( $post_id );
		if ( !$post_views = get_post_meta( $id, 'views', true ) ) {
			$post_views = 0;
			add_post_meta( $id, 'views', 0, true);
		}
	}

	if( $post->post_type !='post' || wp_is_post_revision($post_id) ) return;

	// 取消挂载该函数，防止无限循环
	remove_action('save_post', 'using_id_as_slug' );

	// 使用文章ID作为文章的别名
	wp_update_post(array('ID' => $post_id, 'post_name' => $post_id ));

	// 重新挂载该函数
	add_action('save_post', 'using_id_as_slug', 10, 3 );
}

/* 禁用自动保存 */
function disable_autosave() {
    wp_deregister_script('autosave');
}
add_action( 'wp_print_scripts', 'disable_autosave' );

//不保存修订
add_filter( 'wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2 );
	function specs_wp_revisions_to_keep( $num, $post ) {
		return 0;
}

// WordPress 4.2.3 目测有效 文章ID连续
function keep_id_continuous(){
  global $wpdb;

  // 删掉自动草稿和修订版
  $wpdb->query("DELETE FROM `$wpdb->posts` WHERE `post_status` = 'auto-draft' OR `post_type` = 'revision'");

  // 自增值小于现有最大ID，MySQL会自动设置正确的自增值
  $wpdb->query("ALTER TABLE `$wpdb->posts` AUTO_INCREMENT = 1");  
}

add_filter( 'load-post-new.php', 'keep_id_continuous' );
add_filter( 'load-media-new.php', 'keep_id_continuous' );
add_filter( 'load-nav-menus.php', 'keep_id_continuous' );

// WordPress登录自动勾选记住我的登录信息
add_filter( 'login_footer', 'always_checked_rememberme' );
function always_checked_rememberme() {
	echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
// WordPress延长自动登录时间
add_filter( 'auth_cookie_expiration', 'custom_login_cookie' );
function custom_login_cookie() {
	return 25920000; // 30 days in seconds
}

//评论回复邮件
function comment_mail_notify($comment_id) {
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam')) {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));//发件人e-mail地址，no-reply可改为可用的e-mail
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在'."「".get_option("blogname")."」".'上的留言有回复啦！';
    $message = '<div style="border-right:#666666 1px solid;border-radius:8px;color:#111;font-size:12px;width:95%;border-bottom:#666666 1px solid;font-family:微软雅黑,arial;margin:10px auto 0px;border-top:#666666 1px solid;border-left:#666666 1px solid;border: 1px solid #eee;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);"><div class="adM">
    </div><div style="width:100%;min-height:60px;color:white;border-radius:6px 6px 0 0;background-image: -webkit-linear-gradient(0deg, #c1d9f3, #eff6ff);"><span style="line-height:60px;min-height:60px;margin-left:30px;font-size:12px">您在「<a style="color:#00a1ff;font-weight:600;text-decoration:none" href="' . get_option('home') . '" target="_blank" rel="external nofollow"  target="_blank" rel="external nofollow"  target="_blank">' . get_option('blogname') . '</a>」上的留言有回复啦！</span> </div>
    <div style="margin:0px auto;width:90%">
    <p><span style="font-weight:bold;">' . trim(get_comment($parent_id)->comment_author) . '</span>, 您好!</p>
    <p>您于' . trim(get_comment($parent_id)->comment_date) . ' 在文章<a style="color:#00bbff;text-decoration:none" href="' . htmlspecialchars(get_comment_link($parent_id)) . '" target="_blank" rel="external nofollow"  target="_blank">《' . get_the_title($comment->comment_post_ID) . '》</a>上发表评论: </p>
    <p style="border-bottom:#ddd 1px solid;border-left:#ddd 1px solid;padding-bottom:20px;background-color:#eff5fb;margin:15px 0px;padding-left:20px;padding-right:20px;border-top:#ddd 1px solid;border-right:#ddd 1px solid;padding-top:20px;background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);border-radius: 5px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);">' . nl2br(get_comment($parent_id)->comment_content) . '</p>
    <p><span style="font-weight:bold;">' . trim($comment->comment_author) . '</span> 于' . trim($comment->comment_date) . ' 给您的回复如下: </p>
    <p style="border-bottom:#ddd 1px solid;border-left:#ddd 1px solid;padding-bottom:20px;background-color:#eff5fb;margin:15px 0px;padding-left:20px;padding-right:20px;border-top:#ddd 1px solid;border-right:#ddd 1px solid;padding-top:20px;background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);border-radius: 5px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);">' . nl2br($comment->comment_content) . '</p>
    <p><a style="margin: 0;font-family: '."'"."Helvetica Neue"."'".', Helvetica, Arial, sans-serif;box-sizing: border-box;font-size: 14px;text-decoration: none;color: #FFF;background-color: #348eda;border: solid #348eda;border-width: 10px 20px;line-height: 2em;font-weight: bold;text-align: center;cursor: pointer;display: inline-block;border-radius: 5px;text-transform: capitalize;" href="' . htmlspecialchars(get_comment_link($parent_id)) . '" target="_blank" rel="external nofollow"  target="_blank">点击回复</a></p>
    <p>感谢您对「<a style="color:#00bbff;text-decoration:none" href="' . get_option('home') . '" target="_blank" rel="external nofollow"  target="_blank" rel="external nofollow"  target="_blank">' . get_option('blogname') . '</a>」的留言，如您还有任何疑问，欢迎继续在博客留言，相信我们一定有共同之处！</p></div></div><div class="footer" style="margin: 0; font-family: '.'Helvetica Neue'.', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; padding: 20px;">
                    <table width="100%" style="margin: 0; font-family: '.'Helvetica Neue'.', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;"><tbody><tr style="margin: 0; font-family: '.'Helvetica Neue'.', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px;">
<td class="aligncenter content-block" style="margin: 0; font-family: '.'Helvetica Neue'.', Helvetica, Arial, sans-serif; box-sizing: border-box; vertical-align: top; padding: 0 0 20px; text-align: center; color: #999; font-size: 12px;">'."此邮件由「".'<a href="https://eirms.com" style="margin: 0; font-family: '.'Helvetica Neue'.', Helvetica, Arial, sans-serif; box-sizing: border-box; text-decoration: underline; color: #999; font-size: 12px;" rel="noopener" target="_blank">今是昨非</a>'."」自动发出，请勿直接回复谢谢！".'</td></tr></tbody></table></div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
    }
}
add_action('comment_post', 'comment_mail_notify');

//使用smtp发送邮件（请根据自己使用的邮箱设置SMTP）
    add_action('phpmailer_init', 'mail_smtp');
    function mail_smtp( $phpmailer ) {
    $phpmailer->FromName = '青山'; //发件人名称
    $phpmailer->Host = 'smtp.gmail.com'; //修改为你使用的邮箱SMTP服务器
    $phpmailer->Port = 465; //SMTP端口
    $phpmailer->Username = '填写账户'; //邮箱账户
    $phpmailer->Password = '填写密码'; //邮箱密码
    $phpmailer->From = '填写账户'; //邮箱账户
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = 'ssl'; //tls or ssl （port=25时->留空，465时->ssl）
    $phpmailer->IsSMTP();
    }

//WordPress去除带replytocom参数链接 https://www.ludou.org/wordpress-remove-replytocom-urls.html
add_filter('comment_reply_link', 'add_nofollow', 420, 4);
function add_nofollow($link, $args, $comment, $post){
  return preg_replace( '/href=\'(.*(\?|&)replytocom=(\d+)#respond)/', 'href=\'#respond', $link );
}

// hook thread_comments_depth_max 修改评论嵌套最大嵌套层数为444，默认为10
function filter_thread_comments_depth_max( $maxdeep ) { 
    $maxdeep = 444;
    return $maxdeep;
};
add_filter( 'thread_comments_depth_max', 'filter_thread_comments_depth_max', 10, 1 );



//评论回调函数
if ( ! function_exists( 'twentytwelve_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own twentytwelve_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 */
	function twentytwelve_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		global $post;
		$count_t = theme_parent_comment_counter( $post->ID ); //获取文章父评论数
		extract($args, EXTR_SKIP);

		// 楼层
		global $commentcount;
		if(!$commentcount) {
			if ( get_query_var('cpage') > 0 ) $page = get_query_var('cpage')-1; else $page = get_query_var('cpage');
			$cpp=get_option('comments_per_page');
			$commentcount = intval($cpp) * intval($page);
		}
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				// Display trackbacks differently than normal comments.
				?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default:
				// Proceed with normal comments.
				?>
		<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> <?php if( $depth > 2){ echo ' style="margin-left:0;padding-left:0;border-left: none;"';} //add 评论嵌套修改?> id="comment-<?php comment_ID() ?>">
		<article id="div-comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo '<a title="留言总数：'.theme_comment_count_byemail( get_comment_author_email()).'" href="javascript:;">'.get_avatar( $comment, 44, '', get_bloginfo("name").'-'.get_comment_author() ).'</a>';
					commentauthor();
					//printf(
					//	'<cite><b class="fn">%1$s</b> %2$s</cite>',
					//	get_comment_author_link(),
					//	// If current post author is also comment author, make it known visually.
					//	( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					//);
					printf(
						'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: Date, 2: Time. */
						sprintf( __( '%1$s %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
				?>
				</header><!-- .comment-meta -->

				<?php
				$commenter = wp_get_current_commenter();
				if ( $commenter['comment_author_email'] ) {
					$moderation_note = __( 'Your comment is awaiting moderation.', 'twentytwelve' );
				} else {
					$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'twentytwelve' );
				}
				?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php echo $moderation_note; ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
					<?php comment_text(); ?>
				</section><!-- .comment-content -->

				<div class="comment-reply-edit">
					<span class="floor">
						<?php
							if(!$parent_id = $comment->comment_parent){
								printf('<span>%1$s楼</span>', ++$commentcount);
							}
						?>
					</span>
					<span class="reply">
						<a class="comment-reply-link" href="javascript:;" onclick="return addComment.moveForm('div-comment-<?php comment_ID() ?>', '<?php comment_ID() ?>', 'respond', '<?php the_ID(); ?>')">回复</a>
					</span>
					<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
			</article><!-- #comment-## -->
				<?php
				break;
		endswitch; // End comment_type check.
	}
endif;

//相关文章
function Theme_Related_Posts ( $number ) {
	global $post;
	$output = theme_wp_cache_get( get_the_ID().':'.md5(maybe_serialize(get_lastpostmodified())), 'relatedpost' );
	if( $output === false ) {
		$num = $number;//文章数量
		$i=0;
		$output='';
		if( $i < $num){//相同分类
		    $catid = array();
		    $thisid[] = $post->ID;
		    $catids = get_the_category();
		    if( !empty( $catids ) ) {
		        foreach( $catids as $cat ) {
		            $catid[] = $cat->term_id;
		        }
		    }
		    $args = array(
		        'post_type' => 'post',
		        'post__not_in' => $thisid,
		        'ignore_sticky_posts' => 1,
		        'posts_per_page' => ( $num - $i ),
		        'category__in' => $catid
		    );
		    $rsp = get_posts( $args );
		    foreach( $rsp as $relatedpost ){
		        $output .= '<li><a href="' . get_permalink( $relatedpost->ID ) . '" target="_blank">' . $relatedpost->post_title . '</a></li>';//可自定义样式
		        $i++;
		    }
		}
		if( $i < $num){//相同分类文章数量不够从相同标签获取
		    $tagsid = array();
		    $thisid[] = $post->ID;
		    $posttags = get_the_tags();
		    if( !empty( $posttags ) ) {
		        foreach( $posttags as $tag ) {
		            $tagsid[] = $tag->term_id;
		        }
		    }
		    $args = array(
		        'post_type' => 'post',
		        'post__not_in' => $thisid,
		        'ignore_sticky_posts' => 1,
		        'posts_per_page' => ( $num - $i ),
		        'tag__in' => $tagsid
		    );
		    $rsp = get_posts( $args );
		    foreach( $rsp as $relatedpost ){
		        $output .= '<li><a href="' . get_permalink( $relatedpost->ID ) . '" target="_blank">' . $relatedpost->post_title . '</a></li>';//可自定义样式
		        $i++;
		    }
		}
		$output = '<ul>' . $output . '</ul>';
		theme_wp_cache_set( get_the_ID().':'.md5(maybe_serialize(get_lastpostmodified())), $output, 'relatedpost', 24 * HOUR_IN_SECONDS );
    }
    return $output;
}

//使用flex 打造漂亮友情链接页面 https://fatesinger.com/78155
function get_the_link_items($id = null){
    $bookmarks = get_bookmarks('orderby=rating&order=DESC&category=' . $id);
    $output    = '';
    if (!empty($bookmarks)) {
        $output .= '<ul class="links_items">';
        foreach ($bookmarks as $bookmark) {
            	$output .= '<li class="links_lis"><a href="'.$bookmark->link_url.'" title="'.$bookmark->link_description.'" target="_blank" >'.$bookmark->link_name. '</a></li>';
    	}
        $output .= '</ul>';
    }
    return $output;
}

//系统信息 数据库查询次数 耗时 内存等
if ( !function_exists( 'sys_uptime' ) ) {
	function sys_uptime() {
		$output = sprintf(  '查询 %d 次，耗时 %.3f 秒，内存 %.2fMB',
							get_num_queries(),
							timer_stop( 0, 3 ),
							memory_get_peak_usage() / 1024 / 1024
				);
		if (false === ($str = @file("/proc/uptime"))) { return $output; }
		$output .= " VPS 连续运行：";
		$str = explode(" ", implode("", $str));
		$str = trim($str[0]);
		$min = $str / 60;
		$hours = $min / 60;
		$days = floor($hours / 24);
		$hours = floor($hours - ($days * 24));
		$min = floor($min - ($days * 60 * 24) - ($hours * 60));
		if ($days !== 0) { $output .= $days."天"; }
		if ($hours !== 0) { $output .= $hours."小时"; }
		if ($min !== 0) { $output .= $min."分钟"; }
		return $output;
	}
}

// 目录 - 水煮鱼 theme-toc
//内容中自动加入文章目录
add_filter('the_content',function($content){
	if( is_singular() ){
		global $toc_count;
		global $toc;
		$toc = array();
		$toc_count = 0;

		$regex = '#<h([2-4])(.*?)>(.*?)</h\1>#';

		$content = preg_replace_callback( $regex, function($content) {
			global $toc_count;
			global $toc;
			$toc_count ++;

			$toc[] = array('text' => trim(strip_tags($content[3])), 'depth' => $content[1], 'count' => $toc_count);

			return "<h{$content[1]} {$content[2]}><a name=\"toc-{$toc_count}\"></a>{$content[3]}</h{$content[1]}>";
		}, $content);

		if( $toc_count ){
			$catalog = theme_get_toc( $location = 'catalog' );
			$catalog = '<div id="toc_container" class="article_toc">
    						<div class="toc_title">文章目录 <span class="toc_toggle">「隐藏」</span></div>'
    						.$catalog.
						'</div>';
			$content = $catalog.$content;
		}
		//防被镜像，文末加入本文链接
		$content .= '<div class="ohmygod">本文首发于：<a href="'.esc_url( get_permalink() ).'" rel="bookmark">'.get_the_title().'-'.get_bloginfo('name').'</a></div>';
	}
	return $content;
});


// 根据 $TOC 数组输出文章目录 HTML 代码 
function theme_get_toc( $location = 'catalog' ){
	global $toc;
	$index = theme_wp_cache_get( get_the_ID().':'.md5(maybe_serialize(get_lastpostmodified())), 'cache-'.$location );

	if( $index === false && $toc ){
		$index = '<ol class="toc_list '.$location.'">'."\n";
		$prev_depth='';
		$to_depth = 0;

		foreach( $toc as $toc_item ){
			$toc_depth = $toc_item['depth'];
			if($prev_depth){
				if($toc_depth == $prev_depth){
					$index .= '</li>'."\n";
				}elseif($toc_depth > $prev_depth){
					$to_depth++;
					$index .= '<ol>'."\n";
				}else{
					$to_depth2 = ( $to_depth > ($prev_depth - $toc_depth) )? ($prev_depth - $toc_depth) : $to_depth;
					if($to_depth2){
						for ($i=0; $i<$to_depth2; $i++){
							$index .= '</li>'."\n".'</ol>'."\n";
							$to_depth--;
						}
					}
					$index .= '</li>';
				}
			}
			$index .= '<li><a title="'.$toc_item['text'].'" href="#toc-'.$toc_item['count'].'">'.$toc_item['text'].'</a>';
			$prev_depth = $toc_item['depth'];
		}

		for( $i=0; $i<=$to_depth; $i++ ){
			$index .= '</li>'."\n".'</ol>'."\n";
		}
		theme_wp_cache_set( get_the_ID().':'.md5(maybe_serialize(get_lastpostmodified())), $index, 'cache-'.$location, 24 * HOUR_IN_SECONDS );
	}

	return $index;
}
// 目录 - 水煮鱼 theme-toc end

// comments_popup_link() 加上  nofollow
function add_nofollow_to_comments_popup_link(){
    return ' rel="nofollow" ';
}
add_filter('comments_popup_link_attributes', 'add_nofollow_to_comments_popup_link');

// 分类ID
function show_id() {
	global $wpdb;
	$request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
	$request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
	$request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
	$request .= " ORDER BY term_id asc";
	$categorys = $wpdb->get_results($request);
	foreach ($categorys as $category) { 
		$output = '<ol class="show-id">' . $category->name . '<span>' . $category->term_id . '</span></ol>';
		echo $output;
	}
}
//分类、归档页面不显示私密文章
//https://wpml.org/forums/topic/since-update-wp-6-0-menus-are-messed-up-und-untranslatetable/#post-11372711
//add_action( 'pre_get_posts', function($query) { if ($query->get('post_type') === 'nav_menu_item') { $query->set('tax_query',''); } } );
function theme_search_filter( $query ) {
	if( is_admin() || is_home() || is_front_page() || is_singular() || ($query->get('post_type') === 'nav_menu_item') ){
		return $query;
	}
	if ( $query->is_search || $query->is_archive ) {
		$query->set( 'post_status', 'publish' );
		$query->set( 'post_type', array( 'post', 'page' ) );//归档页面 包含 页面 page
		$query->set( 'orderby', 'modified');
		//$query->set( 'posts_per_page', 15 ); //分类、搜索等页面文章数量不一样
	}
	return $query;
}
add_filter( 'pre_get_posts', 'theme_search_filter' );
//上一篇 下一篇不显示私密文章
add_filter( 'get_previous_post_where', 'theme_mod_adjacent' );
add_filter( 'get_next_post_where', 'theme_mod_adjacent' );
function theme_mod_adjacent( $where ) {
    return $where .= " AND p.post_status = 'publish'";
}
//管理员工具条添加一个简单的菜单
if ( !function_exists( 'custom_adminbar_menu' ) ) {
	function custom_adminbar_menu ( $meta = TRUE ) {
		global $wp_admin_bar;
		if ( !is_user_logged_in() ) { return; }
		if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }
		$menu_id = 'admin_bar_custom_menu';
	    $wp_admin_bar->add_menu(
			array(
				'id' => $menu_id,
				'title' => __( '设置' ),
				'href' => admin_url( 'themes.php?page=ox-theme' ),
				'meta'  => array( 'title' => '主题选项设置', 'target' => '_blank' ),
			)
	    );
		$wp_admin_bar->add_menu(
			array(
				'id'     => 'draft_id_by_asc',
				'title'  => __( '草稿' ),
				'href'   => admin_url( 'edit.php?post_status=draft&post_type=post&orderby=ID&order=asc' ),
				'meta'  => array( 'title' => '草稿按 ID 升序排序', 'target' => '_blank' ),
			)
		);
		$wp_admin_bar->remove_node('wp-logo'); //Removes WP logo
        //$wp_admin_bar->remove_node('site-name'); //Removes site name
        //$wp_admin_bar->remove_node('comments'); //Removes comments
        //$wp_admin_bar->remove_node('updates'); //Removes updates
        $wp_admin_bar->remove_node('customize'); //Removes the customizer
        $wp_admin_bar->remove_node('new-content'); //Removes Add new
        $wp_admin_bar->remove_node('search'); //Removes the search 
        //$wp_admin_bar->remove_node('my-account'); //Removes user menu
	}
}
add_action( 'admin_bar_menu', 'custom_adminbar_menu', 100 );
//WordPress 前台和后台指定不同 favicon（网站图标）
//https://0xo.net/1209/
if ( !function_exists( 'wp_admin_favicon' ) ) {
	function wp_admin_favicon() {
		if ( ox_get_option( 'custom_favicon_admin' ) ) {
			echo ox_get_option( 'custom_favicon_admin' );
		} else {
			echo '<link rel="shortcut icon" href="'.get_bloginfo( "template_directory" ).'/images/favicon.ico">';
		}
	}
}
add_action( 'admin_head', 'wp_admin_favicon' );

//WordPress 站点图标 site_icon hook
//function theme_filter_get_site_icon_url( $url, $size, $blog_id ) {
//	if( ox_get_option( 'custom_site_icon_hook' ) ){
//		$url = ox_get_option( 'custom_site_icon_hook' );
//	}
//    return $url;
//}
//add_filter( 'get_site_icon_url', 'theme_filter_get_site_icon_url', 10, 3 ); 

//修改自带标签云widget字体大小
function twentytwelve_widget_tag_cloud_args( $args ) {
	$args['largest']  = 18;
	$args['smallest'] = 6;
	$args['number'] = 32;
	$args['unit']     = 'pt';
	$args['format']   = 'flat';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentytwelve_widget_tag_cloud_args' );

//标签云 tag 新标签页打开
add_filter('wp_tag_cloud', 'blank_wp_tag_cloud');
function blank_wp_tag_cloud( $text ) {
	return str_replace( '<a href=', '<a target="_blank" href=', $text );
}

//给 the_tags() 新标签页打开
add_filter('the_tags', 'blank_wp_the_tags');
function blank_wp_the_tags( $text ) {
	return str_replace( 'rel="tag"', 'target="_blank" rel="tag"', $text );
}
//https://developer.wordpress.org/reference/functions/get_the_archive_title/
function my_theme_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '分类：', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '标签：', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'my_theme_archive_title' );

// 彻底禁用 feed 需保存一次固定链接
function disable_all_feeds() {
	wp_redirect( home_url( '/1/' ), 302 );
    exit();
	//wp_die(__('<h1>本博客不提供Feed，请访问网站<a href="'.get_bloginfo('url').'">首页</a>！</h1>'));
}
if( ox_get_option( 'feed_rss_enable' ) ){
	add_action('do_feed', 'disable_all_feeds', 1);
	add_action('do_feed_rdf', 'disable_all_feeds', 1);
	add_action('do_feed_rss', 'disable_all_feeds', 1);
	add_action('do_feed_rss2', 'disable_all_feeds', 1);
	add_action('do_feed_atom', 'disable_all_feeds', 1);
	// RSS头部冗余代码
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
} else {
	// RSS头部冗余代码
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
}
// 后台禁用Google Open Sans字体，加速网站
add_filter('gettext_with_context', 'disable_open_sans', 888, 4 );
function disable_open_sans( $translations, $text, $context, $domain ){
    if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
        $translations = 'off';
    }
    return $translations;
}

//To add the last modifed date to your XML sitemap, Google wants the date in W3C format.
//https://developer.wordpress.org/reference/hooks/wp_sitemaps_posts_entry/#comment-5158
add_filter( 'wp_sitemaps_posts_entry', function( $entry, $post ) {
	$entry['lastmod'] = date( DATE_W3C, strtotime( $post->post_modified_gmt ) );//DATE_W3C = 'Y-m-d\TH:i:sO'
	$entry['changefreq'] = 'Daily';
	$entry['priority'] = '0.6';
	return $entry;
}, 10, 2 );
//wp_sitemaps 单个文件突破 2000 限制
add_filter( 'wp_sitemaps_max_urls', 'theme_wp_sitemaps_max_urls' );
function theme_wp_sitemaps_max_urls(){
    return 3333;
}

//Add dashboard widgets 后台侧栏
if ( ! function_exists( 'add_dashboard_widgets' ) ) :
	function admin_info_dashboard_widget_function() {
		echo '当前IP：'.theme_get_ip_address().'<br />';
		echo '最近更新时间：'.date( 'Y年n月j日 H:i:s', strtotime( get_lastpostmodified('blog') ) ).'<br />';
		echo 'Site：<a href="https://www.google.com/search?q=site:'.non_www_domain( home_url('/') ).'" target="_blank" rel="nofollow">Google</a>';
		echo '、<a href="https://www.bing.com/search?q=site:'.non_www_domain( home_url('/') ).'" target="_blank" rel="nofollow">Bing</a>';
		echo '、<a href="https://www.baidu.com/s?wd=site:'.non_www_domain( home_url('/') ).'" target="_blank" rel="nofollow">百度</a>';
		echo '、<a href="/wp-admin/edit.php?post_status=draft&post_type=post&orderby=ID&order=asc">草稿</a><br />';
	}
	function add_dashboard_widgets() {
		wp_add_dashboard_widget('admin_info_dashboard_widget', '统计信息', 'admin_info_dashboard_widget_function');
	}
	add_action('wp_dashboard_setup', 'add_dashboard_widgets' );
endif;

/**
 * Disable the emoji's
 */
// Remove query string from static files 去除静态资源的版本号
function remove_cssjs_ver( $src ) {
	if( strpos( $src, '?ver='.get_bloginfo( 'version' ) ) ){
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}
	return array();
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param  array  $urls          URLs to print for resource hints.
 * @param  string $relation_type The relation type the URLs are printed for.
 * @return array                 Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		// Strip out any URLs referencing the WordPress.org emoji location
		$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
		foreach ( $urls as $key => $url ) {
			if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
				unset( $urls[$key] );
			}
		}

	}
	return $urls;
}

// 禁用工具栏
//show_admin_bar(false);
if ( ! current_user_can( 'manage_options' ) ) {
	show_admin_bar( false );
}

// 后台样式
function admin_style(){
	echo'<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style type="text/css">
       .wp-list-table pre { overflow:auto;}
       .column-views { width: 6%; }
    </style>';
}
add_action('admin_head', 'admin_style');

// 头部冗余代码
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

// 去掉描述P标签
function deletehtml($description) {
	$description = trim($description);
	$description = strip_tags($description,"");
	return ($description);
}

// 后台可按照作者筛选文章
add_action('restrict_manage_posts', function($post_type){
    if(post_type_supports($post_type, 'author')){
    	if(version_compare($GLOBALS['wp_version'], '5.9', '<')){
	        wp_dropdown_users([
	            'name'                      => 'author',
	            'who'                       => 'authors',
	            'show_option_all'           => '所有作者',
	            'hide_if_only_one_author'   => true,
	            'selected'                  => $_REQUEST['author'] ?? 0
	        ]);
	    } else {
	    	wp_dropdown_users([
	            'name'                      => 'author',
	            'capability'                => 'edit_posts',
	            'show_option_all'           => '所有作者',
	            'hide_if_only_one_author'   => true,
	            'selected'                  => $_REQUEST['author'] ?? 0
	        ]);
	    }
    }
});

// 移除管理界面配色方案
remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");

// 禁止代码标点转换
remove_filter( 'the_content', 'wptexturize' );

//彻底关闭 pingback
add_filter('xmlrpc_methods',function($methods){
	$methods['pingback.ping'] = '__return_false';
	$methods['pingback.extensions.getPingbacks'] = '__return_false';
	return $methods;
});

//禁用 pingbacks, enclosures, trackbacks
remove_action( 'do_pings', 'do_all_pings', 10 );

//去掉 _encloseme 和 do_ping 操作。
remove_action( 'publish_post','_publish_post_hook',5 );


// 禁止评论超链接
remove_filter('comment_text', 'make_clickable', 9);

//禁止 WordPress 头部加载 s.w.org
function remove_dns_prefetch( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		return array_diff( wp_dependencies_unique_hosts(), $hints );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

//WordPress 技巧：彻底关闭 WordPress 自动更新和后台更新检查 https://blog.wpjam.com/m/disable-wordpress-auto-update/
add_filter('automatic_updater_disabled', '__return_true');  // 彻底关闭自动更新

remove_action('init', 'wp_schedule_update_checks'); // 关闭更新检查定时作业
wp_clear_scheduled_hook('wp_version_check');            // 移除已有的版本检查定时作业
wp_clear_scheduled_hook('wp_update_plugins');       // 移除已有的插件更新定时作业
wp_clear_scheduled_hook('wp_update_themes');            // 移除已有的主题更新定时作业
wp_clear_scheduled_hook('wp_maybe_auto_update');        // 移除已有的自动更新定时作业

remove_action( 'admin_init', '_maybe_update_core' );        // 移除后台内核更新检查

remove_action( 'load-plugins.php', 'wp_update_plugins' );   // 移除后台插件更新检查
remove_action( 'load-update.php', 'wp_update_plugins' );
remove_action( 'load-update-core.php', 'wp_update_plugins' );
remove_action( 'admin_init', '_maybe_update_plugins' );

remove_action( 'load-themes.php', 'wp_update_themes' );     // 移除后台主题更新检查
remove_action( 'load-update.php', 'wp_update_themes' );
remove_action( 'load-update-core.php', 'wp_update_themes' );
remove_action( 'admin_init', '_maybe_update_themes' );

/**
 * Disable embeds - WordPress 4.4版本以后禁用wp-embed的正确方法 http://themebetter.com/wordpress-embed-kill.html
 * https://www.wppagebuilders.com/disable-embeds-in-wordpress/
 */
// Disable auto-embeds for WordPress >= v3.5
//https://wpengineer.com/2487/disable-oembed-wordpress/
remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
function disable_embeds_code_init() {
 // Remove the REST API endpoint.
 remove_action( 'rest_api_init', 'wp_oembed_register_route' );
 // Turn off oEmbed auto discovery.
 add_filter( 'embed_oembed_discover', '__return_false' );
 // Don't filter oEmbed results.
 remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
 // Remove oEmbed discovery links.
 remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
 // Remove oEmbed-specific JavaScript from the front-end and back-end.
 remove_action( 'wp_head', 'wp_oembed_add_host_js' );
 add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
 // Remove all embeds rewrite rules.
 add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
 // Remove filter of the oEmbed result before any HTTP requests are made.
 remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}
add_action( 'init', 'disable_embeds_code_init', 9999 );
function disable_embeds_tiny_mce_plugin($plugins) {
    return array_diff($plugins, array('wpembed'));
}
function disable_embeds_rewrites($rules) {
    foreach($rules as $rule => $rewrite) {
        if(false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}
function my_deregister_scripts(){
	wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

//WordPress 5.0 去除 Gutenberg（古腾堡） 编辑器
add_filter( 'use_block_editor_for_post', '__return_false', 999 );
remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );
remove_action( 'admin_menu', 'gutenberg_menu' );
remove_action( 'admin_init', 'gutenberg_redirect_demo' );
// Gutenberg 5.3+
remove_action( 'wp_enqueue_scripts', 'gutenberg_register_scripts_and_styles' );
remove_action( 'admin_enqueue_scripts', 'gutenberg_register_scripts_and_styles' );
remove_action( 'admin_notices', 'gutenberg_wordpress_version_notice' );
remove_action( 'rest_api_init', 'gutenberg_register_rest_widget_updater_routes' );
remove_action( 'admin_print_styles', 'gutenberg_block_editor_admin_print_styles' );
remove_action( 'admin_print_scripts', 'gutenberg_block_editor_admin_print_scripts' );
remove_action( 'admin_print_footer_scripts', 'gutenberg_block_editor_admin_print_footer_scripts' );
remove_action( 'admin_footer', 'gutenberg_block_editor_admin_footer' );
remove_action( 'admin_enqueue_scripts', 'gutenberg_widgets_init' );
remove_action( 'admin_notices', 'gutenberg_build_files_notice' );
remove_filter( 'load_script_translation_file', 'gutenberg_override_translation_file' );
remove_filter( 'block_editor_settings', 'gutenberg_extend_block_editor_styles' );
remove_filter( 'default_content', 'gutenberg_default_demo_content' );
remove_filter( 'default_title', 'gutenberg_default_demo_title' );
remove_filter( 'block_editor_settings', 'gutenberg_legacy_widget_settings' );
remove_filter( 'rest_request_after_callbacks', 'gutenberg_filter_oembed_result' );
//WordPress 5.8 Restoring the classic Widgets Editor disable the new Widgets Block Editor.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

//移除头部global-styles-inline-css
add_action( 'wp_print_styles', function(){
	wp_deregister_style('global-styles');
} );

//禁用WordPress Site Health（网站健康）检测项
function theme_remove_site_health( $tests ) {
	unset( $tests['direct']['php_version'] );
	unset( $tests['direct']['wordpress_version'] );
	unset( $tests['direct']['plugin_version'] );
	unset( $tests['direct']['theme_version'] );
	unset( $tests['direct']['sql_server'] );
	unset( $tests['direct']['php_extensions'] );
	unset( $tests['direct']['utf8mb4_support'] );
	unset( $tests['direct']['https_status'] );
	unset( $tests['direct']['ssl_support'] );
	unset( $tests['direct']['scheduled_events'] );
	unset( $tests['direct']['http_requests'] );
	unset( $tests['direct']['is_in_debug_mode'] );
	unset( $tests['direct']['dotorg_communication'] );
	unset( $tests['direct']['background_updates'] );
	unset( $tests['direct']['loopback_requests'] );
    unset( $tests['direct']['rest_availability'] );
	return $tests;
}
add_filter( 'site_status_tests', 'theme_remove_site_health' );

//修正 AMP image logo 错误
function theme_amp_modify_json_metadata( $metadata, $post ) {
	global $post;
	$author_id = $post->post_author;
	if (!array_key_exists('image', $metadata)) {
		$metadata['image'] = array(
			'@type' => 'ImageObject',
			'url' => get_content_first_image( get_the_content() ),
		);
	}
	$metadata['author'] = [
		'@type' => 'Person',
		'url' => get_author_posts_url( $author_id ),
		'name'  => get_the_author_meta('display_name', $author_id),
	];
	if( ox_get_option( 'custom_site_icon_hook' ) ){
		$metadata['publisher']['logo'] = [
			'@type' => 'ImageObject',
			'url'   => ox_get_option( 'custom_site_icon_hook' ),
		];
	}
	return $metadata;
}
add_filter( 'amp_post_template_metadata', 'theme_amp_modify_json_metadata', 10, 2 );

// Google 广告相关
if ( ! function_exists( 'check_ad_enabled' ) ) {
	function check_ad_enabled() {
		if ( is_user_logged_in() ) {
			return false;
		}
		global $post;
		if( !empty( $post ) ){
			$google_ec_post_page_ids = explode(',', ox_get_option( 'google_ec_post_page_ids' ) );
			$ecid = $post->ID;
			if ( in_array( $ecid, $google_ec_post_page_ids ) ){
				return false;
			}
			return ox_get_option( 'google_ads_enable' );
		}
	}
}
//在文章内容 第1段 后面插入指定内容和广告
add_filter( 'the_content', 'theme_insert_p_n_ads', 99);
function theme_insert_p_n_ads( $content ) {
	if ( is_singular() && ox_get_option( 'article_info_head' ) ) {
		$closing_p = '</p>';
		$paragraph_id = 1; //第一段后插入提示信息+广告
		$paragraphs = explode( $closing_p, $content );
		foreach ( $paragraphs as $index => $paragraph ) {
			if ( trim( $paragraph ) ) {
				$paragraphs[$index] .= $closing_p;
			}
			if ( $paragraph_id == $index + 1 ) {//第一段后插入提示信息+广告
				if( check_ad_enabled() && ox_get_option( 'google_ads_single_first' ) ){
					$paragraphs[$index] .= '<p class="google_ads_single_first">'.ox_get_option( 'google_ads_single_first' ).'</p><div class="article_info_head">'.ox_get_option( 'article_info_head' ).'</div>';
				} else {
					$paragraphs[$index] .= '<p class="article_info_head">'.ox_get_option( 'article_info_head' ).'</p>';
				}
			}
		}
		return implode( '', $paragraphs );
	} else {
		return $content;
	}
}
//在文章内容 最后一段前面插入广告
function ads_added_above_last_p( $text ) {
    if ( is_single() && check_ad_enabled() && ox_get_option( 'google_ads_single_last' ) ) {
        if( $pos1 = strrpos( $text, '<p>' ) ){
            $text1 = substr( $text, 0, $pos1 );
            $text2 = substr( $text, $pos1 );
            $text = $text1 . '<p class="google_ads_single_last">'.ox_get_option( 'google_ads_single_last' ).'</p>' . $text2;
        }
	}
    return $text;
}
add_filter('the_content', 'ads_added_above_last_p', 99);
// Google 广告相关 - End

function theme_get_ip_address(){
    $ip = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ip = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = 'UNKNOWN';
    return $ip;
}
//搜索优化 当搜索结果/分类/标签/归档/作者/只有一篇时直接重定向到该文章
function redirect_single_post() {
	if ( ( is_search() || is_archive() || is_category() || is_tag() || is_author() ) && get_query_var('module') == '' ) {
		if( is_search() && empty($GLOBALS['wp_query']->query['s']) ){
			wp_redirect(home_url());
		}else{
			$paged	= get_query_var('paged');
			if ($GLOBALS['wp_query']->post_count == 1 && empty($paged)) {
				wp_redirect(get_permalink($GLOBALS['wp_query']->posts['0']->ID));
			}
		}
	}
}
function esc_search_captcha( $query, $error = true ) {
	if ( is_search() && !current_user_can('manage_options') ) {
		if ( ! isset( $_COOKIE['esc_search_captcha'] ) ) {
			$query->is_search = false;
			$query->query_vars['s'] = false;
			$query->query['s'] = false;
 
			if ( $error == true ){
				//$query->is_404 = true;
				if ( isset( $_POST['result'] ) ) {
					if ( $_POST['result'] == $_COOKIE['result'] ) {
						$_COOKIE['esc_search_captcha'] = 1;
						setcookie('esc_search_captcha',1,0,'/');
						echo '<script>location.reload();</script>';
					}
				}
 
				$num1 = rand(2,22);
				$num2 = rand(3,33);
				$result = $num1+$num2;
				$_COOKIE['result'] = $result;
				setcookie('result',urldecode($result),0,'/');
			?>
 
				<html>
				<head>
				<meta charset="UTF-8">
				<title>人机验证</title>
				<style>
				body{color: #333;text-align: center;font-size: 16px;}
				.erphp-search-captcha{margin: 50px auto 15px;max-width: 250px;width: 100%;padding: 40px 20px;border: 2px solid #f90;text-align: center;border-radius: 5px;}
				.erphp-search-captcha form{margin: 0}
				.erphp-search-captcha input{border: none;border-bottom: 1px solid #666;width: 50px;text-align: center;font-size: 16px;}
				.erphp-search-captcha input:focus{outline: none;}
				.erphp-search-captcha button{border: none;background: transparent;color: #ff5f33;cursor: pointer;}
				.erphp-search-captcha button:focus{outline: none;}
				a{font-size: 20px;}
				</style>
				</head>
				<body>
				<div class="erphp-search-captcha">
				<form action="" method="post"><?php echo $num1;?> + <?php echo $num2;?> = <input type="text" name="result" required /> <button type="submit">验证</button></form>
				</div>
				<a href="<?php echo home_url();?>">返回首页</a>
				</body>
				</html>
				<?php
				exit;
			}
		}
	}
}
if( !is_admin() ){
	add_action( 'template_redirect', 'redirect_single_post' );
	add_action( 'parse_query', 'esc_search_captcha' );
}
//防止用户名暴露 https://blog.wpjam.com/m/hide-wordpress-user-login/
//user_login 不出现在作者的文章列表链接中
//如果用户的 user_nicename 和 user_login 是一样的情况下：作者文章链接使用 author_id 代替 user_nicename。
add_filter('author_link', function($link, $author_id, $author_nicename){
	$author	= get_userdata($author_id);
	if(sanitize_title($author->user_login) == $author_nicename){
		global $wp_rewrite;

		$link	= $wp_rewrite->get_author_permastruct();
		$link	= str_replace('%author%', $author_id, $link);
		$link	= home_url(user_trailingslashit($link));
	}
	return $link;
}, 10, 3);

//原来的作者链接直接设置为 404 页面，防止用户名暴露。
add_action('pre_get_posts',  function($wp_query) {
	if($wp_query->is_main_query() && $wp_query->is_author()){
		if($author_name = $wp_query->get('author_name')){
			$author_name	= sanitize_title_for_query($author_name);
			$author			= get_user_by('slug', $author_name);
			if($author){
				if(sanitize_title($author->user_login) == $author->user_nicename){
					$wp_query->set_404();
				}
			}else{
				if(is_numeric($author_name)){
					$wp_query->set('author_name', '');
					$wp_query->set('author', $author_name);
				}
			}
		}
	}
});

//user_login 不出现在 body_class 中
add_filter('body_class', function($classes){
	if(is_author()){
		global $wp_query;
		$author	= $wp_query->get_queried_object();
		if(sanitize_title($author->user_login) == $author->user_nicename){
			$author_class	= 'author-'.sanitize_html_class($author->user_nicename, $author->ID);
			$classes		= array_diff($classes, [$author_class]);
		}
	}
	return $classes;
});

//user_login 不出现在 comment_class 中
add_filter('comment_class', function ($classes){
	foreach($classes as $key => $class) {
		if(strstr($class, 'comment-author-')){
			unset($classes[$key]);
		}
	}
	return $classes;
});

//获取文章最新评论时间 seo
if ( ! function_exists( 'theme_the_post_latest_comment_time' ) ) {
	function theme_the_post_latest_comment_time( $postid ) {
		global $post;
		$postid = $postid ?: $post->ID;
		$args = array(
			'number' => '1',
			'post_id' => $postid
		);
		$comments = get_comments($args);
		if( $comments != false ){
			return mysql2date( 'Y-n-d\TH:i:s+08:00', $comments[0]->comment_date, true );
		} else {
			return get_the_modified_time( 'Y-n-d\TH:i:s+08:00', $postid );
		}
	}
}

// WordPress 后台复制文章 https://zmingcx.com/duplicate-post-in-wordpress.html
function theme_clone_post_as_draft() {
	global $wpdb;
	if ( !( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'theme_clone_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to clone has been supplied!');
	}
 
	//  Nonce 验证
	if ( !isset( $_GET['clone_nonce'] ) || !wp_verify_nonce( $_GET['clone_nonce'], basename( __FILE__ ) ) ){
		return;
	}
 
	// 获取原文章ID
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
 
	// 所有文章数据
	$post = get_post( $post_id );
 
	// 如果不希望当前用户作为新文章作者，将下两行替换为$new_post_author = $post->post_author;
	//$current_user = wp_get_current_user();
	//$new_post_author = $current_user->ID;
	$new_post_author = $post->post_author;
 
	// 如果发布数据存在，则创建发布克隆
	if (isset( $post ) && $post != null) {
		// 创建新文章数组
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
		// 通过wp_insert_post() 函数添加文章
		$new_post_id = wp_insert_post( $args );
		// 将新的文章设置为草稿
		$taxonomies = get_object_taxonomies($post->post_type); // 返回文章类型的分类数组，例如：array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
		// 查询复制所有文章信息 post meta
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
		wp_redirect( admin_url( 'edit.php?post_type='.$post->post_type ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_theme_clone_post_as_draft', 'theme_clone_post_as_draft' );
// 复制文章并添加到列表
function theme_clone_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		//$actions['clone'] = '<a href="' . wp_nonce_url('admin.php?action=theme_clone_post_as_draft&post=' . $post->ID, basename(__FILE__), 'clone_nonce' ) . '" title="Clone this '.$post->post_type.'" rel="permalink">复制</a>';
		//复制 替换 快速编辑
		$actions['inline hide-if-no-js'] = '<a href="' . wp_nonce_url('admin.php?action=theme_clone_post_as_draft&post=' . $post->ID, basename(__FILE__), 'clone_nonce' ) . '" title="复制文章 / 页面" rel="permalink">复制</a>';
	}
	return $actions;
}
add_filter( 'post_row_actions', 'theme_clone_post_link', 10, 2 );
add_filter( 'page_row_actions', 'theme_clone_post_link', 10, 2 );


//FastCGI Cache 缓存清理 - start
if(ox_get_option( 'post_views_fastcgi_cache' )){
	/**
	* WordPress Nginx FastCGI缓存清理代码(Nginx-Helper纯代码版) By 张戈博客
	* 文章地址：https://zhang.ge/5112.html
	*/
	 
	//初始化配置
	$logSwitch  = 1;                  //配置日志开关，1为开启，0为关闭
	$logFile    = '/var/run/nginx-cache/purge.log';   //配置日志路径
	$cache_path = '/var/run/nginx-cache';     //配置缓存路径
	 
	//清理所有缓存(仅管理员) 范例：http://www.domain.com/?clr=all
	if ( isset( $_GET['clr'] ) && is_admin() ) {
		if( $_GET['clr'] == 'all' ){
			delDirAndFile($cache_path, 0);
		}
	}
	 
	//缓存清理选项
	//add_action('publish_post', 'Clean_By_Publish', 99); //文章发布、更新清理缓存
	add_action('save_post', 'Clean_By_Publish', 99); //页面修改更新清理缓存
	add_action('comment_post', 'Clean_By_Comments',99); //评论提交清理缓存(不需要可注释)
	add_action('comment_unapproved_to_approved', 'Clean_By_Approved',99); //评论审核清理缓存(不需要可注释)
	//add_action('transition_comment_status', 'Clean_By_Approved',99); //评论审核清理缓存(不需要可注释)
	 
	//文章发布清理缓存函数
	function Clean_By_Publish($post_ID){
	    $url = get_permalink($post_ID);
	 
	    cleanFastCGIcache($url);        //清理当前文章缓存
	    cleanFastCGIcache($url.'?amp=1');        //清理当前文章缓存
	    cleanFastCGIcache(home_url().'/');  //清理首页缓存(不需要可注释此行)
	    cleanFastCGIcache(home_url().'/archives/');  //清理归档页缓存(不需要可注释此行)
	        
	    //清理文章所在分类缓存(不需要可注释以下5行)
	    if ( $categories = wp_get_post_categories( $post_ID ) ) {
	        foreach ( $categories as $category_id ) {
	            cleanFastCGIcache(get_category_link( $category_id ));
	        }
	    }
	 
	    //清理文章相关标签页面缓存(不需要可注释以下5行)
	    if ( $tags = get_the_tags( $post_ID ) ) {
	        foreach ( $tags as $tag ) {
		    cleanFastCGIcache( get_tag_link( $tag->term_id ));
	        }
	    }
	}
	 
	// 评论发布清理文章缓存
	function Clean_By_Comments($comment_id){
	    $comment  = get_comment($comment_id);
	    $url      = get_permalink($comment->comment_post_ID);
	    cleanFastCGIcache($url);
		cleanFastCGIcache(home_url().'/');  //清理首页缓存(不需要可注释此行)
	}
	 
	// 评论审核通过清理文章缓存
	function Clean_By_Approved($comment)
	{
	    $url      = get_permalink($comment->comment_post_ID); 
	    cleanFastCGIcache($url);
		cleanFastCGIcache(home_url().'/');  //清理首页缓存(不需要可注释此行)
	}
	 
	//日志记录
	function purgeLog($msg)
	{
	    global $logFile, $logSwitch;
	    if ($logSwitch == 0 ) return;
	    date_default_timezone_set('Asia/Shanghai');
	    file_put_contents($logFile, date('[Y-m-d H:i:s]: ') . $msg . PHP_EOL, FILE_APPEND);
	    return $msg;
	}
	 
	// 缓存文件删除函数
	function cleanFastCGIcache($url) {
	    $url_data  = parse_url($url);
	    global $cache_path;
	    if(!$url_data) {
	        return purgeLog($url.' is a bad url!' );
	    }
	 
	    $hash        = md5($url_data['scheme'].'GET'.$url_data['host'].$url_data['path']);
	    $cache_path  = (substr($cache_path, -1) == '/') ? $cache_path : $cache_path.'/';
	    $cached_file = $cache_path . substr($hash, -1) . '/' . substr($hash,-3,2) . '/' . $hash;
	    
	    if (!file_exists($cached_file)) {
	        return purgeLog($url . " is currently not cached (checked for file: $cached_file)" );
	    } else if (unlink($cached_file)) {
	        return purgeLog( $url." *** CLeanUP *** (cache file: $cached_file)");
	    } else {
	        return purgeLog("- - An error occurred deleting the cache file. Check the server logs for a PHP warning." );
	    }
	}
	 
	/**
	 * 删除目录及目录下所有文件或删除指定文件
	 * 代码出自ThinkPHP：http://www.thinkphp.cn/code/1470.html
	 * @param str $path   待删除目录路径
	 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
	 * @return bool 返回删除状态
	 */
	function delDirAndFile($path, $delDir = FALSE) {
	    $handle = opendir($path);
	    if ($handle) {
	        while (false !== ( $item = readdir($handle) )) {
	            if ($item != "." && $item != "..")
	                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
	        }
	        closedir($handle);
	        if ($delDir)
	            return rmdir($path);
	    }else {
	        if (file_exists($path)) {
	            return unlink($path);
	        } else {
	            return FALSE;
	        }
	    }
	}
}
//FastCGI Cache 缓存清理 - end
// 全部结束

/*
 * 输出全站字数，并匹配书籍
 * 原作者：林木木
 * 修改者：胡鹤仙&ChatGPT
 */
function allwords() {
    global $wpdb;
    $chars = 0;
    $results = $wpdb->get_results("SELECT post_content FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'post'");
    foreach ($results as $result) { $chars += mb_strlen(trim($result->post_content), 'UTF-8'); }
    if($chars<50000){
    echo '全站共 '.$chars.' 字，还在努力更新中..加油！加油啦！';}
    elseif ($chars<70000 && $chars>50000){
    echo '全站共 '.$chars.' 字，写完一本埃克苏佩里的《小王子》了！';}
    elseif ($chars<90000 && $chars>70000){
    echo '全站共 '.$chars.' 字，写完一本鲁迅的《呐喊》了！';}
    elseif ($chars<100000 && $chars>90000){
    echo '全站共 '.$chars.' 字，写完一本林海音的《城南旧事》了！';}
    elseif ($chars<110000 && $chars>100000){
    echo '全站共 '.$chars.' 字，写完一本马克·吐温的《王子与乞丐》了！';}
    elseif ($chars<120000 && $chars>110000){
    echo '全站共 '.$chars.' 字，写完一本鲁迅的《彷徨》了！';}
    elseif ($chars<130000 && $chars>120000){
    echo '全站共 '.$chars.' 字，写完一本余华的《活着》了！';}
    elseif ($chars<140000 && $chars>130000){
    echo '全站共 '.$chars.' 字，写完一本曹禺的《雷雨》了！';}
    elseif ($chars<150000 && $chars>140000){
    echo '全站共 '.$chars.' 字，写完一本史铁生的《宿命的写作》了！';}
    elseif ($chars<160000 && $chars>150000){
    echo '全站共 '.$chars.' 字，写完一本伯内特的《秘密花园》了！';}
    elseif ($chars<170000 && $chars>160000){
    echo '全站共 '.$chars.' 字，写完一本曹禺的《日出》了！';}
    elseif ($chars<180000 && $chars>170000){
    echo '全站共 '.$chars.' 字，写完一本马克·吐温的《汤姆·索亚历险记》了！';}
    elseif ($chars<190000 && $chars>180000){
    echo '全站共 '.$chars.' 字，写完一本沈从文的《边城》了！';}
    elseif ($chars<200000 && $chars>190000){
    echo '全站共 '.$chars.' 字，写完一本亚米契斯的《爱的教育》了！';}
    elseif ($chars<210000 && $chars>200000){
    echo '全站共 '.$chars.' 字，写完一本巴金的《寒夜》了！';}
    elseif ($chars<220000 && $chars>210000){
    echo '全站共 '.$chars.' 字，写完一本东野圭吾的《解忧杂货店》了！';}
    elseif ($chars<230000 && $chars>220000){
    echo '全站共 '.$chars.' 字，写完一本莫泊桑的《一生》了！';}
    elseif ($chars<250000 && $chars>230000){
    echo '全站共 '.$chars.' 字，写完一本简·奥斯汀的《傲慢与偏见》了！';}
    elseif ($chars<280000 && $chars>250000){
    echo '全站共 '.$chars.' 字，写完一本钱钟书的《围城》了！';}
    elseif ($chars<300000 && $chars>280000){
    echo '全站共 '.$chars.' 字，写完一本张炜的《古船》了！';}
    elseif ($chars<310000 && $chars>300000){
    echo '全站共 '.$chars.' 字，写完一本茅盾的《子夜》了！';}
    elseif ($chars<320000 && $chars>310000){
    echo '全站共 '.$chars.' 字，写完一本阿来的《尘埃落定》了！';}
    elseif ($chars<340000 && $chars>320000){
    echo '全站共 '.$chars.' 字，写完一本艾米莉·勃朗特的《呼啸山庄》了！';}
    elseif ($chars<350000 && $chars>340000){
    echo '全站共 '.$chars.' 字，写完一本雨果的《巴黎圣母院》了！';}
    elseif ($chars<400000 && $chars>350000){
    echo '全站共 '.$chars.' 字，写完一本东野圭吾的《白夜行》了！';}
    elseif ($chars<1000000 && $chars>400000){
    echo '全站共 '.$chars.' 字，写完一本我国的名著了！';}
    elseif ($chars>1000000){
    echo '全站共 '.$chars.' 字，已写一本列夫·托尔斯泰的《战争与和平》了！';}
}

//去除分类标志代码
 add_action( 'load-themes.php',  'no_category_base_refresh_rules');
 add_action('created_category', 'no_category_base_refresh_rules');
 add_action('edited_category', 'no_category_base_refresh_rules');
 add_action('delete_category', 'no_category_base_refresh_rules');
 function no_category_base_refresh_rules() {
     global $wp_rewrite;
     $wp_rewrite -> flush_rules();
 }
 add_action('init', 'no_category_base_permastruct');
 function no_category_base_permastruct() {
     global $wp_rewrite, $wp_version;
     if (version_compare($wp_version, '3.4', '<')) {         // For pre-3.4 support         $wp_rewrite -> extra_permastructs['category'][0] = '%category%';
     } else {
         $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
     }
 }
 // Add our custom category rewrite rules
 add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
 function no_category_base_rewrite_rules($category_rewrite) {
     //var_dump($category_rewrite); // For Debugging
     $category_rewrite = array();
     $categories = get_categories(array('hide_empty' => false));
     foreach ($categories as $category) {
         $category_nicename = $category -> slug;
         if ($category -> parent == $category -> cat_ID)// recursive recursion
             $category -> parent = 0;
         elseif ($category -> parent != 0)
             $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
         $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
         $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
         $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
     }
     // Redirect support from Old Category Base
     global $wp_rewrite;
     $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
     $old_category_base = trim($old_category_base, '/');
     $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
     //var_dump($category_rewrite); // For Debugging
     return $category_rewrite;
 }
 // Add 'category_redirect' query variable
 add_filter('query_vars', 'no_category_base_query_vars');
 function no_category_base_query_vars($public_query_vars) {
     $public_query_vars[] = 'category_redirect';
     return $public_query_vars;
 }
 // Redirect if 'category_redirect' is set
 add_filter('request', 'no_category_base_request');
 function no_category_base_request($query_vars) {
     //print_r($query_vars); // For Debugging
     if (isset($query_vars['category_redirect'])) {
         $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
         status_header(301);
         header("Location: $catlink");
         exit();
     }
     return $query_vars;
 }
 
 /*
*WordPress页面链接添加html后缀
*/
function html_page_permalink() {
global $wp_rewrite;
if ( !strpos($wp_rewrite->get_page_permastruct(), '.html')){
$wp_rewrite->page_structure = $wp_rewrite->page_structure . '.html';
}
}
add_action('init', 'html_page_permalink', -1);

// 字数统计
function zm_count_words ($text) {
	global $post;
	$output='';
	if (empty($text)) {
		$text = $post->post_content;
		if (mb_strlen($output, 'UTF-8') < mb_strlen($text, 'UTF-8')) $output .= '<span class="word-count">共' . mb_strlen(preg_replace('/\s/','',html_entity_decode(strip_tags($post->post_content))),'UTF-8') .'字</span>';
		return $output;
	}
}

//添加截取摘要汉字字数为200个  
function custom_excerpt_length( $length ) { 
     return 300;
}  
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//为摘要添加继续阅读字样
// Remove the ... from excerpt and change the text
function change_excerpt_more()
{
function new_excerpt_more($more)
{
// Use .read-more to style the link
return '......<span class="read-more"> <a href="' . get_permalink($post->ID) . '"><br/><br/>继续阅读&raquo;&raquo;&raquo;</a></span>';
}
add_filter('excerpt_more', 'new_excerpt_more');
}
add_action('after_setup_theme', 'change_excerpt_more');

// 评论添加@
function wp_comment_add_at( $comment_text, $comment = '') {
if( $comment->comment_parent > 0) {
$comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a>： ' . $comment_text;
}
return $comment_text;
}
add_filter( 'comment_text' , 'wp_comment_add_at', 20, 2);

//关闭翻译
add_filter('locale', function($locale) {
    $locale = ( is_admin() ) ? $locale : 'en_US';
    return $locale;
});

//添加站点统计小工具
include("widget-websitestat.php");
