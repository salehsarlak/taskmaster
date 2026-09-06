<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-in your account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="reset.css">
</head>
<body>
    


   

<!--      Validation        -->
<?php
require "db.php";

    

session_start();



function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;

}


$usernameErr = "";
$passwordErr = "";

$username = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
   

    if (empty($_POST["username"])){
        $usernameErr = "* Pls enter your name";
    }else{
        $username = test_input($_POST["username"]);

        if(strlen($username) < 5){
        $usernameErr = " * Enter at least 5 characters";
    }

        } 

    if(empty($_POST["password"])){
        $passwordErr = "* Pls enter your password";
    }else{
        $password = test_input($_POST["password"]);
    }


        if ($usernameErr == "" && $passwordErr == "" ){

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s" , $username);

        $stmt -> execute();

        $result = $stmt->get_result();


            if ($result->num_rows == 1 ){
                $users = $result->fetch_assoc();

                if ($password == $users["password"]){
                    $_SESSION["user_id"] = $users["id"];
    $_SESSION["username"] = $users["username"];

                header("location: dashboard.php");
                exit;
                }else{
                    echo "Wrong password";
                }

            }else{
                echo "user not founded";
            }
        }

}
?>

<!--        Header         -->
     <header>

    <div class="main-header">

        <a href="dashboard.php"><img href="sdfsdf.com" src="./assets/logo.png" alt="" class="logo"></a>
        
