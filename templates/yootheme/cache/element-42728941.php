<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form/elements/form_honeypot/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_form_honeypot', 
  'title' => 'Honeypot Anti-Spam', 
  'group' => 'Form Essentials', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_honeypot/images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_honeypot/images/iconSmall.svg', $file), 
  'width' => 500, 
  'element' => true, 
  'defaults' => [
    'control_min_seconds' => 5
  ], 
  'placeholder' => [], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file)
  ], 
  'fields' => [
    'control_min_seconds' => [
      'type' => 'number', 
      'label' => 'Min seconds', 
      'description' => 'A submission done in less than the specified seconds will be considered invalid.'
    ], 
    'control_error_message' => $config->get('yooessentials.form.fields.control_error_message')
  ]
];
