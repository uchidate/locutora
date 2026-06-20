<?php // $file = /home/storage/f/68/ac/locutora1/public_html/plugins/system/yooessentials/modules/element/elements/chart_dataset/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'yooessentials_chart_dataset', 
  'title' => 'Dataset', 
  'width' => 500, 
  'defaults' => [
    'dataset_fill' => false, 
    'dataset_showLine' => true, 
    'dataset_borderWidth' => 3, 
    'dataset_lineTension' => 0.40000000000000002220446049250313080847263336181640625, 
    'dataset_barPercentage' => 0.90000000000000002220446049250313080847263336181640625
  ], 
  'placeholder' => [
    'children' => [[
        'type' => 'yooessentials_chart_data', 
        'props' => [
          'label' => 'January', 
          'data' => 65
        ]
      ], [
        'type' => 'yooessentials_chart_data', 
        'props' => [
          'label' => 'February', 
          'data' => 59
        ]
      ], [
        'type' => 'yooessentials_chart_data', 
        'props' => [
          'label' => 'March', 
          'data' => 80
        ]
      ], [
        'type' => 'yooessentials_chart_data', 
        'props' => [
          'label' => 'April', 
          'data' => 81
        ]
      ], [
        'type' => 'yooessentials_chart_data', 
        'props' => [
          'label' => 'May', 
          'data' => 56
        ]
      ], [
        'type' => 'yooessentials_chart_data', 
        'props' => [
          'label' => 'June', 
          'data' => 55
        ]
      ], [
        'type' => 'yooessentials_chart_data', 
        'props' => [
          'label' => 'July', 
          'data' => 40
        ]
      ]]
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'data' => [
      'label' => 'Data Entries', 
      'type' => 'content-items', 
      'title' => 'label', 
      'button' => 'Add Data', 
      'item' => 'yooessentials_chart_data'
    ], 
    'dataset_label' => [
      'label' => 'Label', 
      'description' => 'The label for the entire Dataset.'
    ], 
    'dataset_type' => [
      'label' => 'Type', 
      'description' => 'You can override the Chart Type for this Dataset, which will enable a mixed chart. A common example is a bar chart that also includes a line dataset, but bear in mind that not all combinations are possible.', 
      'type' => 'select', 
      'options' => [
        'Inherited' => '', 
        'Line' => 'line', 
        'Vertical Bar' => 'bar', 
        'Horizontal Bar' => 'horizontalBar', 
        'Radar' => 'radar', 
        'Pie' => 'pie', 
        'Doughnut' => 'doughnut', 
        'Polar Area' => 'polarArea', 
        'Bubble' => 'bubble', 
        'Scatter' => 'scatter'
      ]
    ], 
    'dataset_showLine' => [
      'type' => 'checkbox', 
      'label' => 'Show Line', 
      'text' => 'Draw a line between data', 
      'enable' => 'dataset_type == \'line\''
    ], 
    'dataset_lineTension' => [
      'label' => 'Line Tension', 
      'description' => 'Bezier curve tension of the line. Set to 0 to draw straightlines.', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0, 
        'max' => 1, 
        'step' => 0.1000000000000000055511151231257827021181583404541015625
      ]
    ], 
    'dataset_barPercentage' => [
      'label' => 'Bar Percentage', 
      'description' => 'Percent of the available width each bar should be within the category width.', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0.1000000000000000055511151231257827021181583404541015625, 
        'max' => 1, 
        'step' => 0.1000000000000000055511151231257827021181583404541015625
      ], 
      'enable' => 'dataset_type == \'bar\' || dataset_type == \'horizontalBar\''
    ], 
    'dataset_borderWidth' => [
      'label' => 'Border Width', 
      'description' => 'The line width (in pixels).', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0, 
        'max' => 20, 
        'step' => 1
      ]
    ], 
    'dataset_borderColor' => [
      'label' => 'Border Color', 
      'description' => 'The line color.', 
      'type' => 'color'
    ], 
    'dataset_backgroundColor' => [
      'label' => 'Background Color', 
      'description' => 'The line fill color.', 
      'type' => 'color'
    ], 
    'dataset_fill' => [
      'label' => 'Fill Line', 
      'type' => 'checkbox', 
      'text' => 'Fill the Area below the Line', 
      'enable' => 'dataset_showLine && (dataset_type == \'line\' || dataset_type == \'radar\')'
    ], 
    'status' => $config->get('builder.statusItem')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Content', 
          'fields' => ['dataset_label', 'dataset_type', 'data']
        ], [
          'title' => 'Settings', 
          'fields' => [[
              'label' => 'Style', 
              'type' => 'group', 
              'divider' => true, 
              'description' => 'Set the style for the entire Dataset. You can as well set or override those for each data individually in the Data instance settings. If you are looking for some nice colors try this green <code>#4BC0C0</code>, this red <code>#FF6384</code>, this blue <code>#36A2EB</code> or this yellow <code>#FFCD56</code>.', 
              'fields' => ['dataset_showLine', 'dataset_fill', 'dataset_lineTension', 'dataset_barPercentage', 'dataset_borderWidth', 'dataset_borderColor', 'dataset_backgroundColor']
            ]]
        ], $config->get('builder.advancedItem')]
    ]
  ]
];
