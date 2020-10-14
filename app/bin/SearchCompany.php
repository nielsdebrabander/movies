<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Data
    $companies = require_once $basePath . 'resources/data/companies.php';
    $companyObject = [];

    // Classes
    require_once $basePath . 'src/Models/Company.php';

    // Functions
    require_once $basePath . 'src/functions.php';
    //search company
    if ($argc > 1) {

        $filteredTerm = filterString((string)$argv[1]);

        $companyObject = searchCompanyByName($companies, $filteredTerm);


        if (count($companyObject) > 0) {
            foreach ($companyObject as $company) {
                echo PHP_EOL . 'Company: ' . $company->getName() . PHP_EOL;
                echo 'Name: ' . $company->getName() .PHP_EOL;
                echo 'Address: ' . $company->formatAddress() . PHP_EOL;
                echo 'Zip: ' . $company->getZip() . PHP_EOL;
                echo 'City: ' . $company->getCity() . PHP_EOL;
                echo 'Activity: ' . $company->getActivity() . PHP_EOL;
                echo 'Vat: ' . $company->getVat() . PHP_EOL;
            }
        }
        else {
            echo 'No companies found for search term: ' . $filteredTerm . PHP_EOL;
        }
    }
    else {
        echo 'No parameters found, give a parameter to the script' . PHP_EOL;
    }

?>
