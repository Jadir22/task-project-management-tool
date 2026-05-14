<?php

include "../../includes/auth_check.php";
include "../../includes/role_check.php";

check_role(["member"]);

include "../../config/db.php";
include "../../models/task_model.php";

$member_id = $_SESSION["user_id"];
$task_id = $_GET["task_id"] ?? "";

if ($task_id == "" || !is_numeric($task_id)) {
    echo "<h2>Invalid task selected.</h2>";
    echo "<p><a href='tasks.php'>Back to Tasks</a></p>";
    exit();
}

$task = get_member_task_by_id($conn, $task_id, $member_id);

if (!$task) {
    echo "<h2>Task not found or access denied.</h2>";
    echo "<p><a href='tasks.php'>Back to Tasks</a></p>";
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Details</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

    <h1>Task Details</h1>
    <p>
        <a href="tasks.php">Back to My Tasks</a> |
        <a href="dashboard.php">Dashboard</a> |
        <a href="../../logout.php">Logout</a>
    </p>
    <hr>

    <h2><?php echo htmlspecialchars($task["title"]); ?></h2>

    <p><strong>Project:</strong> <?php echo htmlspecialchars($task["project_name"] ?? "No Project"); ?></p>
    <p><strong>Project Description:</strong> <?php echo htmlspecialchars($task["project_description"] ?? ""); ?></p>

    <p>
        <strong>Milestone:</strong>
        <?php
        if ($task["milestone_title"]) {
            echo htmlspecialchars($task["milestone_title"]);
        } else {
            echo "No Milestone";
        }
        ?>
    </p>

    <p><strong>Description:</strong> <?php echo htmlspecialchars($task["description"]); ?></p>
    <p><strong>Created By:</strong> <?php echo htmlspecialchars($task["created_by_name"] ?? "Unknown"); ?></p>
    <p><strong>Priority:</strong> <?php echo htmlspecialchars($task["priority"]); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($task["status"]); ?></p>
    <p><strong>Due Date:</strong> <?php echo htmlspecialchars($task["due_date"]); ?></p>
    <p><strong>Estimated Hours:</strong> <?php echo htmlspecialchars($task["estimated_hours"]); ?></p>
    <p><strong>Created At:</strong> <?php echo htmlspecialchars($task["created_at"]); ?></p>

</body>
</html>