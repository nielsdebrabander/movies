<?php
    // General variables
    $basePath = __DIR__ . '/../';

    // Data
    $companies = require_once $basePath . 'resources/data/companies.php';
    $contacts = require $basePath. '/resources/data/contacts.php';
    $companyObject = [];

    require_once $basePath . 'src/Models/Company.php';

    function compare_Name($a, $b) {
        return strnatcmp($a['name'], $b['name']);
    }
    usort($companies, 'compare_Name');

    if (array_key_exists('term', $_GET)) {
        $filterTerm = '';
        $searchTerm = $_GET['term'];
        $searchTerm = strtolower($searchTerm);

        for ($index = 0; $index < strlen($searchTerm); $index++) {
            $char = $searchTerm[$index];
            switch ($char) {
                case 'a':
                    $filterTerm .= 'a';
                    break;
                case 'b':
                    $filterTerm .= 'b';
                    break;
                case 'c':
                    $filterTerm .= 'c';
                    break;
                case 'd':
                    $filterTerm .= 'd';
                    break;
                case 'e':
                    $filterTerm .= 'e';
                    break;
                case 'f':
                    $filterTerm .= 'f';
                    break;
                case 'g':
                    $filterTerm .= 'g';
                    break;
                case 'h':
                    $filterTerm .= 'h';
                    break;
                case 'i':
                    $filterTerm .= 'i';
                    break;
                case 'j':
                    $filterTerm .= 'j';
                    break;
                case 'k':
                    $filterTerm .= 'k';
                    break;
                case 'l':
                    $filterTerm .= 'l';
                    break;
                case 'm':
                    $filterTerm .= 'm';
                    break;
                case 'n':
                    $filterTerm .= 'n';
                    break;
                case 'o':
                    $filterTerm .= 'o';
                    break;
                case 'p':
                    $filterTerm .= 'p';
                    break;
                case 'q':
                    $filterTerm .= 'q';
                    break;
                case 'r':
                    $filterTerm .= 'r';
                    break;
                case 's':
                    $filterTerm .= 's';
                    break;
                case 't':
                    $filterTerm .= 't';
                    break;
                case 'u':
                    $filterTerm .= 'u';
                    break;
                case 'v':
                    $filterTerm .= 'v';
                    break;
                case 'w':
                    $filterTerm .= 'w';
                    break;
                case 'x':
                    $filterTerm .= 'x';
                    break;
                case 'y':
                    $filterTerm .= 'y';
                    break;
                case 'z':
                    $filterTerm .= 'z';
                    break;
                case '0':
                    $filterTerm .= '0';
                    break;
                case '1':
                    $filterTerm .= '1';
                    break;
                case '2':
                    $filterTerm .= '2';
                    break;
                case '3':
                    $filterTerm .= '3';
                    break;
                case '4':
                    $filterTerm .= '4';
                    break;
                case '5':
                    $filterTerm .= '5';
                    break;
                case '6':
                    $filterTerm .= '6';
                    break;
                case '7':
                    $filterTerm .= '7';
                    break;
                case '8':
                    $filterTerm .= '8';
                    break;
                case '9':
                    $filterTerm .= '9';
                    break;
            }
        }
        foreach ($companies as $company) {
            $name = $company['name'];
            $pos = stripos($name, $filterTerm);

            if ($pos !== false) {
                $companyObject[] = new Company($company['name'], $company['address'], $company['zip'], $company['city'], $company['vat'], $company['activity']);
            }
        }
    }
    else {
        foreach ($companies as $index => $company) {
            $name = $company['name'];
            $address = $company['address'];
            $zip = $company['zip'];
            $city = $company['city'];
            $activity = $company['activity'];
            $vat = $company['vat'];
            $companyObject[] = new Company($name, $address, $zip, $city, $activity, $vat);
        }
    }
    //part for contacts
    foreach ($contacts as $counter => $contact){

        if(isset($_GET['term'])){
            $term = $_GET['term'];

            $contactName = strripos(htmlentities($contact['name']),$term);
            $contactClient = strripos(htmlentities($contact['client']),$term);
            $contactEmail = strripos(htmlentities($contact['email']),$term);
            $contactPhone = strripos(htmlentities($contact['phone']),$term);

            if(!ctype_alnum($term)){
                unset($contacts[$counter]);
            }
            if($contactName === false && $contactClient === false && $contactEmail === false && $contactPhone === false ){
                unset($contacts[$counter]);
            }
        }
    }

    // View
    require_once $basePath . 'resources/templates/pages/companies.php';









