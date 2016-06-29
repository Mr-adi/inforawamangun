<?php

class Pixflow_Customize_Textarea_Control extends WP_Customize_Control {

	public $type = 'textarea';

	public $subtitle = '';

	public $separator = false;

	public $required;

    public $class;

	public function render_content() { ?>
		<label class="customizer-textarea <?php echo ' '.esc_attr($this->class); ?>">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo esc_html($this->subtitle); ?></div>
			<?php endif; ?>

			<textarea id="<?php echo esc_attr($this->id) ?>" data-controller-type="textarea" data-controller-transport="<?php echo esc_attr($this->settings['default']->transport);?>" class="of-input" rows="5" style="width:100%;" <?php $this->link(); ?> placeholder="<?php esc_attr_e('Write Text ...','massive-dynamic'); ?>"><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">';?>
    <?php
	}
}
