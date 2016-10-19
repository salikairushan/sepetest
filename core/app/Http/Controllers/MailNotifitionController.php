<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use Vsmoraes\Pdf\Pdf;
use App\User;



class MailNotifitionController extends Controller
{
    private $pdf;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function helloWorld()
    {
       ]
        $mpdf = new \mPDF();
        $mpdf->WriteHTML('Hello World');



        $mpdf->Output('../public/assets/pdf/example1.pdf', "I");

        $name ='salika';
        $html = view('pdf.timetable')->with('name',$name)->render();

        $this->pdf->load($html)
            ->filename('../public/assets/pdf/example1.pdf')
            ->output();

        return 'PDF saved';
    }

    public function sendMails(){
        $lec = User::all();


        foreach($lec as $key => $lecx){

            $name ='salika';
            $html = view('pdf.timetable')->with('name',$name)->render();

            $this->pdf->load($html)
                ->filename('../public/assets/pdf/'.$lecx->fname.'.pdf')
                ->output();
//
//            Mail::later(1,'emails.lecturer_timetable_mail', ['first_name' => $lecx->fname, 'last_name' => $lecx->lname], function ($m) use ($lecx){
//              //  $m->attach('../public/assets/pdf/'.$lecx->fname.'.pdf');
//                $m->to($lecx->email, $lecx->fname)->subject('Time Table');
//            });
        }
        return 'Email will be sent in 5 second';
    }
}
