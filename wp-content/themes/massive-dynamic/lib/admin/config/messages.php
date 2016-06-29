<?php

return array(

	////////////////////////////////////////
	// Localized JS Message Configuration //
	////////////////////////////////////////

	/**
	 * Validation Messages
	 */
	'validation' => array(
		'alphabet'     => esc_attr__('Value needs to be Alphabet', 'massive-dynamic'),
		'alphanumeric' => esc_attr__('Value needs to be Alphanumeric', 'massive-dynamic'),
		'numeric'      => esc_attr__('Value needs to be Numeric', 'massive-dynamic'),
		'email'        => esc_attr__('Value needs to be Valid Email', 'massive-dynamic'),
		'url'          => esc_attr__('Value needs to be Valid URL', 'massive-dynamic'),
		'maxlength'    => esc_attr__('Length needs to be less than {0} characters', 'massive-dynamic'),
		'minlength'    => esc_attr__('Length needs to be more than {0} characters', 'massive-dynamic'),
		'maxselected'  => esc_attr__('Select no more than {0} items', 'massive-dynamic'),
		'minselected'  => esc_attr__('Select at least {0} items', 'massive-dynamic'),
		'required'     => esc_attr__('This is required', 'massive-dynamic'),
	),

	/**
	 * Import / Export Messages
	 */
	'util' => array(
		'import_success'    => esc_attr__('Import succeed, option page will be refreshed..', 'massive-dynamic'),
		'import_failed'     => esc_attr__('Import failed', 'massive-dynamic'),
		'export_success'    => esc_attr__('Export succeed, copy the JSON formatted options', 'massive-dynamic'),
		'export_failed'     => esc_attr__('Export failed', 'massive-dynamic'),
		'restore_success'   => esc_attr__('Restoration succeed, option page will be refreshed..', 'massive-dynamic'),
		'restore_nochanges' => esc_attr__('Options identical to default', 'massive-dynamic'),
		'restore_failed'    => esc_attr__('Restoration failed', 'massive-dynamic'),
	),

	/**
	 * Control Fields String
	 */
	'control' => array(
		// select2 select box
		'select2_placeholder' => esc_attr__('Select option(s)', 'massive-dynamic'),
		// fontawesome chooser
		'fac_placeholder'     => esc_attr__('Select an Icon', 'massive-dynamic'),
	),

);

/**
 * EOF
 */