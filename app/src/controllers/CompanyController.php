<?php

    use Doctrine\DBAL\Connection;
    use Doctrine\DBAL\DriverManager;
    use Twig\Environment;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;
    use Twig\Loader\FilesystemLoader;

    class CompanyController {

        protected Connection $db;
        protected Environment $twig;

        private array $dropdown;
        private array $provinces;
        private string $termValue;
        private string $cityValue;
        private array $provinceValue;

        public function __construct () {
            // Include the needed classes.
            require_once __DIR__ . '/../../src/Models/Company.php';
            require_once __DIR__ . '/../../src/Models/Contact.php';
            require_once __DIR__ . '/../../src/Models/Province.php';
            require_once __DIR__ . '/../../src/Models/Tickets.php';

            // Bootstrap Twig
            $loader = new FilesystemLoader(__DIR__ . '/../../resources/templates');
            $this->twig = new Environment($loader);

            // Database connection
            require_once __DIR__ . '/../../config/database.php';
            $connectionParams = [
                'host' => DB_HOST,
                'dbname' => DB_NAME,
                'user' => DB_USER_NAME,
                'password' => DB_PASS,
                'driver' => 'pdo_mysql',
                'charset' => 'utf8mb4'
            ];

            try {
                $this->db = $connection = DriverManager::getConnection($connectionParams);
                $connection->connect();
            }
            catch (\Doctrine\DBAL\Exception $exception) {
                $connection = null;
                echo $exception;
            }

            // Fill the dropdown with cities.
            try {
                $companyCitiesInfo = [];
                $companyCitiesInfo = $this->db->fetchAllAssociative('SELECT city FROM companies GROUP BY city');
            }
            catch (\Doctrine\DBAL\Exception $exception) {
                echo $exception;
            }

            foreach ($companyCitiesInfo as $city) {
                $companyCities[] = $city['city'];
            }

            sort($companyCities);
            $this->dropdown = $companyCities;

            // Fill multiselect with provinces.
            $this->provinces = [
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

            // Data
            $this->termValue = isset($_GET['term']) ? (string)$_GET['term'] : '';
            $this->cityValue = isset($_GET['city']) ? $_GET['city'] : '';
            $this->provinceValue = isset($_GET['province']) ? (array)$_GET['province'] : array();
        }

        public function overview () {
            $projectsObj = [];

            $msgTerm = '';
            $msgDropdown = '';
            $msgProvince = '';

            $okTerm = true;
            $okDropdown = true;
            $okSelect = true;

            $companyObj = [];
            $contactObj = [];
            $zipVal = [];
            $companies = [];
            $clients = [];

            $moduleAction = isset($_GET['moduleAction']) ? $_GET['moduleAction'] : '';
            if ($moduleAction == 'search-company') {

                /*
                 * This part of the code will only be executed if the form has already been sent before.
                 * The fields are checked and results are searched based on the entered values.
                 */

                /*
                 * Form check
                 */
                $ok = true;

                if (trim($this->termValue) === '') {
                    $msgTerm = 'Gelieve een zoekterm in te vullen';
                    $ok = false;
                    $okTerm = false;
                }

                if ($this->cityValue === 'Choose city') {
                    $msgDropdown = 'Gelieve een stad te kiezen';
                    $ok = false;
                    $okDropdown = false;
                }

                if (count($this->provinceValue) === 0) {
                    $msgProvince = 'Gelieve één of meerdere provincies te selecteren';
                    $ok = false;
                    $okSelect = false;
                }

                /*
                 * if everything is ok show the results
                 */
                if ($ok) {
                    /*
                     * Create an array of the selected provinces their zip values
                     */
                    foreach ($this->provinceValue as $provinceName) {
                        foreach ($this->provinces as $province) {
                            if ($provinceName === $province->getName()) {
                                for ($zip = $province->getLowerZip(); $zip <= $province->getUpperZip(); $zip++) {
                                    $zipVal[] = $zip;
                                }
                            }
                        }
                    }

                    /*
                     * Search for companies that match the search term
                     */
                    $searchTerm = '%' . $this->termValue . '%'; //Percent signs as wildcard for the search value
                    try {
                        $companyRecord = [];
                        $stmt = $this->db->prepare('SELECT * FROM companies WHERE (name LIKE ? OR activity LIKE ?) AND city = ?');
                        $stmt->execute([$searchTerm, $searchTerm, $this->cityValue]);
                        $companyRecord = $stmt->fetchAllAssociative();
                    }
                    catch (\Doctrine\DBAL\Exception $exception) {
                        echo $exception;
                    }
                    catch (\Doctrine\DBAL\Driver\Exception $exception) {
                        echo $exception;
                    }

                    if ($companyRecord) {
                        $companyObjFirst = [];
                        for ($index = 0; $index < count($companyRecord); $index++) {
                            $companyObjFirst[] = new Company(
                                $companyRecord[$index]['id'],
                                $companyRecord[$index]['name'],
                                $companyRecord[$index]['address'],
                                $companyRecord[$index]['zip'],
                                $companyRecord[$index]['city'],
                                $companyRecord[$index]['activity'],
                                $companyRecord[$index]['vat']
                            );
                        }

                        foreach ($companyObjFirst as $companyFirst) {
                            for ($index = 0; $index < count($this->provinceValue); $index++) {
                                foreach ($this->provinces as $province) {
                                    if ($province->getName() === $this->provinceValue[$index] && $companyFirst->getZip() >= $province->getLowerZip() && $companyFirst->getZip() <= $province->getUpperZip()) {
                                        $companyObj[] = $companyFirst;
                                    }
                                }
                            }
                        }
                    }

                    /*
                     *  Here we look if a company of the company list, has a contact
                     */

                    /*
                     *  Create an array with all the id's of the shown companies
                     */
                    $companyIds = [];
                    foreach ($companyObj as $company) {
                        $companyIds[] = $company->getId();
                    }

                    if ($companyIds) {
                        /*
                         *  Construct a query
                         */
                        $idArrayLength = count($companyIds);
                        $counter = 0;
                        $query = 'SELECT clients.id, clients.company_id, clients.first_name, clients.last_name, clients.email, clients.phone, companies.vat FROM clients INNER JOIN companies ON companies.id = clients.company_id WHERE';
                        foreach ($companyIds as $id) {
                            $query .= ' company_id = ?';
                            if ($counter !== $idArrayLength - 1) {
                                $query .= ' OR';
                            }
                            $counter++;
                        }

                        try {
                            $contactRecords = [];
                            $stmt = $this->db->prepare($query);
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
                            $contactObj[] = new Contact(
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
                    /*
                     *  If something is wrong with the form, show all the companies.
                     */
                    try {
                        $companies = $this->db->fetchAllAssociative('SELECT * FROM companies ORDER BY name');
                    }
                    catch (\Doctrine\DBAL\Exception $exception) {
                        echo $exception;
                    }

                    foreach ($companies as $company) {
                        $companyObj[] = new Company(
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
                        $clients = $this->db->fetchAllAssociative('SELECT clients.id, clients.company_id, clients.first_name, clients.last_name, clients.email, clients.phone, companies.vat FROM clients INNER JOIN companies ON companies.id = clients.company_id ORDER BY first_name');
                    }
                    catch (\Doctrine\DBAL\Exception $exception) {
                        echo $exception;
                    }

                    foreach ($clients as $client) {
                        $contactObj[] = new Contact(
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

                /*
                 * In this part of the code, a list of all the companies, contacts and projects is made
                 * if the page is visited for the fist time.
                 *
                 * The companies and contacts are sorted alphabetically.
                 */

                try {
                    $companies = $this->db->fetchAllAssociative('SELECT * FROM companies ORDER BY name');
                }
                catch (\Doctrine\DBAL\Exception $exception) {
                    echo $exception;
                }

                foreach ($companies as $company) {
                    $companyObj[] = new Company(
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
                    $clients = $this->db->fetchAllAssociative('SELECT clients.id, clients.company_id, clients.first_name, clients.last_name, clients.email, clients.phone, companies.vat FROM clients INNER JOIN companies ON companies.id = clients.company_id ORDER BY first_name');
                }
                catch (\Doctrine\DBAL\Exception $exception) {
                    echo $exception;
                }

                $contactObj = [];
                foreach ($clients as $client) {
                    $contactObj[] = new Contact(
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


            // Render template
            try {
                echo $this->twig->render('/pages/companies.twig', [
                    'formAction' => '/dashboard/companies',
                    'okTerm' => $okTerm,
                    'persistTerm' => $this->termValue,
                    'errorMessageTerm' => $msgTerm,
                    'okDropdown' => $okDropdown,
                    'cityValue' => $this->cityValue,
                    'companyCities' => $this->dropdown,
                    'errorMessageCity' => $msgDropdown,
                    'okSelect' => $okSelect,
                    'provinces' => $this->provinces,
                    'provinceValue' => $this->provinceValue,
                    'errorMessageProvince' => $msgProvince,
                    'companyObject' => $companyObj,
                    'contactObject' => $contactObj,
                    'userName' => $_SESSION['user'][0]['first_name'] . ' ' . $_SESSION['user'][0]['last_name'],
                    'user' => isset($_SESSION['user'])
                ]);
            }
            catch (LoaderError $e) {
                echo $e;
            }
            catch (RuntimeError $e) {
                echo $e;
            }
            catch (SyntaxError $e) {
                echo $e;
            }
        }
    }
