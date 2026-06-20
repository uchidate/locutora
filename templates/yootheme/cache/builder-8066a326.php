<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/form-actions/config/builder.json

return [
  'action_name' => [
    'label' => 'Action Name', 
    'description' => 'Define a name to easily identify this action.'
  ], 
  'action_status' => [
    'type' => 'checkbox', 
    'label' => 'Status', 
    'text' => 'Disable action', 
    'description' => 'Disable the action and publish it later.', 
    'attrs' => [
      'true-value' => 'disabled', 
      'false-value' => ''
    ]
  ], 
  'action_conditions' => [
    'label' => 'Execution', 
    'text' => 'Conditions', 
    'type' => 'button-panel', 
    'panel' => 'yooessentials-access', 
    'description' => 'Set conditions under which this action should be executed. Notice that this function relies on the Access Addon.'
  ]
];
