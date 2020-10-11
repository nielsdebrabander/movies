<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Data
    require_once $basePath . 'src/Models/Contact.php';
    require_once  $basePath . 'src/Models/Company.php';
    $contacts = require_once $basePath . 'resources/data/contacts.php';
    $companies = require_once  $basePath . 'resources/data/companies.php';
    $searchTerm = $_GET['search'];

    // Functions
    require_once  $basePath . 'src/functions.php';

    $key = searchName($searchTerm, $contacts);

    if ($key === -1) {
        header('Location: ./companies.php');
        exit();
    }
    else {
        $contactRecord = $contacts[$key];
        $contactObject = new Contact($contactRecord['name'], $contactRecord['client'], $contactRecord['email'], $contactRecord['phone']);
    }

    $key = searchCompanyClient($contactObject->getClient(), $companies);

    if ($key !== 0) {
        $companyRecord = $companies[$key];
        $companyObject = new Company($companyRecord['name'], $companyRecord['address'], $companyRecord['zip'], $companyRecord['city'], $companyRecord['activity'], $companyRecord['vat']);
    }

    // View
    require_once $basePath . 'resources/templates/pages/contact.php';
