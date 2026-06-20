<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form/elements/form_recaptcha/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_form_recaptcha', 
  'title' => 'reCAPTCHA', 
  'group' => 'Form Essentials', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_recaptcha/images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_recaptcha/images/iconSmall.svg', $file), 
  'width' => 500, 
  'element' => true, 
  'defaults' => [
    'margin' => 'default', 
    'control_type' => 'v2-checkbox', 
    'recaptcha_version' => 'v2', 
    'control_theme' => 'light', 
    'control_size' => 'normal', 
    'control_action' => 'yoothemepro_form_submit', 
    'control_badge_position' => 'bottomright', 
    'control_threshold' => '0.5'
  ], 
  'placeholder' => [], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file)
  ], 
  'fields' => [
    'control_type' => [
      'label' => 'Type', 
      'type' => 'select', 
      'options' => [
        'reCAPTCHA v3' => 'v3', 
        'reCAPTCHA v2' => [
          '"I\'m not a robot" Checkbox' => 'v2-checkbox', 
          'Invisible reCAPTCHA badge' => 'v2-invisible'
        ]
      ]
    ], 
    'control_action' => [
      'label' => 'Action', 
      'description' => 'The action name for the captcha request. May only contain alphanumeric characters and slashes.', 
      'show' => 'control_type === \'v3\''
    ], 
    'control_theme' => [
      'label' => 'Theme', 
      'type' => 'select', 
      'options' => [
        'Light' => 'light', 
        'Dark' => 'dark'
      ], 
      'show' => 'control_type !== \'v3\''
    ], 
    'control_badge_position' => [
      'label' => 'Position', 
      'type' => 'select', 
      'description' => 'Reposition the reCAPTCHA badge. \'inline\' lets you position it with CSS.', 
      'options' => [
        'Bottom Right' => 'bottomright', 
        'Bottom Left' => 'bottomleft', 
        'Inline' => 'inline'
      ], 
      'show' => 'control_type === \'v2-invisible\''
    ], 
    'control_size' => [
      'label' => 'Size', 
      'type' => 'select', 
      'options' => [
        'Normal' => 'normal', 
        'Compact' => 'compact'
      ], 
      'show' => 'control_type === \'v2-checkbox\''
    ], 
    'control_site_key' => [
      'label' => 'Site Key', 
      'type' => 'text'
    ], 
    'control_secret_key' => [
      'label' => 'Secret Key', 
      'type' => 'text'
    ], 
    'control_label' => [
      'label' => $config->get('yooessentials.form.fields.control_label.label'), 
      'description' => $config->get('yooessentials.form.fields.control_label.description'), 
      'show' => 'control_type === \'v2-checkbox\' || control_type === \'v2-invisible\'', 
      'enable' => 'control_type === \'v2-checkbox\' || control_badge_position === \'inline\''
    ], 
    'control_threshold' => [
      'label' => 'Score Threshold', 
      'description' => 'reCAPTCHA v3 scores run from 0.0 (bot) to 1.0 (human). This is the threshold <b>below</b> which consider the submitter a bot.', 
      'show' => 'control_type === \'v3\''
    ], 
    'control_error_message' => $config->get('yooessentials.form.fields.control_error_message'), 
    'animation' => $config->get('builder.animation'), 
    '_parallax_button' => $config->get('builder._parallax_button'), 
    'visibility' => $config->get('builder.visibility'), 
    'name' => $config->get('builder.name'), 
    'status' => $config->get('builder.status'), 
    'id' => $config->get('builder.id'), 
    'class' => $config->get('builder.cls'), 
    'attributes' => $config->get('builder.attrs'), 
    'source' => $config->get('builder.source'), 
    'css' => [
      'label' => 'CSS', 
      'description' => 'Enter your own custom CSS. The following selectors will be prefixed automatically for this element: <code>.el-element</code>, <code>.el-link</code>', 
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
          'fields' => ['control_type', [
              'description' => 'Set the keys obtained from <a href="https://www.google.com/recaptcha/admin" target="_blank">reCAPTCHA Dashboard</a>.', 
              'name' => '_recaptcha_keys', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['control_site_key', 'control_secret_key']
            ], 'control_badge_position', 'control_label', 'control_theme', 'control_size', 'control_threshold', 'control_action', 'control_error_message']
        ], $config->get('builder.advanced')]
    ]
  ]
];
