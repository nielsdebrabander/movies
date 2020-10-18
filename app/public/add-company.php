<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Classes
    require_once $basePath . 'src/Models/Company.php';

    $nameValue = isset($_POST['name']) ? (string)$_POST['name'] : '';
    $addressValue = isset($_POST['address']) ? (string)$_POST['address'] : '';

    $zipValue = isset($_POST['zip']) ? (string)$_POST['zip'] : '';
    $zipValue = (int)$zipValue;

    $cityValue = isset($_POST['city']) ? (string)$_POST['city'] : '';
    $vatValue = isset($_POST['vat']) ? (string)$_POST['vat'] : '';
    $activityValue = isset($_POST['Activity']) ? (string)$_POST['Activity'] : '';

    $ErrName = '';
    $ErrAddress = '';
    $ErrCity = '';
    $ErrVat = '';
    $ErrActivity = '';

    $nameOk = true;
    $addressOk = true;
    $cityOk = true;
    $vatOk = true;
    $activityOk = true;

    if (isset($_POST['moduleAction'])) {

        $ok = true;

        if (trim($nameValue) === '') {
            $ErrName = 'Gelieve naam in te vullen';
            $ok = false;
            $nameOk = false;
        }

        if (trim($addressValue) === '') {
            $ErrAddress = 'Gelieve adress in te vullen';
            $ok = false;
            $addressOk = false;
        }

        if ((int)$zipValue < 0 || $zipValue === '') {
            $ErrCity = 'Gelieve stad in te vullen';
            $ok = false;
            $cityOk = false;
        }

        if (trim($cityValue) === '') {
            $ErrCity = 'Gelieve stad in te vullen';
            $ok = false;
            $cityOk = false;
        }

        if (trim($vatValue) === '') {
            $ErrVat = 'Gelieve VAT in te vullen';
            $ok = false;
            $vatOk = false;
        }

        if (trim($activityValue) === '') {
            $ErrActivity = 'Gelieve activiteit in te vullen';
            $ok = false;
            $activityOk = false;
        }

        if ($ok) {
            $company = array('name' => $nameValue, 'address' => $addressValue, 'zip' => $zipValue, 'city' => $cityValue, 'activity' => $activityValue, 'vat' => $vatValue);

            $strNewCompany = '[';

            foreach ($company as $key => $value) {
                if (is_int($value) == 1) {
                    $strNewCompany .= '\'' . $key . '\'' . ' => ' . $value . ', ';
                }
                else {
                    $strNewCompany .= '\'' . $key . '\'' . ' => ' . '\'' . $value . '\'' . ', ';
                }
            }
            $strNewCompany = substr_replace($strNewCompany, ']', -2);

            $filePath = $basePath . 'resources/data/companies.php';
            $file = fopen($filePath, 'r+');

            fseek($file, -7, SEEK_END);

            fwrite($file, ',' . PHP_EOL);
            fwrite($file, '        ' . $strNewCompany . PHP_EOL);
            fwrite($file, '    ];');

            fclose($file);

            header('location: companies.php');
            exit();
        }
    }

    // View
    require_once $basePath . 'resources/templates/pages/add-company.php';

?>

