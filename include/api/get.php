<?php

    require 'link.php';
                    
    // Check connection
    if($link === false){
        die("Get data could not be retrieved. The server returned the following error message: " . mysqli_connect_error());
    }
    
    //assign get variable to php variable
    $ident = filter_var($_GET['ident'], FILTER_SANITIZE_STRING);
    
    //prepare select
    $stmt = $link->prepare("SELECT myString, myEmail, myDate, myBool FROM tbl_tableName WHERE ident = ?");
    if ( false===$stmt ) {
        die("Get data could not be retrieved. The server returned the following error message: prepare() failed: " . mysqli_error($link));
    }

    //bind parameter
    $rc = $stmt->bind_param("s",$ident);
    if ( false===$rc ) {
        die("Get data could not be retrieved. The server returned the following error message: bind_param() failed: " . mysqli_error($link));
    }

    //execute select
    $rc = $stmt->execute();
    if ( false===$rc ) {
        die("Get data could not be retrieved. The server returned the following error message: execute() failed: " . mysqli_error($link));
    }

    //get result object
    $result = $stmt->get_result();
    if ( false===$result ) {
        die("Get data could not be retrieved. The server returned the following error message: get_result() failed: " . mysqli_error($link));
    }

    //check result object not empty
    $row_cnt = $result->num_rows;
    if($row_cnt > 0){
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        //return json object of data if result not empty
        print json_encode($rows);
    } else {
        //if result empty return error
        echo "No data matching ID: ".$ident;
    }

    //close result and statement objects, close connection
    $result->close();
    $stmt->close();
    mysqli_close($link);


?>