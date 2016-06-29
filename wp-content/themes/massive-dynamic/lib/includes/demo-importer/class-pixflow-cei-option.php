<?php
	
/**
 * A class that extends WP_Customize_Setting so we can access
 * the protected updated method when importing options.
 *
 * @since 0.3
 */
if (!class_exists('WP_Customize_Setting')) {
	require_once ABSPATH . WPINC . '/class-wp-customize-setting.php';
}
final class Pixflow_CEI_Option extends WP_Customize_Setting {
	
	/**
	 * Import an option value for this setting.
	 *
	 * @since 0.3
	 * @param mixed $value The option value.
	 * @return void
	 */
	public function import( $value ) 
	{
		$this->update( $value );	
	}
}