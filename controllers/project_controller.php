<?php

session_start();

include "../config/db.php";
include "../models/project_model.php";
include "../models/workspace_model.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "team_lead") {
    header("Location: ../views/auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    if ($action == "create_project") {
        $workspace_id = $_POST["workspace_id"] ?? "";
        $name = trim($_POST["name"] ?? "");
        $description = trim($_POST["description"] ?? "");
        $client_id = $_POST["client_id"] ?? "";
        $deadline = $_POST["deadline"] ?? "";
        $color_label = trim($_POST["color_label"] ?? "");
        $status = $_POST["status"] ?? "";
        $visibility = $_POST["visibility"] ?? "";

        if ($workspace_id == "") {
            $errors[] = "Workspace is required.";
        }

        if ($name == "") {
            $errors[] = "Project name is required.";
        }

        if ($description == "") {
            $errors[] = "Project description is required.";
        }

        if ($client_id == "") {
            $errors[] = "Client is required.";
        }

        if ($deadline == "") {
            $errors[] = "Deadline is required.";
        }

        if ($color_label == "") {
            $errors[] = "Color label is required.";
        }

        $allowed_status = ["planning", "active", "on_hold", "completed", "archived"];
        if (!in_array($status, $allowed_status)) {
            $errors[] = "Invalid project status.";
        }

        $allowed_visibility = ["internal", "client_visible"];
        if (!in_array($visibility, $allowed_visibility)) {
            $errors[] = "Invalid project visibility.";
        }

        $owner_id = $_SESSION["user_id"];
        $workspace = get_workspace_by_id_and_owner($conn, $workspace_id, $owner_id);

        if (!$workspace) {
            $errors[] = "Invalid workspace selected.";
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: ../views/team_lead/create_project.php");
            exit();
        }

        $created = create_project($conn, $workspace_id, $name, $description, $client_id, $deadline, $color_label, $status, $visibility);

        if ($created) {
            $_SESSION["success"] = "Project created successfully.";
            header("Location: ../views/team_lead/projects.php");
            exit();
        } else {
            $_SESSION["errors"] = ["Failed to create project."];
            header("Location: ../views/team_lead/create_project.php");
            exit();
        }
    }
}