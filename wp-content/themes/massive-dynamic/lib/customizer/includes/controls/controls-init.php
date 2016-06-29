<?php
//sanitize_callback functions
function pixflow_validate_color($value ) {
    $value = str_replace( ' ', '', $value );
    if ( empty( $value ) || is_array( $value ) ) {
        return 'rgba(0,0,0,0)';
    }
    // check hex color
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $value ) ){
        return $value;
    }
    //check RGBA color
    elseif(false !== strpos( $value, 'rgba' )){
        sscanf( $value, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
        return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
    }
    //check RGB color
    elseif(false !== strpos( $value, 'rgb' )){
        sscanf( $value, 'rgb(%d,%d,%d)', $red, $green, $blue );
        return 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
    }else{
        return false;
    }
}
function pixflow_validate_checkbox($value ) {
    return ( ( isset( $value ) && true == $value ) ? true : false );
}
function pixflow_validate_description($value ) {
    return wp_filter_post_kses( $value );;
}
function pixflow_validate_gradient($value ) {
    return $value;
}
function pixflow_validate_radio($value ) {
    if (filter_var($value, FILTER_VALIDATE_URL) === false) {
        return sanitize_key( $value );
    }else{
        return $value;
    }
}
function pixflow_validate_rgba($value ) {
    return pixflow_validate_color($value);
}
function pixflow_validate_slider($value ) {
    if (is_numeric($value)) {
        return $value;
    } else {
        return false;
    }
}
function pixflow_validate_switch($value ) {
    return sanitize_key( $value );
}
function pixflow_validate_text($value ) {
    return wp_kses_post( force_balance_tags( $value ) );
}
function pixflow_validate_textarea($value ) {
    return $value;
}
function pixflow_validate_titletext($value ) {
    return sanitize_title($value);
}
function pixflow_validate_select($value ) {
    //return sanitize_title( $value );
    return $value;
}
function pixflow_validate_image($value ) {
    return esc_url_raw($value);
}
function pixflow_validate_upload($value ) {
    return esc_url_raw($value);
}

/**
 * Build the controls
 */
function pixflow_customizer_controls($wp_customize)
{

    $controls = apply_filters('customizer/controls', array());

    if (isset($controls)) {
        foreach ($controls as $control) {

            // Add Panels
            // Background Control
            if ('background' == $control['type']) {

                $wp_customize->add_setting($control['setting'] . '_color', array(
                    'default' => $control['default']['color'],
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_color'
                ));

                $transport = (!array_key_exists('transport', $control) || $control['transport'] == 'refresh' || $control['transport'] == "") ? 'refresh' : 'postMessage';
                $wp_customize->add_setting($control['setting'] . '_image', array(
                    'default' => $control['default']['image'],
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => $transport,
                    'sanitize_callback' => 'pixflow_validate_image'
                ));

                $wp_customize->add_setting($control['setting'] . '_repeat', array(
                    'default' => $control['default']['repeat'],
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_select'
                ));

                $wp_customize->add_setting($control['setting'] . '_size', array(
                    'default' => $control['default']['size'],
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_radio'
                ));

                $wp_customize->add_setting($control['setting'] . '_attach', array(
                    'default' => $control['default']['attach'],
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_select'
                ));

                $wp_customize->add_setting($control['setting'] . '_position', array(
                    'default' => $control['default']['position'],
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_select'
                ));

                if (false != $control['default']['opacity']) {
                    $wp_customize->add_setting($control['setting'] . '_opacity', array(
                        'default' => $control['default']['opacity'],
                        'type' => 'theme_mod',
                        'capability' => 'edit_theme_options',
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'pixflow_validate_slider'
                    ));
                }
            }
            // Gradient Control
            elseif ('gradient' == $control['type'])
            {

                $wp_customize->add_setting($control['setting'] . '_gradient', array(
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_gradient'
                ));

                $wp_customize->add_setting($control['setting'] . '_color1', array(
                    'default' => isset($control['default']['color1']) ? $control['default']['color1'] : '',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_color'
                ));

                $wp_customize->add_setting($control['setting'] . '_color2', array(
                    'default' => isset($control['default']['color2']) ? $control['default']['color2'] : '',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_color'
                ));

                $wp_customize->add_setting($control['setting'] . '_orientation', array(
                    'default' => 'vertical',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'pixflow_validate_select'
                ));
            }
            // Other Control
            else
            {
                // Add settings
                $transport = (!array_key_exists('transport', $control) || $control['transport'] == 'refresh' || $control['transport'] == "") ? 'refresh' : 'postMessage';
                $wp_customize->add_setting($control['setting'], array(
                    'priority' => $control['priority'],
                    'default' => (array_key_exists('default', $control)) ? $control['default'] : '',
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport' => $transport,
                    'sanitize_callback' => 'pixflow_validate_'.$control['type']
                ));
            }

            // Controls
            if ('checkbox' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Customize_Checkbox_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : '',
                    ))
                );

                // Background Controls
            } elseif ('switch' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Customize_Switch_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : '',
                        'text' => isset($control['text']) ? $control['text'] : array(),
                    ))
                );

                // Background Controls
            } elseif ('background' == $control['type']) {

                if (false != $control['default']['color']) {
                    $wp_customize->add_control(new Pixflow_Customize_RGBA_Control($wp_customize, $control['setting'] . '_color', array(
                            'label' => esc_attr__('Bg Color', 'massive-dynamic'),
                            'section' => $control['section'],
                            'settings' => $control['setting'] . '_color',
                            'priority' => $control['priority'],
                            'description' => null,
                            'separator' => false,
                            'required' => isset($control['required']) ? $control['required'] : array(),
                            'class' => isset($control['class']) ? $control['class'] : '',
                            'separator' => false,
                            'opacity' => true,
                        ))
                    );
                }

                $wp_customize->add_control(new Pixflow_Customize_Image_Control($wp_customize, $control['setting'] . '_image', array(
                        'label' => esc_attr__('Background Settings', 'massive-dynamic'),
                        'section' => $control['section'],
                        'settings' => $control['setting'] . '_image',
                        'priority' => $control['priority'] + 1,
                        'separator' => true,
                        'class' => 'glue first',
                        'required' => isset($control['required']) ? $control['required'] : array(),
                    ))
                );

                $wp_customize->add_control(new Pixflow_Select_Control($wp_customize, $control['setting'] . '_repeat', array(
                        'label' => esc_attr__('Repeat', 'massive-dynamic'),
                        'section' => $control['section'],
                        'settings' => $control['setting'] . '_repeat',
                        'priority' => $control['priority'] + 2,
                        'choices' => array(
                            'no-repeat' => esc_attr__('No Repeat', 'massive-dynamic'),
                            'repeat' => esc_attr__('Repeat All', 'massive-dynamic'),
                            'repeat-x' => esc_attr__('Repeat Horizontally', 'massive-dynamic'),
                            'repeat-y' => esc_attr__('Repeat Vertically', 'massive-dynamic'),
                        ),
                        'separator' => true,
                        'class' => 'glue',
                        'required' => isset($control['required']) ? $control['required'] : array(),
                    ))
                );

                if (false != $control['default']['size']) {
                    $wp_customize->add_control(new Pixflow_Customize_Radio_Control($wp_customize, $control['setting'] . '_size', array(
                            'label' => esc_attr__('Size', 'massive-dynamic'),
                            'section' => $control['section'],
                            'settings' => $control['setting'] . '_size',
                            'priority' => $control['priority'] + 3,
                            'choices' => array(
                                'cover' => esc_attr__('Stretch', 'massive-dynamic'),
                                'inherit' => esc_attr__('Normal', 'massive-dynamic'),
                            ),
                            'mode' => 'buttonset',
                            'separator' => true,
                            'class' => 'glue',
                            'required' => isset($control['required']) ? $control['required'] : array(),
                        ))
                    );
                }

                if (false != $control['default']['attach']) {
                    $wp_customize->add_control(new Pixflow_Select_Control($wp_customize, $control['setting'] . '_attach', array(
                            'label' => esc_attr__('Movement', 'massive-dynamic'),
                            'section' => $control['section'],
                            'settings' => $control['setting'] . '_attach',
                            'priority' => $control['priority'] + 4,
                            'choices' => array(
                                'fixed' => esc_attr__('Fixed', 'massive-dynamic'),
                                'scroll' => esc_attr__('Scroll', 'massive-dynamic'),
                            ),
                            'separator' => true,
                            'class' => 'glue',
                            'required' => isset($control['required']) ? $control['required'] : array(),
                        ))
                    );
                }

                $wp_customize->add_control(new Pixflow_Select_Control($wp_customize, $control['setting'] . '_position', array(
                        'label' => esc_attr__('Position', 'massive-dynamic'),
                        'section' => $control['section'],
                        'settings' => $control['setting'] . '_position',
                        'priority' => $control['priority'] + 5,
                        'choices' => array(
                            'center-top' => esc_attr__('Center Top', 'massive-dynamic'),
                            'center-center' => esc_attr__('Center Center', 'massive-dynamic'),
                            'center-bottom' => esc_attr__('Center Bottom', 'massive-dynamic'),
                            'left-top' => esc_attr__('Left Top', 'massive-dynamic'),
                            'left-center' => esc_attr__('Left Center', 'massive-dynamic'),
                            'left-bottom' => esc_attr__('Left Bottom', 'massive-dynamic'),
                            'right-top' => esc_attr__('Right Top', 'massive-dynamic'),
                            'right-center' => esc_attr__('Right Center', 'massive-dynamic'),
                            'right-bottom' => esc_attr__('Right Bottom', 'massive-dynamic')
                        ),
                        'separator' => (false != $control['default']['opacity']) ? true : false,
                        'class' => (false != $control['default']['opacity']) ? 'glue' : 'glue last',
                        'required' => isset($control['required']) ? $control['required'] : array(),
                    ))
                );

                if (false != $control['default']['opacity']) {
                    $wp_customize->add_control(new Pixflow_Customize_Sliderui_Control($wp_customize, $control['setting'] . '_opacity', array(
                            'label' => esc_attr__(' Opacity', 'massive-dynamic'),
                            'section' => $control['section'],
                            'settings' => $control['setting'] . '_opacity',
                            'priority' => $control['priority'] + 6,
                            'choices' => array(
                                'min' => 0,
                                'max' => 1,
                                'step' => 0.1,
                            ),
                            'default' => 1,
                            'separator' => isset($control['separator']) ? $control['separator'] : false,
                            'required' => isset($control['required']) ? $control['required'] : array(),
                            'class' => 'glue last',
                        ))
                    );
                }

                // gradient Controls
            } elseif ('gradient' == $control['type']) {

                // Gradient Orientation
                $wp_customize->add_control(new Pixflow_Select_Control($wp_customize, $control['setting'] . '_orientation', array(
                        'label' => esc_attr__('Orientation', 'massive-dynamic'),
                        'section' => $control['section'],
                        'settings' => $control['setting'] . '_orientation',
                        'gradient' => 'gradient_' . $control['setting'],
                        'priority' => $control['priority'],
                        'choices' => array(
                            'vertical' => esc_attr__('Vertical', 'massive-dynamic'),
                            'horizontal' => esc_attr__('Horizontal', 'massive-dynamic'),
                        ),
                        'separator' => true,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'default' => 'vertical',
                        'class' => isset($control['class']) ? $control['class'] : ''

                    ))
                );

                // Gradient Preview
                $wp_customize->add_control(new Pixflow_Customize_Gradient_Control($wp_customize, $control['setting'] . '_gradient', array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'] . '_gradient',
                        'gradient' => $control['setting'],
                        'priority' => $control['priority'] + 1,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : '',
                        'color1' => $control['setting'] . '_color1',
                        'color2' => $control['setting'] . '_color2',
                       'separator' => true
                    ))
                );

                // Gradient First Color
                $wp_customize->add_control(new Pixflow_Customize_RGBA_Control($wp_customize, $control['setting'] . '_color1', array(
                        'label' => esc_attr__('Beginning Color', 'massive-dynamic'),
                        'section' => $control['section'],
                        'settings' => $control['setting'] . '_color1',
                        'priority' => $control['priority'] + 2,
                        'description' => null,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : '',
                        'separator' => true,
                        'opacity' => true,
                    ))
                );
                // Gradient Second Color
                $wp_customize->add_control(new Pixflow_Customize_RGBA_Control($wp_customize, $control['setting'] . '_color2', array(
                        'label' => esc_attr__('Destination Color', 'massive-dynamic'),
                        'section' => $control['section'],
                        'settings' => $control['setting'] . '_color2',
                        'priority' => $control['priority'] + 3,
                        'description' => null,
                        'separator' => false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => 'glue last',
                        'opacity' => true,
                    ))
                );
                // Color Controls

            } elseif ('color' == $control['type']) {

                $wp_customize->add_control(new pixflow_Customize_Color_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => isset($control['priority']) ? $control['priority'] : '',
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );

                // Image Controls
            } elseif ('image' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Customize_Image_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );

                // Radio Controls
            } elseif ('radio' == $control['type']) {
                $wp_customize->add_control(new Pixflow_Customize_Radio_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'choices' => $control['choices'],
                        'mode' => isset($control['mode']) ? $control['mode'] : 'radio', // Can be 'radio', 'image' or 'buttonset'.
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : '',
                    ))
                );

                // Select Controls
            } elseif ('select' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Select_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'choices' => $control['choices'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );

                // Slider Controls
            } elseif ('slider' == $control['type']) {
                $wp_customize->add_control(new Pixflow_Customize_Sliderui_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'choices' => $control['choices'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );
                // rgba Controls
            } elseif ('rgba' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Customize_RGBA_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : '',
                        'opacity' => isset($control['opacity']) ? $control['opacity'] : false,
                    ))
                );

                // Text Controls
            } elseif ('text' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Customize_Text_Control($wp_customize, $control['setting'], array(
                        'label' => isset($control['label']) ? $control['label'] : '',
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : '',
                        'icon' => isset($control['icon']) ? $control['icon'] : '',
                        'placeholder' => isset($control['placeholder']) ? $control['placeholder'] : ''
                    ))
                );

                // Description Controls
            } elseif ('description' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Customize_Description_Control($wp_customize, $control['setting'], array(
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );

                // Title Controls
            } elseif ('titletext' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Customize_TitleText_Control($wp_customize, $control['setting'], array(
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );

                // Text area Controls
            } elseif ('textarea' == $control['type']) {

                $wp_customize->add_control(new Pixflow_Customize_Textarea_Control($wp_customize, $control['setting'], array(
                        'label' => $control['label'],
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );

                // Upload Controls
            } elseif ('upload' == $control['type']) {

                $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, $control['setting'], array(
                        'label' => $control['label'],
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );

                // Number Controls
            } elseif ('number' == $control['type']) {

                $wp_customize->add_control(new pixflow_Customize_Number_Control($wp_customize, $control['setting'], array(
                        'label' => $control['label'],
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );

                // Multicheck Controls
            } elseif ('multicheck' == $control['type']) {

                $wp_customize->add_control(new pixflow_Customize_Multicheck_Control($wp_customize, $control['setting'], array(
                        'label' => $control['label'],
                        'section' => $control['section'],
                        'settings' => $control['setting'],
                        'priority' => $control['priority'],
                        'choices' => $control['choices'],
                        'separator' => isset($control['separator']) ? $control['separator'] : false,
                        'required' => isset($control['required']) ? $control['required'] : array(),
                        'class' => isset($control['class']) ? $control['class'] : ''
                    ))
                );
            }
            if (isset($control['required'])) {
                $childs[$control['setting']]['type'] = $control['type'];
                $childs[$control['setting']]['compare'] = (isset($control['compare']) && $control['compare'] == 'and') ? 'and' : 'or';
                $childs[$control['setting']]['required'] = $control['required'];
            }
        }
        foreach ($childs as $id => $child) {
            foreach ($child['required'] as $req) {
                $parent = $req['setting'];
                $parents[$parent] = $req['type'];
            }
        }
        $required = array('childs' => $childs, 'parents' => $parents);
        $_SESSION['required'] = $required;
    }
}

add_action('customize_register', 'pixflow_customizer_controls', 99);
