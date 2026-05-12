<?php

session_start();

include "../config/db.php";
include "../models/user_model.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../views/auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    if ($action == "change_status") {
        $user_id = $_POST["user_id"] ?? "";
        $is_active = $_POST["is_active"] ?? "";

        if ($user_id == "" || !is_numeric($user_id)) {
            $errors[] = "Invalid user selected.";
        }

        if ($is_active !== "0" && $is_active !== "1") {
            $errors[] = "Invalid status selected.";
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: ../views/admin/users.php");
            exit();
        }

        $user = get_user_by_id($conn, $user_id);

        if (!$user) {
            $_SESSION["errors"] = ["User not found."];
            header("Location: ../views/admin/users.php");
            exit();
        }

        if ($user["id"] == $_SESSION["user_id"] && $is_active == "0") {
            $_SESSION["errors"] = ["You cannot deactivate your own account."];
            header("Location: ../views/admin/users.php");
            exit();
        }

        $updated = update_user_status($conn, $user_id, $is_active);

        if ($updated) {
            $_SESSION["success"] = "User status updated successfully.";
            header("Location: ../views/admin/users.php");
            exit();
        } else {
            $_SESSION["errors"] = ["Failed to update user status."];
            header("Location: ../views/admin/users.php");
            exit();
        }
    }

    if ($action == "change_role") {
        $user_id = $_POST["user_id"] ?? "";
        $role = $_POST["role"] ?? "";

        if ($user_id == "" || !is_numeric($user_id)) {
            $errors[] = "Invalid user selected.";
        }

        $allowed_roles = ["member", "team_lead", "client", "admin"];

        if (!in_array($role, $allowed_roles)) {
            $errors[] = "Invalid role selected.";
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: ../views/admin/users.php");
            exit();
        }

        $user = get_user_by_id($conn, $user_id);

        if (!$user) {
            $_SESSION["errors"] = ["User not found."];
            header("Location: ../views/admin/users.php");
            exit();
        }

        if ($user["id"] == $_SESSION["user_id"] && $role != "admin") {
            $_SESSION["errors"] = ["You cannot remove your own admin role."];
            header("Location: ../views/admin/users.php");
            exit();
        }

        $updated = update_user_role($conn, $user_id, $role);

        if ($updated) {
            $_SESSION["success"] = "User role updated successfully.";
            header("Location: ../views/admin/users.php");
            exit();
        } else {
            $_SESSION["errors"] = ["Failed to update user role."];
            header("Location: ../views/admin/users.php");
            exit();
        }
    }
}