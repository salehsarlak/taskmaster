<?php

require "db.php";


session_start();

if (!isset($_SESSION["user_id"])){
    exit;
}

$user_id = $_SESSION["user_id"];
$task_id = $_POST["task_id"];
$status = $_POST["status"];

$stmt = $conn ->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
$stmt -> bind_param("sii" , $status , $task_id , $user_id);

$stmt -> execute();


?>