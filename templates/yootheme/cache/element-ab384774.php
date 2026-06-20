<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/element/elements/social_sharing_mailto/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_social_sharing_mailto', 
  'title' => 'Mail To', 
  'iconSmall' => $filter->apply('url', '~yooessentials_url/modules/element/elements/social_sharing_mailto/icon.svg', $file), 
  'width' => 500, 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'defaults' => [
    'icon' => 'mail', 
    'title' => '', 
    'target' => '_self'
  ], 
  'fields' => [
    'mailto' => [
      'label' => 'Mail To', 
      'description' => 'Optional email address which to email to. Separate by comma multiple addresses.', 
      'source' => true
    ], 
    'email_cc' => [
      'label' => 'CC', 
      'source' => true
    ], 
    'email_bcc' => [
      'label' => 'BCC', 
      'source' => true
    ], 
    'email_subject' => [
      'label' => 'Subject', 
      'description' => 'The email subject.', 
      'source' => true
    ], 
    'email_body' => [
      'label' => 'Body', 
      'type' => 'textarea', 
      'description' => 'The email body as plain text only, HTML is not supported. Use the newline escape sequence <code>\\n</code> for line breaks.', 
      'source' => true
    ], 
    'title' => [
      'label' => 'Title', 
      'description' => 'A title for the link.'
    ], 
    'icon' => [
      'label' => 'Icon', 
      'description' => 'Choose an icon from the icon library.', 
      'type' => 'icon', 
      'source' => true
    ], 
    'target' => [
      'label' => 'Target', 
      'description' => 'Set the target window for the link to open.', 
      'type' => 'select', 
      'options' => [
        'Same Window' => '_self', 
        'New Window' => '_blank'
      ]
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
          'fields' => ['email_subject', 'email_body', 'mailto', [
              'description' => 'Optionally set the email addressed that will receive the mail\'s carbon and blind carbon copy. Separate by comma multiple addresses.', 
              'name' => '_cc', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['email_cc', 'email_bcc']
            ], 'title', 'icon', 'target']
        ], $config->get('builder.advanced')]
    ]
  ]
];
