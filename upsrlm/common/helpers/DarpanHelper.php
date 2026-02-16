<?php

namespace common\helpers;

use bc\models\BcGovermentReportBlock;
use bc\models\FootPrintLocation;

class DarpanHelper
{

    const Instance_Code = 2;
    const Project_Code = 2898;
    const API_KEY = 'X5nyDOEuYm7S45duNDBLwZGs+6+fGsa8Ou5iT2vgglM=';
    const HMAC_KEY = 'YwOpvmFDoUWvm4gkmfCJyHSq48J0InxNjY+0CafkOvY=';
    // ZY4hPbe125vdVIr5QPDpQw==

    


    private static function iv()
    {
        // $method = 'AES-128-CBC';
        // echo  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        // die();
        return "ZY4hPbe125vdVIr5QPDpQw==";
        // return "trilinei" . date('YmdHis');
    }

    public static function generateJson_Click()
    {
        $objInput = [];
        $instance_code = SELF::Instance_Code;
        $project_code = SELF::Project_Code;

        $objInput = [
            "instance_code" => $instance_code,
            "project_code" => $project_code,
        ];



        return $response = SELF::decryptdata(SELF::ApiConnect($objInput));

        foreach ($response as $lst) {
            echo $lst["dd"] . "</br>" . $lst["gid"] . "</br>";
        }
    }

    public static function ApiConnectWithDaterange($api)
    {
        $data = json_encode($api);
        $rawdatastring = json_encode(["projpara" => $api, "rawdata" => $data]);

        $iv = SELF::iv();

        $secretiv_base = base64_decode($iv); //IV

        $api_key = SELF::API_KEY;

        $clientmis_key_base = base64_decode($api_key); //APIKEY

        $encryptionMethod = "AES-256-CBC";

        $data = openssl_encrypt(
            $rawdatastring,
            $encryptionMethod,
            $clientmis_key_base,
            "0",
            $secretiv_base
        );

        $hashdata = $data . $api_key;

        $hash = hash("sha512", $hashdata);

        $response = json_encode(
            [
                "data" => $data,
                "hash" => $hash,
                "iv" => $iv,
                "project_code" => $api["project_code"],
                "instance_code" => $api["instance_code"],
            ],
            JSON_UNESCAPED_SLASHES
        );

        return $response;
    }

    public static function ApiConnect($objInput)
    {

        $data = json_encode($objInput);
        $rawdata = json_encode(["projpara" => $objInput, "rawdata" => $data]);

        $token = SELF::GetAuthHeaderValue($rawdata);


        /* $objInput=array();
       $instance_code= SELF::Instance_Code;
	   $project_code=SELF::Project_Code;
	   
	   $objInput=array('instance_code' => $instance_code, 'project_code' => $project_code);
	    */

        $payload = SELF::ApiConnectWithDaterange($objInput);




        $url = "https://stateapi.darpan.nic.in/getdate";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $headers = [
            "Content-Type: application/json",
            "Authorization:" . $token,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $response = curl_exec($ch);
        if (!$response) {
            echo curl_error($ch);
        }
        curl_close($ch);


        return json_encode(json_decode($response), true);
    }

    public static function GetAuthHeaderValue($rawdata)
    {
        //$rawdata='{"projpara":{"instance_code":2,"project_code":2101998},"rawdata":"{\"instance_code\":2,\"project_code\":2101998}"}';

        $requestContentBase64String = hash("sha512", $rawdata);

        $instance_code = SELF::Instance_Code;

        $project_code = SELF::Project_Code;

        $PushDataAPIUrl = "https://stateapi.darpan.nic.in/getdate";

        $requestUri = urlencode($PushDataAPIUrl);

        $requestUri2 = strtolower($requestUri);

        $requestHttpMethod = "POST";

        $requestTimeStamp = time();

        $nonce = base64_encode(time());

        $clientmis_key_base = base64_decode(SELF::HMAC_KEY); //HMACAPIKEY

        $RawSign =
            $instance_code .
            $project_code .
            $requestHttpMethod .
            $requestUri2 .
            $requestTimeStamp .
            $nonce .
            $requestContentBase64String;

        $hmac = hash_hmac("sha512", $RawSign, $clientmis_key_base, true);

        $hmac_base = base64_encode($hmac);

        $token =
            "DarpanToken " .
            $instance_code .
            ":" .
            $project_code .
            ":" .
            $hmac_base .
            ":" .
            $nonce .
            ":" .
            $requestTimeStamp;

        return $token;
    }
    public static function decryptdata($data)
    {
        
        $decryptdata = json_decode($data);
        $decryptdata = json_decode(json_encode($decryptdata), true);
        

        $output = $decryptdata['data'];

        $iv = $decryptdata['iv'];

        $secretiv_base = base64_decode($iv); //IV

        $api_key = SELF::API_KEY;

        $clientmis_key_base = base64_decode($api_key); //APIKEY
        $encryptionMethod = "AES-256-CBC";

        // $clientmis_key_base = base64_decode(SELF::clientmis_key);

        $decryptedMessage = openssl_decrypt(
            $output,
            $encryptionMethod,
            $clientmis_key_base,
            "0",
            $secretiv_base
        );

        $decrypt_json = json_decode($decryptedMessage, true);

        return $decrypt_json;
    }


    

    // // code start for pushdata functionality

    // public static function pushdata() //gerenrate decrypt output of push data
    // {
    //     $host = "host = 127.0.0.1"; //db connection wehere tabe is stored
    //     $port = "port = 5433";
    //     $dbname = "dbname = master";
    //     $credentials = "user = postgres password=postgres";

    //     $db = pg_connect("$host $port $dbname $credentials");

    //     $sql =
    //         "select distinct instance_code,project_code,frequency_id,group_id,datadate,seq_no from darpan3";

    //     $ret = pg_query($db, $sql);

    //     $Contentmaster = [];
    //     $data = [];

    //     while ($row = pg_fetch_assoc($ret)) {
    //         $objInput = [
    //             "instance_code" => (int) $row["instance_code"],
    //             "project_code" => (int) $row["project_code"],
    //         ];
    //         $sql2 = "select kvalue,lvalue from darpan3 where group_id=1";
    //         $ret2 = pg_query($db, $sql2);

    //         while ($row2 = pg_fetch_assoc($ret2)) {
    //             $data2[] = $row2;
    //         }

    //         $old_date = Date_create($row["datadate"]);
    //         $date = Date_format($old_date, "m/d/Y");

    //         array_push($Contentmaster, [
    //             "instance_code" => (int) $row["instance_code"],
    //             "project_code" => (int) $row["project_code"],
    //             "frequency_id" => (int) $row["frequency_id"],
    //             "group_id" => (int) $row["group_id"],
    //             "datadate" => stripslashes($date),
    //             "seq_no" => (int) $row["seq_no"],
    //             "listkpidata" => $data2,
    //             "totalrecordcount" => 2,
    //             "optional1" => null,
    //             "optional2" => null,
    //         ]);
    //     }

    //     $compressstring = json_encode($Contentmaster, JSON_UNESCAPED_SLASHES); //string generated which will used for compresser



    //     $tokenstring = json_encode(
    //         [
    //             "projpara" => $objInput,
    //             "rawdata" => json_encode(
    //                 $Contentmaster,
    //                 JSON_UNESCAPED_SLASHES
    //             ),
    //         ],
    //         JSON_UNESCAPED_SLASHES
    //     ); //string generated which will used for token genertion

    //     $objInput = [];
    //     $instance_code = SELF::Instance_Code;
    //     $project_code = SELF::Project_Code;

    //     $objInput = [
    //         "instance_code" => $instance_code,
    //         "project_code" => $project_code,
    //     ];

    //     $compressdata = SELF::compresser($compressstring); //calling compresser function 

    //     /* echo  $compressdata;
    //      die(); */

    //     $payloadvalue = SELF::PushDataPayload($objInput, $compressdata); //calling payload function 

    //     $token = SELF::PushDataToken($tokenstring); //calling token generation function
    //     //echo $token;

    //     $output = SELF::PushDataApiConnect($payloadvalue, $token); //calling api function

    //     $decryptoutput = SELF::decryptdata($output); //calling decrypt function

    //     print_r($decryptoutput);
    // }

        // // code start for pushdata functionality

    public static function pushdata($g) //gerenrate decrypt output of push data
    {
        
        
        

        $Contentmaster = [];
        $data = [];

          
            $objInput = [
                "instance_code" => SELF::Instance_Code,
                "project_code" => SELF::Project_Code,
            ];
            $sql2 = BcGovermentReportBlock::find()->where(['is_pushed'=>0,'date'=>$g['date']])->orderBy('id')->asArray()->all();
            

            foreach ($sql2 as $sql) {
                $data2[] = [
                    'kvalue' =>$sql['trained_and_certified'].','.$sql['operational'],
                    'lvalue' =>$sql['state_code'].','.$sql['lgd_division_code'].','.$sql['district_code'].','.$sql['block_code']
                ];
            }
           
            
            $old_date = Date_create($g['date']);
            $date = Date_format($old_date, "m/d/Y");

            array_push($Contentmaster, [
                "instance_code" => SELF::Instance_Code,
                "project_code" => SELF::Project_Code,
                "frequency_id" => 4, // taken from api docs 1-Monthly, 2-Fortnightly, 3-Weekly, 4-Daily, 5-Yearly, 6-Half Yearly, 7-Quarterly
                "group_id" => 1,
                "datadate" => stripslashes($date), 
                "seq_no" => 0, //Value should always be 0 (API Doc)
                "listkpidata" => $data2,
                "totalrecordcount" => count($sql2),
                "optional1" => null,
                "optional2" => null,
            ]);

           


        
       

        $compressstring = json_encode($Contentmaster, JSON_UNESCAPED_SLASHES); //string generated which will used for compresser
        // $myfile = fopen("/home/ak/project/yii2_hr/newfile.json", "w") or die("Unable to open file!");
        // $txt = "John Doe\n";
        // fwrite($myfile, $compressstring);
        // fclose($myfile);
        // die();
        // exit;

        

        $tokenstring = json_encode(
            [
                "projpara" => $objInput,
                "rawdata" => json_encode(
                    $Contentmaster,
                    JSON_UNESCAPED_SLASHES
                ),
            ],
            JSON_UNESCAPED_SLASHES
        ); //string generated which will used for token genertion

        $objInput = [];
        $instance_code = SELF::Instance_Code;
        $project_code = SELF::Project_Code;

        $objInput = [
            "instance_code" => $instance_code,
            "project_code" => $project_code,
        ];

        

          $compressdata = SELF::compresser($compressstring); //calling compresser function 

        /* echo  $compressdata;
         die(); */

          $payloadvalue = SELF::PushDataPayload($objInput, $compressdata); //calling payload function 



            $token = SELF::PushDataToken($tokenstring); //calling token generation function

       




        //echo $token;

          $output = SELF::PushDataApiConnect($payloadvalue, $token); //calling api function
         

     return   $decryptoutput = SELF::decryptdata($output); //calling decrypt function

        print_r($decryptoutput);
    }









    public static function compresser($string) //compresser function
    {
        $str = $string;
        $buffer = unpack("C*", $str);
        $compressedData = gzencode($str);
        $compressedData_array = unpack("C*", $compressedData);
        $buffer = unpack("C*", pack("L", sizeof($buffer)));
        $gZipBuffer = array_merge($buffer, $compressedData_array);
        $str = call_user_func_array("pack", array_merge(["C*"], $gZipBuffer));
        return base64_encode($str);
    }

    public static function PushDataPayload($api, $compressdata) //function to generate payload for pushdata
    {
        $rawdatastring = json_encode([
            "projpara" => $api,
            "compresseddata" => $compressdata,
        ]);

        $iv = SELF::iv();

        $secretiv_base = base64_decode($iv); //IV

        $api_key = SELF::API_KEY;

        $clientmis_key_base = base64_decode($api_key); //APIKEY

        $encryptionMethod = "AES-256-CBC"; // AES is used by the U.S. gov't to encrypt top secret documents.

        $data = openssl_encrypt(
            $rawdatastring,
            $encryptionMethod,
            $clientmis_key_base,
            "0",
            $secretiv_base
        );

        $hashdata = $data . $api_key;

        $hash = hash("sha512", $hashdata);

        $response = json_encode(
            [
                "data" => $data,
                "hash" => $hash,
                "iv" => $iv,
                "project_code" => $api["project_code"],
                "instance_code" => $api["instance_code"],
            ],
            JSON_UNESCAPED_SLASHES
        );

        return $response;
    }
    public static function PushDataToken($rawdata) //function to generate token for pushdata
    {

        $requestContentBase64String = hash("sha512", $rawdata);

        $instance_code = SELF::Instance_Code;

        $project_code = SELF::Project_Code;

        $PushDataAPIUrl = "https://stateapi.darpan.nic.in/pushdata";

        $requestUri = urlencode($PushDataAPIUrl);

        $requestUri2 = strtolower($requestUri);

        $requestHttpMethod = "POST";

       

          $requestTimeStamp = time();
        // echo  $requestTimeStamp = '1697713438';
        
           $nonce = base64_encode(time());
        // echo   $nonce = 'MTY5NzcxMzQzOA==';

        $clientmis_key_base = base64_decode(SELF::HMAC_KEY); //HMACAPIKEY
       
          $RawSign =
            $instance_code .
            $project_code .
            $requestHttpMethod .
            $requestUri2 .
            $requestTimeStamp .
            $nonce .
            $requestContentBase64String;

           
        $hmac = hash_hmac("sha512", $RawSign, $clientmis_key_base, true);

        $hmac_base = base64_encode($hmac);

       

         $token =
            "DarpanToken " .
            $instance_code .
            ":" .
            $project_code .
            ":" .
            $hmac_base .
            ":" .
            $nonce .
            ":" .
            $requestTimeStamp;

        return $token;
    }

    public static function PushDataApiConnect($payload, $token) //function for push data api calling
    {


        $url = "https://stateapi.darpan.nic.in/pushdata";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $headers = [
            "Content-Type: application/json",
            "Authorization:" . $token,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $response = curl_exec($ch);
        if (!$response) {
            echo curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }
}
