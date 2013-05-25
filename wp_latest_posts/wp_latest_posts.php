<?php
/*
Plugin Name: LatestPosts
Plugin URI: http://blog.nadeeth.info
Description: Show the latest posts bottom of each single post page
Version: beta 1.0
Author: Nadeeth L.
Author URI: http://nadeeth.info
License: GPL2
*/

// to avoid a name collision, make sure this function is not already defined

if( !function_exists("show_latest_posts")){
    
	function get_latest_posts_list() {

		$args = array(
			'posts_per_page'  => 5,
			'numberposts'     => 5,
			'offset'          => 0,
			'category'        => '',
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'include'         => '',
			'exclude'         => '',
			'meta_key'        => '',
			'meta_value'      => '',
			'post_type'       => 'post',
			'post_mime_type'  => '',
			'post_parent'     => '',
			'post_status'     => 'publish',
			'suppress_filters' => true );

                    $posts = get_posts( $args );

		    if (empty($posts) || count($posts)<1) return;
		
		    $html = "<ul>";
		    foreach ($posts as $post) {

			$html .= "<li><a href='".$post->guid."'>".strip_tags($post->post_title)."</a> - ".strip_tags(substr($post->post_content, 0, 150))."...</li>";
		    }
		    $html .= "</ul>";

		    $container = "<div><h2>Latest Posts... </h2>{$html}</div>";

		    return $container;
	}

	function show_latest_posts($content){

		if(is_single()){
                    return $content . get_latest_posts_list();
		} else{
                    //if `the_content` belongs to a page no change to `the_content`
                    return $content;
		}
	}

	//add our filter function to the hook 
	add_filter('the_content', 'show_latest_posts');
}

?>
