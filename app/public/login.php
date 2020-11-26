<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Require composer autoloader
    require_once $basePath . '/vendor/autoload.php';

    // Bootstrapping twig pages
    $loader = new \Twig\Loader\FilesystemLoader($basePath . 'resources/templates/');
    $twig = new \Twig\Environment($loader);

    // Database connection
    require_once $basePath . 'config/database.php';
    $connectionParams = [
        'host' => DB_HOST,
        'dbname' => DB_NAME,
        'user' => DB_USER_NAME,
        'password' => DB_PASS,
        'driver' => 'pdo_mysql',
        'charset' => 'utf8mb4'
    ];

    try {
        $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        $result = $connection->connect();
    }
    catch (\Doctrine\DBAL\Exception $exception) {
        $connection = null;
        echo $exception;
    }

    // View
    $tpl = $twig->load('/pages/login.twig');
    echo $tpl->render(array(

    ));

?>
