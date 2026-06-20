<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/GoogleMyBusiness/config.json

return [
  'name' => 'google_mybusiness', 
  'title' => 'Google Business Profile', 
  'description' => 'Source based on a Google Business Profile.', 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/sources/google-business-profile', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/GoogleMyBusiness/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/google-mybusiness'
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
        'google' => ['https://www.googleapis.com/auth/business.manage']
      ], 
      'description' => 'The Google account with which to access the resources.'
    ], 
    'businessAccount' => [
      'label' => 'Business Profile Account', 
      'type' => 'yooessentials-select-dropdown-async', 
      'description' => 'The Google Business Profile account with which to access the locations.', 
      'endpoint' => 'yooessentials/source/google-mybusiness/accounts', 
      'watch' => 'account'
    ], 
    'location' => [
      'label' => 'Location', 
      'type' => 'yooessentials-select-dropdown-async', 
      'description' => 'The Location to use as source.', 
      'endpoint' => 'yooessentials/source/google-mybusiness/locations', 
      'watch' => 'businessAccount'
    ]
  ]
];
