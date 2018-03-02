<?php
require 'vendor/autoload.php';

		header("Access-Control-Allow-Origin: *");
		header("Content-Type:application/json; charset=UTF-8");


$app = new Slim\App();


$app->get('/getUserPassWord' , function($request , $response , $args){

    include 'conn.php';

    $json = $request->getBody(); //POST
    $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //

         	  	$sql = "SELECT * FROM tbl_users WHERE superuser = '1'";
    	        $result = $conn->query($sql);

	           $arr = array();

	        if ($arr != "") {
	              if ($result->num_rows > 0) {
	        // output data of each row
	        while($row = $result->fetch_assoc()) {
				$id = $row['id'];
				$username = $row['username'];
				$password = $row['password'];
				

	            $data[] = (object)array('id' => $id,'username' => $username,'password' => $password	                                    );
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
    });


$app->run();
?>