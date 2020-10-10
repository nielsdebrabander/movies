<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Data
    require_once $basePath . 'src/Models/Company.php';
    $companies = require_once $basePath . 'resources/data/companies.php';
    $searchTerm = $_GET['search'];

    function searchCompany (string $searchName, array $companies): int {
        foreach ($companies as $key => $company) {
            $name = $company['name'];
            if ($searchName === $name) {
                return $key;
            }
        }
        return -1;
    }

    $key = searchCompany($searchTerm, $companies);

    if ($key === -1) {
        header('Location: ./companies.php');
        exit();
    }
    else {
        $companyRecord = $companies[$key];
        $companyObject = new Company($companyRecord['name'], $companyRecord['address'], $companyRecord['zip'], $companyRecord['city'], $companyRecord['activity'], $companyRecord['vat']);
    }

    // View
    require_once $basePath . 'resources/templates/pages/company.php';


