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
        
        <div class="header-btn">

    
</a>
</header>


        <!--    Section       -->

    <div class="reg">


<!--  Form    -->

    <div class="form-div">

    <form  method="POST"  action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);  ?>">
               
    <div class="inp">
    <h2 class="text">Login to your account</h2>
     <label for="username"> Username  </label>
        <input type="text"  id="username"  name="username" value="<?php echo $username; ?>" >
        <span class="eror"> <?php echo $usernameErr ?> </span>
          </div>


    
    <div class="inp">

         <label for="password"> Password  </label>
        <input type="password"  id="password"  name="password">
        <span class="eror" > <?php echo $passwordErr ?> </span>

    </div>
        
    <button class="a" type="submit">login</button>

    <h3 class="regal"> You don't have any account ? <a class= "regals "href="register.php" class="regals">Register</a></h3>
    
    
    </form>

    </div>


    </div>



</body>
</html>