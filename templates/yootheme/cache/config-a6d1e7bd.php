<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/Vimeo/config.json

return [
  'name' => 'vimeo', 
  'title' => 'Vimeo', 
  'description' => 'Source based on Media from Vimeo.', 
  'group' => 'Social Media', 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/sources/vimeo', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/Vimeo/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/vimeo'
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
        'vimeo' => ['video_files']
      ], 
      'description' => 'The Vimeo account from which media to create the source.'
    ]
  ]
];
