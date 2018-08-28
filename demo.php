<?php

require __DIR__.'/vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use FormManager\Factory as f;

$inputs = [
    'Checkbox',
    'Color',
    'Date',
    'DatetimeLocal',
    'Email',
    'File',
    'Hidden',
    'Month',
    'Number',
    'Password',
    'Radio',
    'Range',
    'Search',
    // 'Select',
    //'Submit',
    'Tel',
    'Text',
    'Textarea',
    'Time',
    'Url',
    'Week',
];

$form = f::form();

foreach ($inputs as $input) {
    $form[$input] = f::$input()->setLabel($input)->setFormat('<div>{format}</div>');
}

$form['color'] = f::radioGroup([
    'red' => 'Vermello',
    'blue' => 'Azul',
]);

$form['user'] = f::group([
    'name' => f::text('nome'),
    'age' => f::number('idade'),
    'direction' => f::group([
        'line1' => f::text('Line 1'),
        'line2' => f::text('Line 2'),
        'type' => f::radioGroup([
            'rua' => 'Rúa',
            'avenida' => 'Avenida',
        ])
    ])
])
?>

<!DOCTYPE html>
<html>
<head>
    <title>Demo</title>
</head>
<body>
    <?= $form ?>
</body>
</html>
