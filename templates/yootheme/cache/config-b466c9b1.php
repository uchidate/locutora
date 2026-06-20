<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/Rss/config.json

return [
  'name' => 'rss', 
  'title' => 'RSS', 
  'description' => 'Source based on a RSS feed.', 
  'group' => 'Structured Data', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/Rss/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/rss'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'A name to identify this source.', 
      'attrs' => [
        'autofocus' => true
      ]
    ], 
    'url' => [
      'label' => 'URL', 
      'description' => 'The URL to the RSS feed.'
    ]
  ]
];
