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

    // Models
    require_once $basePath . 'src/Models/Company.php';
    require_once $basePath . 'src/Models/Tickets.php';

    // Data
    $id = $_GET['id'];
    $ticketObject = [];
    $companyRecord = [];

    // Functions
    require_once $basePath . 'src/functions.php';

    // Logic
    try {
        $stmt = $connection->prepare('SELECT * FROM companies WHERE id = ?');
        $stmt->execute([$id]);
        $companyRecord = $stmt->fetchAssociative();
    }
    catch (\Doctrine\DBAL\Exception $exception) {
        echo $exception;
    }
    catch (\Doctrine\DBAL\Driver\Exception $exception) {
        echo $exception;
    }

    $companyObject = new Company(
        $companyRecord['id'],
        $companyRecord['name'],
        $companyRecord['address'],
        $companyRecord['zip'],
        $companyRecord['city'],
        $companyRecord['activity'],
        $companyRecord['vat']
    );

    if (file_exists($basePath . 'resources/data/tickets')) {
        if (file_exists($basePath . 'resources/data/tickets/' . $companyObject->getVat() . '.csv')) {
            $ticketObject = createTicketObj($basePath . 'resources/data/tickets/' . $companyObject->getVat() . '.csv');
        }
        else {
            //echo 'No tickets found';
        }
    }
    else {
        //echo 'folder tickes does not exist';
    }

    // View
    $tpl = $twig->load('/pages/company.twig');
    echo $tpl->render(array(
        'companyName' => $companyObject->getName(),
        'companyAddress' => $companyObject->getAddress(),
        'companyZip' => $companyObject->getZip(),
        'companyCity' => $companyObject->getCity(),
        'companyVat' => $companyObject->getVat(),
        'companyActivity' => $companyObject->getActivity(),
        'tickets' => $ticketObject
    ));

?>