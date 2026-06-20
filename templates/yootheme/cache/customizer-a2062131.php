<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form/config/customizer.json

return [
  'panels' => [
    'yooessentials-form-settings' => [
      'title' => 'Form', 
      'fields' => [
        'yooessentials_form.html5validation' => [
          'label' => 'Validation', 
          'text' => 'Enable HTML 5 Validation', 
          'description' => 'If disabled only the Ajax/PHP based validation will be processed.', 
          'type' => 'checkbox', 
          'default' => true
        ], 
        'yooessentials_form.after_submit_actions' => [
          'label' => 'After Submit Actions', 
          'description' => 'Set actions to be executed after a form has been successfully submitted. The established order is respected when possible.', 
          'type' => 'yooessentials-dataset-multi', 
          'txtAdd' => 'Add Action', 
          'txtEmpty' => 'No actions yet.', 
          'options' => []
        ], 
        'yooessentials_form.name' => [
          'label' => 'Name Attribute', 
          'description' => 'Optional Name attribute for the form node.'
        ], 
        'yooessentials_form.id' => [
          'label' => 'ID Attribute'
        ], 
        'yooessentials_form.class' => [
          'label' => 'Class Attribute'
        ], 
        'yooessentials_form.override_action_url' => [
          'label' => 'Submission', 
          'text' => 'Override Submission Action', 
          'type' => 'checkbox', 
          'description' => 'Submit the form to a custom URL and method, useful for 3rd party form integrations.', 
          'default' => false
        ], 
        'yooessentials_form.action_url' => [
          'label' => 'Action URL'
        ], 
        'yooessentials_form.action_method' => [
          'label' => 'Action Method', 
          'type' => 'select', 
          'options' => [
            'GET' => 'GET', 
            'POST' => 'POST'
          ], 
          'default' => 'POST'
        ]
      ], 
      'fieldset' => [
        'default' => [
          'type' => 'tabs', 
          'fields' => [[
              'title' => 'Settings', 
              'fields' => ['yooessentials_form.html5validation', 'yooessentials_form.after_submit_actions']
            ], [
              'title' => 'Advanced', 
              'fields' => ['yooessentials_form.name', [
                  'name' => '_style', 
                  'type' => 'grid', 
                  'width' => '1-2', 
                  'description' => 'Optional ID and Class attributes for the form node, useful for styling or customizations.', 
                  'fields' => ['yooessentials_form.id', 'yooessentials_form.class']
                ], 'yooessentials_form.override_action_url', [
                  'name' => '_action_override', 
                  'type' => 'grid', 
                  'width' => '1-2', 
                  'show' => 'yooessentials_form.override_action_url', 
                  'fields' => ['yooessentials_form.action_url', 'yooessentials_form.action_method']
                ]]
            ]]
        ]
      ]
    ]
  ]
];
