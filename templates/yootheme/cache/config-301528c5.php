<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form-actions/src/Redirect/config.json

return [
  'name' => 'redirect', 
  'title' => 'Redirect', 
  'description' => 'Redirect the browser to a custom url.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form-actions/src/Redirect/icon.svg', $file), 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/forms/action/redirect', 
  'fields' => [
    'redirect' => [
      'label' => 'Redirect To', 
      'description' => 'Where should we redirect the user to.', 
      'type' => 'link', 
      'source' => true, 
      'formPlaceholder' => true
    ], 
    'blank' => [
      'text' => 'Redirect to a New Window', 
      'type' => 'checkbox'
    ], 
    'timeout' => [
      'label' => 'Timeout', 
      'description' => 'Time to wait (secs) before triggering the redirect.', 
      'attrs' => [
        'type' => 'number', 
        'default' => '0'
      ]
    ], 
    'name' => $config->get('yooessentials.form.fields.action_name'), 
    'status' => $config->get('yooessentials.form.fields.action_status'), 
    'conditions' => $config->get('yooessentials.form.fields.action_conditions')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Action', 
          'fields' => ['redirect', 'blank', 'timeout']
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'conditions']
        ]]
    ]
  ]
];
