<?php

class Pixflow_Customize_Gradient_Control extends WP_Customize_Control {

	public $type = 'gradient';

	public $subtitle = '';

	public $separator = false;

	public $required;

    public $class = '';

    public $gradient = '';

    public $color1 = '';

    public $color2 = '';

	public function enqueue() {
        wp_enqueue_script('customizer-controller-gradient',pixflow_path_combine(PIXFLOW_THEME_CUSTOMIZER_URI,'assets/js/gradient.js'),array(),PIXFLOW_THEME_VERSION,true);
    }

	public function render_content() {
        $color1 = pixflow_get_theme_mod($this->color1,constant('PIXFLOW_'.strtoupper($this->color1)));
        $color2 = pixflow_get_theme_mod($this->color2,constant('PIXFLOW_'.strtoupper($this->color2)));
        $orientation = esc_attr(pixflow_get_theme_mod($this->gradient.'_orientation',constant('PIXFLOW_'.strtoupper($this->gradient.'_orientation'))));
        $color1 = ($color1 != '')?$color1:'rgba(0, 0, 0, 1)';
        $color2 = ($color2 != '')?$color2:'rgba(255, 255, 255, 1)';
        $orientation = ($orientation != '')?$orientation:'horizontal';
        ?>
		<label class="<?php echo ' '.esc_attr($this->class); ?>">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>
			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo esc_html($this->subtitle); ?></div>
			<?php endif; ?>
            <div id="gradient_<?php echo esc_attr($this->id); ?>" class="gradient_preview"></div>
		</label>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; ?>
		<style>
            #gradient_<?php echo esc_attr($this->id); ?>{
                background: <?php echo esc_attr($color1) ?>; /* Old browsers */
                <?php if($orientation == 'horizontal'){ ?>
                background: -moz-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(100%,<?php echo esc_attr($color2) ?>)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%); /* IE10+ */
                background: linear-gradient(to right,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%); /* W3C */
                <?php }else{ ?>
                background: -moz-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(100%,<?php echo esc_attr($color2) ?>)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%); /* IE10+ */
                background: linear-gradient(to bottom,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%); /* W3C */
                <?php } ?>
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo esc_attr($color1) ?>', endColorstr='<?php echo esc_attr($color2) ?>',GradientType=0 ); /* IE6-8 */
            }
        </style>
        <?php
	}
}
