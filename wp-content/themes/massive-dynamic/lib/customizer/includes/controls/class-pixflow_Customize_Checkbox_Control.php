<?php

class Pixflow_Customize_Checkbox_Control extends WP_Customize_Control {

	public $type = 'checkbox';

	public $subtitle = '';

	public $separator = false;

	public $required;

    public  $class;

    public function enqueue() {
        wp_enqueue_style('customizer-controller-switchery-css',pixflow_path_combine(PIXFLOW_THEME_CUSTOMIZER_URI,'assets/css/switchery.css'),array(),PIXFLOW_THEME_VERSION);
        wp_enqueue_script('customizer-controller-switchery-js',pixflow_path_combine(PIXFLOW_THEME_CUSTOMIZER_URI,'assets/js/switchery.js'),array(),PIXFLOW_THEME_VERSION,true);
    }

    public function render_content() { ?>
		<label class="customizer-checkbox clearfix <?php echo ' '.esc_attr($this->class); ?>">
			<input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" data-controller-type="checkbox" data-controller-transport="<?php echo esc_attr($this->settings['default']->transport);?>" id="<?php echo esc_attr($this->id) ; ?>" <?php $this->link(); checked( $this->value() ); ?> />
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo esc_html($this->subtitle); ?></div>
			<?php endif; ?>
		</label>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">';?>
    <?php
	}
}
