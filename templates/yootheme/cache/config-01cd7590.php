<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form-actions/src/SaveDatabase/config.json

return [
  'name' => 'save-database', 
  'title' => 'Save to Database', 
  'group' => 'Save To', 
  'description' => 'Save data to a Database table.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/form-actions/src/SaveDatabase/icon.svg', $file), 
  'fields' => [
    'external' => [
      'text' => 'With Custom Connection', 
      'type' => 'checkbox'
    ], 
    'table' => [
      'label' => 'Table', 
      'type' => 'yooessentials-select-dropdown-async', 
      'endpoint' => 'yooessentials/form-action/savedb/tables', 
      'description' => 'The table where the submission data will be appended to.'
    ], 
    'table_key' => [
      'label' => 'Associative Key', 
      'type' => 'yooessentials-select-dropdown-async', 
      'endpoint' => 'yooessentials/form-action/savedb/fields'
    ], 
    'table_key_value' => [
      'label' => 'Value', 
      'source' => true, 
      'sourceOmitOrigin' => ['query.page']
    ], 
    'update_if_exists' => [
      'text' => 'Update record if already exists', 
      'type' => 'checkbox'
    ], 
    'content' => [
      'label' => 'Content', 
      'type' => 'yooessentials-dataset-mapping', 
      'description' => 'The content for each table column.', 
      'endpoint' => 'yooessentials/form-action/savedb/columns', 
      'watch' => 'table', 
      'enable' => 'table', 
      'panel' => [
        'title' => 'Content', 
        'fields' => [
          'value' => [
            'label' => 'Value', 
            'source' => true, 
            'sourceOmitOrigin' => ['query.page']
          ]
        ]
      ]
    ], 
    'db_name' => $config->get('yooessentials.core.fields.db.name'), 
    'db_host' => $config->get('yooessentials.core.fields.db.host'), 
    'db_port' => $config->get('yooessentials.core.fields.db.port'), 
    'db_user' => $config->get('yooessentials.core.fields.db.user'), 
    'db_password' => $config->get('yooessentials.core.fields.db.password'), 
    'name' => $config->get('yooessentials.form.fields.action_name'), 
    'status' => $config->get('yooessentials.form.fields.action_status'), 
    'conditions' => $config->get('yooessentials.form.fields.action_conditions')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Action', 
          'fields' => ['db_name', 'external', [
              'name' => '_connection', 
              'type' => 'group', 
              'show' => 'external', 
              'fields' => ['db_host', 'db_port', 'db_user', 'db_password']
            ], 'table', 'update_if_exists', [
              'name' => '_update', 
              'type' => 'grid', 
              'width' => '1-2', 
              'description' => 'The key and value that will associate the submission with an existing record.', 
              'show' => 'update_if_exists && table', 
              'fields' => ['table_key', 'table_key_value']
            ], 'content']
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'conditions']
        ]]
    ]
  ]
];
