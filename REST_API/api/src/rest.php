<?php

$colors = [
    'blue',
    'red',
    'green',
    'pink',
    'yellow',
    'maroon',
    'teal',
    'darkorange'
];

$colTbl = '';
foreach ($colors as $col) {
    $colTbl .= '<div style="width: 100px; background-color: '
            . $col.'">'.$col.'</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($colors);
}
