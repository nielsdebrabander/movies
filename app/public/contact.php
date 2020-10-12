<?php

    //general variables
    $basePath = __DIR__ . '/../';

    //data
    require_once $basePath . '/src/Models/company.php';
    $companies = require $basePath . 'resources/data/companies.php';
   // $companyClient;

    foreach($companies as $counter => $company){
        $companyClient = new Company($company['name'], $company['address'], $company['zip'], $company['city'], $company['vat'] , $company['activity']);

    }

    //view
    require_once $basePath . '/resources/templates/pages/contact.php';
