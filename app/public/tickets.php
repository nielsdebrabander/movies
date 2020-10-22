<?php
    // General variables
    $basePath = __DIR__ . '/../';

    // Data
    $companies = require_once $basePath . 'resources/data/companies.php';
    require_once $basePath . 'src/Models/Company.php';
    require_once $basePath . 'src/functions.php';
    $priority = ['laag', 'middel', 'hoog'];

    $nameValue = isset($_POST['name']) ? (string)$_POST['name'] : '';
    $companyValue = isset($_POST['company']) ? (string)$_POST['company'] : '';
    $dateValue = isset($_POST['date']) ? (string)$_POST['date'] : '';
    $shortValue = isset($_POST['short']) ? (string)$_POST['short'] : '';
    $longValue = isset($_POST['long']) ? (string)$_POST['long'] : '';
    $desiredValue = isset($_POST['desired']) ? (string)$_POST['desired'] : '';
    $priorValue = isset($_POST['prior']) ? (string)$_POST['prior'] : '';
    $emailValue = isset($_POST['email']) ? (string)$_POST['email'] : '';
    $fileToUploadValue = isset($_FILES['fileToUpload']) ? $_FILES['fileToUpload'] : '';
    $allowed_image_extension = array("jpeg", "png", "doc", "docx", "xls","xlsx", "pdf");

    $ErrName = '';
    $ErrCompany = '';
    $ErrDate = '';
    $ErrShort = '';
    $ErrLong = '';
    $ErrDesired = '';
    $ErrPrior = '';
    $ErrEmail = '';
    $ErrFileToUpload = '';

    $nameOk = true;
    $companyOk = true;
    $dateOk = true;
    $shortOk = true;
    $longOk = true;
    $desiredOk = true;
    $priorOk = true;
    $emailOk = true;
    $fileToUploadOk = true;

    if (isset($_POST['moduleAction'])) {

        $ok = true;

        if (trim($nameValue) === '') {
            $ErrName = 'Gelieve een naam in te vullen';
            $ok = false;
            $nameOk = false;
        }

        if (trim($companyValue) === '') {
            $ErrCompany = 'Gelieve een bedrijf aan te duiden';
            $ok = false;
            $companyOk = false;
        }
        if (trim($dateValue) === '') {
            $ErrDate = 'Gelieve een datum op te geven';
            $ok = false;
            $dateOk = false;
        }

        if (trim($shortValue) === '') {
            $ErrShort = 'Gelieve een korte beschrijving te geven';
            $ok = false;
            $shortOk = false;
        }

        if (trim($longValue) === '') {
            $ErrLong = 'Gelieve een gedetailleerde beschrijving te geven';
            $ok = false;
            $longOk = false;
        }
        if (trim($desiredValue) === '') {
            $ErrDesired = 'Gelieve een situatie in te geven';
            $ok = false;
            $desiredOk = false;
        }

        if (trim($priorValue) === '') {
            $ErrPrior = 'Gelieve een prioriteit aan te duiden';
            $ok = false;
            $priorOk = false;
        }
        if (trim($emailValue) === '') {
            $ErrEmail = 'Gelieve een email adres op te geven';
            $ok = false;
            $emailOk = false;
        }
        if (trim($fileToUploadValue) === '') {
            $ErrFileToUpload = 'Gelieve een bestand te uploaden';
            $ok = false;
            $fileToUploadOk = false;
        }
        if(in_array($fileToUploadValue, $allowed_image_extension)=== false){
            $ErrFileToUpload = 'Gelieve een (jpeg, png, doc(x), xls(x) of pdf) ';
            $ok = false;
            $fileToUploadOk = false;
        }

        if ($ok) {
            $info = array($nameValue, $companyValue, $dateValue, $shortValue, $longValue, $desiredValue, $priorValue, $emailValue, $fileToUploadValue);

            foreach ($companies as $company) {
               if ($company['name'] === $companyValue) {
                    $getVat = $company['vat'];
               }
            }

            $filePath = $basePath . 'resources/data/tickets';
            //$path = $filePath .  '/' . $getVat . '.csv';
            $file = fopen($filePath, "w");
            $test = "hallo";
            fwrite($file, $test);


        }
    }

    // View
    require_once $basePath . 'resources/templates/pages/tickets.php';