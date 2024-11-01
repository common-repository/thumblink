<?php
/**
 * @package Thumblink
 * @version 1.3
 */
/*
Plugin Name: Thumblink
Plugin URI: http://wordpress.org/plugins/thumblink/
Description: Thumblink automatically creates thumbnails for all of your blog posts to make your links look better. A link to your WordPress site on platforms like Facebook, Twitter, and LinkedIn is often the first interaction you have with a visitor. The link's thumbnail is 3x larger than its text preview - if it looks ugly or unmaintained, they won't click on it. Thumblink automatically generates these thumbnails by taking a screenshot of each page.
Author: Team Thumblink
Version: 1.3
Author URI: https://thumblink.com/
*/

global $wp;
function hook_thumblink() {
    $post_title = get_the_title();
    echo "<meta name=\"twitter:card\" content=\"summary_large_image\" />\n";
    echo "<meta name=\"twitter:title\" content=\"{$post_title}\" />\n";
    if (has_post_thumbnail()) {
        $post_image = wp_get_attachment_image_src(get_post_thumbnail_id(), "full");
        if (!empty($post_image[0])) {
            $post_image = $post_image[0];
            echo "<meta name=\"twitter:image\" content=\"{$post_image}\" />\n";
            echo "<meta property=\"og:image\" content=\"{$post_image}\" />\n";
            echo "<meta property=\"og:image:secure_url\" content=\"{$post_image}\" />\n";
            return;
        }
    }
    $url = get_page_link();
    $post = get_post();
    if (!is_null($post)) {
    	if(is_array($post)) {
    		$post = $post[0];
    	}
    	$url .= "#post-{$post->ID}";
    }
    $url = urlencode($url);
    echo "<meta name=\"twitter:image\" content=\"https://generate.thumblink.com/?url={$url}\" />\n";
    echo "<meta property=\"og:image\" content=\"https://generate.thumblink.com/?url={$url}\" />\n";
    echo "<meta property=\"og:image:secure_url\" content=\"https://generate.thumblink.com/?url={$url}\" />\n";
}
add_action('wp_head', 'hook_thumblink');
