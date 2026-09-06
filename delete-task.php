<?php

require "db.php";

session_start();

if(!isset ($_SESSION["user_id"])){
    exit;
}

$user_id = $_SESSION["user_id"];
$taskid = $_POST["task_id"];


$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii" , $taskid , $user_id);
$stmt->execute();


?>