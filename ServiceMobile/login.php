<?php
require 'vendor/autoload.php';

$app = new Slim\App();

$app->POST('/login', function($request , $response , $args)  {

	include 'conn.php';

	 $json = $request->getBody(); //POST
    $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //
    $username = isset($jsonArr['username'])?$jsonArr['username']:"";
    $password = isset($jsonArr['password'])?mysqli_real_escape_string($conn,md5($jsonArr['password'])):"";

                $sql = "SELECT * FROM tbl_users WHERE (username='$username' or email='$username') and password='$password' ";
                $result = $conn->query($sql);

    // if(!empty($result))
    //     {
    //         $user_id=$result->id;
    //         // var_dump("user_id",$user_id);
    //         $userData->token = apiToken($user_id);
    //     }

               $arr = array();
                
        if ($result->num_rows > 0) 
            {
                $arr['result'] = 'success';
                $arr['data'] = $result->fetch_assoc();
                
            }
                else 
                {
                    $arr['result'] = 'false';
                }
                echo json_encode($arr , JSON_UNESCAPED_UNICODE);
                // var_dump("arr",$arr);
                
                $conn->close();
    });


$app->run();
?>