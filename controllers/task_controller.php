<?php

session_start();

include "../config/db.php";
include "../models/task_model.php";
include "../models/project_model.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "team_lead") {
    header("Location: ../views/auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    if ($action == "create_task") {
        $project_id = $_POST["project_id"] ?? "";
        $milestone_id = $_POST["milestone_id"] ?? "";
        $title = trim($_POST["title"] ?? "");
        $description = trim($_POST["description"] ?? "");
        $assigned_to = $_POST["assigned_to"] ?? "";
        $priority = $_POST["priority"] ?? "";
        $status = $_POST["status"] ?? "";
        $due_date = trim($_POST["due_date"] ?? "");
        $estimated_hours = trim($_POST["estimated_hours"] ?? "");
        $created_by = $_SESSION["user_id"];

        if ($project_id == "") {
            $errors[] = "Project is required.";
        }

        if ($title == "") {
            $errors[] = "Task title is required.";
        }

        if ($description == "") {
            $errors[] = "Task description is required.";
        }

        if ($assigned_to == "") {
            $errors[] = "Assigned member is required.";
        }

        $allowed_priorities = ["low", "medium", "high", "critical"];
        if (!in_array($priority, $allowed_priorities)) {
            $errors[] = "Invalid priority selected.";
        }

        $allowed_status = ["todo", "in_progress", "review", "done"];
        if (!in_array($status, $allowed_status)) {
            $errors[] = "Invalid task status selected.";
        }

        if ($due_date == "") {
            $errors[] = "Due date is required.";
        } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $due_date)) {
            $errors[] = "Due date format must be YYYY-MM-DD.";
        }

        if ($estimated_hours == "") {
            $errors[] = "Estimated hours is required.";
        } elseif (!is_numeric($estimated_hours) || $estimated_hours <= 0) {
            $errors[] = "Estimated hours must be a positive number.";
        }

        if ($milestone_id == "") {
            $milestone_id = null;
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: ../views/team_lead/create_task.php");
            exit();
        }

        $created = create_task(
            $conn,
            $project_id,
            $milestone_id,
            $title,
            $description,
            $assigned_to,
            $created_by,
            $priority,
            $status,
            $due_date,
            $estimated_hours
        );

        if ($created) {
            $_SESSION["success"] = "Task created successfully.";
            header("Location: ../views/team_lead/tasks.php");
            exit();
        } else {
            $_SESSION["errors"] = ["Failed to create task."];
            header("Location: ../views/team_lead/create_task.php");
            exit();
        }
    }
}