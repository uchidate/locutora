<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/element/elements/social_sharing_viber/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_social_sharing_viber', 
  'title' => 'Viber', 
  'iconSmall' => $filter->apply('url', '~yooessentials_url/modules/element/elements/social_sharing_viber/icon.svg', $file), 
  'width' => 500, 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'defaults' => [
    'text' => ''
  ], 
  'fields' => [
    'text' => [
      'label' => 'text', 
      'description' => 'The text to forward to.', 
      'source' => true
    ], 
    'title' => [
      'label' => 'Title', 
      'description' => 'Optionally set the title for the link.'
    ], 
    'icon' => [
      'label' => 'Icon', 
      'description' => 'Choose an icon from the icon library.', 
      'type' => 'icon', 
      'source' => true
    ], 
    'status' => $config->get('builder.status'), 
    'id' => $config->get('builder.id'), 
    'class' => $config->get('builder.cls'), 
    'attributes' => $config->get('builder.attrs'), 
    'source' => $config->get('builder.source')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Content', 
          'fields' => ['text', 'icon', 'title']
        ], $config->get('builder.advanced')]
    ]
  ]
];
