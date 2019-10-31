<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       lucasgerroir.com
 * @since      1.0.0
 *
 * @package    Instapull
 * @subpackage Instapull/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Instapull
 * @subpackage Instapull/public
 * @author     Lucas Gerroir <lucasgerroir@gmail.com>
 */
class Instapull_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instapull_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instapull_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/instapull-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instapull_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instapull_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/instapull-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Use the instagram graphql api to get the set user's page. 
	 *
	 * @param      string    $user_id    Instagram unique user id/handle.
	 * @return     object                The returned object data of the users instagram page.
	 * @since    1.0.0
	 */
	private function get_instagram_feed($user_id) {

		$data = wp_remote_get( "https://www.instagram.com/" . $user_id . "/?__a=1");

		return json_decode($data['body']);;
	}

	/**
	 * Map the returned instagram graphql data to our own readable post data array. 
	 *
	 * @param      string    $data    Object data of the users instagram page.
	 * @return     array                 The formatted array of post data.
	 * @since    1.0.0
	 */
	private function map_instagram_data($data = null) {
		
		if(is_null($data)) {
			return;
		}

		$post_data = [
			"image"=> $data->thumbnail_src,
			"title"=> $data->title,
			"date"=> date('m/d/Y', $data->taken_at_timestamp),
			"url"=> $data->display_url,
			"description"=> $data->edge_media_to_caption->edges[0]->node->text,
		];

		return $post_data;
	}

	/**
	 * A check to see if we should use the shortcode attribute or admin set limit. 
	 *
	 * @param      integer    $limit           The shortcode attribue limit.
	 * @param      integer    $option_limit    The admin set limit.
	 * @return     array                       The limit we want to use.
	 * @since    1.0.0
	 */
	private function set_limit($limit = null, $option_limit = null) {
		
		if(empty($limit) == false) {
			return $limit;
		}

		return $option_limit;
	}

	/**
	 * The instagram shortcode that displays a users instagram feed
	 *
	 * @param      array    $atts              The shortcode attribues.
	 * @return     array                       The shortcode html.
	 * @since    1.0.0
	 */
	public function insta_pull_func( $atts ){ 
		
		extract(shortcode_atts(array(
			'limit' => null
		), $atts));

		// get the admin options.
		$options = get_option($this->plugin_name);

		// check if there is a feed set if not warn users.
		if(empty($options['feed'])) {
			return "Please set an instagram user.";
		}
		
		// Try to get the users instagram page data.
		$feed_data = $this->get_instagram_feed($options['feed']);

		// If there is no data warn user.
		if(empty($feed_data)) {
			return "Please set a valid instagram user.";
		}

		// Get the max limit we want to use either as a shortcode attribute or admin param 
		$max_limit = $this->set_limit($limit, $options['limit']);
		
		// set the shortcode title
		$shortcode_title = $options['title'];
		
		// assign the instagram posts to variable
		$feed_posts = $feed_data->graphql->user->edge_owner_to_timeline_media->edges;
		
		// start output buffer
		ob_start();

		// keep track of the posts count to compare limit
		$post_count = 0;

		// include the shortcode header
		require( 'partials/instapull-header.php' );

		// loop through posts to display them
		foreach($feed_posts as $key => $post) {

			// check if we have hit the limit
			if($post_count == $max_limit) {
				break;
			}

			// map the post data to a formatted easy to read array
			$post_node = $post->node;
			$post_data = $this->map_instagram_data($post_node);
			
			// include the post card view
			require( 'partials/instapull-posts.php' );

			// increase the counter
			$post_count ++;
		}

		// include the shortcode footer
		require( 'partials/instapull-footer.php' );
		
		// return the buffer output
		$output = ob_get_clean();

		return $output;
	}

}
