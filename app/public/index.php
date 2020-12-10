<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Require composer autoloader
    require_once $basePath . '/vendor/autoload.php';
    require_once $basePath . '/src/controllers/AutController.php';
    require_once $basePath . '/src/controllers/HomeController.php';

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Start always a session
    $router->before('GET|POST', '/.*', function () {
        session_start();
    });

    $router->get('/', function () {
        header('Location: /home');
        exit();
    });
    $router->get('/home', 'HomeController@showHome');
    $router->get('/login', 'AuthController@showLogin');
    $router->post('/register', 'AuthController@register');
    $router->post('/logout', 'AuthController@logout');

    $router->before('GET|POST', '/dashboard.*', function(){
        if(!isset($_SESSION['user'])){
            header('Location: /login');
            exit();
        }
    });

    $router->mount('/dashboard', function()use($router){
        $router->get('/companies', 'CompanyController@overview');
        $router->get('/companies/(\w+)', 'CompanyController@detail');

        $router->get('/companies/create', 'CompanyController@showCreate');
        $router->post('/companies/create', 'CompanyController@create');
        $router->get('/companies/(\w+)/update', 'CompanyController@showEdit');
        $router->post('/companies/(\w+)/update', 'CompanyController@edit');
        $router->get('/companies/create', 'CompanyController@showCreate');
        $router->post('/companies/create', 'CompanyController@create');

        $router->get('/contacts', 'CompanyController@contacts');
        $router->get('/contacts/(\w+)', 'CompanyController@contactDetail');

    });

    // RUN THE ROUTER
    $router->run();

?>


