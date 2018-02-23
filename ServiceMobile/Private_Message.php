<?php
require 'vendor/autoload.php';

		header("Access-Control-Allow-Origin: *");
		header("Content-Type:application/json; charset=UTF-8");

$app = new Slim\App();


       $postdata = file_get_contents("php://input");
            include 'conn.php';

    if (isset($postdata)) {
        $request = json_decode($postdata);
        $pm_topic = $request->pm_topic;
        $pm_quest = $request->pm_quest;
        $create_by = $request->create_by;
        $pm_to = $request->pm_to;
        $pm_alert = $request->pm_alert;
        $question_status = $request->question_status;
        $all_file = $request->all_file;
        // $contac_ans_subject = $request->contac_ans_subject;
        // $create_by = $request->create_by;
        // ,create_by,contac_ans_subject
        // ,'$create_by','$contac_ans_subject'
         $create_date = date("Y-m-d H:i:s");

        if ($pm_topic != "") {
           $sql = "INSERT INTO tbl_contactus (pm_topic, pm_quest, create_by, pm_to,pm_alert,question_status, all_file, create_date)
             
            VALUES ('$pm_topic', '$pm_quest' , '$create_by','$pm_to','$pm_alert','$question_status','$all_file', '$create_date')";

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
            echo "Server returns: " . $pm_topic,'+',$pm_quest;
        }
        else {
            echo "Empty username parameter!";
        }
    }
    else {
        echo "Not called properly with username parameter!";
    }
         $conn->close();


//   $app->post('/DelectNews', function($request , $response , $args)  {

//         include 'conn.php';

//             $json = $request->getBody(); //POST
//             $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST     

// 		 if(isset($jsonArr['pm_id'])){
//          	   $pm_id = $jsonArr['pm_id'];
//          }else {
//          	$error[] = "false";
//          }

//           if(isset($error)){
//           	$arr['result'] = 'false';
//           	$arr['data'] = $error;

//           	echo json_encode($arr , JSON_UNESCAPED_UNICODE);
//           }else {
           
//             $sql = " UPDATE tbl_news  SET active = 'n' WHERE pm_id = '$pm_id' " ;

//             if ($conn->query($sql) === TRUE) {

// 				$arr['result'] = 'success';
//           		$arr['data'] = "Record delete successfully";
//           		echo json_encode($arr , JSON_UNESCAPED_UNICODE);

//             } else {
// 				$arr['result'] = 'false';
//           		$arr['data'] = "Error updating record: " . $conn->error;
//           		echo json_encode($arr , JSON_UNESCAPED_UNICODE);
//         }
//     }
//         $conn->close();

// });


   // $app->post('/UpdatedNews', function($request , $response , $args)  {

   //      include 'conn.php';

   //          $json = $request->getBody(); //POST
   //          $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
   //     /*     $pm_id = $jsonArr['pm_id'];*/
            

   //          if(isset($jsonArr['pm_id'])){
   //       	   $pm_id = $jsonArr['pm_id'];
   //       }else {
   //       	$error[] = " Can not Update ";
   //       }

   //        if(isset($error)){
   //        	$arr['result'] = 'false';
   //        	$arr['data'] = $error;

   //        	echo json_encode($arr , JSON_UNESCAPED_UNICODE);
   //        }else {
   //          $pm_topic = isset($jsonArr['pm_topic'])?$jsonArr['pm_topic']:"";
   //          $pm_quest = isset($jsonArr['pm_quest'])?$jsonArr['pm_quest']:"";
   //         	$pm_to = isset($jsonArr['pm_to'])?$jsonArr['pm_to']:"";
   //       	$question_status = isset($jsonArr['question_status'])?$jsonArr['question_status']:"";
   //          $update_by = isset($jsonArr['update_by'])?$jsonArr['update_by']:"";
            
   //          $update_date = date("Y-m-d H:i:s");

   //          $pm_alert = isset($jsonArr['pm_alert'])?$jsonArr['pm_alert']:"";
          
            
   //              $sql = " UPDATE tbl_news  SET pm_topic = '$pm_topic', pm_quest = '$pm_quest',
   //              pm_to = '$pm_to',
   //              pm_alert = '$pm_alert', 
   //              question_status = '$question_status', 
   //              update_date = '$update_date', 
   //              update_by = '$update_by'
                 
   //              WHERE pm_id = '$pm_id' " ;

   //          if ($conn->query($sql) === TRUE) {
   //          	$arr['result'] = 'success';
   //        		$arr['data'] = "Record updated successfully";
   //        		echo json_encode($arr , JSON_UNESCAPED_UNICODE);
   //          } else {
	  //          	$arr['result'] = 'false';
   //        		$arr['data'] = "Error updating record: " . $conn->error;
   //        		echo json_encode($arr , JSON_UNESCAPED_UNICODE);
   //  }
   //      $conn->close();
   //          }
   //  });




$app->get('/getPrivateMessage' , function($request , $response , $args){
    include 'conn.php';

    $json = $request->getBody(); //POST
    $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //

    if(isset($jsonArr['pm_id'])){
         	   $pm_id = $jsonArr['pm_id'];
         	   $sql = "SELECT * FROM private_message WHERE pm_id = '$pm_id' AND active = 'y'";
         }else if (isset($jsonArr['pm_id'])== "") {
         	  	$sql = "SELECT * FROM private_message WHERE active = 'y'";
         }else {
         	$error[] = "Unsuccessful";
         }

          if(isset($error)){
          	$arr['result'] = 'false';
          	$arr['data'] = $error;
          	echo json_encode($arr , JSON_UNESCAPED_UNICODE);
          }else {

	        $result = $conn->query($sql);

	        $arr = array();

	        if ($arr != "") {
	              if ($result->num_rows > 0) {
	        // output data of each row
	        while($row = $result->fetch_assoc()) {

	            $pm_id = $row['pm_id'];
	            $pm_topic = $row['pm_topic'];
	            $pm_quest = $row['pm_quest'];
	            $pm_to = $row['pm_to'];
	            $pm_alert = $row['pm_alert'];
	            $question_status = $row['question_status'];
              $all_file = $row['all_file'];
	            
              $create_date = $row['create_date'];
	            $create_by = $row['create_by'];
	            $update_date = $row['update_date'];
	            $update_by = $row['update_by'];
	            $active = $row['active'];

	            $data[] = (object)array('pm_id' => $pm_id,
	                                  'pm_topic' => $pm_topic,
	                                    'pm_quest'=> $pm_quest,
	                                    'pm_to' => $pm_to,
	                                    'pm_alert' => $pm_alert,
	                                    'question_status' => $question_status,
                                      'all_file' => $all_file,
	                                    'create_date' => $create_date,
	                                    'create_by' => $create_by,
	                                    'update_date' => $update_date,
	                                    'update_by' => $update_by,
	                                    'active' => $active
	                                    );

	          

	               }
		            $arr['result'] = 'success';
	          		$arr['data'] = $data;
	          		echo json_encode($arr , JSON_UNESCAPED_UNICODE);

    		     } else {
            		$arr['result'] = 'false';
          			$arr['data'] = "Unsuccessful";
          		echo json_encode($arr , JSON_UNESCAPED_UNICODE);

             	}
             	$conn->close();
             }
  
	     }
	   
       
    });


$app->run();
?>