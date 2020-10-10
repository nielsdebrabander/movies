<?php
    // General variables
    $basePath = __DIR__ . '/../';

    // Data
    $companies = require_once $basePath . 'resources/data/companies.php';
    $companyObject = [];

    require_once $basePath . 'src/Models/Company.php';

    function sorter (string $key): callable {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }

    usort($companies, sorter('name'));

    if (array_key_exists('term', $_GET)) {
        $filteredTerm = '';
        $searchTerm = $_GET['term'];
        $searchTerm = strtolower($searchTerm);

        for ($index = 0; $index < strlen($searchTerm); $index++) {
            $char = $searchTerm[$index];
            switch ($char) {
                case 'a':
                    $filteredTerm .= 'a';
                    break;

                case 'b':
                    $filteredTerm .= 'b';
                    break;

                case 'c':
                    $filteredTerm .= 'c';
                    break;

                case 'd':
                    $filteredTerm .= 'd';
                    break;

                case 'e':
                    $filteredTerm .= 'e';
                    break;

                case 'f':
                    $filteredTerm .= 'f';
                    break;

                case 'g':
                    $filteredTerm .= 'g';
                    break;

                case 'h':
                    $filteredTerm .= 'h';
                    break;

                case 'i':
                    $filteredTerm .= 'i';
                    break;

                case 'j':
                    $filteredTerm .= 'j';
                    break;

                case 'k':
                    $filteredTerm .= 'k';
                    break;

                case 'l':
                    $filteredTerm .= 'l';
                    break;

                case 'm':
                    $filteredTerm .= 'm';
                    break;

                case 'n':
                    $filteredTerm .= 'n';
                    break;

                case 'o':
                    $filteredTerm .= 'o';
                    break;

                case 'p':
                    $filteredTerm .= 'p';
                    break;

                case 'q':
                    $filteredTerm .= 'q';
                    break;

                case 'r':
                    $filteredTerm .= 'r';
                    break;

                case 's':
                    $filteredTerm .= 's';
                    break;

                case 't':
                    $filteredTerm .= 't';
                    break;

                case 'u':
                    $filteredTerm .= 'u';
                    break;

                case 'v':
                    $filteredTerm .= 'v';
                    break;

                case 'w':
                    $filteredTerm .= 'w';
                    break;

                case 'x':
                    $filteredTerm .= 'x';
                    break;

                case 'y':
                    $filteredTerm .= 'y';
                    break;

                case 'z':
                    $filteredTerm .= 'z';
                    break;

                case '0':
                    $filteredTerm .= '0';
                    break;

                case '1':
                    $filteredTerm .= 'z1';
                    break;

                case '2':
                    $filteredTerm .= '2';
                    break;

                case '3':
                    $filteredTerm .= '3';
                    break;

                case '4':
                    $filteredTerm .= '4';
                    break;

                case '5':
                    $filteredTerm .= '5';
                    break;

                case '6':
                    $filteredTerm .= '6';
                    break;

                case '7':
                    $filteredTerm .= '7';
                    break;

                case '8':
                    $filteredTerm .= '8';
                    break;

                case '9':
                    $filteredTerm .= '9';
                    break;
            }
        }

        foreach ($companies as $company) {
            $name = $company['name'];

            $pos = stripos($name, $filteredTerm);

            if ($pos !== false) {
                $companyObject[] = new Company($company['name'], $company['address'], $company['zip'], $company['city'], $company['activity'], $company['vat']);
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

    // View
    require_once $basePath . 'resources/templates/pages/companies.php';









