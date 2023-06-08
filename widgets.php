<?php
// 最近更新文章
class recently_updated_posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_recently_updated_posts', 'description' => __( '调用最近更新文章') );
		parent::__construct( 'recently_updated_posts', __( '主题：最近更新文章·可指定分类' ), $widget_ops );
	}
    function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 5;
		$daysat = strip_tags($instance['daysat']) ? absint( $instance['daysat'] ) : 7;
		$daysin = strip_tags($instance['daysin']) ? absint( $instance['daysin'] ) : 90;
		$cat_id = strip_tags($instance['cat_id']) ? absint( $instance['cat_id'] ) : '';

		if ( ! empty( $title ) ){
			if( $cat_id == '' ){
				echo $before_title . $title . $after_title;
			} else {
				echo $before_title . $title . '<a target="_blank" href="'.get_category_link( $cat_id ).'" title="'.get_cat_name( $cat_id ).'"><i class="icon-link-ext"></i></a>' . $after_title;
			}
		}
?>

<div id="recently_updated_posts_widget">
	<ul>
		<?php
			if ( function_exists( 'recently_updated_posts' ) ) {
				$output_tmp = theme_wp_cache_get($this->id.':'.md5(maybe_serialize(get_lastpostmodified())),'recently_updated_posts');
				if( $output_tmp === false ){
					$output_tmp = recently_updated_posts( $num=$number, $daysat=$daysat, $daysin=$daysin, $cat_ID=$cat_id );
					theme_wp_cache_set($this->id.':'.md5(maybe_serialize(get_lastpostmodified())), $output_tmp, 'recently_updated_posts', DAY_IN_SECONDS );//缓存一天
				}
				echo $output_tmp;
	    	}
	    ?>
	</ul>
</div>

<?php
	echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['daysat'] = strip_tags($new_instance['daysat']);
			$instance['daysin'] = strip_tags($new_instance['daysin']);
			$instance['cat_id'] = strip_tags($new_instance['cat_id']);
			return $instance;
		}
	function form($instance) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '最近更新';
		}
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('number' => '5'));
		$instance = wp_parse_args((array) $instance, array('daysat' => '7'));
		$instance = wp_parse_args((array) $instance, array('daysin' => '90'));
		$instance = wp_parse_args((array) $instance, array('cat_id' => ''));
		$number = strip_tags($instance['number']);
		$daysat = strip_tags($instance['daysat']);
		$daysin = strip_tags($instance['daysin']);
		$cat_id = strip_tags($instance['cat_id']);
 ?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id('daysat'); ?>">更新与发布相隔时间：</label>
	<input id="<?php echo $this->get_field_id( 'daysat' ); ?>" name="<?php echo $this->get_field_name( 'daysat' ); ?>" type="text" value="<?php echo $daysat; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id('daysin'); ?>">限定时间内（天）：</label>
	<input id="<?php echo $this->get_field_id( 'daysin' ); ?>" name="<?php echo $this->get_field_name( 'daysin' ); ?>" type="text" value="<?php echo $daysin; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id('cat_id'); ?>">指定分类 ID：</label>
	<input id="<?php echo $this->get_field_id( 'cat_id' ); ?>" name="<?php echo $this->get_field_name( 'cat_id' ); ?>" type="text" value="<?php echo $cat_id; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){ register_widget( 'recently_updated_posts' ); });

// 相关文章
class related_post extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_related_post', 'description' => __( '显示相关文章') );
		parent::__construct( 'related_post', __( '主题：相关文章' ), $widget_ops );
	}
    function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( ! empty( $title ) )
		echo $before_title . $title . $after_title;
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 5;
?>

<div id="related_post_widget">
	<?php
		echo Theme_Related_Posts ( $number );
	?>
</div>

<?php
	echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['number'] = strip_tags($new_instance['number']);
			return $instance;
		}
	function form($instance) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '相关文章';
		}
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('number' => '5'));
		$number = strip_tags($instance['number']);
?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){ register_widget( 'related_post' ); });

// 读者墙
class readers extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_readers', 'description' => __( '最活跃的读者') );
		parent::__construct( 'readers', __( '主题：读者墙' ), $widget_ops );
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( ! empty( $title ) )
		echo $before_title . $title . $after_title;
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 6;
		$days = strip_tags($instance['days']) ? absint( $instance['days'] ) : 90;
		$size = strip_tags($instance['size']) ? absint( $instance['size'] ) : 44;
?>

<div id="readers_widget" class="readers">
	<?php
		$output = theme_wp_cache_get( $this->id.':'.md5(maybe_serialize(get_lastpostmodified())), 'widget_active_friends' );
		if( $output === false ){
			$output = get_active_friends($num = $number,$size=$size,$days=$days);
			theme_wp_cache_set( $this->id.':'.md5(maybe_serialize(get_lastpostmodified())), $output, 'widget_active_friends', 12 * HOUR_IN_SECONDS );//缓存一天
		}
		echo $output;
	?>
	<div class="clear"></div>
</div>

<?php
	echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['days'] = strip_tags($new_instance['days']);
			$instance['size'] = strip_tags($new_instance['size']);
			return $instance;
		}
	function form($instance) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '读者墙';
		}
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('number' => '6'));
		$instance = wp_parse_args((array) $instance, array('days' => '90'));
		$instance = wp_parse_args((array) $instance, array('size' => '44'));
		$number = strip_tags($instance['number']);
		$days = strip_tags($instance['days']);
		$size = strip_tags($instance['size']);
 ?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id('days'); ?>">时间限定（天）：</label>
	<input id="<?php echo $this->get_field_id( 'days' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>" type="text" value="<?php echo $days; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id('size'); ?>">头像尺寸：</label>
	<input id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" type="text" value="<?php echo $size; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', function(){ register_widget( 'readers' ); });

//自定义友情链接
class WP_Widget_Links_Custom extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'description' => __( '链接、友情链接' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'WP_Widget_Links_Custom', __( '主题：链接' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		$category = isset($instance['category']) ? $instance['category'] : false;
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'name';
		$order = $orderby == 'rating' ? 'DESC' : 'ASC';
		$limit = isset( $instance['limit'] ) ? $instance['limit'] : -1;
		$more_link = isset( $instance['more_link'] ) ? $instance['more_link'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		$link_title = '';

		if ( !empty($instance['title']) ){
			$link_title = $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		if( !empty($instance['more_link']) ){
			$link_title = $args['before_title'] . $instance['title'] . '「<a href="'.$instance['more_link'].'" rel="bookmark" title="More useful links" target="_blank">More</a>」'.$args['after_title'];
		}

		echo $link_title;

		$output = theme_wp_cache_get( $this->id.':'.md5(maybe_serialize(get_lastpostmodified())), 'widget_custom_links' );
		if( $output === false ){
			$widget_links_args = array(
				'show_images'      => 0,
				'show_description' => 0,
				'show_name'        => 1,
				'show_rating'      => 0,
				'categorize'       => 0,
				'title_li'         => __(''),
				'category'         => $category,
				'class'            => 'linkcat widget',
				'orderby'          => $orderby,
				'order'            => $order,
				'limit'            => $limit,
				'echo'             => 0,
			);
			$output = wp_list_bookmarks( apply_filters( 'widget_links_args', $widget_links_args, $instance ) );
			theme_wp_cache_set( $this->id.':'.md5(maybe_serialize(get_lastpostmodified())), $output, 'widget_custom_links', 12 * HOUR_IN_SECONDS );//缓存一天
		}
		echo '<div class="doublecol"><ul>'.$output.'</ul></div>';
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		$instance['orderby'] = 'name';
		if ( in_array( $new_instance['orderby'], array( 'name', 'rating', 'id', 'rand' ) ) ){
			$instance['orderby'] = $new_instance['orderby'];
		}
		$instance['category'] = intval( $new_instance['category'] );
		$instance['limit'] = ! empty( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : -1;
		$instance['more_link'] = ! empty( $new_instance['more_link'] ) ?  sanitize_text_field( $new_instance['more_link'] ) : '';
		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$instance = wp_parse_args( (array) $instance, array( 'category' => false, 'orderby' => 'name', 'limit' => -1 ) );
		$link_cats = get_terms( 'link_category' );
		if ( ! $limit = intval( $instance['limit'] ) ){
			$limit = -1;
		}
		$more_link = isset( $instance['more_link'] ) ? $instance['more_link'] : '';
			?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e( 'Select Link Category:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
		<option value=""><?php _ex('All Links', 'links widget'); ?></option>
		<?php
		foreach ( $link_cats as $link_cat ) {
			echo '<option value="' . intval( $link_cat->term_id ) . '"'
				. selected( $instance['category'], $link_cat->term_id, false )
				. '>' . $link_cat->name . "</option>\n";
		}
		?>
		</select>
		<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e( 'Sort by:' ); ?></label>
		<select name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>" class="widefat">
			<option value="name"<?php selected( $instance['orderby'], 'name' ); ?>><?php _e( 'Link title' ); ?></option>
			<option value="rating"<?php selected( $instance['orderby'], 'rating' ); ?>><?php _e( 'Link rating' ); ?></option>
			<option value="id"<?php selected( $instance['orderby'], 'id' ); ?>><?php _e( 'Link ID' ); ?></option>
			<option value="rand"<?php selected( $instance['orderby'], 'rand' ); ?>><?php _ex( 'Random', 'Links widget' ); ?></option>
		</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Number of links to show:' ); ?></label>
			<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit == -1 ? '' : intval( $limit ); ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('more_link'); ?>"><?php _e( '更多' ); ?></label>
			<input id="<?php echo $this->get_field_id('more_link'); ?>" name="<?php echo $this->get_field_name('more_link'); ?>" type="text" value="<?php echo esc_attr( $more_link ); ?>" size="24" />
		</p>
		<?php
	}
}
add_action( 'widgets_init', function(){ register_widget( 'WP_Widget_Links_Custom' ); });

### WP_Widget_Theme_PostViews 浏览最多文章/页面
 class WP_Widget_Theme_PostViews extends WP_Widget {
	// Constructor
	function __construct() {
		$widget_ops = array('classname' => 'widget_most_views', 'description' => __('浏览最多文章'));
		parent::__construct('most_views', __( '主题：浏览最多文章' ), $widget_ops);
	}

	// Display Widget
	function widget($args, $instance) {
		$title = apply_filters('widget_title', esc_attr($instance['title']));
		$mode = esc_attr($instance['mode']);
		$limit = intval($instance['limit']);
		$days = intval($instance['days']);
		$chars = intval($instance['chars']);
		echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
		echo '<ul>'."\n";

		$output = theme_wp_cache_get($this->id.':'.md5(maybe_serialize(get_lastpostmodified())),'widget_most_viewed');
		if( $output === false ){
			$output = get_most_viewed($mode, $limit, $chars, $days, $display = false);
			theme_wp_cache_set($this->id.':'.md5(maybe_serialize(get_lastpostmodified())), $output, 'widget_most_viewed', DAY_IN_SECONDS );//缓存1小时
		}
		echo $output;
		//wp_cache_delete( $this->id,'widget_most_viewed' );
		
		echo '</ul>'."\n";
		echo  $args['after_widget'];
	}

	// When Widget Control Form Is Posted
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['mode'] = strip_tags($new_instance['mode']);
		$instance['limit'] = intval($new_instance['limit']);
		$instance['days'] = intval($new_instance['days']);
		$instance['chars'] = intval($new_instance['chars']);
		return $instance;
	}

	// DIsplay Widget Control Form
	function form($instance) {
		$instance = wp_parse_args((array) $instance, array('title' => __('Views', 'wp-theme-postviews'), 'mode' => '', 'limit' => 10, 'chars' => 200, 'days' => 0, 'cat_ids' => '0'));
		$title = esc_attr($instance['title']);
		$mode = trim(esc_attr($instance['mode']));
		$limit = intval($instance['limit']);
		$days = intval($instance['days']);
		$chars = intval($instance['chars']);
		$post_types = get_post_types(array(
			'public' => true
		));
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-theme-postviews'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('mode'); ?>"><?php _e('Include Views From:', 'wp-theme-postviews'); ?>
				<select name="<?php echo $this->get_field_name('mode'); ?>" id="<?php echo $this->get_field_id('mode'); ?>" class="widefat">
					<option value=""<?php selected('', $mode); ?>><?php _e('All', 'wp-theme-postviews'); ?></option>
					<?php if($post_types > 0): ?>
						<?php foreach($post_types as $post_type): ?>
							<option value="<?php echo $post_type; ?>"<?php selected($post_type, $mode); ?>><?php printf(__('%s Only', 'wp-theme-postviews'), ucfirst($post_type)); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('No. Of Records To Show:', 'wp-theme-postviews'); ?> <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('days'); ?>"><?php _e('显示最近多少天文章，0 则不限制时间', 'wp-theme-postviews'); ?> <input class="widefat" id="<?php echo $this->get_field_id('days'); ?>" name="<?php echo $this->get_field_name('days'); ?>" type="text" value="<?php echo $days; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('chars'); ?>"><?php _e('Maximum Post Title Length (Characters):', 'wp-theme-postviews'); ?> <input class="widefat" id="<?php echo $this->get_field_id('chars'); ?>" name="<?php echo $this->get_field_name('chars'); ?>" type="text" value="<?php echo $chars; ?>" /></label><br />
			<small><?php _e('<strong>0</strong> to disable.', 'wp-theme-postviews'); ?></small>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
	}
}
//Init WP_Widget_Theme_PostViews 浏览最多文章/页面
add_action( 'widgets_init', function(){ register_widget( 'WP_Widget_Theme_PostViews' ); });

//主题：最新文章
class WP_Widget_theme_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_posts',
			'description' => __( '最新文章.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'theme-recent-posts', __( '主题：最新文章' ), $widget_ops );
		$this->alt_option_name = 'widget_recent_posts';
	}

	function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '最新文章' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 6;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = theme_wp_cache_get($this->id.':'.md5(maybe_serialize(get_lastpostmodified())),'widget_recent_posts');
		if( $r === false ){
			$r = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $number,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			), $instance ) );

			theme_wp_cache_set($this->id.':'.md5(maybe_serialize(get_lastpostmodified())), $r, 'widget_recent_posts', DAY_IN_SECONDS );//缓存一天
		}

		if ( ! $r->have_posts() ) {
			return;
		}

		?>
		<?php echo $args['before_widget']; ?>
		<?php
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		<ul>
			<?php foreach ( $r->posts as $recent_post ) : ?>
				<?php
				$post_title = get_the_title( $recent_post->ID );
				$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
				?>
				<li>
					<a href="<?php the_permalink( $recent_post->ID ); ?>" target="_blank" title="<?php echo $title.' - 发布日期：'.get_the_date( '', $recent_post->ID ); ?>"><?php echo $title; ?></a>
					<?php if ( $show_date ) : ?>
						<span class="post-date"><?php echo get_the_date( '', $recent_post->ID ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 6;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
	}
}
//Init WP_Widget_theme_Recent_Posts
add_action( 'widgets_init', function(){ register_widget( 'WP_Widget_theme_Recent_Posts' ); });