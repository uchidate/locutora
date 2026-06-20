<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/legacy/src/FormAction/SaveCsvLegacy/config.json

return [
  'name' => 'save-csv-legacy', 
  'title' => 'Save to CSV (Legacy)', 
  'group' => 'legacy', 
  'description' => 'Save data to a CSV formatted file.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/legacy/src/FormAction/SaveCsvLegacy/icon.svg', $file), 
  'fields' => [
    'path' => [
      'label' => 'Path', 
      'description' => 'Pick or input a folder where the submissions should be saved at.', 
      'type' => 'yooessentials-file', 
      'mode' => 'folder'
    ], 
    'file' => [
      'label' => 'Filename', 
      'description' => 'Set the name for the CSV file.'
    ], 
    'columns' => [
      'label' => 'Columns', 
      'type' => 'yooessentials-settings-panel', 
      'panel' => 'forms-action-save-csv-column', 
      'emptyMsg' => 'Add Column', 
      'button' => 'Add Field', 
      'description' => 'List of columns to compose the CSV. Defaults to all fields.'
    ], 
    'separator' => [
      'label' => 'Separator', 
      'attrs' => [
        'placeholder' => ','
      ]
    ], 
    'enclosure' => [
      'label' => 'Enclosure', 
      'attrs' => [
        'placeholder' => '"'
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
          'fields' => ['path', 'file', [
              'description' => 'Set the separator and enclosure characters for the CSV file formatting.', 
              'name' => '_csv_format', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['separator', 'enclosure']
            ], 'columns']
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'conditions']
        ]]
    ]
  ], 
  'panels' => [
    'forms-action-save-csv-column' => [
      'title' => 'CSV Column', 
      'fields' => [
        'title' => [
          'label' => 'Title'
        ], 
        'field' => [
          'label' => 'Field', 
          'type' => 'yooessentials-form-control-select'
        ]
      ]
    ]
  ]
];
