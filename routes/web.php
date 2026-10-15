<?php

route_get('/', function() {
    return view('index');
});

route_get('ar', function() {
    set_session('lang', 'ar');
    return redirect('/');
});

route_get('en', function() {
    set_session('lang', 'en');
    return redirect('/');
});

route_get('dashboard', function() {
    return view('dashboard');
});

route_get('upload', function() {
    return view('upload');
});

route_post('upload', function() {
    $nameOk = validate('name', $_POST['name'] ?? null, ['required', 'string']);
    $fileOk = validate('file', $_FILES['file'] ?? null, ['required', 'file', 'image']);

    // keep old text input across redirect so form repopulates
    set_session('old_name', $_POST['name'] ?? '');

    if (!$nameOk || !$fileOk) {
        delete_session('uploaded');
        return redirect('upload');
    }

    $stored = store_file($_FILES['file'], 'uploads');

    if ($stored === false) {
        global $validations;
        $validations['file'] = trans('validation.mimes', [
            'attribute' => trans('keywords.file', [], 'file'),
            'mimes' => 'jpg, png, pdf, txt... (max 5MB)',
        ]);
        session()->set('validations', $validations);
        delete_session('uploaded');
    } else {
        set_session('uploaded', $stored);
        delete_session('upload_error');
        delete_session('old_name');
        // clear old validation errors on success
        $validations = [];
        session()->set('validations', $validations);
    }

    return redirect('upload');
});

route_post('submit', function() {
    $name = $_POST['name'] ?? '';
    echo "Hello, " . htmlspecialchars($name);
});