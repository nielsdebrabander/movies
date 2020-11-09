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

    $companyId = isset($_GET['id']) ? $_GET['id'] : '';

    if ($companyId !== '') {
        try {
            $companyRecord = 0;
            $stmt = $connection->prepare('SELECT count(id) FROM companies AS id WHERE id = ?');
            $stmt->execute([$companyId]);
            $companyRecord = $stmt->fetchOne();
        }
        catch (\Doctrine\DBAL\Exception $exception) {
            echo $exception;
        }
        catch (\Doctrine\DBAL\Driver\Exception $exception) {
            echo $exception;
        }

        if ((int)$companyRecord === 0) {
            header('location: companies.php');
            exit();
        }
    }
    else {
        header('location: companies.php');
        exit();
    }

    if (isset($_POST['moduleAction'])) {
        try {
            $companyRecord = 0;
            $stmt = $connection->prepare('DELETE FROM companies WHERE id = ?');
            $stmt->execute([$companyId]);
        }
        catch (\Doctrine\DBAL\Exception $exception) {
            echo $exception;
        }
        catch (\Doctrine\DBAL\Driver\Exception $exception) {
            echo $exception;
        }

        header('location: companies.php');
        exit();
    }

    // View
    $tpl = $twig->load('/pages/delete-company.twig');
    echo $tpl->render(array(
        'companyIdValue' => $companyId
    ));

?>
