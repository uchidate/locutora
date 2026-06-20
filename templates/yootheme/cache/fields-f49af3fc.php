<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/core/config/fields.json

return [
  'db' => [
    'name' => [
      'label' => 'Database', 
      'description' => 'The name of the database to connect to.', 
      'attrs' => [
        'placeholder' => $config->get('yooessentials.db.database')
      ]
    ], 
    'host' => [
      'label' => 'Host', 
      'attrs' => [
        'placeholder' => $config->get('yooessentials.db.host')
      ]
    ], 
    'port' => [
      'label' => 'Port', 
      'attrs' => [
        'placeholder' => $config->get('yooessentials.db.port')
      ]
    ], 
    'user' => [
      'label' => 'Username', 
      'attrs' => [
        'placeholder' => '******'
      ]
    ], 
    'password' => [
      'label' => 'Password', 
      'encrypt' => true, 
      'attrs' => [
        'placeholder' => '******'
      ]
    ]
  ]
];
