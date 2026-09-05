<?php
$helpers = [
    'config',
    'db',
    'session',
    'debug',
    'mail',
    'routing',
    'view',
    'translation'
];

foreach ($helpers as $helper) {
    include __DIR__ . "/{$helper}.php";
}