<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/source-sources/src/Database/config.json

return [
  'name' => 'database', 
  'title' => 'Database', 
  'description' => 'Source based on a local or external Database Table.', 
  'group' => 'Structured Data', 
  'docs' => 'https://www.zoolanders.com/docs/essentials-for-yootheme-pro/sources/database', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/source-sources/src/Database/icon.svg', $file), 
  'endpoints' => [
    'presave' => 'yooessentials/source/database'
  ], 
  'fields' => [
    'name' => [
      'label' => 'Name', 
      'description' => 'A name to identify this source.', 
      'attrs' => [
        'autofocus' => true
      ]
    ], 
    'db_name' => $config->get('yooessentials.core.fields.db.name'), 
    'external' => [
      'text' => 'With Custom Connection', 
      'type' => 'checkbox'
    ], 
    '_connection' => [
      'type' => 'group', 
      'show' => 'external', 
      'fields' => [
        'db_host' => $config->get('yooessentials.core.fields.db.host'), 
        'db_port' => $config->get('yooessentials.core.fields.db.port'), 
        'db_user' => $config->get('yooessentials.core.fields.db.user'), 
        'db_password' => $config->get('yooessentials.core.fields.db.password')
      ]
    ], 
    '_table' => [
      'type' => 'grid', 
      'width' => '1-2', 
      'description' => 'The name of the database table which to use as source and its Primary Key.', 
      'fields' => [
        'table' => [
          'label' => 'Table', 
          'type' => 'yooessentials-select-dropdown-async', 
          'endpoint' => 'yooessentials/source/database/tables'
        ], 
        'table_primary_key' => [
          'label' => 'Primary Key', 
          'type' => 'yooessentials-select-dropdown-async', 
          'endpoint' => 'yooessentials/source/database/fields', 
          'watch' => 'table', 
          'params' => [
            'table' => '#__{values.table}'
          ]
        ]
      ]
    ], 
    'table_relations' => [
      'label' => 'Relations', 
      'type' => 'yooessentials-repeatable-multi', 
      'txtAdd' => 'Add Relation', 
      'orderable' => false, 
      'fields' => [
        'relation_name' => [
          'label' => 'Name', 
          'description' => 'The name to associate the relation with.'
        ], 
        '_relation' => [
          'type' => 'grid', 
          'width' => '1-2', 
          'description' => 'The relation type and the related table to make the relation with. <b>One to One</b> relation, also known as BelongsTo, allows relating an entry with another single entry, e.g. <i>Article belongs to an Author</i>. <b>One to Many</b> relation, also known as HasMany, allows relating an entry with multiple entries, e.g. <i>Article has many Categories</i>. You can create multiple relations of different types.', 
          'fields' => [
            'relation_type' => [
              'label' => 'Relation Type', 
              'type' => 'select', 
              'default' => '1-1', 
              'options' => [
                'One to One' => '1-1', 
                'One to Many' => '1-n'
              ]
            ], 
            'related_table' => [
              'label' => 'Related Table', 
              'type' => 'yooessentials-select-dropdown-async', 
              'endpoint' => 'yooessentials/source/database/tables'
            ]
          ]
        ], 
        '_related_table' => [
          'type' => 'grid', 
          'width' => '1-2', 
          'fields' => [
            'main_table_key' => [
              'label' => 'Main Table Key', 
              'description' => 'The main table key to make the relation from.', 
              'type' => 'yooessentials-select-dropdown-async', 
              'endpoint' => 'yooessentials/source/database/fields', 
              'params' => [
                'table' => '#__{values.table}'
              ]
            ], 
            'related_table_key' => [
              'label' => 'Related Table Key', 
              'description' => 'The related table key to make the relation to.', 
              'type' => 'yooessentials-select-dropdown-async', 
              'endpoint' => 'yooessentials/source/database/fields', 
              'params' => [
                'table_field_path' => 'table_relations.#__{repeatable_index}.related_table'
              ]
            ]
          ]
        ]
      ]
    ], 
    '_table_relations_info' => [
      'type' => 'yooessentials-info', 
      'show' => 'table_relations.length === 0', 
      'description' => 'Set a relation with another table to form a more advanced set of data.'
    ]
  ]
];
