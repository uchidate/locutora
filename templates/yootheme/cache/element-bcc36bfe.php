<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form/elements/form_hcaptcha/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_form_hcaptcha', 
  'title' => 'hCaptcha', 
  'group' => 'Form Essentials', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_hcaptcha/images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_hcaptcha/images/iconSmall.svg', $file), 
  'width' => 500, 
  'element' => true, 
  'defaults' => [
    'control_type' => 'checkbox', 
    'control_theme' => 'light', 
    'control_size' => 'normal', 
    'control_threshold' => '0.5', 
    'control_compliance' => 'This site is protected by hCaptcha and its <a href="https://hcaptcha.com/privacy">Privacy Policy</a> and <a href="https://hcaptcha.com/terms">Terms of Service</a> apply.'
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
        'Checkbox' => 'checkbox', 
        'Invisible' => 'invisible'
      ]
    ], 
    'control_theme' => [
      'label' => 'Theme', 
      'type' => 'select', 
      'options' => [
        'Light' => 'light', 
        'Dark' => 'dark'
      ]
    ], 
    'control_size' => [
      'label' => 'Size', 
      'type' => 'select', 
      'options' => [
        'Normal' => 'normal', 
        'Compact' => 'compact'
      ], 
      'show' => 'control_type === \'checkbox\''
    ], 
    'control_site_key' => [
      'label' => 'Site Key', 
      'type' => 'text'
    ], 
    'control_secret_key' => [
      'label' => 'Secret Key', 
      'type' => 'text'
    ], 
    'control_threshold' => [
      'label' => 'Score Threshold (Enterprise only)', 
      'description' => 'hCaptcha scores run from 0.0 (no risk) to 1.0 (confirmed threat). This is the threshold <b>over</b> which consider the submitter a bot.'
    ], 
    'control_compliance' => [
      'label' => 'Compliance', 
      'description' => 'A legally required text to comply with online privacy laws. Make sure it links to hCaptcha <a href="https://hcaptcha.com/privacy">Privacy Policy</a> and <a href="https://hcaptcha.com/terms">Terms of Service</a>', 
      'show' => 'control_type === \'invisible\''
    ], 
    'control_label' => $config->get('yooessentials.form.fields.control_label'), 
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
              'description' => 'Set the keys obtained from <a href="https://dashboard.hcaptcha.com" target="_blank">hCaptcha Dashboard</a>.', 
              'name' => '_captcha_keys', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['control_site_key', 'control_secret_key']
            ], 'control_label', 'control_theme', 'control_size', 'control_threshold', 'control_compliance', 'control_error_message']
        ], $config->get('builder.advanced')]
    ]
  ]
];
