<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/element/elements/chart_data/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_chart_data', 
  'title' => 'Data', 
  'width' => 500, 
  'defaults' => [], 
  'placeholder' => [], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'label' => [
      'label' => 'Label', 
      'source' => true, 
      'description' => 'The label for this single data entry.'
    ], 
    'data' => [
      'label' => 'Value', 
      'description' => 'The value for this single data entry.', 
      'attrs' => [
        'type' => 'number'
      ], 
      'source' => true
    ], 
    'backgroundColor' => [
      'label' => 'Background Color', 
      'type' => 'color', 
      'source' => true
    ], 
    'borderColor' => [
      'label' => 'Border Color', 
      'type' => 'color', 
      'source' => true, 
      'description' => 'If style is omited will be inherited from the Dataset settings. If looking for some nice colors try this green <code>#4BC0C0</code>, this red <code>#FF6384</code>, this blue <code>#36A2EB</code> or this yellow <code>#FFCD56</code>.<p>Take in consideration that Line Chart doesn\'t support data styling.</p>'
    ], 
    'source' => $config->get('builder.source')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Content', 
          'fields' => ['label', 'data', 'backgroundColor', 'borderColor']
        ], $config->get('builder.advancedItem')]
    ]
  ]
];
