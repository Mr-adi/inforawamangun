<?php

class Pixflow_Select_Control extends WP_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'select';

    public $subtitle = '';

    public $separator = false;

    public $required;

    public $class;

    public function render_content() {

        if ( empty( $this->choices ) ) {
            return;
        } ?>

        <label class="<?php echo ' '.esc_attr($this->class); ?>">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?>
			</span>

            <?php if ( '' != $this->subtitle ) : ?>
                <div class="customizer-subtitle"><?php echo esc_html($this->subtitle); ?></div>
            <?php endif; ?>

            <div class="ios-select" data-id="<?php echo esc_attr($this->id); ?>">
                <input type="text" style="display: none" data-id="<?php echo esc_attr($this->id); ?>" data-controller-type="select" id="input_<?php echo esc_attr($this->id); ?>" disabled value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?>/>
                <div class="flash"></div>
                <div class="items"></div>

                <div id="select_<?php echo esc_attr($this->id); ?>" class="select-outline">
                    <div class="select" parent="<?php echo esc_attr($this->id); ?>">
                        <?php
                        foreach ( $this->choices as $value => $label ) {
                            $selected = '';
                            if( $this->value() == $value) $selected = 'selected';
                            ?>

                            <span value="<?php echo esc_attr($value) ?>" class="select-item <?php echo esc_attr($selected);?>">
                                <?php  echo  esc_attr($label) ;  ?>
                                <span class="cd-dropdown-option"></span>
                            </span>

                        <?php  } ?>
                    </div>
                </div>

            </div>
        </label>
        <?php if ( $this->separator ) echo '<hr class="customizer-separator">';
    }
}
