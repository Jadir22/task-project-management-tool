<?php

session_start();

include "../config/db.php";
include "../models/workspace_model.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: ../views/auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    if ($action == "change_workspace_status") {
        $workspace_id = $_POST["workspace_id"] ?? "";
        $is_active = $_POST["is_active"] ?? "";

        if ($workspace_id == "" || !is_numeric($workspace_id)) {
            $errors[] = "Invalid workspace selected.";
        }

        if ($is_active !== "0" && $is_active !== "1") {
            $errors[] = "Invalid workspace status selected.";
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: ../views/admin/workspaces.php");
            exit();
        }

        $workspace = get_workspace_by_id_admin($conn, $workspace_id);

        if (!$workspace) {
            $_SESSION["errors"] = ["Workspace not found."];
            header("Location: ../views/admin/workspaces.php");
            exit();
        }

        $updated = update_workspace_status_admin($conn, $workspace_id, $is_active);

        if ($updated) {
            $_SESSION["success"] = "Workspace status updated successfully.";
        } else {
            $_SESSION["errors"] = ["Failed to update workspace status."];
        }

        header("Location: ../views/admin/workspaces.php");
        exit();
    }

    if ($action == "delete_workspace") {
        $workspace_id = $_POST["workspace_id"] ?? "";

        if ($workspace_id == "" || !is_numeric($workspace_id)) {
            $_SESSION["errors"] = ["Invalid workspace selected."];
            header("Location: ../views/admin/workspaces.php");
            exit();
        }

        $workspace = get_workspace_by_id_admin($conn, $workspace_id);

        if (!$workspace) {
            $_SESSION["errors"] = ["Workspace not found."];
            header("Location: ../views/admin/workspaces.php");
            exit();
        }

        $deleted = delete_workspace_admin($conn, $workspace_id);

        if ($deleted) {
            $_SESSION["success"] = "Workspace deleted successfully.";
        } else {
            $_SESSION["errors"] = ["Failed to delete workspace."];
        }

        header("Location: ../views/admin/workspaces.php");
        exit();
    }

    if ($action == "remove_workspace_member") {
        $workspace_member_id = $_POST["workspace_member_id"] ?? "";
        $workspace_id = $_POST["workspace_id"] ?? "";

        if ($workspace_member_id == "" || !is_numeric($workspace_member_id)) {
            $_SESSION["errors"] = ["Invalid workspace member selected."];
            header("Location: ../views/admin/workspaces.php");
            exit();
        }

        if ($workspace_id == "" || !is_numeric($workspace_id)) {
            $_SESSION["errors"] = ["Invalid workspace selected."];
            header("Location: ../views/admin/workspaces.php");
            exit();
        }

        $workspace_member = get_workspace_member_by_id_admin($conn, $workspace_member_id);

        if (!$workspace_member) {
            $_SESSION["errors"] = ["Workspace member not found."];
            header("Location: ../views/admin/workspace_members.php?workspace_id=" . $workspace_id);
            exit();
        }

        $removed = remove_workspace_member_admin($conn, $workspace_member_id);

        if ($removed) {
            $_SESSION["success"] = "Workspace member removed successfully.";
        } else {
            $_SESSION["errors"] = ["Failed to remove workspace member."];
        }

        header("Location: ../views/admin/workspace_members.php?workspace_id=" . $workspace_id);
        exit();
    }
}