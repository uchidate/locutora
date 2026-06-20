<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form-actions/src/SaveCsv/config.json

return [
  'name' => 'save-csv', 
  'title' => 'Save to CSV', 
  'group' => 'Save To', 
  'description' => 'Save data to a CSV formatted file.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form-actions/src/SaveCsv/icon.svg', $file), 
  'fields' => [
    'file' => [
      'label' => 'File', 
      'description' => 'The CSV file where the submission data will be appended to.', 
      'type' => 'yooessentials-file'
    ], 
    'content' => [
      'label' => 'Content', 
      'type' => 'yooessentials-dataset-mapping', 
      'description' => 'The content for each CSV column.', 
      'endpoint' => 'yooessentials/form-action/savecsv/columns', 
      'watch' => 'file,separator,enclosure', 
      'enable' => 'file', 
      'panel' => [
        'title' => 'Content', 
        'fields' => [
          'value' => [
            'label' => 'Value', 
            'source' => true, 
            'sourceOmitOrigin' => ['query.page'], 
            'description' => 'The value for this data entry.'
          ]
        ]
      ]
    ], 
    'separator' => [
      'label' => 'Delimiter', 
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
          'fields' => ['file', [
              'description' => 'The delimiter and enclosure characters the CSV file is formated with.', 
              'name' => '_csv_format', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['separator', 'enclosure']
            ], 'content']
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'conditions']
        ]]
    ]
  ]
];
