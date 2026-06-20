<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/herzogdupont/modules/elements/elements/hd-progress/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'hd-progress', 
  'title' => 'HD Progress', 
  'group' => 'herzog-dupont', 
  'icon' => $filter->apply('url', 'images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', 'images/iconSmall.svg', $file), 
  'element' => true, 
  'container' => true, 
  'width' => 500, 
  'defaults' => [
    'content' => 'Lorem ipsum dolor sit amet', 
    'start' => 0, 
    'max' => 100, 
    'stop' => 70, 
    'animation_step' => 1, 
    'animation_speed' => 10, 
    'margin' => 'default'
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'content' => [
      'label' => 'Content', 
      'description' => 'Content that will be displayed above the progress bar', 
      'type' => 'editor', 
      'source' => true, 
      'attrs' => [
        'rows' => 10, 
        'placeholder' => 'Enter text...'
      ]
    ], 
    'start' => [
      'label' => 'Start Value', 
      'description' => 'Set the initial value of the progress bar', 
      'type' => 'number', 
      'source' => true
    ], 
    'stop' => [
      'label' => 'Stop Value', 
      'description' => 'Set the value at which the animation should stop', 
      'type' => 'number', 
      'source' => true
    ], 
    'max' => [
      'label' => 'Max Value', 
      'description' => 'Set the maximum value of the progress bar', 
      'type' => 'number', 
      'source' => true
    ], 
    'animation_step' => [
      'label' => 'Animation Step Size', 
      'description' => 'Set the size of an animation step', 
      'type' => 'number', 
      'source' => true
    ], 
    'animation_speed' => [
      'label' => 'Animation Speed', 
      'description' => 'Set the animation speed in ms', 
      'type' => 'number', 
      'source' => true
    ], 
    'progress_value_color' => [
      'label' => 'Progress Value Color', 
      'description' => 'Set the value for the progress bar', 
      'type' => 'color'
    ], 
    'progress_background_color' => [
      'label' => 'Progress Background Color', 
      'description' => 'Set the background color for the progress bar', 
      'type' => 'color'
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
    'text_align' => $config->get('builder.text_align_justify'), 
    'text_align_breakpoint' => $config->get('builder.text_align_breakpoint'), 
    'text_align_fallback' => $config->get('builder.text_align_justify_fallback'), 
    'animation' => $config->get('builder.animation'), 
    '_parallax_button' => $config->get('builder._parallax_button'), 
    'visibility' => $config->get('builder.visibility'), 
    'name' => $config->get('builder.name'), 
    'status' => $config->get('builder.status'), 
    'source' => $config->get('builder.source'), 
    'id' => $config->get('builder.id'), 
    'class' => $config->get('builder.cls'), 
    'attributes' => $config->get('builder.attrs'), 
    'css' => [
      'label' => 'CSS', 
      'description' => 'Enter your own custom CSS. The following selectors will be prefixed automatically for this element: <code>.el-element</code>', 
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
          'fields' => ['content', 'start', 'stop', 'max']
        ], [
          'title' => 'Settings', 
          'fields' => ['animation_step', 'animation_speed', 'progress_value_color', 'progress_background_color', [
              'label' => 'General', 
              'type' => 'group', 
              'fields' => ['position', 'position_left', 'position_right', 'position_top', 'position_bottom', 'position_z_index', 'margin', 'margin_remove_top', 'margin_remove_bottom', 'maxwidth', 'maxwidth_breakpoint', 'block_align', 'block_align_breakpoint', 'block_align_fallback', 'text_align', 'text_align_breakpoint', 'text_align_fallback', 'animation', '_parallax_button', 'visibility']
            ]]
        ], $config->get('builder.advanced')]
    ]
  ]
];
