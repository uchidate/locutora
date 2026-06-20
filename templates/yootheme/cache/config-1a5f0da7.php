<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/Instagram/config.json

return [
  'name' => 'instagram', 
  'title' => 'Instagram', 
  'description' => 'Source based on Instagram Personal account.', 
  'group' => 'Social Media', 
  'collection' => 'Instagram', 
  'collectionDescription' => 'Sources based on Instagram media.', 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/sources/instagram', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/Instagram/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/instagram'
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
        'instagrambasic' => ['user_profile', 'user_media']
      ], 
      'description' => 'The Instagram account from which media to create the source.'
    ]
  ]
];
