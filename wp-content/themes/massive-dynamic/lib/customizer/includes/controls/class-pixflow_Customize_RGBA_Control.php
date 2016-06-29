<?php

class Pixflow_Customize_RGBA_Control extends WP_Customize_Control {

	public $type = 'rgba';

	public $subtitle = '';

	public $separator = false;

	public $required;

    public $class;

    public $opacity;

	public function enqueue() {


        wp_enqueue_style('customizer-controller-rgba',pixflow_path_combine(PIXFLOW_THEME_CUSTOMIZER_URI,'assets/css/spectrum.css'),array(),PIXFLOW_THEME_VERSION);
        wp_enqueue_script('customizer-controller-rgba',pixflow_path_combine(PIXFLOW_THEME_CUSTOMIZER_URI,'assets/js/spectrum.js'),array(),PIXFLOW_THEME_VERSION,true);

	}

    public function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        return 'rgb('.implode(",", $rgb).')'; // returns the rgb values separated by commas
        //return $rgb; // returns an array with the rgb values
    }

    public function render_content() {
        $defaultColor = ($this->value() != '')?$this->value():$this->settings['default']->default;
        $defaultColor = ($defaultColor != '')?$defaultColor:'rgb(0,0,0)';
        if($defaultColor[0] == '#'){
            $defaultColor = $this->hex2rgb($defaultColor);
        }
        ?>
        <label class="<?php echo ' '.esc_attr($this->class); ?>">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo esc_html($this->subtitle); ?></div>
			<?php endif; ?>

			<input type="text" data-alpha="<?php echo esc_attr($this->opacity == true)?'true':'false'; ?>" data-default-color="<?php echo esc_attr($defaultColor) ?>" data-controller-id="<?php echo esc_attr($this->id); ?>" data-controller-type="color" data-controller-transport="<?php echo esc_attr($this->settings['default']->transport);?>" id="input_<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($defaultColor); ?>" <?php $this->link(); ?>/>

		</label>

		<?php if ( $this->separator ) echo '<hr class="customizer-separator">';
	}
}
