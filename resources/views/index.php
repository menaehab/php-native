<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?= view('layout.navbar') ?>
    <h1><?= trans('keywords.welcome') ?></h1>

    <button onclick="location.href='<?php echo url('dashboard'); ?>'"><?= trans('keywords.dashboard') ?></button>
</body>
</html>