<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "task_project_management_tool";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}