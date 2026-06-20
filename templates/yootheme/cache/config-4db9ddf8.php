<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form-actions/src/Data/config.json

return [
  'name' => 'data', 
  'title' => 'Data', 
  'description' => 'Add or alter submission data.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form-actions/src/Data/icon.svg', $file), 
  'fields' => [
    'data' => [
      'label' => 'Data', 
      'type' => 'yooessentials-dataset', 
      'description' => 'Data to add to the submission.', 
      'txtEmpty' => 'No Data yet.', 
      'panel' => [
        'title' => 'Data', 
        'fields' => [
          'name' => [
            'label' => 'Name', 
            'description' => 'The data name, if already exists it value will be overwritten.'
          ], 
          'value' => [
            'label' => 'Value', 
            'source' => true, 
            'formPlaceholder' => true, 
            'sourceOmitOrigin' => ['query.page'], 
            'description' => 'The data value.'
          ]
        ]
      ]
    ], 
    'name' => $config->get('yooessentials.form.fields.action_name'), 
    'status' => $config->get('yooessentials.form.fields.action_status'), 
    'conditions' => $config->get('yooessentials.form.fields.action_conditions')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Action', 
          'fields' => ['data']
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'conditions']
        ]]
    ]
  ]
];
