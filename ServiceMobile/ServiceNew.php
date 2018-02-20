<?php
require 'vendor/autoload.php';

$app = new Slim\App();

$app->post('/getReport', function($request , $response , $args)  {

    include 'conn.php';

    $sql = "SELECT * FROM tbl_news";
    $result = $conn->query($sql);

    $arr = array();

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

            $cms_id = $row["cms_id"];
            $cms_title = $row["cms_title"];
            $cms_short_title = $row["cms_short_title"];
            $cms_detail = $row["cms_detail"];
            $cms_picture = $row["cms_picture"];
            $create_date = $row["create_date"];
            $create_by = $row["create_by"];
            $update_date = $row["update_date"];
            $update_by = $row["update_by"];
            $active = $row["active"];
           

        $data = (object)array('cms_id' => $cms_id,
                              'cms_title' => $cms_title,
                                'cms_short_title'=> $cms_short_title,
                                'cms_detail' => $cms_detail,
                                'cms_picture' => $cms_picture,
                                'create_date' => $create_date,
                                'create_by' => $create_by,
                                'update_date' => $update_date,
                                'update_by' => $update_by,
                                'active' => $active
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




$app->post('/getReport' , function($request , $response , $args){

    include 'conn.php';

    $json = $request->getBody(); //POST
    $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
    $cms_id = $jsonArr['cms_id'];
    $cms_title = $jsonArr['cms_title'];
    $cms_short_title = $jsonArr['cms_short_title'];
    $cms_detail = $jsonArr['cms_detail'];
    $cms_picture = $jsonArr['cms_picture'];
    $create_date = $jsonArr['create_date'];
    $create_by = $jsonArr['create_by'];
    $update_date = $jsonArr['update_date'];
    $update_by = $jsonArr['update_by'];
    $active = $jsonArr['active'];



 if($cms_id == ""){

        $sql = "SELECT * FROM tbl_news";

    } else { //WHERE Condition SQL Start!

        $sql = "SELECT * FROM tbl_news WHERE cms_id = '$cms_id'";

        if($cms_title != ""){

            $sql .= " AND cms_title = '$cms_title'"; //Add Condition report_type

                }
        if($cms_short_title != ""){ //Add Condition DateTime Since $report_dateData

            //$sql .= " AND ( report_date >= '$report_dateData')";
            $sql .= " AND cms_short_title = '$cms_short_title'";

           }
        if($cms_detail != ""){
            $sql .= " AND cms_detail= '$cms_detail'";
        }

        if($cms_picture != ""){

            $sql .= " AND (cms_picture = '$cms_picture')"; 
        }

        if($create_date != ""){

            $sql .= "AND ( create_date = '$create_date')";

        }

        if($create_by != ""){

            $sql .= "AND ( create_by = '$create_by')";

        }

        if($update_date != ""){

            $sql .= "AND ( update_date = '$update_date')";

        }

        if($update_by != ""){

            $sql .= "AND ( update_by = '$update_by')";
        }

        if($active != ""){

            $sql .= "AND ( active = '$active')";
        }
    }

     var_dump($sql);
    $result = $conn->query($sql);

    $arr = array();

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {


        $cms_id = $row['cms_id'];
        $cms_title = $row['cms_title'];
        $cms_short_title = $row['cms_short_title'];
        $cms_detail = $row['cms_detail'];
        $cms_picture = $row['cms_picture'];
        $create_date = $row['create_date'];
        $create_by = $row['create_by'];
        $update_date = $row['update_date'];
        $update_by = $row['update_by'];
        $active = $row['active'];



        $data = (object)array('cms_id' => $cms_id,
                              'cms_title' => $cms_title,
                                'cms_short_title'=> $cms_short_title,
                                'cms_detail' => $cms_detail,
                                'cms_picture' => $cms_picture,
                                'create_date' => $create_date,
                                'create_by' => $create_by,
                                'update_date' => $update_date,
                                'update_by' => $update_by,
                                'active' => $active
                                );

        $arr[] = $data;

    }

     echo json_encode($arr , JSON_UNESCAPED_UNICODE);

     } else {
    echo "0 results";
    }

    $conn->close();
});




$app->post('/DelectNews', function($request , $response , $args)  {

    include 'conn.php';

        $json = $request->getBody(); //POST
        $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
        $cms_id = $jsonArr['cms_id'];
 /*       $cms_title = $jsonArr['cms_title'];
        $cms_short_title = $jsonArr['cms_short_title'];
        $cms_detail = $jsonArr['cms_detail'];
        $cms_picture = $jsonArr['cms_picture'];
        $create_date = $jsonArr['create_date'];
        $create_by = $jsonArr['create_by'];
        $update_date = $jsonArr['update_date'];
        $update_by = $jsonArr['update_by'];
        $active = $jsonArr['active'];*/


        $sql = " UPDATE tbl_news  SET active = 'สวย' WHERE cms_id = '$cms_id' " ;

        if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        } else {
        echo "Error updating record: " . $conn->error;
}
    $conn->close();

});




$app->post('/InsertNews' , function($request , $response , $args){

        include 'conn.php';

        $json = $request->getBody(); //POST
        $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
      //  $cms_id = $jsonArr['cms_id'];
        $cms_title = $jsonArr['cms_title'];
        $cms_short_title = $jsonArr['cms_short_title'];
        $cms_detail = $jsonArr['cms_detail'];
       // $cms_picture = $jsonArr['cms_picture'];
        //  $create_date = $jsonArr['cms_date'];

        $create_date = date("Y-m-d H:i:s");


        //$create_by = $jsonArr['create_by'];
       // $update_date = $jsonArr['update_date'];
       // $update_by = $jsonArr['update_by'];
       // $active = $jsonArr['active'];


        $sql = "INSERT INTO tbl_news (cms_title, cms_short_title, cms_detail, create_date )
        VALUES ('$cms_title', '$cms_short_title' , '$cms_detail', '$create_date')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    $conn->close();
});


$app->post('/UpdatedNews', function($request , $response , $args)  {

    include 'conn.php';

        $json = $request->getBody(); //POST
        $jsonArr = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE); //POST
        $cms_id = $jsonArr['cms_id'];
        $cms_title = $jsonArr['cms_title'];
        $cms_short_title = $jsonArr['cms_short_title'];
        $cms_detail = $jsonArr['cms_detail'];
        $cms_picture = $jsonArr['cms_picture'];
    //  $create_date = $jsonArr['create_date'];
    //   $create_by = $jsonArr['create_by'];
     //   $update_date = $jsonArr['update_date'];

        $update_by = $jsonArr['update_by'];
      // $active = $jsonArr['active'];

        $update_date = date("Y-m-d H:i:s");

        $sql = " UPDATE tbl_news  SET cms_title = '$cms_title', cms_short_title = '$cms_short_title',
            cms_detail = '$cms_detail', 
            cms_picture = '$cms_picture', 
            update_date = '$update_date', 
            update_by = '$update_by'
             
            WHERE cms_id = '$cms_id' " ;

        if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        } else {
        echo "Error updating record: " . $conn->error;
}
    $conn->close();

});

$app->run();
?>