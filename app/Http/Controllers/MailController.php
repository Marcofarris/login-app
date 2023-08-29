<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDemo;
use Symfony\Component\HttpFoundation\Response;

// prova
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\SMTP;

class MailController extends Controller {
    
    public function sendEmail(Request $request) {
        $email = $request->email;
   
        $content = $request->content;
        Mail::to($email)->send(new EmailDemo($content));
   
        return response()->json([
            'message' => 'Email has been sent.'
        ], Response::HTTP_OK);
    }

      
    public function sendEmailPhp() {
//         $mail = new PHPMailer(true);

//     $mail->IsSMTP(); // telling the class to use SMTP
//     $mail->SMTPAuth = true; // enable SMTP authentication
//     $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
//     $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
//     $mail->Port = 465; // set the SMTP port for the GMAIL server
//     $mail->Username = "TuaEmail@gmail.com"; // GMAIL username
//     $mail->Password = "Tua pwd"; // GMAIL password

// //Typical mail data
// $mail->AddAddress("TuaEmail", "tuo nome");
// $mail->SetFrom("email destinatario", "nome destinatario");
// $mail->Subject = "My Subject";
// $mail->Body = "Mail contents";

// try{
//     $mail->Send();
//     echo "Success!";
// } catch(Exception $e){
//     //Something went bad
//     echo "Fail - " . $mail->ErrorInfo;
// }
    }
}