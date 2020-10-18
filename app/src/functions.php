<?php

    function searchByName (string $searchName, array $companies): int {
        foreach ($companies as $key => $company) {
            $name = $company['name'];
            if ($searchName === $name) {
                return $key;
            }
        }
        return -1;
    }

    function searchCompanyByClient (string $client, array $companies): int {
        foreach ($companies as $key => $company) {
            $vat = $company['vat'];
            if ($vat === $client) {
                return $key;
            }
        }
        return -1;
    }

    function sorter (string $key): callable {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }

    function filterString (string $string): string {
        $filterTerm = '';
        $searchTerm = $string;
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
                    $filterTerm .= 'z1';
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

                case ' ':
                    $filterTerm .= ' ';
                    break;
            }
        }

        return $filterTerm;
    }

    function searchCompanyByName (array $companies, string $searchTerm): array {
        $companyObject = [];
        foreach ($companies as $company) {
            $nameCompany = $company['name'];

            $posCompany = stripos($nameCompany, $searchTerm);

            if ($posCompany !== false) {
                $companyObject[] = new Company($company['name'], $company['address'], $company['zip'], $company['city'], $company['activity'], $company['vat']);
            }
        }

        return $companyObject;
    }
    function createCompanyObj (array $array): array {
        $companyObj = [];
        foreach ($array as $index => $company) {
            $name = $company['name'];
            $address = $company['address'];
            $zip = $company['zip'];
            $city = $company['city'];
            $activity = $company['activity'];
            $vat = $company['vat'];

            $companyObj[] = new Company($name, $address, $zip, $city, $vat, $activity);
        }

        return $companyObj;
    }
    function createContactObj (array $array): array {
        $contactObj = [];
        foreach ($array as $index => $contact) {
            $name = $contact['name'];
            $client = $contact['client'];
            $email = $contact['email'];
            $phone = $contact['phone'];

            $contactObj[] = new Contact($name, $client, $email, $phone);
        }

        return $contactObj;
    }


?>
