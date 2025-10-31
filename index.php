<?php
define('BASE_URL', 'http://localhost/wrapstation/index.php');
define('BASE_DIR', 'http://localhost/wrapstation');

require_once('controllers/CoreController.php');

$controller = new CoreController();
$controller->index();
