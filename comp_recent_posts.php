<?php
/**
* @package comp_tool_recent_posts
* @version 1.6
*/
/*
Plugin Name: comp tool recent posts
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Hello.
Author: Aaron Saderholm
Version: 666
Author URI: saderholm.com
*/
class comp_tool_recent_posts extends WP_Widget {


	function __construct() {
		$this->plugin_slug				= 'comp_tool_recent_posts';
		$this->plugin_version			= '666';
		$widget_name = "Aaron's Bad Recent Posts Widget";
		$widget_desc = "Don't let Aaron program Wordpress.";
	
		$widget_ops = array( 'classname' => $this->plugin_slug, 'description' => $widget_desc );
		parent::__construct( $this->plugin_slug, $widget_name, $widget_ops );

		// not in use, just for the po-editor to display the translation on the plugins overview list
		$widget_name = __( 'Comp Tool Recent Posts With Thumbnails', 'recent-posts-widget-with-thumbnails' );
		$widget_desc = __( 'List of your site&#8217;s most recent posts, with clickable title and thumbnails.', 'recent-posts-widget-with-thumbnails' );

	}

	function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}
			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
			
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$number = 3;
			
			$r = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true
			) ) );
			if ($r->have_posts()) :
	?>
	<?php while ( $r->have_posts() ):
	$r->the_post(); ?>
	<?php if (!has_post_thumbnail( get_the_ID() ) ) {
		continue;
	} ?>
	<div class="col-md-4">
		<div class="blog-entry">
			
			<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' ); ?>
			<div class="blog-entry-image">
				<img src="<?php echo $image[0]; ?>" />
			</div>
			<h3><a href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>
			<p><?= get_the_date() ?></p>
		</div>
		
	</div>
	<?php endwhile;
	endif;
	}
}

function register_comp_tool_recent_posts () {
	register_widget( 'comp_tool_recent_posts' );
}
add_action( 'widgets_init', 'register_comp_tool_recent_posts', 1 );