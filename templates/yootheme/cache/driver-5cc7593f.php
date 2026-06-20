<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/auth-drivers/src/ApiKey/driver.json

return [
  'name' => 'api-key', 
  'title' => 'API Key', 
  'description' => 'Key for authenticating API requests.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/auth-drivers/src/ApiKey/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/auth/api-key'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'Optional name to identify this key.'
    ], 
    'key' => [
      'label' => 'API Key', 
      'description' => 'The API Key created within a service.', 
      'encrypt' => true
    ]
  ]
];
