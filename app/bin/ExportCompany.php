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

    if ($argc > 1) {

        $filterTerm = filterString((string)$argv[1]);

        $companyObject = searchCompanyByName($companies, $filterTerm);

        if (count($companyObject) > 0) {

            header("Content-type: company/csv");

            $csvHeading = ['Name', 'Address', 'Zip', 'City', 'Activity', 'Vat'];

            $zone = new DateTimeZone('Europe/Brussels');
            try {
                $date = new DateTime('now', $zone);
            }
            catch (Exception $e) {
                echo $e;
            }

            $path = $basePath . 'storage/' . $filterTerm . ' ' . $date->format('d-F-Y') . '.csv';

            $csv_handlerCreate = fopen ($path,'a');
            $csv_handlerWrite = fopen ($path,'w');
            fputcsv($csv_handlerWrite, $csvHeading, ';');
            foreach ($companyObject as $company) {
                $csvCompany = [$company->getName(), $company->getAddress(), $company->getZip(), $company->getCity(), $company->getActivity(), $company->getVat()];
                fputcsv($csv_handlerWrite, $csvCompany, ';');
            }

            fclose ($csv_handlerWrite);
        }
        else {
            echo 'No companies found for search term: ' . $filterTerm . PHP_EOL;
        }
    }
    else {
        echo 'No parameters found, give a parameter to the script' . PHP_EOL;
    }

?>

