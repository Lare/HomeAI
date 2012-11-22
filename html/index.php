<?php

// Require mainfile
require_once 'mainfile.php';

// Determine requested module
$module = isset($_REQUEST['Module']) ? trim($_REQUEST['Module']) : NULL;
$action = isset($_REQUEST['Action']) ? trim($_REQUEST['Action']) : NULL;

// Create module initializer
$initializer = new \Module\Initializer($module, $action);

// Handle current request
$initializer->handleRequest();

?>