<?php
require 'vendor/autoload.php';

	 if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        }
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        } 
        exit(0);
    }
 


$app = new Slim\App();




 $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request = json_decode($postdata);
        $contac_by_name = $request->contac_by_name;
        $contac_by_surname = $request->contac_by_surname;
        $contac_by_tel = $request->contac_by_tel;
        $contac_by_email = $request->contac_by_email;
        $contac_subject = $requests->contac_subject;
        $contac_type = $request->contac_type;
        $contac_detail = $request->contac_detail;
        // $contac_ans_subject = $request->contac_ans_subject;
        // $create_by = $request->create_by;
        // ,create_by,contac_ans_subject
        // ,'$create_by','$contac_ans_subject'
         $create_date = date("Y-m-d H:i:s");

            include 'conn.php';

        if ($contac_by_name != "") {
           $sql = "INSERT INTO tbl_contactus (contac_by_name, contac_by_surname, contac_by_tel, contac_by_email,contac_subject,contac_type, contac_detail, create_date)
             
            VALUES ('$contac_by_name', '$contac_by_surname' , '$contac_by_tel','$contac_by_email','$contac_subject','$contac_type','$contac_detail', '$create_date')";

           if (mysqli_query($conn, $sql)) 
           {
              $arr['result'] = 'success';
              $arr['data'] = "Successfully";
              echo json_encode($arr , JSON_UNESCAPED_UNICODE);
            } 
              else 
                {
                      $arr['result'] = 'false';
                      $arr['data'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
                      echo json_encode($arr , JSON_UNESCAPED_UNICODE);
                }

         $conn->close();
            

            echo "Server returns: " . $contac_by_name,'+',$contac_by_surname;
        }
        else {
            echo "Empty username parameter!";
        }
    }
    else {
        echo "Not called properly with username parameter!";
    }


// $app->run();
?>