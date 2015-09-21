<?php

use Caxy\HtmlDiff\HtmlDiff;

ini_set('display_errors', 1);
error_reporting(E_ERROR);

$classes = array(
    'Caxy/HtmlDiff/AbstractDiff',
    'Caxy/HtmlDiff/HtmlDiff',
    'Caxy/HtmlDiff/Match',
    'Caxy/HtmlDiff/Operation',
    'Caxy/HtmlDiff/ListDiff',
);

foreach ($classes as $class) {
    require __DIR__.'/../lib/'.$class.'.php';
}

$input = file_get_contents('php://input');

if ($input) {
    $data = json_decode($input, true);
    $diff = new HtmlDiff($_POST['oldText'], $_POST['newText'], 'UTF-8', array());
    $diff->build();
    echo $diff->getDifference();die;

    header('Content-Type: application/json');
    echo json_encode(array('diff' => $diff->getDifference()));
} else {
    header('Content-Type: text/html');
    echo file_get_contents('demo.html');
}
