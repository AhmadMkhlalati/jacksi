<?php


namespace App\Helpers;

use Illuminate\Support\Facades\URL;
use App\Models\User;
class Notification
{
    public static function send($title, $body,$image, $receiver_id)
    {

        $user = User::find($receiver_id);
        if ($user) {
            $token = $user->fcm;
            try {
//                Notify::create([
//                    'user_id' => $receiver_id,
//                    'token' => $token,
//                    'title' => $title,
//                    'body' => $body,
//                    'image' => $image,
//                    'order_id' => $order_id,
//                    'type' => $type,
//                ]);

            }catch (\Exception $e){
                return $e;
            }
            $SERVER_API_KEY = 'my key';


            // payload data, it will vary according to requirement
            $data = [
                "to" => $token, // for single device id
                "notification" => array(
                    'title' => $title,
                    'body' => $body,
                    'image' =>  $image
                ),
                "data" => [
//                    "orderId" => $order_id,
//                    "image" =>  $image
                ],
                "priority" => "high",

            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);

            curl_close($ch);

            return $response;
        }

    }

    public static function sendall($title, $body)
    {
        $users = User::select('fcm')->where('fcm', '!=', null)->get();
        $FCMs = [];
        foreach ($users as $key => $user) {
            $FCMs[$key] = $user['fcm'];
        }

        $token = 'general';




        $SERVER_API_KEY = 'my keys';


        $data = [
            "registration_ids" => $FCMs, // for All device
            "notification" => array(
                'title' => $title,
                'body' => $body,
            ),
            "priority" => "high",
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
