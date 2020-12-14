<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Require composer autoloader
    require_once $basePath . '/vendor/autoload.php';
    require_once $basePath . '/src/controllers/AuthController.php';
    require_once $basePath . '/src/controllers/HomeController.php';
    require_once $basePath . '/src/controllers/CompaniesController.php';

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Start always a session
    $router->before('GET|POST', '/.*', function () {
        session_start();
    });

    // Define routes
    /*
     *  Go always to the home route when you go to the root.
     */
    $router->get('/', function () {
        header('Location: /home');
        exit();
    });
    $router->get('/home', 'HomeController@showHome');

    /*
     *  Check if user is already logged in.
     */
    $router->before('GET|POST', '/login', function () {
        if (isset($_SESSION['user'])) {
            header('Location: /dashboard/companies');
            exit();
        }
    });
    $router->get('/login', 'AuthController@showLogin');
    $router->post('/login', 'AuthController@login');
    $router->post('/logout', 'AuthController@logout');

    /*
     *  Secured pages under the route /dashboard
     */
    $router->mount('/dashboard', function () use ($router) {
        /*
         *  Go always to the companies page if you go to the /dashboard route.
         */
        $router->get('/', function () {
            header('Location: /dashboard/companies');
            exit();
        });

        /*
         *  Only show the companies page if you are logged in.
         */
        $router->before('GET|POST', '/companies', function () use ($router) {
            if (!isset($_SESSION['user'])) {
                header('Location: /login');
                exit();
            }
        });

        $router->get('/companies', 'CompaniesController@overview');
        $router->get('/companies/(\d+)', 'CompaniesController@detail');

        $router->get('/companies/create', 'CompaniesController@showCreate');
        $router->post('/companies/create', 'CompaniesController@create');
        $router->get('/companies/(\d+)/update', 'CompaniesController@showUpdate');
        $router->post('/companies/(\d+)/update', 'CompaniesController@update');
        $router->get('/companies/(\d+)/delete', 'CompaniesController@showDelete');
        $router->post('/companies/(\d+)/delete', 'CompaniesController@delete');
    });

    // RUN THE ROUTER
    $router->run();

?>



