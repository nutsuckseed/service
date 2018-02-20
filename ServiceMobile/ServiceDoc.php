<?php
require 'vendor/autoload.php';

$app = new Slim\App();

$app->post('/getdocs' , function($request , $response , $args){ //เงือ่ไข

    include 'conn.php';

    $json = $request->getBody(); //POST
    $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
     $dow_id = $jsonArr['dty_id'];
    
	 	if($dow_id == "")
		 	{
		        $sql = "SELECT cms_download_type.dty_id,cms_download_type.dty_name, cms_download.dow_name, cms_download.dow_detail FROM cms_download_type 
    INNER JOIN cms_download ON cms_download_type.dty_id = cms_download.dty_id WHERE cms_download_type.active = '1'";
		    }
		    	else 
		    		{ //WHERE Condition SQL Start!
				       $sql = "SELECT  cms_download_type.dty_id,cms_download_type.dty_name, cms_download.dow_name, cms_download.dow_detail FROM cms_download_type 
    INNER JOIN cms_download ON cms_download_type.dty_id = cms_download.dty_id WHERE cms_download_type.active = '1' AND cms_download_type.dty_id = '$dow_id'";
		    		}
		    		
    $result = $conn->query($sql);
    $arr = array();
	    if ($result->num_rows > 0)
	    	{
			    // output data of each row
			    while($row = $result->fetch_assoc())
			    	{
        				$cms_download_type = $row['dty_id'];
        				$dty_name = $row['dty_name'];
        				// $dow_name = $row['dow_name'];
        				$dow_detail = $row['dow_detail'];
				        
        				
					        $data = (object)array('dty_id' => $cms_download_type,
					        	'dty_name' => $dty_name,
					        	// 'dow_name' => $dow_name,
					        	'dow_detail' => $dow_detail

					                            
					                            );
					        $arr[] = $data;
			    	}
			     echo json_encode($arr , JSON_UNESCAPED_UNICODE);
	     	}
	     		else
	     			{
	    				echo "0 results";
	    			}
    $conn->close();
});

$app->run();
?>
