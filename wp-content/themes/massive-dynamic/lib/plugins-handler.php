<?php

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once PIXFLOW_THEME_INCLUDES . '/class-tgm-plugin-activation.php';


function pixflow_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		//Visual Composer
		array(
			'name'			    => 'WPBakery Visual Composer', // The plugin name
			'slug'			    => 'js_composer', // The plugin slug (typically the folder name)
			'source'            => pixflow_path_combine(PIXFLOW_THEME_PLUGINS, 'js_composer.zip'), // The plugin source
			'required'			=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation'	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'		=> '', // If set, overrides default API URL and points to an external URL
		),
		//Pixflow Portfolio Post Type
		array(
			'name'			    => 'Pixflow Portfolio',
			'slug'			    => 'px-portfolio',
			'source'            => pixflow_path_combine(PIXFLOW_THEME_PLUGINS, 'px-portfolio.zip'),
			'required'			=> true,
			'force_activation'	=> false,
			'force_deactivation'=> false,
		),
		//Massive Dynamic Shortcodes
		array(
			'name'			    => 'Massive Dynamic Shortcodes',
			'slug'			    => 'md-shortcodes',
			'source'            => pixflow_path_combine(PIXFLOW_THEME_PLUGINS, 'md-shortcodes.zip'),
			'required'			=> true,
			'force_activation'	=> false,
			'force_deactivation'=> false,
		),
		//Envato market
		array(
			'name'			    => 'Envato Market',
			'slug'			    => 'envato-market',
			'source'            => pixflow_path_combine(PIXFLOW_THEME_PLUGINS, 'envato-market.zip'),
			'required'			=> false,
			'force_activation'	=> false,
			'force_deactivation'=> false,
		),
		//Contact Form 7
		array(
			'name' => 'Contact Form 7',
			'slug' => 'contact-form-7',
			'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'required' => false,
		),
		// WooCommerce
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		//Share Buttons by AddToAny
		array(
			'name' 		=> 'Share Buttons by AddToAny',
			'slug' 		=> 'add-to-any',
			'required' 	=> false,
		),
		array(
			'name'      => 'MailChimp for WordPress',
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
		),
		//Revolution Slider
		array(
			'name'			    => 'Revolution Slider ', // The plugin name
			'slug'			    => 'revslider', // The plugin slug (typically the folder name)
			'source'            => pixflow_path_combine(PIXFLOW_THEME_PLUGINS, 'revslider.zip'), // The plugin source
			'required'			=> false, // If false, the plugin is only 'recommended' instead of required
			'force_deactivation'=> false,
		),
		//master slider
		array(
			'name'			    => 'Master Slider ', // The plugin name
			'slug'			    => 'masterslider', // The plugin slug (typically the folder name)
			'source'            => pixflow_path_combine(PIXFLOW_THEME_PLUGINS, 'masterslider.zip'), // The plugin source
			'required'			=> false, // If false, the plugin is only 'recommended' instead of required
			'force_deactivation'=> false,
		),
		//Go Pricing
		array(
			'name'			    => 'Go Pricing', // The plugin name
			'slug'			    => 'go_pricing', // The plugin slug (typically the folder name)
			'source'            => pixflow_path_combine(PIXFLOW_THEME_PLUGINS, 'go_pricing.zip'), // The plugin source
			'required'			=> false, // If false, the plugin is only 'recommended' instead of required
			'force_deactivation'=> false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'massive-dynamic',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'massive-dynamic' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'massive-dynamic' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'massive-dynamic' ), // %s = plugin name.
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'massive-dynamic' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'massive-dynamic'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'massive-dynamic'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'massive-dynamic'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'massive-dynamic'
			),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'massive-dynamic' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'massive-dynamic' ),
			'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'massive-dynamic' ),
			'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'massive-dynamic' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'massive-dynamic' ),  // %1$s = plugin name(s).
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'massive-dynamic' ), // %s = dashboard link.
			'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'massive-dynamic' ),
			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'pixflow_register_required_plugins');

// Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the  Settings-> Visual Composer page
function pixflow_vcSetAsTheme() {
	vc_set_as_theme();
}

add_action( 'vc_before_init', 'pixflow_vcSetAsTheme');

// Initialising Massive Dynamic Shortcodes
if (class_exists('WPBakeryVisualComposerAbstract')) {

	// Remove hints from frontend editor
	add_action( 'vc_before_init', 'pixflow_vc_remove_fe_pointers');
	function pixflow_vc_remove_fe_pointers() {
		remove_action( 'admin_init', 'vc_frontend_editor_pointer' );
	}

	// Include Related files to VC
	function pixflow_requireVcExtend(){
		require_once (PIXFLOW_THEME_LIB.'/extendvc/extend-vc.php');
		$list = array(
				'page',
				'portfolio',
				'post'
		);
		vc_set_default_editor_post_types( $list );
	}
	add_action('init', 'pixflow_requireVcExtend',999);

	// Add custom font to VC
	add_filter('vc_google_fonts_get_fonts_filter', 'pixflow_changevcfont');
	function pixflow_changevcfont()
	{
		$fonts_list = '[{"font_family":"Roboto","font_styles":"regular,100,100italic,300,300italic,italic,500,500italic,700,700italic,900,900italic","font_types":"400 regular:400:normal,100 light regular:100:normal,100 light italic:100:italic,300 light regular:300:normal,300 light italic:300:italic,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,700 bold regular:700:normal,700 bold italic:700:italic,900 bold regular:900:normal,900 bold italic:900:italic"},{"font_family":"Open Sans",	"font_styles":"300,300italic,regular,italic,600,600italic,700,700italic,800,800italic",	"font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,600 bold regular:600:normal,600 bold italic:600:italic,700 bold regular:700:normal,700 bold italic:700:italic,800 bold regular:800:normal,800 bold italic:800:italic"}	,{"font_family":"Open Sans Condensed","font_styles":"300,300italic,700","font_types":"300 light regular:300:normal,300 light italic:300:italic,700 bold regular:700:normal"},{"font_family":"Orbitron","font_styles":"regular,500,700,900","font_types":"400 regular:400:normal,500 bold regular:500:normal,700 bold regular:700:normal,900 bold regular:900:normal"},{"font_family":"Oswald","font_styles":"300,regular,700","font_types":"300 light regular:300:normal,400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Oxygen","font_styles":"300,regular,700","font_types":"300 light regular:300:normal,400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"PT Sans","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"PT Serif","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Pacifico","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Permanent Marker","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Philosopher","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Playfair Display","font_styles":"regular,italic,700,700italic,900,900italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic,900 bold regular:900:normal,900 bold italic:900:italic"},{"font_family":"Poppins","font_styles":"300,regular,500,600,700","font_types":"300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal"},{"font_family":"Radley","font_styles":"regular,italic","font_types":"400 regular:400:normal,400 italic:400:italic"},{"font_family":"Raleway","font_styles":"100,200,300,regular,500,600,700,800,900","font_types":"100 light regular:100:normal,200 light regular:200:normal,300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal,800 bold regular:800:normal,900 bold regular:900:normal"},{"font_family":"Roboto Condensed","font_styles":"300,300italic,regular,italic,700,700italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Roboto Slab","font_styles":"100,300,regular,700","font_types":"100 light regular:100:normal,300 light regular:300:normal,400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Satisfy","font_styles":"regular","font_types":"400 regular:400:normal"},{"font_family":"Signika","font_styles":"300,regular,600,700","font_types":"300 light regular:300:normal,400 regular:400:normal,600 bold regular:600:normal,700 bold regular:700:normal"},{"font_family":"Source Code Pro","font_styles":"200,300,regular,500,600,700,900","font_types":"200 light regular:200:normal,300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal,900 bold regular:900:normal"},{"font_family":"Ubuntu","font_styles":"300,300italic,regular,italic,500,500italic,700,700italic","font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Ubuntu Mono","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Vollkorn","font_styles":"regular,italic,700,700italic","font_types":"400 regular:400:normal,400 italic:400:italic,700 bold regular:700:normal,700 bold italic:700:italic"},{"font_family":"Montserrat","font_styles":"regular,700","font_types":"400 regular:400:normal,700 bold regular:700:normal"},{"font_family":"Ubuntu",	"font_styles":"300,300italic,regular,italic,500,500italic,700,700italic", "font_types":"300 light regular:300:normal,300 light italic:300:italic,400 regular:400:normal,400 italic:400:italic,500 bold regular:500:normal,500 bold italic:500:italic,700 bold regular:700:normal,700 bold italic:700:italic"}]';
		return json_decode( $fonts_list );
	}
}
