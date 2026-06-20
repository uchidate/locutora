<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/legacy/src/FormAction/SaveGoogleSheetLegacy/config.json

return [
  'name' => 'save-google-sheet-legacy', 
  'title' => 'Save to Google Sheet (Legacy)', 
  'group' => 'legacy', 
  'description' => 'Save data to a Google Spreadsheet.', 
  'icon' => $filter->apply('url', '~yooessentials_url/modules/legacy/src/FormAction/SaveGoogleSheetLegacy/icon.svg', $file), 
  'fields' => [
    'account' => [
      'label' => 'Account', 
      'type' => 'yooessentials-connected-auth', 
      'connections' => [
        'google' => ['https://www.googleapis.com/auth/drive.readonly', 'https://www.googleapis.com/auth/spreadsheets']
      ], 
      'description' => 'The Google account with which to access the resources.'
    ], 
    'sheet_id' => [
      'label' => 'Spreadsheet', 
      'type' => 'yooessentials-select-dropdown-async', 
      'description' => 'The Spreadsheet to which to connect.', 
      'endpoint' => 'yooessentials/form-action/save-gsheet/spreadsheets', 
      'watch' => 'account'
    ], 
    'sheet_name' => [
      'label' => 'Sheet', 
      'description' => 'The Spreadsheet Sheet where the submission data will be appended to.', 
      'type' => 'yooessentials-select-dropdown-async', 
      'endpoint' => 'yooessentials/form-action/save-gsheet/sheets', 
      'watch' => 'sheet_id', 
      'placeholder' => 'Default'
    ], 
    'columns' => [
      'label' => 'Columns', 
      'type' => 'yooessentials-settings-panel', 
      'panel' => 'forms-action-google-sheet-column', 
      'emptyMsg' => 'No Columns Yet', 
      'button' => 'Add Field', 
      'description' => 'List of columns to compose the Google Sheet. Defaults to all fields.'
    ], 
    'value_input' => [
      'label' => 'Value Input Option', 
      'type' => 'select', 
      'options' => [
        'Raw' => 'INPUT_TYPE_RAW', 
        'User Entered' => 'INPUT_TYPE_USER_ENTERED'
      ], 
      'default' => 'INPUT_TYPE_RAW', 
      'description' => 'Determines how input data should be interpreted. <b>Raw</b>, the values will be stored as-is. <b>User Entered</b>, the values will be parsed as if were typed into the UI.'
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
          'fields' => ['account', 'sheet_id', 'sheet_name', 'value_input', 'columns']
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'conditions']
        ]]
    ]
  ], 
  'panels' => [
    'forms-action-google-sheet-column' => [
      'title' => 'Google Sheet Column', 
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
