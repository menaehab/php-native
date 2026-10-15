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
    'storage',
    'validations',
];

foreach ($helpers as $helper) {
    include __DIR__ . "/{$helper}.php";
}