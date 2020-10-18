<?php
    // General variables
    $basePath = __DIR__ . '/../';

    // Data
    $companies = require_once $basePath . 'resources/data/companies.php';
    $contacts = require $basePath. '/resources/data/contacts.php';
    require_once $basePath . 'src/Models/Company.php';
    require_once $basePath . 'src/Models/Contact.php';
    require_once $basePath . 'src/Models/Province.php';
    require_once $basePath . 'src/functions.php';
    $companyObject = [];
    $provinces = [
        $antwerpen = new Province('Antwerpen', 2000, 2999),
        $brussel = new Province('Brussel', 1000, 1999),
        $henegouwen = new Province('Henegouwen', 6000, 6999),
        $limburg = new Province('Limburg', 3000, 3999),
        $luik = new Province('Luik', 4000, 4999),
        $luxemburg = new Province('Luxemburg', 6000, 6999),
        $namen = new Province('Namen', 5000, 5999),
        $oost_vlaanderen = new Province('Oost-Vlaanderen', 9000, 9999),
        $vlaams_brabant = new Province('Vlaams-Brabant', 1000, 1999),
        $waals_brabant = new Province('Waals-Brabant', 1000, 1999),
        $west_vlaanderen = new Province('West-Vlaanderen', 8000, 8999)
    ];

        function compare_Name ($a, $b) {
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

        foreach ($contacts as $counter => $contact) {

            if (isset($_GET['term'])) {
                $term = $_GET['term'];

                $contactName = strripos(htmlentities($contact['name']), $term);
                $contactClient = strripos(htmlentities($contact['client']), $term);
                $contactEmail = strripos(htmlentities($contact['email']), $term);
                $contactPhone = strripos(htmlentities($contact['phone']), $term);

                if (!ctype_alnum($term)) {
                    unset($contacts[$counter]);
                }
                if ($contactName === false && $contactClient === false && $contactEmail === false && $contactPhone === false) {
                    unset($contacts[$counter]);
                }
            }

            $term = isset($_GET['term']) ? (string)$_GET['term'] : '';
            $cityValue = isset($_GET['city']) ? $_GET['city'] : '';
            $provinceValue = isset($_GET['province']) ? (array)$_GET['province'] : array();

            $ErrTerm = '';
            $ErrDropdown = '';
            $ErrProvince = '';

            $okTerm = true;
            $okCity = true;
            $okProvince = true;

            $moduleAction = isset($_GET['moduleAction']) ? $_GET['moduleAction'] : '';
            if ($moduleAction == 'search-company') {
                    $ok = true;

                if (trim($term) === '') {
                    $ErrTerm = 'Gelieve een zoekterm in te vullen';
                    $ok = false;
                    $okTerm = false;
                }

                if ($cityValue === 'Choose city') {
                    $ErrDropdown = 'Gelieve een stad te kiezen';
                    $ok = false;
                    $okDropdown = false;
                }

                if (count($provinceValue) === 0) {
                    $ErrProvince = 'Gelieve één of meerdere provincies te selecteren';
                    $ok = false;
                    $okSelect = false;
                }

                if ($ok) {

                    $companyObjSearch = searchCompanyByName($companies, $term);
                    foreach ($companyObjSearch as $company) {

                        if ($company->getCity() === $cityValue) {

                            for ($index = 0; $index < count($provinceValue); $index++) {
                                foreach ($provinces as $province) {
                                    if ($province->getName() === $provinceValue[$index] && $company->getZip() >= $province->getLowerZip() && $company->getZip() <= $province->getUpperZip()) {
                                        $companyObject[] = $company;
                                    }
                                }
                            }
                        }
                    }


                    usort($contacts, sorter('name'));

                    $contactObjSearch = createContactObj($contacts);
                    foreach ($contactObjSearch as $contactSearch) {
                        foreach ($companyObject as $company) {
                            if ($contactSearch->getClient() === $company->getVat()) {
                                $contactObject[] = $contactSearch;
                            }
                        }
                    }
                }
                else {
                    usort($companies, sorter('name'));
                    usort($contacts, sorter('name'));

                    $companyObject = createCompanyObj($companies);

                    $contactObject = createContactObj($contacts);
                }
            }
            else {

                usort($companies, sorter('name'));
                usort($contacts, sorter('name'));

                $companyObject = createCompanyObj($companies);

                // Convert data to objects for contacts
                $contactObject = createContactObj($contacts);
            }

            $companyObjCity = createCompanyObj($companies);

            $companyCities = [];
            foreach ($companyObjCity as $company) {
                if (!in_array($company->getCity(), $companyCities)) {
                    $companyCities[] = $company->getCity();
                }
            }
        }

            sort($companyCities);


    // View
    require_once $basePath . 'resources/templates/pages/companies.php';









