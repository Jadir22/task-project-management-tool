<?php

session_start();

include "../config/db.php";
include "../models/feedback_model.php";
include "../models/milestone_model.php";
include "../models/activity_model.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "client") {
    header("Location: ../views/auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    if ($action == "submit_feedback") {
        $milestone_id = $_POST["milestone_id"] ?? "";
        $feedback_text = trim($_POST["feedback_text"] ?? "");
        $approval_status = $_POST["approval_status"] ?? "";
        $client_id = $_SESSION["user_id"];

        if ($milestone_id == "" || !is_numeric($milestone_id)) {
            $errors[] = "Invalid milestone selected.";
        }

        if ($feedback_text == "") {
            $errors[] = "Feedback text is required.";
        }

        $allowed_status = ["approved", "revision_requested"];

        if (!in_array($approval_status, $allowed_status)) {
            $errors[] = "Please select a valid approval status.";
        }

        $milestone = null;

        if ($milestone_id != "" && is_numeric($milestone_id)) {
            $milestone = get_client_visible_milestone_by_id($conn, $milestone_id, $client_id);

            if (!$milestone) {
                $errors[] = "Milestone not found or access denied.";
            }
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: ../views/client/feedback.php");
            exit();
        }

        $created = create_client_feedback($conn, $milestone_id, $client_id, $feedback_text, $approval_status);

        if ($created) {
            add_activity_log(
                $conn,
                null,
                $milestone["project_id"],
                $client_id,
                "client_feedback_submitted",
                "Client submitted feedback for milestone: " . $milestone["title"]
            );

            $_SESSION["success"] = "Feedback submitted successfully.";
            header("Location: ../views/client/feedback.php");
            exit();
        } else {
            $_SESSION["errors"] = ["Failed to submit feedback."];
            header("Location: ../views/client/feedback.php");
            exit();
        }
    }
}

header("Location: ../views/client/feedback.php");
exit();