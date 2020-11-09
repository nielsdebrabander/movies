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
    require_once $basePath . 'src/Models/Contact.php';
    require_once $basePath . 'src/Models/Tickets.php';

    // Data
    $searchTerm = $_GET['id'];
    $contactRecord = [];
    $companyRecords = [];

    // Functions
    require_once  $basePath . 'src/functions.php';

    // Logic


    try {
        $stmt = $connection->prepare('SELECT * FROM clients WHERE id = ?');
        $stmt->execute([$searchTerm]);
        $contactRecord = $stmt->fetchAssociative();
    }
    catch (\Doctrine\DBAL\Exception $exception) {
        echo $exception;
    }
    catch (\Doctrine\DBAL\Driver\Exception $exception) {
        echo $exception;
    }

    $contactObject = new Contact(
        $contactRecord['id'],
        $contactRecord['company_id'],
        $contactRecord['first_name'],
        $contactRecord['last_name'],
        $contactRecord['email'],
        $contactRecord['phone']
    );

    /*
     * Search for the client bij vat number
     */
    try {
        $stmt = $connection->prepare('SELECT * FROM companies WHERE id = ?');
        $stmt->execute([$contactObject->getCompanyId()]);
        $companyRecords = $stmt->fetchAllAssociative();
    }
    catch (\Doctrine\DBAL\Exception $exception) {
        echo $exception;
    }
    catch (\Doctrine\DBAL\Driver\Exception $exception) {
        echo $exception;
    }

    $companyObject = new Company(
        $companyRecords[0]['id'],
        $companyRecords[0]['name'],
        $companyRecords[0]['address'],
        $companyRecords[0]['zip'],
        $companyRecords[0]['city'],
        $companyRecords[0]['activity'],
        $companyRecords[0]['vat']
    );

    // View
    $tpl = $twig->load('/pages/contact.twig');
    echo $tpl->render(array(
        'contactName' => $contactObject->getFirstName(),
        'clientNumber' => $companyObject->getVat(),
        'contactEmail' => $contactObject->getEmail(),
        'contactPhone' => $contactObject->getPhone(),
        'companyName' => $companyObject->getName(),
        'companyAddress' => $companyObject->getAddress(),
        'companyZip' => $companyObject->getZip(),
        'companyCity' => $companyObject->getCity(),
        'companyVat' => $companyObject->getVat(),
        'companyActivity' => $companyObject->getActivity()
    ));
