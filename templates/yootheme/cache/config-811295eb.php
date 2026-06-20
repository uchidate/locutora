<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/YouTube/config.json

return [
  'name' => 'youtube', 
  'title' => 'YouTube', 
  'description' => 'Advanced query of public videos via API Key.', 
  'group' => 'Social Media', 
  'collection' => 'YouTube', 
  'collectionDescription' => 'Sources based on YouTube media.', 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/sources/youtube', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/YouTube/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/youtube'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'A name to identify this source.', 
      'attrs' => [
        'autofocus' => true
      ]
    ], 
    'api_key' => [
      'label' => 'API Key', 
      'type' => 'yooessentials-connected-auth', 
      'connections' => [
        'google-api-key' => []
      ], 
      'description' => 'The Google API Key with which to access the media.'
    ]
  ]
];
