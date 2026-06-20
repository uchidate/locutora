<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/auth-drivers/src/AWS/driver.json

return [
  'type' => 'auth', 
  'name' => 'aws', 
  'title' => 'AWS', 
  'description' => 'Amazon Web Services account connection.', 
  'documentation' => 'https://docs.aws.amazon.com/IAM/latest/UserGuide/id_credentials_access-keys.html', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/auth-drivers/src/AWS/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/auth/aws'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'Optional name to identify this auth.'
    ], 
    '_access_key' => [
      'description' => 'The AWS Access Key and it Secret.', 
      'type' => 'grid', 
      'width' => '1-2', 
      'fields' => [
        'access_key_id' => [
          'label' => 'Access Key ID', 
          'type' => 'text', 
          'encrypt' => true
        ], 
        'access_key_secret' => [
          'label' => 'Access Key Secret', 
          'type' => 'yooessentials-password', 
          'encrypt' => true
        ]
      ]
    ]
  ]
];
