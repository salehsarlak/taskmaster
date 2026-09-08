<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create your account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="reset.css">
</head>
<body>
    


   

<!--      Validation        -->
<?php

    require "db.php";

        

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;

}


$allowedimgtypes = ["image/jpeg" , "image/png" , "image/webp"];
$pfpsize = 2 * 1024 * 1024;


$usernameErr = "";
$pfpErr = "";
$passwordErr = "";

$pfp = "";
$username = "";
$password = "";
$regsuc = null;
if ($_SERVER["REQUEST_METHOD"] == "POST"){
   

    if (empty($_POST["username"])){
        $usernameErr = "* Pls enter your name";
    }else{
        $username = test_input($_POST["username"]);

        if(strlen($username) < 5){
        $usernameErr = " * Enter at least 5 characters";
    }

        } 


    if ($_FILES["pfp"]["error"] === UPLOAD_ERR_NO_FILE ){
        $pfpErr = "* Pls upload a picture";
    }else{      
            if (!in_array($_FILES["pfp"]["type"] , $allowedimgtypes)){
                $pfpErr = "* You can only add image";
            } else{
              if ($_FILES["pfp"]["size"] > $pfpsize ){
                $pfpErr = "* Only photos under 2 MB are allowed";
              }else{

    $pfp = $_FILES["pfp"]["name"];

    move_uploaded_file(
        $_FILES["pfp"]["tmp_name"],
        "assets/uploads/" . $_FILES["pfp"]["name"]
    );
}
            }

        } 

    if(empty($_POST["password"])){
        $passwordErr = "* Pls enter your password";
    }else{
        $password = test_input($_POST["password"]);
    }


        if ($pfpErr == "" && $usernameErr == "" && $passwordErr == ""){

            $stmt = $conn->prepare("INSERT INTO users (pfp , username , password) VALUES (? , ? , ?) ");
    $stmt->bind_param("sss" , $pfp , $username , $password);


    if ($stmt -> execute()){
            $regsuc = true;
        }else{
            $regsuc = false;
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


    <form     enctype="multipart/form-data"
  method="POST"  action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);  ?>">
               
    <div class="inp1">

        <img class="pfpa" id="avatarPreview" src="./assets/Oval.png" alt="pfpa">
        <input type="file"  id="pfp"  name="pfp" accept="image/jpeg,image/png,image/webp" >
     <label for="pfp"> Your Aatar  </label>
        <span class="eror"> <?php echo $pfpErr ?> </span>
          </div>
    
          <div class="inp">

     <label for="username"> Username  </label>
        <input type="text"  id="username"  name="username" value="<?php echo $username; ?>" >
        <span class="eror"> <?php echo $usernameErr ?> </span>
          </div>


    
    <div class="inp">

         <label for="password"> Password  </label>
        <input type="password"  id="password"  name="password">
        <span class="eror" > <?php echo $passwordErr ?> </span>

    </div>
        
    <button class="a" type="submit">Register</button>

        <h3 class="regal"> You alredy have any account ? <a class= "regals "href="login.php" class="regals">Login</a></h3>


    </form>

    </div>

    <?php
  if ($regsuc === true){
    ?>
     <h2 class="regh2">
            Your registration was successful
        </h2> 
  <?php
    }elseif($regsuc === false){
    ?>    
    <h2 class="regh2">
            Registration failed
        </h2> 
    <?php
    }
   
    ?>

    </div>


<script>

const pfpinput = document.getElementById("pfp");
const avatarPreview = document.getElementById("avatarPreview");

pfpinput.addEventListener("change", function() {

    const file = this.files[0];

    if (file) {
        avatarPreview.src = URL.createObjectURL(file);
    }

});

</script>
</body>
</html>