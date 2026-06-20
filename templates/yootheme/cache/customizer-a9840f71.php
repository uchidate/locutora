<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/core-joomla/config/customizer.json

return [
  '@extend' => [$filter->apply('path', '../../core/config/customizer.json', $file)], 
  'panels' => [
    'yooessentials-advanced' => [
      'fields' => [
        'core.geoipdb' => [
          'description' => 'A path to the <a href="https://www.maxmind.com/en/geoip2-services-and-databases" target="_blank">MaxMind GeoIp Database</a> used for IP Geolocation. Set the path to a City or Country DB manually or install <a href="https://www.akeeba.com/download/akgeoip.html" target="_blank">Akeeba GeoIP Provider</a> plugin, the path will be auto populated.'
        ]
      ]
    ]
  ]
];
