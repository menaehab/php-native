<?php
$helpers = [
    'config',
    'db',
    'session',
    'debug',
];

foreach ($helpers as $helper) {
    include __DIR__ . "/{$helper}.php";
}