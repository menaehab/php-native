<?php

return [
    // Must be inside public/ so Apache can serve file_url() directly.
    // URL: {app.url}/storage/files/...  ->  {project}/public/storage/files/...
    'file_path' => base_path('public/storage/files'),
    'max_size' => 5 * 1024 * 1024,
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip'],
    'url_prefix' => 'storage/files',
];
