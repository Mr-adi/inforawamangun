<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://themeforest.net/user/PixFlow/portfolio
 * @since      1.0.0
 *
 * @package    PX_Portfolio
 * @subpackage PX_Portfolio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    PX_Portfolio
 * @subpackage PX_Portfolio/public
 * @author     Pixflow <pxflow@gmail.com>
 */
class PX_Portfolio_Public {

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
		 * defined in PX_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PX_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/px-portfolio-public.css', array(), $this->version, 'all' );

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
		 * defined in PX_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PX_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/px-portfolio-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create Portfolio Custom Post Type
	 *
	 * @since    1.0.0
	 */
	public function create_custom_post_type() {

		$labels = array(
				'name' => __( 'Portfolio', 'px-portfolio'),
				'singular_name' => __( 'Portfolio', 'px-portfolio' ),
				'add_new' => __('Add New', 'px-portfolio'),
				'add_new_item' => __('Add New Portfolio', 'px-portfolio'),
				'edit_item' => __('Edit Portfolio', 'px-portfolio'),
				'new_item' => __('New Portfolio', 'px-portfolio'),
				'view_item' => __('View Portfolio', 'px-portfolio'),
				'search_items' => __('Search Portfolio', 'px-portfolio'),
				'not_found' =>  __('No portfolios found', 'px-portfolio'),
				'not_found_in_trash' => __('No portfolios found in Trash', 'px-portfolio'),
				'parent_item_colon' => ''
		);
		$args = array(
				'labels' =>  $labels,
				'public' => true,
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_icon' => plugin_dir_url( __FILE__ ) . 'img/portfolio-icon.png',
				'rewrite' => array('slug' => __( 'portfolios', 'px-portfolio' ), 'with_front' => true),
				'supports' => array('title',
						'editor',
						'thumbnail',
						'post-formats'
				),
		);
		register_post_type( 'portfolio', $args );
		/* Register the corresponding taxonomy */
		register_taxonomy('skills', 'portfolio',
				array("hierarchical" => true,
						"label" => __( "Skills", 'px-portfolio' ),
						"singular_label" => __( "Skill",  'px-portfolio' ),
						"rewrite" => false,
				));

	}

}
