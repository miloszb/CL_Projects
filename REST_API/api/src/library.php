<?php
require_once 'Connection.php';
require_once 'Book.php';


function makeList(array $names)
{
    $list = '<ul>';
    foreach ($names as $name) {
        $list .= '<li>'. $name . '</li>';
    }
    $list .= '</ul>';
    return $list;
}

function makeListOfLinks(array $namesWithIDs, $target)
{
    $list = '<ul>';
    foreach ($namesWithIDs as $pair) {
        $list .= sprintf(
                '<li><a href="%s?id=%s">%s</a></li>',
                $target,
                $pair['id'],
                $pair['name']
        );
    }
    $list .= '</ul>';
    return $list;
}

