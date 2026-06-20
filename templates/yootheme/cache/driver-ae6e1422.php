<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/auth-drivers/src/Facebook/driver.json

return [
  'type' => 'oauth', 
  'name' => 'facebook', 
  'title' => 'Facebook', 
  'description' => 'A Facebook account OAuth connection.', 
  'accessTokenThreshold' => '1 month', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/auth-drivers/src/Facebook/icon.svg', $file), 
  'endpoints' => [
    'oauth' => 'https://oauth.zoolanders.com/facebook', 
    'presave' => 'yooessentials/auth/facebook'
  ], 
  'scopes' => [
    'public_profile' => 'Public Profile', 
    'instagram_basic' => 'Instagram Account Profile', 
    'pages_show_list' => 'Pages Show List', 
    'pages_read_engagement' => 'Pages Read Engagement', 
    'pages_read_user_content' => 'Pages Read User Content'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'Optional name to identify this auth.'
    ], 
    '_scopes' => [
      'label' => 'Scopes', 
      'type' => 'yooessentials-oauth-scopes', 
      'description' => 'The scopes this auth has access to.'
    ], 
    '_oauth_title' => [
      'label' => 'Authentication', 
      'type' => 'yooessentials-info'
    ], 
    '_oauth' => [
      'type' => 'yooessentials-oauth-grant', 
      'show' => '!custom', 
      'description' => 'Connect to a Facebook Account and grant the required scope access to our Auth App, you can revoke those anytime.'
    ], 
    'custom' => [
      'text' => 'Use Custom App', 
      'type' => 'checkbox'
    ], 
    'custom_info' => [
      'type' => 'yooessentials-info', 
      'description' => 'Use a Custom App to make the authentication with.', 
      'show' => 'custom'
    ], 
    '_custom' => [
      'type' => 'fields', 
      'show' => 'custom', 
      'fields' => [
        'accessToken' => [
          'label' => 'Access Token', 
          'encrypt' => true
        ]
      ]
    ]
  ]
];
