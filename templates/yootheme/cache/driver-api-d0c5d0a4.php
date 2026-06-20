<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/auth-drivers/src/Google/driver-api.json

return [
  'name' => 'google-api-key', 
  'title' => 'Google API Key', 
  'description' => 'Google API Key', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/auth-drivers/src/Google/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/auth/google/api'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'Optional name to identify this key.'
    ], 
    'key' => [
      'label' => 'API Key', 
      'description' => 'The Google API Key, create a new one if necessary within the <a href="https://console.cloud.google.com/apis/credentials" target="_blank">Google Cloud Platform</a>.', 
      'encrypt' => true
    ]
  ]
];
