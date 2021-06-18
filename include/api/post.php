<?php

    require 'link.php';
                    
    // Check connection
    if($link === false){
        die("Post data could not be stored. The server returned the following error message: " . mysqli_connect_error());
    }
    
    // Generate unique short ID
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    do {
        $pass = 0;
        $uuid = substr(str_shuffle($permitted_chars), 0, 6);    
        if ($result = $link->query("SELECT * FROM tbl_tableName WHERE ident = '$uuid'")) {
            $row_cnt = $result->num_rows;
            if($row_cnt > 0){
                $uuid = substr(str_shuffle($permitted_chars), 0, 6);
            } else {
                $pass ++;
            }
            /* close result set */
            $result->close();
        } else {
            echo "A new unique ID could not be created. The server returned the following error message: " . mysqli_error($link);
        }
    } while ($pass < 1);

    $errMsg = "";

    //returns true if $date matches $format
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    //get sanitized POST variables and validate
    $myString = filter_var($_POST['myString'], FILTER_SANITIZE_STRING);
    if (strlen($myString) == 0) {
        $errMsg = "myString name is blank; ";
    }
    $myEmail = filter_var($_POST['myEmail'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($myEmail, FILTER_VALIDATE_EMAIL)) {
        $errMsg = $errMsg . "myEmail is not valid; ";
    }
    $myDate = filter_var($_POST['myDate'], FILTER_SANITIZE_STRING);
    if (!validateDate($myDate, 'Y-m-d')) {
        $errMsg = $errMsg . "myDate is not valid; ";
    }
    $myBool = filter_var($_POST['myBool'], FILTER_VALIDATE_BOOLEAN);

    //return errMsg if validation failed
    if (strlen($errMsg) > 0) {
        die("Post data could not be stored. The server returned the following error message: " . $errMsg);
    }

    //prepare insert
    $stmt = $link->prepare("INSERT INTO tbl_tableName (ident, myString, myEmail, myDate, myBool) VALUES (?, ?, ?, ?, ?)");
    if ( false===$stmt ) {
        die("Post data could not be stored. The server returned the following error message: prepare() failed: " . mysqli_error($link));
    }

    //bind parameters
    $rc = $stmt->bind_param("sssss",$ident, $myString, $myEmail, $myDate, $myBool);
    if ( false===$rc ) {
        die("Post data could not be stored. The server returned the following error message: bind_param() failed: " . mysqli_error($link));
    }

    //execute insert
    $rc = $stmt->execute();
    if ( false===$rc ) {
        die("Post data could not be stored. The server returned the following error message: execute() failed: " . mysqli_error($link));
    }

    //close connection
    $stmt->close();
    mysqli_close($link);
?>