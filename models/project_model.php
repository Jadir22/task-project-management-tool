<?php

function count_all_projects($conn) {
    $sql = "SELECT COUNT(*) AS total FROM projects";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)["total"];
}

function count_active_projects($conn) {
    $sql = "SELECT COUNT(*) AS total FROM projects WHERE status = 'active'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)["total"];
}

function count_teamlead_active_projects($conn, $team_lead_id) {
    $sql = "SELECT COUNT(*) AS total 
            FROM projects 
            WHERE workspace_id IN (
                SELECT workspace_id 
                FROM workspaces 
                WHERE owner_id = ?
            )
            AND status = 'active'";

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