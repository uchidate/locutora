<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form-actions/src/Download/config.json

return [
  'name' => 'download', 
  'title' => 'Download File', 
  'description' => 'Trigger a file download.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form-actions/src/Download/icon.svg', $file), 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/forms/action/download', 
  'fields' => [
    'file' => [
      'label' => 'File', 
      'description' => 'Pick or input a file to be downloaded.', 
      'type' => 'yooessentials-file', 
      'mode' => 'file', 
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
          'fields' => ['file']
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'conditions']
        ]]
    ]
  ]
];
