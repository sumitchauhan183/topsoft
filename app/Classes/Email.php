<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Mail;


Class Email{
    
    public Static function sendWelcomeMail($tname,$temail,$subject,$name,$body){
        $data = array("name"=>$name, "body" => $body);
        Mail::send("user.mails.welcome", $data, function($message) use ($tname, $temail,$subject) {
        $message->to($temail, $tname)
        ->subject($subject);
        $message->from("sumit@appscioto.com", "Welcome To TopSoft");
        });
    }

    public Static function sendVerificationMail($tname,$temail,$subject,$name,$body,$url){
        $data = array("name"=>$name, "body" => $body, "url" => $url);
        Mail::send("user.mails.verify", $data, function($message) use ($tname, $temail,$subject) {
        $message->to($temail, $tname)
        ->subject($subject);
        $message->from("sumit@appscioto.com", "Welcome To TopSoft");
        });
    }

    public Static function sendOtpMail($tname,$temail,$subject,$name,$body){
        $data = array("name"=>$name, "body" => $body);
        Mail::send("mails.send_otp", $data, function($message) use ($tname, $temail,$subject) {
        $message->to($temail, $tname)
        ->subject($subject);
        $message->from("sumit@appscioto.com", "Welcome To TopSoft");
        });
    }
    
}