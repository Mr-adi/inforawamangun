<?php

/**
 * The main export/import class.
 *
 * @since 0.1
 */
final class Pixflow_CEI_Core {

	/**
	 * An array of core options that shouldn't be imported.
	 *
	 * @since 0.3
	 * @access private
	 * @var array $core_options
	 */
	static private $core_options = array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);
	
	/**
	 * Check to see if we need to do an export or import.
	 * This should be called by the customize_register action.
	 *
	 * @since 0.1
	 * @since 0.3 Passing $wp_customize to the export and import methods.
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static public function init( $req,$wp_customize, $file )
	{
		if ( current_user_can( 'edit_theme_options' ) ) {
			
			if ( $req == 'export' ) {
				self::_export( $wp_customize );
			}
			if ( $req == 'import' && isset( $file ) ) {
				self::_import( $wp_customize,$file );
			}
		}
	}
	
	/**
	 * Export customizer settings.
	 *
	 * @since 0.1
	 * @since 0.3 Added $wp_customize param and exporting of options.
	 * @access private
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function _export( $wp_customize ) 
	{

		$theme		= get_stylesheet();
		$template	= get_template();
		$charset	= get_option( 'blog_charset' );
		$mods		= get_theme_mods();
		$data		= array(
						  'template'  => $template,
						  'mods'	  => $mods ? $mods : array(),
						  'options'	  => array()
					  );
		
		// Get options from the Customizer API.
		$settings = $wp_customize->settings();
	
		foreach ( $settings as $key => $setting ) {
			
			if ( 'option' == $setting->type ) {
				
				// Don't save widget data.
				if ( stristr( $key, 'widget_' ) ) {
					continue;
				}
				
				// Don't save sidebar data.
				if ( stristr( $key, 'sidebars_' ) ) {
					continue;
				}
				
				// Don't save core options.
				if ( in_array( $key, self::$core_options ) ) {
					continue;
				}
				
				$data['options'][ $key ] = $setting->value();
			}
		}
					  
		// Plugin developers can specify additional option keys to export.
		$option_keys = apply_filters( 'cei_export_option_keys', array() );
		
		foreach ( $option_keys as $option_key ) {
			
			$option_value = get_option( $option_key );
			
			if ( $option_value ) {
				$data['options'][ $option_key ] = $option_value;
			}
		}
		
		// Set the download headers.
		header( 'Content-disposition: attachment; filename=' . $theme . '-export.dat' );
		header( 'Content-Type: application/octet-stream; charset=' . $charset );
		
		// Serialize the export data.
		echo serialize( $data );
		
		// Start the download.
		die();
	}
	
	/**
	 * Imports uploaded mods and calls WordPress core customize_save actions so
	 * themes that hook into them can act before mods are saved to the database.
	 *
	 * @since 0.1
	 * @since 0.3 Added $wp_customize param and importing of options.
	 * @access private
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @param string $file Address of exported file.
	 * @return void
	 */
	static private function _import( $wp_customize,$file )
	{

		require_once 'class-pixflow-cei-option.php';
		
		global $wp_customize;
		global $cei_error;
		
		$cei_error	 = false;
		$template	 = get_template();
		$customizer_file = content_url().'/uploads/demo/customizer.dat';
		$raw = wp_remote_get(
				$customizer_file,
				array(
						"timeout" => 90,
						"sslverify" => false
				)
		);
		$raw = $raw['body'];
		$pos 		 = strpos($raw, 'a:3');
		$raw 		 = substr($raw, $pos);
		$data		 = @unserialize( $raw );
		
		// Data checks.
		if ( 'array' != gettype( $data ) ) {
			$cei_error = esc_attr__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'massive-dynamic' );
			return;
		}
		if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
			$cei_error = esc_attr__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'massive-dynamic' );
			return;
		}
		if ( $data['template'] != $template ) {
			$cei_error = esc_attr__( 'Error importing settings! The settings you uploaded are not for the current theme.', 'massive-dynamic' );
			return;
		}
		
		// Import images.
		//if ( isset( $_REQUEST['cei-import-images'] ) ) {
			$data['mods'] = self::_import_images( $data['mods'] );
		//}
		
		// Import custom options.
		if ( isset( $data['options'] ) ) {
			
			foreach ( $data['options'] as $option_key => $option_value ) {
				
				$option = new Pixflow_CEI_Option( $wp_customize, $option_key, array(
					'default'		=> '',
					'type'			=> 'option',
					'capability'	=> 'edit_theme_options'
				) );

				$option->import( $option_value );
			}
		}
		
		// Call the customize_save action.
		do_action( 'customize_save', $wp_customize );
		
		// Loop through the mods.
		foreach ( $data['mods'] as $key => $val ) {
			
			// Call the customize_save_ dynamic action.
			do_action( 'customize_save_' . $key, $wp_customize );
			
			// Save the mod.
			set_theme_mod( $key, $val );
		}
		
		// Call the customize_save_after action.
		do_action( 'customize_save_after', $wp_customize );
	}
	
	/**
	 * Imports images for settings saved as mods.
	 *
	 * @since 0.1
	 * @access private
	 * @param array $mods An array of customizer mods.
	 * @return array The mods array with any new import data.
	 */
	static private function _import_images( $mods ) 
	{
		foreach ( $mods as $key => $val ) {
			
			if ( self::_is_image_url( $val ) ) {
				
				$data = self::_sideload_image( $val );
				
				if ( ! is_wp_error( $data ) ) {
					
					$mods[ $key ] = $data->url;
					
					// Handle header image controls.
					if ( isset( $mods[ $key . '_data' ] ) ) {
						$mods[ $key . '_data' ] = $data;
						update_post_meta( $data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet() );
					}
				}
			}
		}
		
		return $mods;
	}
	
	/**
	 * Taken from the core media_sideload_image function and
	 * modified to return an array of data instead of html.
	 *
	 * @since 0.1
	 * @access private
	 * @param string $file The image file path.
	 * @return array An array of image data.
	 */
	static private function _sideload_image( $file ) 
	{
		$data = new stdClass();
		
		if ( ! function_exists( 'media_handle_sideload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}
		if ( ! empty( $file ) ) {
			
			// Set variables for storage, fix file filename for query strings.
			preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
			$file_array = array();
			$file_array['name'] = basename( $matches[0] );
	
			// Download file to temp location.
			$file_array['tmp_name'] = download_url( $file );
	
			// If error storing temporarily, return the error.
			if ( is_wp_error( $file_array['tmp_name'] ) ) {
				return $file_array['tmp_name'];
			}
	
			// Do the validation and storage stuff.
			$id = media_handle_sideload( $file_array, 0 );
	
			// If error storing permanently, unlink.
			if ( is_wp_error( $id ) ) {
				@unlink( $file_array['tmp_name'] );
				return $id;
			}
			
			// Build the object to return.
			$meta					= wp_get_attachment_metadata( $id );
			$data->attachment_id	= $id;
			$data->url				= wp_get_attachment_url( $id );
			$data->thumbnail_url	= wp_get_attachment_thumb_url( $id );
			$data->height			= $meta['height'];
			$data->width			= $meta['width'];
		}
	
		return $data;
	}
	
	/**
	 * Checks to see whether a string is an image url or not.
	 *
	 * @since 0.1
	 * @access private
	 * @param string $string The string to check.
	 * @return bool Whether the string is an image url or not.
	 */
	static private function _is_image_url( $string = '' ) 
	{
		if ( is_string( $string ) ) {
			
			if ( preg_match( '/\.(jpg|jpeg|png|gif)/i', $string ) ) {
				return true;
			}
		}
		
		return false;
	}
}
