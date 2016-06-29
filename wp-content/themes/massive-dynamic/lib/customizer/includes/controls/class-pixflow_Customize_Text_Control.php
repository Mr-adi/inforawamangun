<?php

class Pixflow_Customize_Text_Control extends WP_Customize_Control {

	public $type = 'text';

	public $subtitle = '';

	public $separator = false;

	public $required;

    public $class;

    public $icon;

    public $placeholder;

	public function render_content() {
        $titleClass = ( $this->icon != '' )? $this->icon:'customize-control-title';
        $placeHolderText = ( $this->placeholder == '' || $this->placeholder == null )? 'Write Something Here':$this->placeholder;
        ?>

		<label class="customizer-text <?php echo ' '.esc_attr($this->class); ?>">
			<span class="  <?php echo esc_attr($titleClass); ?>">
				<?php echo esc_html( $this->label ); ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle "><?php echo esc_html($this->subtitle); ?></div>
			<?php endif; ?>

			<input type="text" data-controller-type="text" data-controller-transport="<?php echo esc_attr($this->settings['default']->transport);?>" id="<?php echo esc_attr($this->id) ?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> placeholder="<?php echo esc_attr($placeHolderText); ?>" />
		</label>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">';?>
    <?php
	}
}
