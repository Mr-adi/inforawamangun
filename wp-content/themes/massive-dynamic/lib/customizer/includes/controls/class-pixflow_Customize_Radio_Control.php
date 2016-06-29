<?php

class Pixflow_Customize_Radio_Control extends WP_Customize_Control {

	public $type = 'radio';

	public $mode = 'radio';

	public $subtitle = '';

	public $separator = false;

	public $required;

    public $class = '';

	public function enqueue() {
        wp_enqueue_script( 'jquery-ui-button' );
	}

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id;

		?>
        <?php if ( '' != $this->label ) : ?>

            <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
            </span>

        <?php endif; ?>

		<div id="input_<?php echo esc_attr($this->id); ?>" data-name="<?php echo esc_attr( $name ); ?>" data-controller-type="radio" data-controller-transport="<?php echo esc_attr($this->settings['default']->transport);?>" class="<?php echo esc_attr($this->mode); echo ' '.esc_attr($this->class); ?>">
			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo esc_html($this->subtitle); ?></div>
			<?php endif; ?>
			<?php

			// JqueryUI Button Sets
			if ( 'buttonset' == $this->mode ) {

				foreach ( $this->choices as $value => $label ) : ?>
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr($this->id . $value); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo esc_attr($this->id . $value); ?>">
							<?php echo esc_html( $label ); ?>
						</label>
					</input>
					<?php
				endforeach;

			// Image radios.
			} elseif ( 'image' == $this->mode ) {

				foreach ( $this->choices as $value => $label ) : ?>
					<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr($this->id . $value); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo esc_attr($this->id . $value); ?>">
							<img src="<?php echo esc_html( $label ); ?>">
						</label>
					</input>
					<?php
				endforeach;

			// Normal radios
			}else{
                foreach ( $this->choices as $value => $label ) : ?>
                    <span class="customize-control-title radio-item-title">
                        <?php echo esc_html( $label ); ?>
                    </span>
                    <input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr($this->id . $value); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
                    <label class="ui-radio" for="<?php echo esc_attr($this->id . $value); ?>"></label>
                    <br/>
                <?php
                endforeach;

                // Image radios.
            }
			?>
		</div>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">';
	}
}
