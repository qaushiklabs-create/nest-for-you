<?php
    $name = $_post['name'];
    $email = $_post['email'];
    $subject = $_post['subject'];
    $message = $_post['message'];

    $conn = new sqli('localhost','root','','nestforyou_contacts');
    if ($conn->connection_error){
        die('connection failed :' .$conn->connect_error);
    
    }else{
        $stmt = $conn->prepare("insert into contact(name,email,subject,message)value(?,?,?,?)");
        $stmt->bind_param("sssi",$name,$email,$subject,$message);
        $stmt->execute();
    }


?>