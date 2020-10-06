<?php

/**
 * We're finally here, the specific script that will use any initiated items and render the view
 */

// The data that we are using in the view
$companies = [];


require_once $basePath . 'resources/templates/pages/' . $script . '.php';
