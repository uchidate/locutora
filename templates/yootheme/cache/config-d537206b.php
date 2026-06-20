<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/TikTok/config.json

return [
  'name' => 'tiktok', 
  'title' => 'TikTok', 
  'description' => 'Source based on Media from TikTok.', 
  'group' => 'Social Media', 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/sources/tiktok', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/TikTok/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/tiktok'
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
        'tiktok' => ['video.list']
      ], 
      'description' => 'The TikTok account from which media to create the source.'
    ]
  ]
];
