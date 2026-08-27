<?php
ob_start();
session_start();

require_once __DIR__ . '/includes/app.php';

mysqli_close($connect);
ob_end_clean();
ob_end_flush();