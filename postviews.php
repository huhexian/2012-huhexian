<?php
/*
Postviews Modify: zwwooooo https://zww.me
Version：2.2.2
*/
if ( ! is_user_logged_in() ) {
	if ( ! ox_get_option( 'post_views_fastcgi_cache' ) ) { //没有缓存
		if ( !function_exists( 'process_postviews' ) ) {
			function process_postviews() {
				global $post;
				if( is_int( $post ) ) {
					$post = get_post( $post );
				}
				if( ! wp_is_post_revision( $post ) && ! is_preview() ) {
					if( is_single() || is_page() ) {
						$id = intval( $post->ID );
						if ( !$post_views = get_post_meta( $post->ID, 'views', true ) ) {
							$post_views = 0;
							add_post_meta( $id, 'views', 0, true);
						}
						update_post_meta( $id, 'views', ( $post_views + 1 ) );
					}
				}
			}
		}
		add_action( 'wp_head', 'process_postviews' );
	}

	if( ox_get_option( 'post_views_fastcgi_cache' ) ){ // CDN、开缓存wp-config.php开启缓存
		//缓存时更新浏览量-有缓存 http://www.capjsj.cn/ajax_cookies_views.html
		function postviews_cache(){
			if( empty( $_POST['postviews_id'] ) ) return;
			$post_ID = $_POST['postviews_id'];
			if( $post_ID > 0 ) {
				$post_views = (int)get_post_meta($post_ID, 'views', true);
				update_post_meta($post_ID, 'views', ( $post_views + 1 ));
				//没有开启 访客显示实际浏览数
				//开启 访客不显示浏览数
				if( !ox_get_option( 'post_views_guest_off' ) ){ 
					echo ( $post_views + 1 );
				}
				exit();
			}
		}
		add_action( 'wp_ajax_nopriv_postviews', 'postviews_cache' );
		add_action( 'wp_ajax_postviews', 'postviews_cache' );
	}
}
### Function: Round Numbers To K (Thousand), M (Million) or B (Billion)
if( ! function_exists( 'postviews_round_number' ) ) {
	function postviews_round_number( $number, $min_value = 1000, $decimal = 1 ) {
		if( $number < $min_value ) {
			return number_format_i18n( $number );
		}
		$alphabets = array( 1000000000 => 'B', 1000000 => 'M', 1000 => 'K' );
		foreach( $alphabets as $key => $value )
			if( $number >= $key ) {
				return round( $number / $key, $decimal ) . '' . $value;
			}
	}
}
### Function: Snippet Text
if(!function_exists('snippet_text')) {
	function snippet_text($text, $length = 0) {
		if (defined('MB_OVERLOAD_STRING')) {
		  $text = @html_entity_decode($text, ENT_QUOTES, get_option('blog_charset'));
			 if (mb_strlen($text) > $length) {
				return htmlentities(mb_substr($text,0,$length), ENT_COMPAT, get_option('blog_charset')).'...';
			 } else {
				return htmlentities($text, ENT_COMPAT, get_option('blog_charset'));
			 }
		} else {
			$text = @html_entity_decode($text, ENT_QUOTES, get_option('blog_charset'));
			 if (strlen($text) > $length) {
				return htmlentities(substr($text,0,$length), ENT_COMPAT, get_option('blog_charset')).'...';
			 } else {
				return htmlentities($text, ENT_COMPAT, get_option('blog_charset'));
			 }
		}
	}
}
if ( !function_exists( 'the_views' ) ) {
	function the_views( $display = true, $prefix = '', $postfix = '', $always = false ) {
		if( ox_get_option( 'post_views_guest_off' ) && !current_user_can('administrator') ){
			return '';//访客不显示浏览数
		} else {
			$post_views = intval( get_post_meta( get_the_ID(), 'views', true ) );
		}

		if ($post_views === '') {
			return '';
		} else {
			if ($display) {
				echo $prefix.postviews_round_number( $post_views ) . $postfix;
			} else {
				return $prefix.postviews_round_number( $post_views ) . $postfix;
			}
		}
	}
}

### Function: Display Total Views
if(!function_exists('get_totalviews')) {
	function get_totalviews($display = true) {
		global $wpdb;
		$total_views = intval($wpdb->get_var("SELECT SUM(meta_value+0) FROM $wpdb->postmeta WHERE meta_key = 'views'"));
		if($display) {
			echo postviews_round_number($total_views);
		} else {
			return postviews_round_number($total_views);
		}
	}
}

### Function: Display Most Viewed Page/Post
if ( ! function_exists( 'get_most_viewed' ) ) {
	function get_most_viewed( $mode = '', $limit = 10, $chars = 0, $days = 0, $display = true ) {

		$output = '';

		if ( $days ) {
			$most_viewed = new WP_Query( array(
				'post_type'         => ( empty( $mode ) || $mode === 'both' ) ? 'any' : $mode,
				'post_status' 		=>	'publish',
				'date_query'		=>	array('after' => $days . ' days ago'),
				'posts_per_page'    =>	$limit,
				'orderby'           =>	'meta_value_num',
				'order'             =>	'desc',
				'meta_key'          =>	'views',
				'ignore_sticky_posts' => 1 //忽略 sticky posts
			) );
		} else {
			$most_viewed = new WP_Query( array(
				'post_type'         => ( empty( $mode ) || $mode === 'both' ) ? 'any' : $mode,
				'post_status' 		=>	'publish',
				//'date_query'		=>	array('after' => $days . ' days ago'),
				'posts_per_page'    =>	$limit,
				'orderby'           =>	'meta_value_num',
				'order'             =>	'desc',
				'meta_key'          =>	'views',
				'ignore_sticky_posts' => 1 //忽略 sticky posts
			) );
		}

		if ( $most_viewed->have_posts() ) {
			while ( $most_viewed->have_posts() ) {
				$most_viewed->the_post();

				// Post Views.
				//$post_views = get_post_meta( get_the_ID(), 'views', true );

				// Post Title.
				$post_title = get_the_title();
				if ( $chars > 0 ) {
					$post_title = snippet_text( $post_title, $chars );
				}

				$output .= '<li><a href="'.get_permalink().'"  title="'.$post_title.' - '.the_views( $display = false, $prefix = '', $postfix = '', $always = false ).'">'.$post_title.'</a></li>';
			}

			wp_reset_postdata();
		}  else {
			$output = '<li>' . __( 'N/A', 'wp-postviews' ) . '</li>' . "\n";
		}

		if( $display ) {
			echo $output;
		} else {
			return $output;
		}
	}
}
//后台文章列表添加 浏览数
### Function Show Post Views Column in WP-Admin
add_action('manage_posts_custom_column', 'add_postviews_column_content');
add_filter('manage_posts_columns', 'add_postviews_column');
add_action('manage_pages_custom_column', 'add_postviews_column_content');
add_filter('manage_pages_columns', 'add_postviews_column');
function add_postviews_column($defaults) {
	$defaults['views'] = __( 'Views' );
	return $defaults;
}
### Functions Fill In The Views Count
function add_postviews_column_content($column_name) {
	if ($column_name === 'views' ) {
		if ( function_exists('the_views' ) ) {
			the_views( true, '', '', true );
		}
	}
}
### Function Sort Columns
add_filter( 'manage_edit-post_sortable_columns', 'sort_postviews_column');
add_filter( 'manage_edit-page_sortable_columns', 'sort_postviews_column' );
function sort_postviews_column( $defaults ) {
	$defaults['views'] = 'views';
	return $defaults;
}
add_action('pre_get_posts', 'sort_postviews');
function sort_postviews($query) {
	if ( ! is_admin() ) {
		return;
	}
	$orderby = $query->get('orderby');
	if ( 'views' === $orderby ) {
		$query->set( 'meta_key', 'views' );
		$query->set( 'orderby', 'meta_value_num' );
	}
}
//后台文章列表添加 浏览数 - END
////后台文章列表添加 ID 可排序
//### Function Show post id Column in WP-Admin
add_action('manage_posts_custom_column', 'add_show_postid_column_content', 5, 2);
add_filter('manage_posts_columns', 'add_show_postid_column');
add_action('manage_pages_custom_column', 'add_show_postid_column_content', 5, 2);
add_filter('manage_pages_columns', 'add_show_postid_column');
function add_show_postid_column($defaults) {
	$defaults['show_id'] = __( 'ID' );
	$new = array();
    $show_id = $defaults['show_id'];  // save the show_id column
    unset($defaults['show_id']);   // remove it from the columns list

    foreach($defaults as $key=>$value) {
        if($key=='title') {  // when we find the title column
           $new['show_id'] = $show_id;  // put the show_id column before it
        }
        $new[$key]=$value;
    }
    return $new;
}
### Functions Fill In The Views Count
function add_show_postid_column_content($column_name, $id) {
	if ($column_name === 'show_id' ) {
		echo $id;
	}
}
//### Function Sort Columns
add_filter( 'manage_edit-post_sortable_columns', 'sort_show_postid_column');
add_filter( 'manage_edit-page_sortable_columns', 'sort_show_postid_column' );
function sort_show_postid_column( $defaults ) {
	$defaults['show_id'] = __( 'ID' );
	$new = array();
    $show_id = $defaults['show_id'];  // save the show_id column
    unset($defaults['show_id']);   // remove it from the columns list

    foreach($defaults as $key=>$value) {
        if($key=='title') {  // when we find the title column
           $new['show_id'] = $show_id;  // put the show_id column before it
        }
        $new[$key]=$value;
    }
    return $new;
}
////后台文章列表添加 ID 可排序 - END