<?php // $file = /home/storage/f/68/ac/locutora1/public_html/templates/yootheme/vendor/yootheme/builder/elements/layout/element.json

return [
  'name' => 'layout', 
  'title' => 'Layout', 
  'container' => true, 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ]
];
