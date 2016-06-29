<?php
return array(
    'id'          => 'portfolio_options',
    'types'       => array('portfolio'),
    'title'       => esc_attr__('Portfolio Setting', 'massive-dynamic'),
    'priority'    => 'core',
    'repeating' => true,
    'template'    => array(
        array(
            'type' => 'radiobutton',
            'name' => 'template_type',
            'label' => esc_attr__('Content Type', 'massive-dynamic'),
            'items' => array(
                array(
                    'value' => 'standard',
                    'label' => esc_attr__('Static Layout', 'massive-dynamic'),
                ),
                array(
                    'value' => 'shortcode',
                    'label' => esc_attr__('Shortcode Base', 'massive-dynamic'),
                )
            ),
            'default' => array(
                'standard',
            ),
        ),
        array(
            'type' => 'select',
            'name' => 'related_items',
            'label' => esc_attr__('Related Items', 'massive-dynamic'),
            'items' => array(
                array(
                    'value' => 'show',
                    'label' => esc_attr__('Show', 'massive-dynamic'),
                ),
                array(
                    'value' => 'hide',
                    'label' => esc_attr__('Hide', 'massive-dynamic'),
                ),
            ),
            'validation' => 'required',
            'default' => array(
                'show'
            ),
        ),
        array(
            'type'      => 'group',
            'repeating' => false,
            'name'      => 'standard_group',
            'title'     => esc_attr__('Portfolio Options', 'massive-dynamic'),
            'dependency' => array(
                'field' => 'template_type',
                'function' => 'template_is_standard',
            ),
            'fields'    => array(
                array(
                    'type' => 'select',
                    'name' => 'portfolio_template',
                    'label' => esc_attr__('Portfolio Template', 'massive-dynamic'),
                    'items' => array(
                        array(
                            'value' => 'split',
                            'label' => esc_attr__('Split', 'massive-dynamic'),
                        ),
                        array(
                            'value' => 'full',
                            'label' => esc_attr__('Full Width Media', 'massive-dynamic'),
                        ),
                        array(
                            'value' => 'carousel',
                            'label' => esc_attr__('Carousel Media', 'massive-dynamic'),
                        ),
                    ),
                    'validation' => 'required',
                    'default' => array(
                        'split'
                    ),
                ),
                array(
                    'type' => 'select',
                    'name' => 'video_position',
                    'label' => esc_attr__('Video Position', 'massive-dynamic'),
                    'items' => array(
                        array(
                            'value' => 'at_start',
                            'label' => esc_attr__('Before Images', 'massive-dynamic'),
                        ),
                        array(
                            'value' => 'at_end',
                            'label' => esc_attr__('After Images', 'massive-dynamic'),
                        )
                    ),
                    'default' => array(
                        'at_start',
                    ),
                ),
                array(
                    'type' => 'textbox',
                    'name' => 'link_text',
                    'label' => esc_attr__('Portfolio Link Text', 'massive-dynamic'),
                    'description' => esc_attr__('Enter Link text', 'massive-dynamic'),
                ),
                array(
                    'type' => 'textbox',
                    'name' => 'link_url',
                    'label' => esc_attr__('Portfolio Link URL', 'massive-dynamic'),
                    'description' => esc_attr__('Enter Link URL', 'massive-dynamic'),
                    'validation' => 'url',
                ),
                array(
                    'type' => 'wpeditor',
                    'name' => 'content',
                    'label' => esc_attr__('Portfolio Description', 'massive-dynamic'),
                    'use_external_plugins' => '0',
                    'disabled_externals_plugins' => '',
                    'disabled_internals_plugins' => '',
                ),
                array(
                    'type'      => 'group',
                    'repeating' => true,
                    'sortable' => true,
                    'name'      => 'attribute_group',
                    'title'     => esc_attr__('Attribute', 'massive-dynamic'),
                    'fields'    => array(
                        array(
                            'type' => 'textbox',
                            'name' => 'attr_title',
                            'label' => esc_attr__('Attribute Title', 'massive-dynamic'),
                            'description' => esc_attr__('Enter attribute title', 'massive-dynamic'),
                        ),
                        array(
                            'type' => 'textarea',
                            'name' => 'attr_value',
                            'label' => esc_attr__('Attribute Value', 'massive-dynamic'),
                            'description' => esc_attr__('Enter attribute value', 'massive-dynamic'),
                        ),
                        array(
                            'type' => 'toggle',
                            'name' => 'attr_icon_enable',
                            'label' => esc_attr__('Add icon to attribute', 'massive-dynamic'),
                            'default' => '1',
                        ),
                        array(
                            'type' => 'fontawesome',
                            'name' => 'attr_icon',
                            'label' => esc_attr__('Attribute Icon', 'massive-dynamic'),
                            'default' => array(
                                '{{first}}',
                            ),
                            'dependency' => array(
                                'field' => 'attr_icon_enable',
                                'function' => 'portfolio_attr_icon',
                            ),
                        ),
                    ),
                ),
                array(
                    'type'      => 'group',
                    'repeating' => true,
                    'sortable' => true,
                    'name'      => 'gallery_group',
                    'title'     => esc_attr__('Image', 'massive-dynamic'),
                    'fields'    => array(
                        array(
                            'type' => 'upload',
                            'name' => 'images',
                            'label' => esc_attr__('Upload Image', 'massive-dynamic'),
                        ),
                    ),
                ),
                array(
                    'type'      => 'group',
                    'name'      => 'video_group',
                    'repeating' => false,
                    'title'     => esc_attr__('Video', 'massive-dynamic'),
                    'fields'    => array(
                        array(
                            'type' => 'radiobutton',
                            'name' => 'video_src',
                            'label' => esc_attr__('Video Source', 'massive-dynamic'),
                            'description' => esc_attr__('Select Video Source', 'massive-dynamic'),
                            'items' => array(
                                array(
                                    'value' => 'youtube',
                                    'label' => esc_attr__('Youtube', 'massive-dynamic'),
                                ),
                                array(
                                    'value' => 'vimeo',
                                    'label' => esc_attr__('Vimeo', 'massive-dynamic'),
                                ),
                            ),
                            'default' => array(
                                'youtube',
                            ),
                        ),
                        array(
                            'type' => 'textbox',
                            'name' => 'video_url',
                            'label' => esc_attr__('Video URL', 'massive-dynamic'),
                            'description' => esc_attr__('Enter video URL', 'massive-dynamic'),
                            'validation' => 'url'
                        ),
                        array(
                            'type' => 'upload',
                            'name' => 'video_image',
                            'label' => esc_attr__('Video Image', 'massive-dynamic'),
                            'description' => esc_attr__('URL of image to show', 'massive-dynamic'),
                            'validation' => 'url'
                        ),
                        array(
                            'type' => 'toggle',
                            'name' => 'fullsize_image',
                            'label' => esc_attr__('Strech image to whole area', 'massive-dynamic'),
                            'default' => '0',
                        )
                    ),
                ),
            )
        )
    )
);

/**
 * EOF
 */
