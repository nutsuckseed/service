<?php
require 'vendor/autoload.php';

$app = new Slim\App();


//number2
$app->post('/getusability', function($request , $response , $args)  {

	include 'conn.php';

	$json = $request->getBody(); //POST
	$jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST


	$sql = "SELECT * FROM tbl_usability";
	$result = $conn->query($sql);

	$arr = array();
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

    	$usa_id = $row["usa_id"];
    	$usa_title = $row["usa_title"];
        $usa_detail = $row["usa_detail"];
        $create_data = $row["create_data"];
        $create_by = $row["create_by"];
        $update_date = $row["update_date"];
        $update_by = $row["update_by"];
        $active = $row["active"];

    $data = (object)array('usa_id' => $usa_id,
    						  
        				'reportProblem' => array('usa_title' => $usa_title,
        										'usa_detail' => $usa_detail,
												'create_data' => $create_data,
												'create_by' => $create_by,
												'update_date' => $update_date,
												'update_by' => $update_by,
												'active' => $active, 
							),
        						
        						
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
?>