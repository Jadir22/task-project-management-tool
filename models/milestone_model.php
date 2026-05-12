<?php

function get_milestones_by_teamlead($conn, $team_lead_id) {
    $sql = "SELECT m.*, p.name AS project_name
            FROM milestones m
            LEFT JOIN projects p ON m.project_id = p.id
            WHERE p.workspace_id IN (
                SELECT id FROM workspaces WHERE owner_id = ?
            )
            ORDER BY m.due_date ASC";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $team_lead_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}