<?php

class Pixflow_Customize_Switch_Control extends WP_Customize_Control {

    public $type = 'switch';

    public $subtitle = '';

    public $separator = false;

    public $required;

    public $text;

    public  $class;

    public function enqueue() {
        wp_enqueue_script( 'jquery-ui-button' );
    }

    public function render_content() {
        ?>
        <div data-unchecked-text="<?php echo esc_attr($this->text['unchecked']); ?>" data-checked-text="<?php echo esc_attr($this->text['checked']); ?>" data-controller-id="<?php echo esc_attr($this->id); ?>" id="input_<?php echo esc_attr($this->id); ?>" class="<?php echo esc_attr($this->class); ?>" data-controller-type="switch" data-controller-transport="<?php echo esc_attr($this->settings['default']->transport);?>">
            <?php if ( '' != $this->subtitle ) : ?>
                <div class="customizer-subtitle"><?php echo esc_html($this->subtitle); ?></div>
            <?php endif; ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" id="<?php echo esc_attr($this->id) ; ?>" <?php $this->link(); checked( $this->value() ); ?> />
                    <label class="ui-switch" for="<?php echo esc_attr($this->id); ?>"></label>
                    <span id="<?php echo esc_attr($this->id).'-switch-status'; ?>" class="customize-control-title switch-status"><?php echo esc_attr($this->value() == 1 ||$this->value() == 'on' )?$this->text['checked']:$this->text['unchecked']; ?></span>
                </div>
        <?php if ( $this->separator ) echo '<hr class="customizer-separator">';
    }
}