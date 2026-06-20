<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form/elements/form_frcaptcha/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_form_frcaptcha', 
  'title' => 'Friendly Captcha', 
  'group' => 'Form Essentials', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_frcaptcha/images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_frcaptcha/images/iconSmall.svg', $file), 
  'width' => 500, 
  'element' => true, 
  'placeholder' => [], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file)
  ], 
  'defaults' => [
    'control_endpoint' => 'global'
  ], 
  'fields' => [
    'control_site_key' => [
      'label' => 'Site Key', 
      'type' => 'text'
    ], 
    'control_secret_key' => [
      'label' => 'API Key', 
      'type' => 'text'
    ], 
    'control_endpoint' => [
      'label' => 'Endpoint', 
      'description' => 'Choose the primary endpoint for the puzzles and verification requests. Note that this feature requires a FriendlyCaptcha premium plan and be specifically enabled in it App configuration.', 
      'source' => true, 
      'type' => 'select', 
      'options' => [
        'Global' => 'global', 
        'EU' => 'eu'
      ]
    ], 
    'control_language' => [
      'label' => 'Language', 
      'description' => 'Set the language for the Captcha, defaults to the site language.', 
      'source' => true, 
      'type' => 'data-list', 
      'options' => [
        'English' => 'en', 
        'French' => 'fr', 
        'German' => 'de', 
        'Italian' => 'it', 
        'Dutch' => 'nl', 
        'Portuguese' => 'pt', 
        'Spanish' => 'es', 
        'Catalan' => 'ca', 
        'Danish' => 'da', 
        'Japanese' => 'ja', 
        'Russian' => 'ru', 
        'Swedish' => 'sv', 
        'Greek' => 'el', 
        'Ukrainian' => 'uk', 
        'Bulgarian' => 'bg', 
        'Czech' => 'cs', 
        'Slovak' => 'sk', 
        'Norwegian' => 'no', 
        'Finnish' => 'fi', 
        'Latvian' => 'lv', 
        'Lithuanian' => 'lt', 
        'Polish' => 'pl', 
        'Estonian' => 'et', 
        'Croatian' => 'hr', 
        'Serbian' => 'sr', 
        'Slovenian' => 'sl', 
        'Hungarian' => 'hu', 
        'Romanian' => 'ro'
      ]
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
          'fields' => [[
              'description' => 'Set the keys obtained from <a href="https://docs.friendlycaptcha.com/#/installation?id=_1-generating-a-sitekey" target="_blank">Friendly Captcha</a>.', 
              'name' => '_captcha_keys', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['control_site_key', 'control_secret_key']
            ], 'control_label', 'control_endpoint', 'control_language', 'control_error_message']
        ], $config->get('builder.advanced')]
    ]
  ]
];
