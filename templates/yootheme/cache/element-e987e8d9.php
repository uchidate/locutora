<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form/elements/form_hidden/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_form_hidden', 
  'title' => 'Hidden', 
  'group' => 'Form Essentials', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_hidden/images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', '~yooessentials_url/modules/form/elements/form_hidden/images/iconSmall.svg', $file), 
  'width' => 500, 
  'element' => true, 
  'container' => true, 
  'submittable' => true, 
  'defaults' => [
    'control_id_inherit' => true
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file)
  ], 
  'fields' => [
    'control_value' => [
      'label' => 'Value', 
      'description' => 'The field value.', 
      'source' => true
    ], 
    'control_name' => $config->get('yooessentials.form.fields.control_name'), 
    'control_id' => $config->get('yooessentials.form.fields.control_id'), 
    'control_id_inherit' => $config->get('yooessentials.form.fields.control_id_inherit'), 
    'source' => $config->get('builder.source')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Field', 
          'fields' => ['control_name', 'control_id_inherit', 'control_id', 'control_value']
        ], $config->get('builder.advancedItem')]
    ]
  ]
];
