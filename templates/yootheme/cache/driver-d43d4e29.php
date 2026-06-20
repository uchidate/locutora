<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/auth-drivers/src/Instagram/driver.json

return [
  'type' => 'oauth', 
  'name' => 'instagrambasic', 
  'title' => 'Instagram', 
  'description' => 'An Instagram account OAuth connection.', 
  'services' => ['Personal Account'], 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/auth-drivers/src/Instagram/icon.svg', $file), 
  'accessTokenThreshold' => '1 month', 
  'endpoints' => [
    'oauth' => 'https://oauth.zoolanders.com/instagrambasic', 
    'presave' => 'yooessentials/auth/instagram-basic'
  ], 
  'scopes' => [
    'user_profile' => 'Profile Information', 
    'user_media' => 'Media'
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
      'description' => 'Connect to an Instagram Account and grant the required scope access to our Auth App, you can revoke those anytime.'
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
          'description' => 'The User Access Token.', 
          'encrypt' => true
        ]
      ]
    ]
  ]
];
