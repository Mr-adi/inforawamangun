<?php

class Pixflow_Customize_TitleText_Control extends WP_Customize_Control {

    public $type = 'titletext';

    public $subtitle = '';

    public $separator = false;

    public $required;

    public $class;

    public function render_content() { ?>

        <div class="customizer-titletext <?php echo ' '.esc_attr($this->class); ?>">
            <div class="content"><?php echo esc_attr( $this->value() ); ?></div>
        </div>
        <?php if ( $this->separator ) echo '<hr class="customizer-separator">';
    }
}
