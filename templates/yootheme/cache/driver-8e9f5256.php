<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/auth-drivers/src/Twitter/driver.json

return [
  'type' => 'oauth', 
  'name' => 'twitter', 
  'title' => 'Twitter', 
  'description' => 'A Twitter account OAuth2 connection.', 
  'services' => ['Twitter'], 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/auth-drivers/src/Twitter/icon.svg', $file), 
  'endpoints' => [
    'id' => 'yooessentials/auth/twitter/id', 
    'oauth' => 'https://oauth.zoolanders.com/twitter', 
    'presave' => 'yooessentials/auth/twitter'
  ], 
  'poll' => true, 
  'scopes' => [
    'users.read' => 'Public Profile', 
    'tweet.read' => 'Read Tweets', 
    'offline.access' => 'Continuous Access'
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
      'description' => 'Connect to a Twitter Account and grant the required scope access to our Auth App, you can revoke those anytime.'
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
        ]
      ]
    ]
  ]
];
