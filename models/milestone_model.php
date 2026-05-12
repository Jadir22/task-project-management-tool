<?php

function create_milestone($conn, $project_id, $title, $description, $due_date, $status, $is_client_visible) {
    $sql = "INSERT INTO milestones 
            (project_id, title, description, due_date, status, is_client_visible)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "issssi",
        $project_id,
        $title,
        $description,
        $due_date,
        $status,
        $is_client_visible
    );

    return mysqli_stmt_execute($stmt);
}

function get_milestones_by_teamlead($conn, $team_lead_id) {
    $sql = "SELECT 
                m.*, 
                p.name AS project_name
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

function get_milestone_by_id_and_teamlead($conn, $milestone_id, $team_lead_id) {
    $sql = "SELECT m.*
            FROM milestones m
            LEFT JOIN projects p ON m.project_id = p.id
            WHERE m.id = ? 
            AND p.workspace_id IN (
                SELECT id FROM workspaces WHERE owner_id = ?
            )";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ii", $milestone_id, $team_lead_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function mark_milestone_completed($conn, $milestone_id) {
    $sql = "UPDATE milestones 
            SET status = 'completed', completed_at = NOW()
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $milestone_id);

    return mysqli_stmt_execute($stmt);
}