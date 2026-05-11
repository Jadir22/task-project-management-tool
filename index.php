<?php
session_start();

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] == "member") {
        header("Location: views/member/dashboard.php");
        exit();
    } elseif ($_SESSION["role"] == "team_lead") {
        header("Location: views/team_lead/dashboard.php");
        exit();
    } elseif ($_SESSION["role"] == "client") {
        header("Location: views/client/dashboard.php");
        exit();
    } elseif ($_SESSION["role"] == "admin") {
        header("Location: views/admin/dashboard.php");
        exit();
    }
}

header("Location: views/auth/login.php");
exit();