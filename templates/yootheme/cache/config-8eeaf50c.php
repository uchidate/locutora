<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form-actions/src/Message/config.json

return [
  'name' => 'message', 
  'title' => 'Display Message', 
  'description' => 'Display a message in a modal.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form-actions/src/Message/icon.svg', $file), 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/forms/action/message', 
  'fields' => [
    'content' => [
      'type' => 'editor', 
      'mode' => 'text/html', 
      'label' => 'Message', 
      'description' => 'The content to display in the modal.', 
      'source' => true, 
      'formPlaceholder' => true
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
          'fields' => ['content']
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'conditions']
        ]]
    ]
  ]
];
