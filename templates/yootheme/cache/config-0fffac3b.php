<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/Twitter/config.json

return [
  'name' => 'twitter', 
  'title' => 'Twitter', 
  'description' => 'Source based on Twitter content.', 
  'group' => 'Social Media', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/Twitter/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/twitter'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'A name to identify this source.', 
      'attrs' => [
        'autofocus' => true
      ]
    ], 
    'account' => [
      'label' => 'Account', 
      'type' => 'yooessentials-connected-auth', 
      'connections' => [
        'twitter' => ['users.read', 'tweet.read', 'offline.access']
      ], 
      'description' => 'The Twitter account which to connect to.'
    ]
  ]
];
