<?= view('layout.header') ?>
<?= view('layout.navbar') ?>
<div class="container py-5">
    <h1><?= trans('keywords.upload') ?></h1>

    <?php if ($uploaded = get_session('uploaded')): ?>
        <div class="alert alert-success">
            <?= trans('keywords.uploaded') ?>: <?= htmlspecialchars($uploaded) ?><br>
            <a href="<?= htmlspecialchars(file_url($uploaded)) ?>" target="_blank"><?= trans('keywords.viewFile') ?></a><br>
            <?php if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $uploaded)): ?>
                <img src="<?= htmlspecialchars(file_url($uploaded)) ?>" style="max-width:300px" class="mt-2">
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="<?= url('upload') ?>" method="POST" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3">
            <label class="form-label"><?= trans('keywords.name') ?></label>
            <input type="text" name="name"
                class="form-control <?= validation_error('name') ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars(get_session('old_name') ?? '') ?>">
            <?php if ($msg = validation_error('name')): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label"><?= trans('keywords.fileHint') ?></label>
            <input type="file" name="file"
                class="form-control <?= validation_error('file') ? 'is-invalid' : '' ?>">
            <?php if ($msg = validation_error('file')): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary"><?= trans('keywords.uploadButton') ?></button>
    </form>
</div>
<?= view('layout.footer') ?>
