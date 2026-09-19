<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Generates the Birmingham 2027 visa invitation letter PDF.
 *
 * The HTML/CSS template below is preserved as-is from the original
 * GET-parameter prototype (temp/pdf.php) and must not be redesigned.
 * Only the data source (database instead of GET) and the output method
 * (save to storage instead of stream) have changed.
 */
final class VisaLetterPdfService
{
    private string $imagesDir;

    public function __construct()
    {
        $this->imagesDir = dirname(__DIR__, 2) . '/public/assets/images';
    }

    /**
     * Renders the PDF for the given visa request data and returns the raw PDF bytes.
     *
     * @param array{
     *     inviteeName: string,
     *     passportCountry: string,
     *     passportNumber: string,
     *     dateOfBirth: string,
     *     dateOfIssue: string,
     *     dateOfExpiry: string,
     *     homeAddress: string
     * } $data
     */
    public function render(array $data): string
    {
        $html = $this->buildHtml($data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);
        $options->set('chroot', dirname(__DIR__, 2));
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    private function buildHtml(array $data): string
    {
        $date = date('j F Y');
        $inviteeName = $data['inviteeName'];
        $passportCountry = $data['passportCountry'];
        $passportNumber = $data['passportNumber'];
        $dateOfBirth = $data['dateOfBirth'];
        $dateOfIssue = $data['dateOfIssue'];
        $dateOfExpiry = $data['dateOfExpiry'];
        $homeAddress = $data['homeAddress'];

        $logoUrl = $this->imagesDir . '/logo.png';
        $signatureUrl = $this->imagesDir . '/sign.png';
        $footerUrl = $this->imagesDir . '/footer.png';

        $e = static function (string $value): string {
            return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        };

        return '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>
@page {
    size: A4 portrait;
    margin: 0;
}

html,
body {
    margin: 0;
    padding: 0;
    width: 210mm;
    height: 297mm;
}

body {
    background: #fff3cf;
    color: #000000;
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 8.7pt;
    line-height: 1.22;
}

.page {
    position: relative;
    width: 210mm;
    height: 297mm;
    overflow: hidden;
    background: #fff3cf;
}

/* ============================================================
   MAIN CONTENT AREA
   ============================================================ */

.content {
    position: absolute;
    left: 24mm;
    right: 24mm;
    top: 3mm;
    bottom: 39mm;
}

/* ============================================================
   LOGO
   ============================================================ */

.logo-wrapper {
    width: 100%;
    text-align: center;
    margin: 0;
    padding: 0;
}

.logo {
    width: 23mm;
    height: auto;
    display: inline-block;
}

/* ============================================================
   CHURCH HEADER
   ============================================================ */

.church-header {
    text-align: center;
    font-size: 8.5pt;
    line-height: 1.05;
    margin-top: 0.5mm;
}

.church-name {
    font-weight: normal;
}

.church-address {
    font-weight: normal;
}

/* ============================================================
   DATE
   ============================================================ */

.date {
    text-align: right;
    font-size: 8.7pt;
    margin-top: 5mm;
    margin-bottom: 5.5mm;
}

/* ============================================================
   SUBJECT
   ============================================================ */

.subject {
    font-size: 8.7pt;
    margin-bottom: 6mm;
}

.subject strong {
    font-weight: bold;
}

/* ============================================================
   SALUTATION
   ============================================================ */

.salutation {
    margin-bottom: 6mm;
}

/* ============================================================
   PARAGRAPHS
   ============================================================ */

p {
    margin: 0 0 5.5mm 0;
    padding: 0;
    text-align: justify;
}

/* ============================================================
   HOTEL
   ============================================================ */

.hotel {
    margin-top: -1mm;
    margin-bottom: 5.5mm;
}

.hotel-name {
    font-weight: bold;
}

/* ============================================================
   INVITEE INTRO
   ============================================================ */

.invitee-intro {
    margin-bottom: 2.5mm;
}

/* ============================================================
   DETAILS LIST
   ============================================================ */

.details {
    margin-top: 0;
    margin-bottom: 5.5mm;
    padding-left: 7mm;
}

.details li {
    margin: 0;
    padding-left: 0.8mm;
    line-height: 1.32;
}

.details strong {
    font-weight: bold;
}

/* ============================================================
   CLOSING
   ============================================================ */

.yours {
    margin-top: 1mm;
    margin-bottom: 1.5mm;
}

/* ============================================================
   SIGNATURE
   ============================================================ */

.signature {
    display: block;
    width: 32mm;
    height: auto;
    margin: 0 0 3.5mm 0;
}

/* ============================================================
   SIGNATORY
   ============================================================ */

.signatory {
    font-size: 8.7pt;
    line-height: 1.25;
}

.signatory-name {
    margin: 0;
}

.signatory-title {
    margin: 0;
}

.email {
    margin: 0;
}

/* ============================================================
   FOOTER IMAGE
   ============================================================ */

.footer-image {
    position: absolute;
    width: 170mm;
    height: auto;
    left: 20mm;
    bottom: 0;
    display: block;
}

/* ============================================================
   FOOTER TEXT
   ============================================================ */

.footer-text {
    position: absolute;
    left: 20mm;
    right: 20mm;
    bottom: 3.5mm;
    text-align: center;
    color: #ffffff;
    font-size: 5.8pt;
    line-height: 1.25;
    z-index: 20;
}

</style>
</head>

<body>

<div class="page">

    <!-- ======================================================
         MAIN LETTER
         ====================================================== -->

    <div class="content">

        <!-- LOGO -->

        <div class="logo-wrapper">
            <img
                src="' . $e($logoUrl) . '"
                class="logo"
                alt="Godstone Tabernacle"
            >
        </div>

        <!-- CHURCH NAME -->

        <div class="church-header">
            <div class="church-name">
                Godstone Tabernacle
            </div>
            <div class="church-address">
                Sylverdale Road<br>
                CR8 2DT, United Kingdom
            </div>
        </div>

        <!-- DATE -->

        <div class="date">
            Date: ' . $e($date) . '
        </div>

        <!-- SUBJECT -->

        <div class="subject">
            <strong>Subject:</strong>
            International Christian Convention, Birmingham, UK, 2027
        </div>

        <!-- SALUTATION -->

        <div class="salutation">
            Dear Sir/Madam,
        </div>

        <!-- INTRODUCTION -->

        <p>
            <strong>Godstone Tabernacle UK</strong> is hosting an International
            Christian Conference at the Hilton Birmingham Metropole, Birmingham,
            UK from 6th August to 11th August 2027.
        </p>

        <!-- HOTEL -->

        <div class="hotel">
            <div class="hotel-name">
                Hilton Birmingham Metropole
            </div>
            Pendigo Way, Marston Green,<br>
            Birmingham B40 1PP UK
        </div>

        <!-- INVITATION -->

        <p class="invitee-intro">
            Christian friends from around the world have been invited to the
            Conference. I would be extremely grateful if the below mentioned
            person could be granted a temporary visa to attend our international
            Conference:
        </p>

        <!-- INVITEE DETAILS -->

        <ul class="details">

            <li>
                <strong>Name: </strong>' . $e($inviteeName) . '
            </li>

            <li>
                <strong>Country of passport: </strong>' . $e($passportCountry) . '
            </li>

            <li>
                <strong>Passport Number: </strong>' . $e($passportNumber) . '
            </li>

            <li>
                <strong>Date of birth: </strong>' . $e($dateOfBirth) . '
            </li>

            <li>
                <strong>Date of issue: </strong>' . $e($dateOfIssue) . '
            </li>

            <li>
                <strong>Date of expiry: </strong>' . $e($dateOfExpiry) . '
            </li>

            <li>
                <strong>Full home address: </strong>' . $e($homeAddress) . '
            </li>

        </ul>

        <!-- ACCOMMODATION -->

        <p>
            They will be staying at the Hilton Birmingham Metropole for the
            duration of the Conference. We will be responsible for all of their
            needs during their stay (food, accommodation, finances), and will
            ensure their departure from the UK back to their country of origin
            immediately after the Conference.
        </p>

        <!-- FINAL PARAGRAPH -->

        <p>
            I hope that the above information is sufficient, and express my
            appreciation to you in advance for granting
            <strong>' . $e($inviteeName) . '</strong>
            a visa for the purpose of attending the International Christian
            Conference. If you have any questions or need further information,
            please do not hesitate to contact me. Thank you.
        </p>

        <!-- CLOSING -->

        <div class="yours">
            Yours sincerely,
        </div>

        <!-- SIGNATURE -->

        <img
            src="' . $e($signatureUrl) . '"
            class="signature"
            alt="Signature"
        >

        <!-- SIGNATORY -->

        <div class="signatory">
            <div class="signatory-name">
                Dr Matthew O. King
            </div>

            <div class="signatory-title">
                Head Trustee, Godstone Tabernacle, UK
            </div>

            <div class="email">
                Conventions@godstonetabernacle.com
            </div>
        </div>

    </div>

    <!-- ======================================================
         RED FOOTER GRAPHIC
         ====================================================== -->

    <img
        src="' . $e($footerUrl) . '"
        class="footer-image"
        alt=""
    >

    <!-- ======================================================
         FOOTER TEXT
         ====================================================== -->

    <div class="footer-text">
        Godstone Tabernacle, Sylverdale Road, Purley, Surrey CR8 2DT<br>
        Pastor: Rev. K. Blewett<br>
        Godstone Tabernacle (Handcroft Chapel) – Charity No: 1082686
    </div>

</div>

</body>
</html>';
    }
}
