<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Classes
    require_once $basePath . 'src/Models/Company.php';
    require_once $basePath . 'src/Models/Contact.php';
    require_once $basePath . 'src/functions.php';

    $companies = require_once $basePath . 'resources/data/companies.php';
    $contacts = require_once $basePath . 'resources/data/contacts.php';

    $companyObj = createCompanyObj($companies);

    $contactObj = createContactObj($contacts);

    $titleValue = isset($_POST['title']) ? (string)$_POST['title'] : '';
    $companyValue = isset($_POST['company']) ? (string)$_POST['company'] : '';
    $dateValue = isset($_POST['date']) ? (string)$_POST['date'] : '';
    $shortDescValue = isset($_POST['shortDesc']) ? (string)$_POST['shortDesc'] : '';
    $longDescValue = isset($_POST['longDesc']) ? (string)$_POST['longDesc'] : '';
    $preferredSituationValue = isset($_POST['preferred_situation']) ? (string)$_POST['preferred_situation'] : '';
    $priorityValue = isset($_POST['priority']) ? (string)$_POST['priority'] : '';
    $mailValue = isset($_POST['mail']) ? (string)$_POST['mail'] : '';
    $fileValue = isset($_FILES['file']) ? $_FILES['file'] : '';

    $msgTitle = '';
    $msgCompany = '';
    $msgDate = '';
    $msgShortDesc = '';
    $msgPriority = '';
    $msgMail = '';
    $msgFile = '';

    $titleOk = true;
    $companyOk = true;
    $dateOk = true;
    $shortDescOk = true;
    $priorityOk = true;
    $mailOk = true;
    $fileOk = true;

    $vatClient = '';

    if (isset($_POST['moduleAction'])) {

        $ok = true;

        if (trim($titleValue) === '') {
            $msgTitle = 'Gelieve titel in te vullen';
            $ok = false;
            $titleOk = false;
        }

        if ($companyValue === 'Select company') {
            $msgCompany = 'Gelieven bedrijf te kiezen';
            $ok = false;
            $companyOk = false;
        }

        if ($dateValue === '') {
            $msgDate = 'Gelieve datum in te vullen';
            $ok = false;
            $dateOk = false;
        }

        if ($shortDescValue === '') {
            $msgShortDesc = 'Gelieve beschrijving in te vullen';
            $ok = false;
            $shortDescOk = false;
        }

        if ($priorityValue === 'select priority') {
            $msgPriority = 'Gelieve niveau te kiezen';
            $ok = false;
            $priorityOk = false;
        }

        if ($mailValue === '') {
            $msgMail = 'Gelieve mail in te vullen';
            $ok = false;
            $mailOk = false;
        }

        foreach ($companyObj as $company) {
            if ($company->getName() == urldecode($companyValue)) {
                $vatClient = $company->getVat();
            }
        }

        if (!file_exists('../resources/data/tickets')) {
            mkdir('../resources/data/tickets');
        }

        if (!file_exists('../resources/data/tickets/documents')) {
            mkdir('../resources/data/tickets/documents');
        }

        if (!file_exists('../resources/data/tickets/documents/' . $vatClient)) {
            mkdir('../resources/data/tickets/documents/' . $vatClient);
        }

        if (isset($_FILES['file']) && ($_FILES['file']['error'] === UPLOAD_ERR_OK)) {
            if (in_array((new SplFileInfo($_FILES['file']['name']))->getExtension(), ['jpeg', 'jpg', 'doc', 'docx', 'xls', 'xlsx', 'pdf'])) {
                $moved = @move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . '/../resources/data/tickets/documents/' . $vatClient . '/' . $_FILES['file']['name']);

                if (!$moved) {
                    $msgFile = 'Fout bij het opslaan van het bestand';
                    $fileOk = false;
                }
            }
            else {
                $msgFile = 'Extentie niet toegestaan';
                $fileOk = false;
            }
        }

        if ($ok && $fileOk) {

            $uploadedFilePAth = isset($_FILES['file']) ? 'resources/data/tickets/documents/' . $vatClient . '/' . $_FILES['file']['name'] : '';
            $ticket = fopen($basePath . 'resources/data/tickets/' . $vatClient . '.csv', 'a');
            $value = [urldecode($titleValue), urldecode($companyValue), urldecode($dateValue), trim(urldecode($shortDescValue)), trim(urldecode($longDescValue)), trim(urldecode($preferredSituationValue)), urldecode($priorityValue), urldecode($mailValue), $uploadedFilePAth];
            fputcsv($ticket, $value, ';');

            header('location: companies.php');
            exit();
        }
    }

    $dateTimeObj = new DateTime('today');
    $today = date_format($dateTimeObj, 'Y-m-d');



    // View
    require_once $basePath . 'resources/templates/pages/tickets.php';
?>
