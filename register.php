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
$emailErr = "";

$username = "";
$password = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    if (empty($_POST["username"])){
        $usernameErr = "* Pls enter your name";
    }else{
        $username = test_input($_POST["username"]);
        if(strlen($username) < 5){
            $usernameErr = " * Enter at least 5 characters";
        }
    }

    if(empty($_POST["email"])){
        $emailErr = "* Pls enter your email";
    }else{
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "* Invalid email format";
        }
    }

    if(empty($_POST["password"])){
        $passwordErr = "* Pls enter your password";
    }else{
        $password = test_input($_POST["password"]);
        if(strlen($password) < 6){
            $passwordErr = "* Password must be at least 6 characters";
        }
    }

    if ($usernameErr == "" && $passwordErr == "" && $emailErr == ""){

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss" , $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            echo "Username or email already exists";
        }else{
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);
            $stmt->execute();

            header("location: login.php");
            exit;
        }
    }
}
?>

<header>
    <div class="main-header">
        <a href="dashboard.php"><img src="./assets/logo.png" alt="" class="logo"></a>
        <div class="header-btn">
        </div>
    </div>
</header>

<div class="reg">
    <div class="form-div">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="inp">
                <h2 class="text">Create your account</h2>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>">
                <span class="error"><?php echo $usernameErr; ?></span>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr; ?></span>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>">
                <span class="error"><?php echo $passwordErr; ?></span>

                <input type="submit" name="submit" value="Register" class="sub">

                <p class="acc">Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>