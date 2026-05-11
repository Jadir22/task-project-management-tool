<?php

function count_all_tasks($conn) {
    $sql = "SELECT COUNT(*) AS total FROM tasks";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)["total"];
}

function count_tasks_created_today($conn) {
    $sql = "SELECT COUNT(*) AS total FROM tasks WHERE DATE(created_at) = CURDATE()";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)["total"];
}

function count_overdue_tasks($conn) {
    $sql = "SELECT COUNT(*) AS total 
            FROM tasks 
            WHERE due_date < CURDATE() 
            AND status != 'done'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)["total"];
}

function count_teamlead_total_tasks($conn, $team_lead_id) {
    $sql = "SELECT COUNT(*) AS total
            FROM tasks
            WHERE project_id IN (
                SELECT id 
                FROM projects 
                WHERE workspace_id IN (
                    SELECT id 
                    FROM workspaces 
                    WHERE owner_id = ?
                )
            )";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return 0;
    }

    mysqli_stmt_bind_param($stmt, "i", $team_lead_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row["total"];
}

function count_teamlead_overdue_tasks($conn, $team_lead_id) {
    $sql = "SELECT COUNT(*) AS total
            FROM tasks
            WHERE due_date < CURDATE()
            AND status != 'done'
            AND project_id IN (
                SELECT id 
                FROM projects 
                WHERE workspace_id IN (
                    SELECT id 
                    FROM workspaces 
                    WHERE owner_id = ?
                )
            )";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return 0;
    }

    mysqli_stmt_bind_param($stmt, "i", $team_lead_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row["total"];
}