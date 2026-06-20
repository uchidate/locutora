<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/herzogdupont/modules/elements/elements/hd-image-comparison/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'hd-image-comparison', 
  'title' => 'HD Image Comparison', 
  'group' => 'herzog-dupont', 
  'icon' => $filter->apply('url', 'images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', 'images/iconSmall.svg', $file), 
  'element' => true, 
  'width' => 500, 
  'defaults' => [
    'icon' => 'code', 
    'icon_width' => 40, 
    'slider_background' => 'default', 
    'slider_start' => 50, 
    'margin' => 'default'
  ], 
  'placeholder' => [
    'props' => [
      'image_before' => $filter->apply('url', '~yootheme/theme/assets/images/element-image-placeholder.png', $file), 
      'image_after' => $filter->apply('url', '~yootheme/theme/assets/images/element-image-placeholder.png', $file)
    ]
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'image_before' => [
      'label' => 'Before Image', 
      'type' => 'image', 
      'source' => true
    ], 
    'image_width' => [
      'label' => 'Width', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'image_before'
    ], 
    'image_height' => [
      'label' => 'Height', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'image_before'
    ], 
    'image_before_alt' => [
      'label' => 'Before Image Alt', 
      'description' => 'Enter the first image’s alt attribute.', 
      'source' => true, 
      'enable' => 'image_before'
    ], 
    'image_after' => [
      'label' => 'After Image', 
      'type' => 'image', 
      'source' => true
    ], 
    'image_after_alt' => [
      'label' => 'After Image Alt', 
      'description' => 'Enter the second image’s alt attribute.', 
      'source' => true, 
      'enable' => 'image_after'
    ], 
    'icon' => [
      'label' => 'Slider Icon', 
      'description' => 'Click on the pencil to pick an icon from the icon library.', 
      'type' => 'icon', 
      'source' => true
    ], 
    'image_border' => [
      'label' => 'Border', 
      'description' => 'Select the image\'s border style.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Rounded' => 'rounded', 
        'Circle' => 'circle', 
        'Pill' => 'pill'
      ]
    ], 
    'image_box_shadow' => [
      'label' => 'Box Shadow', 
      'description' => 'Select the image\'s box shadow size.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Small' => 'small', 
        'Medium' => 'medium', 
        'Large' => 'large', 
        'X-Large' => 'xlarge'
      ]
    ], 
    'image_box_decoration' => [
      'label' => 'Box Decoration', 
      'description' => 'Select the image box decoration style.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Default' => 'default', 
        'Primary' => 'primary', 
        'Secondary' => 'secondary', 
        'Floating Shadow' => 'shadow', 
        'Mask' => 'mask'
      ]
    ], 
    'image_box_decoration_inverse' => [
      'type' => 'checkbox', 
      'text' => 'Inverse style', 
      'enable' => '$match(image_box_decoration, \'^(default|primary|secondary)$\')'
    ], 
    'icon_color' => [
      'label' => 'Slider Icon Color', 
      'description' => 'Select the icon color.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Muted' => 'muted', 
        'Emphasis' => 'emphasis', 
        'Primary' => 'primary', 
        'Secondary' => 'secondary', 
        'Success' => 'success', 
        'Warning' => 'warning', 
        'Danger' => 'danger'
      ]
    ], 
    'icon_width' => [
      'label' => 'Slider Icon Width', 
      'description' => 'Set the icon width.'
    ], 
    'slider_background' => [
      'label' => 'Slider Background', 
      'type' => 'select', 
      'options' => [
        'Default' => 'default', 
        'Muted' => 'muted', 
        'Primary' => 'primary', 
        'Secondary' => 'secondary'
      ]
    ], 
    'slider_start' => [
      'label' => 'Slider Start Position', 
      'description' => 'Set the start position of the slider in percent.', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0, 
        'max' => 100, 
        'step' => 1
      ]
    ], 
    'slider_onmousemove' => [
      'label' => 'Slide On Mousemove', 
      'type' => 'checkbox', 
      'text' => 'Change the slider position on mousemove'
    ], 
    'position' => $config->get('builder.position'), 
    'position_left' => $config->get('builder.position_left'), 
    'position_right' => $config->get('builder.position_right'), 
    'position_top' => $config->get('builder.position_top'), 
    'position_bottom' => $config->get('builder.position_bottom'), 
    'position_z_index' => $config->get('builder.position_z_index'), 
    'margin' => $config->get('builder.margin'), 
    'margin_remove_top' => $config->get('builder.margin_remove_top'), 
    'margin_remove_bottom' => $config->get('builder.margin_remove_bottom'), 
    'maxwidth' => $config->get('builder.maxwidth'), 
    'maxwidth_breakpoint' => $config->get('builder.maxwidth_breakpoint'), 
    'block_align' => $config->get('builder.block_align'), 
    'block_align_breakpoint' => $config->get('builder.block_align_breakpoint'), 
    'block_align_fallback' => $config->get('builder.block_align_fallback'), 
    'text_align' => $config->get('builder.text_align'), 
    'text_align_breakpoint' => $config->get('builder.text_align_breakpoint'), 
    'text_align_fallback' => $config->get('builder.text_align_fallback'), 
    'animation' => $config->get('builder.animation'), 
    '_parallax_button' => $config->get('builder._parallax_button'), 
    'visibility' => $config->get('builder.visibility'), 
    'container_padding_remove' => $config->get('builder.container_padding_remove'), 
    'name' => $config->get('builder.name'), 
    'status' => $config->get('builder.status'), 
    'source' => $config->get('builder.source'), 
    'id' => $config->get('builder.id'), 
    'class' => $config->get('builder.cls'), 
    'attributes' => $config->get('builder.attrs'), 
    'css' => [
      'label' => 'CSS', 
      'description' => 'Enter your own custom CSS. The following selectors will be prefixed automatically for this element: <code>.el-element</code>, <code>.el-image-before</code>, <code>.el-image-after</code>', 
      'type' => 'editor', 
      'editor' => 'code', 
      'mode' => 'css', 
      'attrs' => [
        'debounce' => 500
      ]
    ]
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Content', 
          'fields' => ['image_before', [
              'description' => 'Setting just one value preserves the original proportions. The image will be resized and cropped automatically, and where possible, high resolution images will be auto-generated.', 
              'name' => '_image_dimension', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['image_width', 'image_height']
            ], 'image_before_alt', 'image_after', 'image_after_alt', 'icon']
        ], [
          'title' => 'Settings', 
          'fields' => [[
              'label' => 'Image', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['image_border', 'image_box_shadow', 'image_box_decoration', 'image_box_decoration_inverse']
            ], [
              'label' => 'Slider', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['icon_width', 'icon_color', 'slider_background', 'slider_start', 'slider_onmousemove']
            ], [
              'label' => 'General', 
              'type' => 'group', 
              'fields' => ['position', 'position_left', 'position_right', 'position_top', 'position_bottom', 'position_z_index', 'margin', 'margin_remove_top', 'margin_remove_bottom', 'maxwidth', 'maxwidth_breakpoint', 'block_align', 'block_align_breakpoint', 'block_align_fallback', 'text_align', 'text_align_breakpoint', 'text_align_fallback', 'animation', '_parallax_button', 'visibility', 'container_padding_remove']
            ]]
        ], $config->get('builder.advanced')]
    ]
  ]
];
