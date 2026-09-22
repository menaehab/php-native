<?php
$helpers = [
    'config',
    'db',
    'AES',
    'session',
    'debug',
    'mail',
    'routing',
    'view',
    'translation',
];

foreach ($helpers as $helper) {
    include __DIR__ . "/{$helper}.php";
}