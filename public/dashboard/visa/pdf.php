<?php

require __DIR__ . '/../../../app/bootstrap.php';

use App\Models\VisaRequest;
use App\Services\VisaLetterPdfService;
use function App\Middleware\requireLogin;

requireLogin();

$id = (int) ($_GET['id'] ?? 0);
$request = $id ? VisaRequest::findById($id) : null;

if (!$request) {
    http_response_code(404);
    exit('Visa request not found.');
}

$service = new VisaLetterPdfService();
$pdf = $service->render([
    'inviteeName' => $request['full_name'],
    'passportCountry' => $request['passport_country'],
    'passportNumber' => $request['passport_number'],
    'dateOfBirth' => date('j F Y', strtotime($request['date_of_birth'])),
    'dateOfIssue' => date('j F Y', strtotime($request['passport_issue_date'])),
    'dateOfExpiry' => date('j F Y', strtotime($request['passport_expiry_date'])),
    'homeAddress' => $request['home_address'],
]);

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="visa-letter-' . $id . '.pdf"');
header('X-Content-Type-Options: nosniff');
echo $pdf;
