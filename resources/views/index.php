<?= view('layout.header') ?>
<?= view('layout.navbar') ?>
<div class="container py-5">
    <h1><?= trans('keywords.welcome') ?></h1>
    <button class="btn btn-primary" onclick="location.href='<?php echo url('dashboard'); ?>'"><?= trans('keywords.dashboard') ?></button>
    <?= decrypt(encrypt('hello world')) ?>

</div>
<?= view('layout.footer') ?>