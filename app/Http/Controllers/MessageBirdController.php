<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageBirdController extends Controller
{
  
  public function sendSms(Request $request) {
   $MessageBird = new \MessageBird\Client("91p6gv4qqQB5uKKOWtoxX9tjx");
  $Message = new \MessageBird\Objects\Message();
  $Message->originator = "TestMessage";
  $Message->recipients = $request->number;
  $Message->body = $request->body;

  $sms = $MessageBird->messages->create($Message);

  return response()->json([
        "message" => $sms
    ]);
}
//Con il simulatore scrivo ciao: lui mi risponde ciao e invia richiesta a mio endpoint per salvare
//Salvo numero con storage
//https://mutuoverso-api.v-net.t/api/marco-test
  public function SaveNumber(Request $request){
    $data = [
      "key"=> "Number",
      "value"=> $request->value
  ];
    $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => "https://flows.messagebird.com/databases/key-values/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30000,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($data),
      CURLOPT_HTTPHEADER => array(
          //"accept-language: en-US,en;q=0.8",
          "content-type: application/json; charset=utf-8",
          "Authorization: AccessKey 91p6gv4qqQB5uKKOWtoxX9tjx"
      ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);
  if ($err) {
      echo "cURL Error #:" . $err;
  } else {
    print_r(json_decode($response));
  }
  }

  public function MessageWA(Request $request){
    // $data1 = [
    //   "type" => "hsm",
    //   "to" => "+393470427936",
    //   "from" => "f893e6eb-893e-4cf9-8b62-2af0470bf85b",
    //   "content"=> [
    //     "hsm"=> [
    //       "namespace"=>"dd69cade_7c77_4ce5_96b9_6c4893c5514d",
    //       "templateName"=>"template_prova",
    //       "language"=>[
    //         "policy"=>"deterministic",
    //           "code"=>"it"
    //         ],
    //       "params"=>array(
    //                       [
    //                       "default"=>"Marco"
    //                       ],
    //                       [
    //                       "default"=>"22-05-97"
    //                       ]
    //                       ),
    //       ]
    //         ],
    // ];
  //   $data1 = [
  //     "content"=> [
  //       "hsm"=> [
  //         "language"=>[
  //             "code"=>"it"
  //           ],
  //         "components"=>array(
  //                     [
  //                       "type"=>"body",
  //                       "parameters"=>array(
  //                         [
  //                         "text"=>"Nicc"
  //                         ],
  //                         [
  //                           "text"=>"22-05-97"
  //                           ]
  //                         )
  //                       ]
  //                     ),
  //         "namespace"=>"dd69cade_7c77_4ce5_96b9_6c4893c5514d",
  //         "templateName"=>"template_prova",
  //         ]
  //           ],
  //     "to" => "+393470427936",
  //     "type" => "hsm",
  //     "from" => "fa6b836b-2798-4e22-ae72-8844991b227e",
  //   ];



  //   $data2 = [
  //     "to" => "+393470427936",
  //     "type" => "text",
  //     "from" => "fa6b836b-2798-4e22-ae72-8844991b227e",
  //     "content"=> [
  //       "text"=>"Prova testo",
  //       "disableUrlPreview"=>false
  //     ]
  // ];
  $curl = curl_init();
  
  curl_setopt_array($curl, array(
      CURLOPT_URL => "https://conversations.messagebird.com/v1/conversations/fa8f8d6eae1b454097fc0655cd163009/messages",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30000,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => '    {"to": "3470427936",
        "from": "f893e6eb-893e-4cf9-8b62-2af0470bf85b",
        "type": "hsm",
        "content": {
        "hsm": {
         "namespace": "dd69cade_7c77_4ce5_96b9_6c4893c5514d",
         "templateName": "template_prova",
         "language": {
           "policy": "deterministic",
           "code": "it"
         },
         "components": [
           {
             "type": "body",
             "parameters": [
               {
                 "default": "Robert4"
               },
               {
                "default": "Robert4"
              }
             ]
           }
         ]
        }}}',
      CURLOPT_HTTPHEADER => array(
          //"accept-language: en-US,en;q=0.8",
          "content-type: application/json; charset=utf-8",
          "Authorization: AccessKey 91p6gv4qqQB5uKKOWtoxX9tjx"
      ),
  ));
  
  // $curl2 = 'curl -X "POST" "https://conversations.messagebird.com/v1/conversations/21f12172a7114f0f978bba4bee2f864f/messages" \\'."
  // -H 'Authorization: AccessKey 91p6gv4qqQB5uKKOWtoxX9tjx' \\"."
  // -H 'Content-Type: application/json; charset=utf-8'  \\
  // -d $'";
  // $curl3 = '{"to": "+393463741244",
  //   "channelId": "fa6b836b-2798-4e22-ae72-8844991b227e",
  //   "type": "hsm",
  //   "content": {
  //   "hsm": {
  //    "namespace": "dd69cade_7c77_4ce5_96b9_6c4893c5514d",
  //    "templateName": "template_prova",
  //    "language": {
  //      "policy": "deterministic",
  //      "code": "it"
  //    },
  //    "components": [
  //      {
  //        "type": "body",
  //        "parameters": [
  //          {
  //            "type": "text",
  //            "text": "Robert3"
  //          },
  //          {
  //           "type": "text",
  //           "text": "Robert3"
  //         }
  //        ]
  //      }
  //    ]
  //   }}}';
  //   $curl4 = curl_init($curl2.$curl3."'");
  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);
  return $curl2.$curl3."'";
  if ($err) {
      echo "cURL Error #:" . $err;
  } else {
    print_r(json_decode($response));
  }
  }
}
