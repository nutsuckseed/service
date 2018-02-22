<?php
require 'vendor/autoload.php';

$app = new Slim\App();

$app->get('/getvdo' , function($request , $response , $args){ //เงือ่ไข

    include 'conn.php';

    $json = $request->getBody(); //POST
    $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
     $vdo_id = isset($jsonArr['vdo_id'])?$jsonArr['vdo_id']:"";
    
	 	if($vdo_id == "")
		 	{
		        $sql = "SELECT * FROM tbl_vdo WHERE active = 'y'";
		    }
		    	else 
		    		{ //WHERE Condition SQL Start!
				        $sql = "SELECT * FROM tbl_vdo WHERE vdo_id = '$vdo_id' AND active = 'y'";
		    		}
    $result = $conn->query($sql);
    $arr = array();
	    if ($result->num_rows > 0)
	    	{
				$arr["results"] = "successfully";

			    // output data of each row
			    while($row = $result->fetch_assoc())
			    	{
				        $vdo_id = $row['vdo_id'];
        				$vdo_title = $row['vdo_title'];
        				$vdo_path = $row['vdo_path'];
        				$create_date = $row['create_date'];
        				$create_by = $row['create_by'];
        				$update_date = $row['update_date'];
        				$update_by = $row['update_by'];
        				$active = $row['active'];


					        $data = (object)array('vdo_id' => $vdo_id,
					                              'vdo_title' => $vdo_title,
					                              'vdo_path' => $vdo_path,
					                               'create_date' => $create_date,
					                               'create_by' => $create_by,
					                               'update_date' => $update_date,
					                               'update_by' => $update_by,
					                               'active' => $active
					                            );
					        $arr["data"][] = $data;
			    	}
	     	}
	     		else
	     			{
	    				$arr["results"] = "error";
	    				$arr["data"] = "failed";
	    			}

		echo json_encode($arr , JSON_UNESCAPED_UNICODE);

    $conn->close();
});

////Delate   
$app->post('/delete', function($request , $response , $args)  
	{
	    include 'conn.php';
	        $json = $request->getBody(); //POST
	        $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
			$vdo_id = $jsonArr['vdo_id'];
		if ($vdo_id == "") 
		{
			$arr["results"] = "failed: " . $conn->error;
	    	$arr["data"] = "failed";
		}
		else
		{
			$sql = " UPDATE tbl_vdo  SET active = 'n' WHERE vdo_id = '$vdo_id' " ;
			        if ($conn->query($sql) === TRUE)
			        	{
			        		$arr["results"] = "success";
			        	} 
			        		else 
			        			{
			        				$arr["results"] = "Error updating record: " . $conn->error;
								}
		}
		        echo json_encode($arr , JSON_UNESCAPED_UNICODE);
		    $conn->close();
	});

$app->post('/insert' , function($request , $response , $args)
	{
	        include 'conn.php';
		        $json = $request->getBody(); //POST
		        $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
		        $vdo_title = isset($jsonArr['vdo_title'])?$jsonArr['vdo_title']:"";
		        $vdo_path = isset($jsonArr['vdo_path'])?$jsonArr['vdo_path']:"";
		        $create_by = isset($jsonArr['create_by'])?$jsonArr['create_by']:"";

		        if (!empty($vdo_title)) 
		        {
		        	$create_date = date("Y-m-d H:i:s");
		        	$update_date = date("Y-m-d H:i:s");

			        $sql = "INSERT INTO tbl_vdo (vdo_title,
			                                    	vdo_path,
			                                    	create_by,
			                                     	create_date,
			                                     	update_date )
			                VALUES ('$vdo_title',
			                                    	'$vdo_path',
			                                    	'$create_by',
			                                    	'$create_date',
			                                    	'$update_date')";
			        if (mysqli_query($conn, $sql)) 
			        	{
			            	$arr["success"] = "New record created successfully";
			        	}
		        }
		        	else 
			        	{
						    $arr["success"] = "Error";
						}
			echo json_encode($arr , JSON_UNESCAPED_UNICODE);
	    $conn->close();
	});


$app->post('/update', function($request , $response , $args)  
	{
	    include 'conn.php';
			        $json = $request->getBody(); //POST
			        $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
			        $vdo_id = isset($jsonArr['vdo_id'])?$jsonArr['vdo_id']:"";
			        // $vdo_path = $jsonArr['vdo_path'];
			        $vdo_title = isset($jsonArr['vdo_title'])?$jsonArr['vdo_title']:"";
					$vdo_path = isset($jsonArr['vdo_path'])?$jsonArr['vdo_path']:"";
					$update_by = isset($jsonArr['update_by'])?$jsonArr['update_by']:"";
					$update_date = date("Y-m-d H:i:s");
			        
		if ($vdo_id == "") 
		{
			$arr["result"]= "Error updating record: " . $conn->error;
		}
			else
				{

					$sql = " UPDATE tbl_vdo SET
									vdo_path = '$vdo_path',
						        	vdo_title = '$vdo_title',
									update_date = '$update_date', 
									update_by = '$update_by'
							WHERE
									vdo_id = '$vdo_id' " ;
						        if ($conn->query($sql) === TRUE) 
						        	{
									    $arr["result"] = "Record updated successfully";
									} 
									else 
									    {
											$arr["result"] = "Error updating record: " . $conn->error;
										}
				}
		        echo json_encode($arr , JSON_UNESCAPED_UNICODE);
		    $conn->close();
	});

$app->run();
?>