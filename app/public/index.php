<?php

// General variables
$basePath = __DIR__ . '/../';

    // Require composer autoloader
    require_once $basePath . '/vendor/autoload.php';

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Bootstrapping twig pages
    $loader = new \Twig\Loader\FilesystemLoader($basePath . 'resources/templates/');
    $twig = new \Twig\Environment($loader);

    // Models
    require_once $basePath . 'src/Models/AutController.php';


    $router->get('/login', 'AuthController@showLogin');
    $router->post('/login', 'AuthController@login');

    $router->run();

   /* // View
    require_once $basePath . 'resources/templates/pages/index.twig';*/