<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/CloudflareStream/config.json

return [
  'name' => 'cloudflare-stream', 
  'title' => 'Cloudflare Stream', 
  'description' => 'Source based on Media from Cloudflare Stream.', 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/sources/cloudflare-stream', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/CloudflareStream/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/cloudflare/stream/presave-source'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'A name to identify this source.', 
      'attrs' => [
        'autofocus' => true
      ]
    ], 
    'token' => [
      'label' => 'Token', 
      'type' => 'yooessentials-connected-auth', 
      'connections' => [
        'cloudflare-api-token' => ['de21485a24744b76a004aa153898f7fe', '714f9c13a5684c2885a793f5edb36f59', 'c1fde68c7bcc44588cbb6ddbc16d6480']
      ], 
      'description' => 'The Cloudflare API Token with which to access the resources.'
    ], 
    'account' => [
      'label' => 'Account', 
      'description' => 'The Cloudflare account from which to access the resources.', 
      'type' => 'yooessentials-select-dropdown-async', 
      'endpoint' => 'yooessentials/cloudflare/accounts', 
      'watch' => 'token'
    ], 
    'signing_key' => [
      'label' => 'Signing Key', 
      'type' => 'yooessentials-connected-auth', 
      'connections' => [
        'cloudflare-stream-key' => []
      ], 
      'description' => 'A key for signing Stream private videos URLs, if your streams are public it is not necessary to provide one.'
    ]
  ]
];
