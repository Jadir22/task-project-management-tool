<?php

session_start();

include "../config/db.php";
include "../models/comment_model.php";
include "../models/task_model.php";
include "../models/activity_model.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "member") {
    header("Location: ../views/auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";

    if ($action == "add_comment") {
        $task_id = $_POST["task_id"] ?? "";
        $comment_body = trim($_POST["comment_body"] ?? "");
        $is_internal = $_POST["is_internal"] ?? "";
        $member_id = $_SESSION["user_id"];

        if ($task_id == "" || !is_numeric($task_id)) {
            $errors[] = "Invalid task selected.";
        }

        if ($comment_body == "") {
            $errors[] = "Comment is required.";
        }

        if ($is_internal !== "0" && $is_internal !== "1") {
            $errors[] = "Invalid comment visibility selected.";
        }

        $task = null;

        if ($task_id != "" && is_numeric($task_id)) {
            $task = get_member_task_by_id($conn, $task_id, $member_id);

            if (!$task) {
                $errors[] = "Task not found or access denied.";
            }
        }

        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: ../views/member/task_detail.php?task_id=" . $task_id);
            exit();
        }

        $created = create_task_comment($conn, $task_id, $member_id, $comment_body, $is_internal);

        if ($created) {
            if (function_exists("add_activity_log")) {
                add_activity_log(
                    $conn,
                    null,
                    $task["project_id"],
                    $member_id,
                    "task_comment_added",
                    "Member added comment on task: " . $task["title"]
                );
            }

            $_SESSION["success"] = "Comment added successfully.";
            header("Location: ../views/member/task_detail.php?task_id=" . $task_id);
            exit();
        } else {
            $_SESSION["errors"] = ["Failed to add comment."];
            header("Location: ../views/member/task_detail.php?task_id=" . $task_id);
            exit();
        }
    }
}

header("Location: ../views/member/tasks.php");
exit();