<?php
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

const BASE_API = 'http://api.music.zilack.com/';
const APP_ID = '1';

if (!function_exists('login_api')) {
    /**
     *
     * @return json
     */
    function login_api($data) {

        $client = new Client();

        $data = [
            'sec_name' => $data['email'],
            'sec_pass' => $data['password'],
            'app_id' => APP_ID
        ];

        try {
            $request = $client->request('POST', BASE_API . 'auth/login', ['query' => $data]);

            $result = json_decode($request->getBody());

            return [
                'result' => true,
                'token' => $result->data->token,
                'user' => $result->data->auth
            ];
        } catch (GuzzleException $exception) {
            $responseBodyAsString = $exception->getResponse()->getBody()->getContents();
            $response = json_decode($responseBodyAsString);

            return [
                'result' => false,
                'message' => $response->error
            ];
        }
    }
}

if (!function_exists('login_fb_api')) {
    /**
     *
     * @return json
     */
    function login_fb_api($data) {

        $client = new Client();

        $data = [
            'token' => $data['access_token'],
        ];

        try {
            $request = $client->request('POST', BASE_API . 'auth/login/facebook', ['query' => $data]);

            $result = json_decode($request->getBody());

            return [
                'result' => true,
                'token' => $result->data->token,
                'user' => $result->data->auth
            ];
        } catch (GuzzleException $exception) {
            $responseBodyAsString = $exception->getResponse()->getBody()->getContents();
            $response = json_decode($responseBodyAsString);

            return [
                'result' => false,
                'message' => $response->error
            ];
        }
    }
}

if (!function_exists('charge_api')) {
    /**
     *
     * @return json
     */
    function charge_api($data) {

        $client = new Client();

        $data = [
            'provider' => $data['provider'],
            'pin' => $data['pin'],
            'serial' => $data['serial']
        ];

        try {
            $request = $client->request('POST', BASE_API . 'payment/charge', [
                'query' => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . session('api_token')
                ]
            ]);

            $result = json_decode($request->getBody());

            if (!$result->error) {
                return [
                    'result' => true,
                    'user' => $result->data
                ];
            } else {
                return [
                    'result' => false,
                    'message' => 'Nạp thẻ không thành công'
                ];
            }


        } catch (GuzzleException $exception) {
            $responseBodyAsString = $exception->getResponse()->getBody()->getContents();
            $response = json_decode($responseBodyAsString);

            return [
                'result' => false,
                'message' => $response->error
            ];
        }
    }
}


if (!function_exists('vietnamese_url')) {
    function vietnamese_url($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        $str = str_replace(" ", "-", str_replace("&*#39;","",$str));

        return $str;
    }
}

if (!function_exists('array_rotate')) {
    function array_rotate(array $array, $count) {
        for ($turn = 1; $turn <= $count; $turn++) {
            array_push($array, array_shift($array));
        }

        return $array;
    }
}
