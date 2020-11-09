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
    /*
     *  Get request
     */
    $companyId = isset($_GET['id']) ? $_GET['id'] : '';

    /*
     *  Post request
     */
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

    if ($companyId !== '') {

        try {
            $companyRecord = [];
            $stmt = $connection->prepare('SELECT * FROM companies  WHERE id = ?');
            $stmt->execute([$companyId]);
            $companyRecord = $stmt->fetchAllAssociative();
        }
        catch (\Doctrine\DBAL\Exception $exception) {
            echo $exception;
        }
        catch (\Doctrine\DBAL\Driver\Exception $exception) {
            echo $exception;
        }

        if (count($companyRecord) !== 0) {
            /*
             *  If the company exists,
             *  create an object of it.
             */
            $companyObject = new Company(
                $companyRecord[0]['id'],
                $companyRecord[0]['name'],
                $companyRecord[0]['address'],
                $companyRecord[0]['zip'],
                $companyRecord[0]['city'],
                $companyRecord[0]['activity'],
                $companyRecord[0]['vat']
            );

            $nameValue = $companyObject->getName();
            $addressValue = $companyObject->getAddress();
            $zipValue = $companyObject->getZip();
            $cityValue = $companyObject->getCity();
            $vatValue = $companyObject->getVat();
            $tempVatValue = $companyObject->getVat();
            $activityValue = $companyObject->getActivity();
        }
        else {
            header('location: companies.php');
            exit();
        }
    }
    else {
        header('location: companies.php');
        exit();
    }

    // Check if form is submitted
    if (isset($_POST['moduleAction'])) {

        $nameValue = isset($_POST['name']) ? (string)$_POST['name'] : '';
        $addressValue = isset($_POST['address']) ? (string)$_POST['address'] : '';

        $zipValue = isset($_POST['zip']) ? (string)$_POST['zip'] : '';
        $zipValue = (int)$zipValue;

        $cityValue = isset($_POST['city']) ? (string)$_POST['city'] : '';
        $vatValue = isset($_POST['vat']) ? (string)$_POST['vat'] : '';
        $activityValue = isset($_POST['Activity']) ? (string)$_POST['Activity'] : '';

        $id = isset($_POST['id']) ? (int)$_POST['id'] : '';

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

        if ((int)$companyRecord !== 0 && $companyObject->getVat() !== trim($vatValue)) {
            $msgVat = 'VAT nummer al in gebruik';
            $ok = false;
            $vatOk = false;
        }

        if (trim($activityValue) === '') {
            $msgActivity = 'Gelieve activiteit in te vullen';
            $ok = false;
            $activityOk = false;
        }

        // if everything is ok, send the data to the database
        if ($ok) {

            /*
             *  Do the update query.
             */
            try {
                $stmt = $connection->prepare('UPDATE companies SET name = ?, address = ?, zip = ?, city = ?, activity = ?, vat= ? WHERE id = ?');
                $stmt->execute([$nameValue, $addressValue, $zipValue, $cityValue, $activityValue, $vatValue, $id]);
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
    $tpl = $twig->load('/pages/edit-company.twig');
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
        'msgActivity' => $msgActivity,
        'companyIdValue' => $companyObject->getId()
    ));

?>
