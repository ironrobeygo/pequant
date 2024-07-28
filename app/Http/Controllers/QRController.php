<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use mikehaertl\pdftk\Pdf;



class QRController extends Controller
{

    public function index()
    {
        // $result = Builder::create()
        //     ->writer(new PngWriter())
        //     ->writerOptions([])
        //     ->data('https://google.com')
        //     ->encoding(new Encoding('UTF-8'))
        //     ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        //     ->size(150)
        //     ->margin(10)
        //     ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
        //     ->logoPath(public_path('images/logo.png'))
        //     ->logoResizeToWidth(50)
        //     ->logoPunchoutBackground(true)
        //     ->labelText('')
        //     ->labelFont(new NotoSans(20))
        //     ->labelAlignment(LabelAlignment::Center)
        //     ->validateResult(false)
        //     ->build();

        // header('Content-Type: '.$result->getMimeType());
        // // echo $result->getString();

        // echo '<img src="'.$result->getDataUri().'">';
        // $data = array(
        //     'Name' => 'Iron Robey Go',
        //     'Course' => 'Prescriptive Analysis'
        // );

        // $pdf = Pdf::loadFile(public_path('images/templates/certficate-template-fillable.pdf'), $data);
        $pdf = new Pdf(public_path('images/templates/certficate-template-fillable.pdf'), [
            'command' => '/usr/local/bin/pdftk',
            'useExec' => true,
        ]);

        $result = $pdf->fillForm([
                'Name' => 'Iron Robey Go',
                'Course' => 'Prescriptive Analysis'
            ])
            ->needAppearances()
            ->saveAs(public_path('images/templates/filled.pdf'));

        // Always check for errors
        if ($result === false) {
            $error = $pdf->getError();
        }
    }
}
