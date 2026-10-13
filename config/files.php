<?php

return [
    'file_path' => base_path('storage/files'),
    'max_size' => 5 * 1024 * 1024,
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip'],
    'url_prefix' => 'storage/files',
];
