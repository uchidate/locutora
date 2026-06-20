<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/element/elements/social_sharing_item/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_social_sharing_item', 
  'title' => 'Network', 
  'iconSmall' => $filter->apply('url', '~yooessentials_url/modules/element/elements/social_sharing/images/iconSmall.svg', $file), 
  'width' => 500, 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'defaults' => [
    'link_target' => '_blank', 
    'link_target_width' => '', 
    'link_target_height' => ''
  ], 
  'fields' => [
    'link' => [
      'label' => 'Social Network', 
      'type' => 'select', 
      'default' => 'twitter', 
      'options' => [
        'Twitter' => 'twitter', 
        'Facebook' => 'facebook', 
        'WhatsApp' => 'whatsapp', 
        'Telegram' => 'telegram', 
        'LinkedIn' => 'linkedin', 
        'Pinterest' => 'pinterest', 
        'Custom' => 'custom'
      ]
    ], 
    'custom_link' => [
      'label' => 'Link', 
      'attrs' => [
        'placeholder' => 'http://mysharer.com/?url=%s&text=%s'
      ], 
      'description' => 'Set a custom share link where <code>%s</code> is a reference to the current site url.', 
      'show' => 'link == \'custom\''
    ], 
    'link_target' => [
      'label' => 'Target', 
      'description' => 'Set the target window for the sharing links to open.', 
      'type' => 'select', 
      'options' => [
        'New Window' => '_blank', 
        'Same Window' => '_self', 
        'PopUp Window' => 'popup'
      ]
    ], 
    'link_target_width' => [
      'label' => 'Width', 
      'attrs' => [
        'placeholder' => 600
      ]
    ], 
    'link_target_height' => [
      'label' => 'Height', 
      'attrs' => [
        'placeholder' => 600
      ]
    ], 
    'title' => [
      'label' => 'Title', 
      'description' => 'An optional title for the link.'
    ], 
    'text' => [
      'label' => 'Text', 
      'description' => 'An optional text that will be included with the link.', 
      'show' => 'link === \'telegram\' || link === \'custom\''
    ], 
    'icon' => [
      'label' => 'Icon', 
      'description' => 'Leave empty for the default icon or pick a custom one from the icon library.', 
      'type' => 'icon', 
      'source' => true
    ], 
    'status' => $config->get('builder.status'), 
    'id' => $config->get('builder.id'), 
    'class' => $config->get('builder.cls'), 
    'attributes' => $config->get('builder.attrs')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Content', 
          'fields' => ['link', 'custom_link', 'link_target', [
              'description' => 'The target window specifications.', 
              'name' => '_target', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['link_target_width', 'link_target_height'], 
              'show' => 'link_target === \'popup\''
            ], 'title', 'text', 'icon']
        ], $config->get('builder.advanced')]
    ]
  ]
];
