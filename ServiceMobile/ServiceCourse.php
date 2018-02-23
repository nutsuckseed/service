<?php
require 'vendor/autoload.php';

$app = new Slim\App();

$app->get('/getvdo' , function($request , $response , $args){ //เงือ่ไข

    include 'conn.php';

    $json = $request->getBody(); //POST
    $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
     $cate_id = isset($jsonArr['cate_id'])?$jsonArr['cate_id']:"";
    
	 	if($cate_id == "")
		 	{
		        $sql = "SELECT * FROM tbl_category WHERE active = 'y'";
		    }
		    	else 
		    		{ //WHERE Condition SQL Start!
				        $sql = "SELECT * FROM tbl_category WHERE cate_id = '$cate_id' AND active = 'y'";
		    		}
    $result = $conn->query($sql);
    $arr = array();
	    if ($result->num_rows > 0)
	    	{
				$arr["results"] = "successfully";
				while($row = $result->fetch_assoc())
				{
					  $cate_id = $row['cate_id'];
        				$cate_type = $row['cate_type'];
        				$cate_title = $row['cate_title'];
        				$cate_short_detail = $row['cate_short_detail'];
        				$cate_detail = $row['cate_detail'];
        				$cate_image = $row['cate_image'];
        				$cate_show = $row['cate_show'];
        				$create_date = $row['create_date'];
        				$update_date = $row['update_date'];
        				$update_by = $row['update_by'];
        				$active = $row['active'];
        				$special_category = $row['special_category'];


					$data = (object)array('cate_id' => $cate_id,
					                              'cate_type' => $cate_type,
					                              'cate_title' => $cate_title,
					                               'cate_short_detail' => $cate_short_detail,
					                               'cate_detail' => $cate_detail,
					                               'create_date' => $create_date,
					                               'cate_image' => $cate_image,
					                               'active' => $active
					                            );
					$arr["data"][] = $data;
				}
					// mysqli_close($conn);
				// return json_encode($arr);
	 
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
			$cate_id = $jsonArr['cate_id'];
		if ($cate_id == "") 
		{
			$arr["results"] = "failed: " . $conn->error;
	    	$arr["data"] = "failed";
		}
		else
		{
			$sql = " UPDATE tbl_vdo  SET active = 'n' WHERE cate_id = '$cate_id' " ;
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
		        $cate_type = isset($jsonArr['cate_type'])?$jsonArr['cate_type']:"";
		        $cate_title = isset($jsonArr['cate_title'])?$jsonArr['cate_title']:"";
		        $cate_detail = isset($jsonArr['cate_detail'])?$jsonArr['cate_detail']:"";

		        if (!empty($cate_type)) 
		        {
		        	$cate_short_detail = date("Y-m-d H:i:s");
		        	$update_date = date("Y-m-d H:i:s");

			        $sql = "INSERT INTO tbl_vdo (cate_type,
			                                    	cate_title,
			                                    	cate_detail,
			                                     	cate_short_detail,
			                                     	update_date )
			                VALUES ('$cate_type',
			                                    	'$cate_title',
			                                    	'$cate_detail',
			                                    	'$cate_short_detail',
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
			        $cate_id = isset($jsonArr['cate_id'])?$jsonArr['cate_id']:"";
			        // $cate_title = $jsonArr['cate_title'];
			        $cate_type = isset($jsonArr['cate_type'])?$jsonArr['cate_type']:"";
					$cate_title = isset($jsonArr['cate_title'])?$jsonArr['cate_title']:"";
					$cate_show = isset($jsonArr['cate_show'])?$jsonArr['cate_show']:"";
					$update_date = date("Y-m-d H:i:s");
			        
		if ($cate_id == "") 
		{
			$arr["result"]= "Error updating record: " . $conn->error;
		}
			else
				{

					$sql = " UPDATE tbl_vdo SET
									cate_title = '$cate_title',
						        	cate_type = '$cate_type',
									update_date = '$update_date', 
									cate_show = '$cate_show'
							WHERE
									cate_id = '$cate_id' " ;
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