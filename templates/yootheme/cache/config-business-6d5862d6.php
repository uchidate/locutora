<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/Instagram/config-business.json

return [
  'name' => 'instagram_business', 
  'title' => 'Instagram Business', 
  'description' => 'Source based on Instagram Business account.', 
  'group' => 'Social Media', 
  'collection' => 'Instagram', 
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
        'facebook' => ['instagram_basic', 'pages_show_list', 'pages_read_engagement']
      ], 
      'description' => 'The Facebook account with which to connect.'
    ], 
    'page_id' => [
      'label' => 'Page', 
      'description' => 'The Facebook Page associated with the Instagram Business account.', 
      'type' => 'yooessentials-select-dropdown-async', 
      'endpoint' => 'yooessentials/source/instagram/pages', 
      'watch' => 'account'
    ]
  ]
];
