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

    // Reading the elements of the query string
    $nameValue = isset($_POST['name']) ? (string)$_POST['name'] : '';
    $addressValue = isset($_POST['address']) ? (string)$_POST['address'] : '';

    $zipValue = isset($_POST['zip']) ? (string)$_POST['zip'] : '';
    $zipValue = (int)$zipValue;

    $cityValue = isset($_POST['city']) ? (string)$_POST['city'] : '';
    $vatValue = isset($_POST['vat']) ? (string)$_POST['vat'] : '';
    $activityValue = isset($_POST['Activity']) ? (string)$_POST['Activity'] : '';

    $msgName = '';
    $msgAddress = '';
    $msgCity = '';
    $msgVat = '';
    $msgActivity = '';

    $nameOk = true;
    $addressOk = true;
    $cityOk = true;
    $vatOk = true;
    $activityOk = true;

    if (isset($_POST['moduleAction'])) {

        try {
            $stmt = $connection->prepare('SELECT count(vat) FROM companies AS vat WHERE vat = ?');
            $stmt->execute([$vatValue]);
            $companyRecord = $stmt->fetchOne();
        }
        catch (\Doctrine\DBAL\Exception $exception) {
            echo $exception;
        }
        catch (\Doctrine\DBAL\Driver\Exception $exception) {
            echo $exception;
        }

        $ok = true;

        if (trim($nameValue) === '') {
            $msgName = 'Gelieve naam in te vullen';
            $ok = false;
            $nameOk = false;
        }

        if (trim($addressValue) === '') {
            $msgAddress = 'Gelieve adress in te vullen';
            $ok = false;
            $addressOk = false;
        }

        if ((int)$zipValue <= 0 || $zipValue === '') {
            $msgCity = 'Gelieve stad in te vullen';
            $ok = false;
            $cityOk = false;
        }

        if (trim($cityValue) === '') {
            $msgCity = 'Gelieve stad in te vullen';
            $ok = false;
            $cityOk = false;
        }

        if (trim($vatValue) === '') {
            $msgVat = 'Gelieve VAT in te vullen';
            $ok = false;
            $vatOk = false;
        }

        if ((int)$companyRecord !== 0) {
            $msgVat = 'Dit VAT nummer is al in gebruik';
            $ok = false;
            $vatOk = false;
        }

        if (trim($activityValue) === '') {
            $msgActivity = 'Gelieve activiteit in te vullen';
            $ok = false;
            $activityOk = false;
        }

        // if everything is ok, send the data
        if ($ok) {
            /*
             *  If everything is ok, insert a new company in the database
             */
            try {
                $stmt = $connection->prepare('INSERT INTO companies VALUES (null, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$nameValue, $addressValue, $zipValue, $cityValue, $activityValue, $vatValue]);
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
    }

    // View
    $tpl = $twig->load('/pages/add-company.twig');
    echo $tpl->render(array(
        'okName' => $nameOk,
        'persistName' => $nameValue,
        'msgName' => $msgName,
        'okAddress' => $addressOk,
        'persistAddress' => $addressValue,
        'msgAddress' => $msgAddress,
        'okCity' => $cityOk,
        'persistZip' => $zipValue,
        'persistCity' => $cityValue,
        'msgCity' => $msgCity,
        'okVat' => $vatOk,
        'persistVat' => $vatValue,
        'msgVat' => $msgVat,
        'okActivity' => $activityOk,
        'persistActivity' => $activityValue,
        'msgActivity' => $msgActivity
    ));

?>
