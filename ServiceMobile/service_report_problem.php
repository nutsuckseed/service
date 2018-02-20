<?php

require 'vendor/autoload.php';

$app = new Slim\App();



//number4
$app->post('/getReportProbAll', function($request , $response , $args)  {

	include 'conn.php';

	$sql = "SELECT * FROM tbl_report_problem";
	$result = $conn->query($sql);

	$arr = array();

	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

         	$id = $row["id"];
        	$firstname = $row["firstname"];
        	$lastname = $row["lastname"];
        	$email = $row["email"];
        	$tel = $row["tel"];
        	$report_type = $row["report_title"];
        	$report_detail = $row["report_detail"];
        	$report_pic = $row["report_pic"];
        	$report_date = $row["report_date"];
        	$accept_report_date = $row["accept_report_date"];
        	$status = $row["status"];
        	$answer = $row["answer"];

        $data = (object)array('id' => $id,
    						  'firstname' => $firstname,
    						   	'lastname'=> $lastname,
    						   	'email' => $email,
    						   	'tel' => $tel,
    						   	'reportProblem' => array('report_type' => $report_type,
    						   							 'report_detail' => $report_detail,
    						   							 'report_pic' => $report_pic,
    						   						     'report_date' => $report_date,
    						   							 'accept_report_date' => $accept_report_date
    						   							),
    						   	'status' => $status,
    						   	'answer' => $answer,
    						   );

        $arr[] = $data;

    }

     echo json_encode($arr , JSON_UNESCAPED_UNICODE);
     //return $response->getBody()->write("Hello, " . $args['name'] . "(" . $args['nickname'] . ")"); //!!!Add params $response

	} else {
    echo "0 results";
	}

	$conn->close();
});

$app->post('/getReportProbStatus' , function($request , $response , $args){

	include 'conn.php';

	$json = $request->getBody(); //POST
	$jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
	$value = $jsonArr['status'];

	//$value = $args['status']; //GET

	$sql = "SELECT * FROM tbl_report_problem WHERE status = '$value'";
	$result = $conn->query($sql);
	//var_dump($sql);

	$arr = array();

	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

         	$id = $row["id"];
        	$firstname = $row["firstname"];
        	$lastname = $row["lastname"];
        	$email = $row["email"];
        	$tel = $row["tel"];
        	$report_type = $row["report_title"];
        	$report_detail = $row["report_detail"];
        	$report_pic = $row["report_pic"];
        	$report_date = $row["report_date"];
        	$accept_report_date = $row["accept_report_date"];
        	$status = $row["status"];
        	$answer = $row["answer"];

        $data = (object)array('id' => $id,
    						  'firstname' => $firstname,
    						   	'lastname'=> $lastname,
    						   	'email' => $email,
    						   	'tel' => $tel,
    						   	'reportProblem' => array('report_type' => $report_type,
    						   							 'report_detail' => $report_detail,
    						   							 'report_pic' => $report_pic,
    						   						     'report_date' => $report_date,
    						   							 'accept_report_date' => $accept_report_date
    						   							),
    						   	'status' => $status,
    						   	'answer' => $answer,
    						   );

        $arr[] = $data;

    }

     echo json_encode($arr , JSON_UNESCAPED_UNICODE);
     //return $response->getBody()->write("Hello, " . $args['name'] . "(" . $args['nickname'] . ")"); //!!!Add params $response

	} else {
    echo "0 results";
	}

	$conn->close();
});

$app->post('/' , function(){

});



$app->run();

?>