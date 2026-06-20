<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/auth-drivers/src/Google/driver.json

return [
  'type' => 'oauth', 
  'name' => 'google', 
  'title' => 'Google OAuth', 
  'description' => 'Google OAuth 2.0 token', 
  'documentation' => 'https://developers.google.com/identity/protocols/oauth2', 
  'services' => ['Google Drive'], 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/auth-drivers/src/Google/icon.svg', $file), 
  'endpoints' => [
    'oauth' => 'https://oauth.zoolanders.com/google', 
    'presave' => 'yooessentials/auth/google/oauth'
  ], 
  'scopes' => [
    'https://www.googleapis.com/auth/drive.readonly' => 'Drive Readonly', 
    'https://www.googleapis.com/auth/drive.metadata.readonly' => 'Drive Metadata Readonly', 
    'https://www.googleapis.com/auth/spreadsheets' => 'Spreadsheets Manage', 
    'https://www.googleapis.com/auth/spreadsheets.readonly' => 'Spreadsheets Readonly', 
    'https://www.googleapis.com/auth/business.readonly' => 'My Business Readonly', 
    'https://www.googleapis.com/auth/business.manage' => 'My Business Manage', 
    'https://www.googleapis.com/auth/youtube.readonly' => 'YouTube Readonly'
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
      'description' => 'Connect to a Google Account and grant the required scope access to our Auth App, you can <a href="https://myaccount.google.com/permissions" target="_blank">revoke</a> those anytime.'
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
