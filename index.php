<?php

namespace App;

use Dompdf\Dompdf;
use Dompdf\Options;

require_once 'vendor/autoload.php';



class DomPdfRemoteUrlCapitalSensitiveIssue
{
    private Dompdf $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->setIsJavascriptEnabled(false);
        $options->setIsPhpEnabled(true);
        $options->setDefaultPaperSize('a4');
        $options->setIsRemoteEnabled(true);
        $options->setIsFontSubsettingEnabled(true);
        $options->setIsHtml5ParserEnabled(true);

        $this->dompdf = new Dompdf($options);
    }

    public function render(string $file)
    {
        $this->dompdf->loadHtml(file_get_contents(sprintf('%s/%s', __DIR__, $file)));
        $this->dompdf->render();
        file_put_contents(sprintf('%s.pdf', $file), $this->dompdf->output());

        global $_dompdf_warnings;
        var_dump($_dompdf_warnings);
        $_dompdf_warnings = [];
    }
}

(new DomPdfRemoteUrlCapitalSensitiveIssue())->render('not-working.html');
(new DomPdfRemoteUrlCapitalSensitiveIssue())->render('working.html');