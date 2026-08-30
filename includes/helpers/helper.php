<?php
$helpers = [
    'config',
    'db',
    'session',
    'debug',
    'mail',
    'routing'
];

foreach ($helpers as $helper) {
    include __DIR__ . "/{$helper}.php";
}