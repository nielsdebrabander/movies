<?php

   /* // General variables
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
    require_once $basePath . 'src/Models/Province.php';

    // Data
    $msgTerm = '';
    $msgDropdown = '';
    $msgProvince = '';

    $okTerm = true;
    $okDropdown = true;
    $okSelect = true;

    $companyObject = [];
    $contactObject = [];
    $zipVal = [];
    $companyRecord = [];
    $companies = [];
    $clients = [];
    $provinces = [
        $antwerpen = new Province('Antwerpen', 2000, 2990),
        $brussel = new Province('Brussel', 1000, 1999),
        $henegouwen = new Province('Henegouwen', 6000, 7973),
        $limburg = new Province('Limburg', 3500, 3990),
        $luik = new Province('Luik', 4000, 4990),
        $luxemburg = new Province('Luxemburg', 6600, 6997),
        $namen = new Province('Namen', 5000, 5680),
        $oost_vlaanderen = new Province('Oost-Vlaanderen', 8550, 9992),
        $vlaams_brabant = new Province('Vlaams-Brabant', 1500, 3473),
        $waals_brabant = new Province('Waals-Brabant', 1300, 1495),
        $west_vlaanderen = new Province('West-Vlaanderen', 8000, 8980)
    ];

    // Functions
    require_once $basePath . 'src/functions.php';

    // Logic

    $termValue = isset($_GET['term']) ? (string)$_GET['term'] : '';
    $cityValue = isset($_GET['city']) ? $_GET['city'] : '';
    $provinceValue = isset($_GET['province']) ? (array)$_GET['province'] : array();

    $moduleAction = isset($_GET['moduleAction']) ? $_GET['moduleAction'] : '';
    if ($moduleAction == 'search-company') {


        $ok = true;

        if (trim($termValue) === '') {
            $msgTerm = 'Gelieve een zoekterm in te vullen';
            $ok = false;
            $okTerm = false;
        }

        if ($cityValue === 'Choose city') {
            $msgDropdown = 'Gelieve een stad te kiezen';
            $ok = false;
            $okDropdown = false;
        }

        if (count($provinceValue) === 0) {
            $msgProvince = 'Gelieve één of meerdere provincies te selecteren';
            $ok = false;
            $okSelect = false;
        }

        if ($ok) {

            foreach ($provinceValue as $provinceName) {
                foreach ($provinces as $province) {
                    if ($provinceName === $province->getName()) {
                        for ($zip = $province->getLowerZip(); $zip <= $province->getUpperZip(); $zip++) {
                            $zipVal[] = $zip;
                        }
                    }
                }
            }

            $searchTerm = '%' . $termValue . '%'; //Percent signs as wildcard for the search value
            try {
                $stmt = $connection->prepare('SELECT * FROM companies WHERE (name LIKE ? OR activity LIKE ?) AND city = ?');
                $stmt->execute([$searchTerm, $searchTerm, $cityValue]);
                $companyRecord = $stmt->fetchAllAssociative();
            }
            catch (\Doctrine\DBAL\Exception $exception) {
                echo $exception;
            }
            catch (\Doctrine\DBAL\Driver\Exception $exception) {
                echo $exception;
            }

            if ($companyRecord) {
                $companyObjectFirst = [];

                for ($index = 0; $index < count($companyRecord); $index++) {
                    $companyObjectFirst[] = new Company(
                        $companyRecord[$index]['id'],
                        $companyRecord[$index]['name'],
                        $companyRecord[$index]['address'],
                        $companyRecord[$index]['zip'],
                        $companyRecord[$index]['city'],
                        $companyRecord[$index]['activity'],
                        $companyRecord[$index]['vat']
                    );
                }

                foreach ($companyObjectFirst as $companyFirst) {
                    for ($index = 0; $index < count($provinceValue); $index++) {
                        foreach ($provinces as $province) {
                            if ($province->getName() === $provinceValue[$index] && $companyFirst->getZip() >= $province->getLowerZip() && $companyFirst->getZip() <= $province->getUpperZip()) {
                                $companyObject[] = $companyFirst;
                            }
                        }
                    }
                }
            }

            $companyIds = [];
            foreach ($companyObject as $company) {
                $companyIds[] = $company->getId();
            }

            if ($companyIds) {

                $idArrayLength = count($companyIds);
                $counter = 0;
                $query = 'SELECT clients.id, clients.company_id, clients.first_name, clients.last_name, clients.email, clients.phone, companies.vat FROM clients INNER JOIN companies ON companies.id = clients.company_id WHERE';
                foreach ($companyIds as $id) {
                    $query .= ' company_id = ?';
                    if ($counter !== $idArrayLength -1) {
                        $query .= ' OR';
                    }
                    $counter++;
                }

                try {
                    $contactRecords = [];
                    $stmt = $connection->prepare($query);
                    $stmt->execute($companyIds);
                    $contactRecords = $stmt->fetchAllAssociative();
                }
                catch (\Doctrine\DBAL\Exception $exception) {
                    echo $exception;
                }
                catch (\Doctrine\DBAL\Driver\Exception $exception) {
                    echo $exception;
                }

                foreach ($contactRecords as $contact) {
                    $contactObject[] = new Contact(
                        $contact['id'],
                        $contact['company_id'],
                        $contact['first_name'],
                        $contact['last_name'],
                        $contact['vat'],
                        $contact['email'],
                        $contact['phone']
                    );
                }
            }

        }
        else {

            try {
                $companies = $connection->fetchAllAssociative('SELECT * FROM companies ORDER BY name');
            }
            catch (\Doctrine\DBAL\Exception $exception) {
                echo $exception;
            }
            catch (\Doctrine\DBAL\Driver\Exception $exception) {
                echo $exception;
            }

            foreach ($companies as $company) {
                $companyObject[] = new Company(
                    $company['id'],
                    $company['name'],
                    $company['address'],
                    $company['zip'],
                    $company['city'],
                    $company['activity'],
                    $company['vat']
                );
            }

            try {
                $clients = $connection->fetchAllAssociative('SELECT clients.id, clients.company_id, clients.first_name, clients.last_name, clients.email, clients.phone, companies.vat FROM clients INNER JOIN companies ON companies.id = clients.company_id ORDER BY first_name');
            }
            catch (\Doctrine\DBAL\Exception $exception) {
                echo $exception;
            }
            catch (\Doctrine\DBAL\Driver\Exception $exception) {
                echo $exception;
            }

            foreach ($clients as $client) {
                $contactObject[] = new Contact(
                    $client['id'],
                    $client['company_id'],
                    $client['first_name'],
                    $client['last_name'],
                    $client['vat'],
                    $client['email'],
                    $client['phone']
                );
            }
        }
    }
    else {


        try {
            $companies = $connection->fetchAllAssociative('SELECT * FROM companies ORDER BY name');
        }
        catch (\Doctrine\DBAL\Exception $exception) {
            echo $exception;
        }
        catch (\Doctrine\DBAL\Driver\Exception $exception) {
            echo $exception;
        }

        foreach ($companies as $company) {
            $companyObject[] = new Company(
                $company['id'],
                $company['name'],
                $company['address'],
                $company['zip'],
                $company['city'],
                $company['activity'],
                $company['vat']
            );
        }

        try {
            $clients = $connection->fetchAllAssociative('SELECT clients.id, clients.company_id, clients.first_name, clients.last_name, clients.email, clients.phone, companies.vat FROM clients INNER JOIN companies ON companies.id = clients.company_id ORDER BY first_name');
        }
        catch (\Doctrine\DBAL\Exception $exception) {
            echo $exception;
        }
        catch (\Doctrine\DBAL\Driver\Exception $exception) {
            echo $exception;
        }

        foreach ($clients as $client) {
            $contactObject[] = new Contact(
                $client['id'],
                $client['company_id'],
                $client['first_name'],
                $client['last_name'],
                $client['vat'],
                $client['email'],
                $client['phone']
            );
        }
    }

    try {
        $companyCitiesInfo = [];
        $companyCitiesInfo = $connection->fetchAllAssociative('SELECT city FROM companies GROUP BY city');
    }
    catch (\Doctrine\DBAL\Exception $exception) {
        echo $exception;
    }
    catch (\Doctrine\DBAL\Driver\Exception $exception) {
        echo $exception;
    }

    foreach ($companyCitiesInfo as $city) {
        $companyCities[] = $city['city'];
    }

    sort($companyCities);*/

    // View
   /* $tpl = $twig->load('/pages/companies.twig');
    echo $tpl->render(array(
        'formAction' => $_SERVER['PHP_SELF'],
        'okTerm' => $okTerm,
        'persistTerm' => $termValue,
        'errorMessageTerm' => $msgTerm,
        'okDropdown' => $okDropdown,
        'cityValue' => $cityValue,
        'companyCities' => $companyCities,
        'errorMessageCity' => $msgDropdown,
        'okSelect' => $okSelect,
        'provinces' => $provinces,
        'provinceValue' => $provinceValue,
        'errorMessageProvince' => $msgProvince,
        'companyObject' => $companyObject,
        'contactObject' => $contactObject
    ));*/

?>