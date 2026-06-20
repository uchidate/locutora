<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/Facebook/config.json

return [
  'name' => 'facebook', 
  'title' => 'Facebook', 
  'description' => 'Source based on Facebook Pages.', 
  'group' => 'Social Media', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/Facebook/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/facebook'
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
        'facebook' => ['pages_show_list', 'pages_read_engagement', 'pages_read_user_content']
      ], 
      'description' => 'The Facebook account which to connect to.'
    ], 
    'page_id' => [
      'enable' => 'account', 
      'label' => 'Page', 
      'description' => 'The Facebook Page from which to fetch the content.', 
      'type' => 'yooessentials-select-dropdown-async', 
      'endpoint' => 'yooessentials/source/facebook/pages', 
      'account' => 'account'
    ]
  ]
];
