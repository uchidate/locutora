<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/auth-drivers/src/TikTok/driver.json

return [
  'type' => 'oauth', 
  'name' => 'tiktok', 
  'title' => 'TikTok', 
  'description' => 'A TikTok account OAuth connection.', 
  'documentation' => 'https://developers.tiktok.com/doc/login-kit-manage-user-access-tokens', 
  'services' => ['Personal Account'], 
  'accessTokenThreshold' => '12 hours', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/auth-drivers/src/TikTok/icon.svg', $file), 
  'endpoints' => [
    'oauth' => 'https://oauth.zoolanders.com/tiktok', 
    'presave' => 'yooessentials/auth/tiktok'
  ], 
  'scopes' => [
    'user.info.basic' => 'Read Only access to avatar and display name.', 
    'video.list' => 'Read Only access to public TikTok videos.'
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
      'show' => '!override', 
      'description' => 'Connect to a TikTok Account and grant the required scope access to our Auth App, you can revoke those anytime.'
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
        'clientId' => [
          'label' => 'OAuth Client ID', 
          'description' => 'The public identifier of the app.', 
          'encrypt' => true
        ], 
        'clientSecret' => [
          'label' => 'OAuth Client secret', 
          'description' => 'The secret known only to the application and the authorization server.', 
          'encrypt' => true
        ], 
        'refreshToken' => [
          'label' => 'Refresh Token', 
          'description' => 'The token that will allows us to obtain and refresh an Access Token.', 
          'encrypt' => true
        ], 
        'accessToken' => [
          'label' => 'Access Token', 
          'encrypt' => true, 
          'show' => false
        ]
      ]
    ]
  ]
];
