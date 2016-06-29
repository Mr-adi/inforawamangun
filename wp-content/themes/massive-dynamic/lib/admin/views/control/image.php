<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<img class="vp-input vp-image-field" data-name="<?php echo $name; ?>" src="<?php echo esc_url($value); ?>"/>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>