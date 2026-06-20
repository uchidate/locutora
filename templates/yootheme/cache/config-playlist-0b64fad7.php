<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/YouTube/config-playlist.json

return [
  'name' => 'youtube_playlist', 
  'title' => 'YouTube Playlist', 
  'description' => 'All videos (Private & Unlisted) from your playlist via oAuth.', 
  'group' => 'Social Media', 
  'collection' => 'YouTube', 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/sources/youtube', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/YouTube/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/youtube'
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
        'google' => ['https://www.googleapis.com/auth/youtube.readonly']
      ], 
      'description' => 'The Google account associated with the playlist.'
    ], 
    'playlist_id' => [
      'label' => 'Playlist', 
      'type' => 'yooessentials-select-dropdown-async', 
      'description' => 'The Playslist from which to retrieve the media.', 
      'endpoint' => 'yooessentials/source/youtube/playlists', 
      'watch' => 'account'
    ]
  ]
];
