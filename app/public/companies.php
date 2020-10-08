<?php

// General variables
$basePath = __DIR__ . '/../';


// Data
$companies = require_once $basePath . 'resources/data/companies.php';
function compare_name($a, $b)
{
    return strnatcmp($a['name'], $b['name']);
}
usort($companies, 'compare_name');

// View
require_once $basePath . 'resources/templates/pages/companies.php';
