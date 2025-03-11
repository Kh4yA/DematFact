<?php

namespace App\Services;

use Mpdf\Mpdf;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PdfGeneratorService
{
    public function generatePdf(string $html, string $entreprise, string $email, string $cgv)
    {
        try {
            // Initialisation de mPDF avec des options
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P', // Portrait
                'default_font' => 'Arial'
            ]);

            // ✅ Ajouter un footer HTML
        $footerHtml = '<div style="text-align: center; font-size: 12px; border-top: 1px solid black; padding-top: 5px;">
                <b>'.$entreprise.'</b> - '.$email.'
            </div>';

            // Définir le footer pour toutes les pages
            $mpdf->SetHTMLFooter($footerHtml);

            // Ajouter le contenu HTML
            $mpdf->WriteHTML($html);
            if(!empty($cgv)){
                $mpdf->AddPage();
                $mpdf->WriteHTML($cgv);
            }

            // Retourne le contenu du PDF en tant que string
            return $mpdf->Output('', 'S'); // 'S' retourne le PDF sous forme de string
        } catch (\Exception $e) {
            throw new HttpException(500, 'Erreur lors de la génération du PDF : ' . $e->getMessage());
        }
    }
}
