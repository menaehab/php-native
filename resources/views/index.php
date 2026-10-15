<?= view('layout.header') ?>
<?= view('layout.navbar') ?>
<div class="container py-5">
    <h1><?= trans('keywords.welcome') ?></h1>
    <button class="btn btn-primary" onclick="location.href='<?php echo url('dashboard'); ?>'"><?= trans('keywords.dashboard') ?></button>
    <?php validate('email', 'test@test.com', ['email', 'required' , 'string']); ?>
    <?php validate('required', 'test', ['required']); ?>
    <?php validate('numeric', '123', ['numeric']); ?>
    <?php validate('string', 'hello', ['string']); ?>
    <?php validate('boolean', 'true', ['boolean']); ?>
    <?php if (!empty(get_session('validations'))): ?>
        <div class="alert alert-danger mt-3">
            <ul>
                <?php foreach (get_session('validations') as $attribute => $message): ?>
                    <li><?= $message ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?= view('layout.footer') ?>