<?php

class Pixflow_Customize_Sliderui_Control extends WP_Customize_Control {

    public $type = 'slider';

    public $subtitle = '';

    public $separator = false;

    public $required;

    public $class;

    public function enqueue() {

        wp_enqueue_style('nouislider-style',pixflow_path_combine(PIXFLOW_THEME_CUSTOMIZER_URI,'assets/css/jquery.nouislider.css'),array(),PIXFLOW_THEME_VERSION);
        wp_enqueue_script('nouislider-script',pixflow_path_combine(PIXFLOW_THEME_CUSTOMIZER_URI,'assets/js/jquery.nouislider.js'),array(),PIXFLOW_THEME_VERSION);

    }

    public function render_content() {
        $unit = isset($this->choices['unit'])?$this->choices['unit']:''
        ?>
        <span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>
        <label class="<?php echo ' '.esc_attr($this->class); ?>">
            <?php if ( '' != $this->subtitle ) : ?>
                <div class="customizer-subtitle"><?php echo esc_html($this->subtitle); ?></div>
            <?php endif; ?>
            <input class="md-hidden" type="text" id="input_<?php echo esc_attr($this->id); ?>" min="<?php echo esc_attr($this->choices['min']); ?>" max="<?php echo esc_attr($this->choices['max']); ?>" step="<?php echo esc_attr($this->choices['step']); ?>" value="<?php echo esc_attr($this->value()); ?>" <?php esc_attr($this->link()); ?>/>
            <div class="slider-controller" data-transform="<?php echo esc_attr($this->settings['default']->transport); ?>" data-id="<?php echo esc_attr($this->id); ?>" id="slider_<?php echo esc_attr($this->id); ?>" min="<?php echo esc_attr($this->choices['min']); ?>" max="<?php echo esc_attr($this->choices['max']); ?>" step="<?php echo esc_attr($this->choices['step']); ?>" unit="<?php echo esc_attr($unit); ?>" value="<?php echo esc_attr($this->value()); ?>"></div>
            <span id="decimal_<?php echo esc_attr($this->id); ?>" class="slider-value"><?php echo esc_attr($this->value().$unit); ?></span>
        </label>

        <?php
        if ( $this->separator ) echo '<hr class="customizer-separator">';
    }
}
