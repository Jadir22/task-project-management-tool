<?php

function count_all_workspaces($conn) {
    $sql = "SELECT COUNT(*) AS total FROM workspaces";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)["total"];
}

function count_active_workspaces($conn) {
    $sql = "SELECT COUNT(*) AS total FROM workspaces WHERE is_active = 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)["total"];
}

function create_workspace($conn, $name, $description, $owner_id, $invite_code, $plan) {
    $sql = "INSERT INTO workspaces (name, description, owner_id, invite_code, plan) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ssiss", $name, $description, $owner_id, $invite_code, $plan);

    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($conn);
    }

    return false;
}

function add_workspace_member($conn, $workspace_id, $user_id, $workspace_role) {
    $sql = "INSERT INTO workspace_members (workspace_id, user_id, workspace_role) 
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iis", $workspace_id, $user_id, $workspace_role);

    return mysqli_stmt_execute($stmt);
}

function get_workspaces_by_owner($conn, $owner_id) {
    $sql = "SELECT * FROM workspaces 
            WHERE owner_id = ? 
            ORDER BY created_at DESC";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $owner_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function get_workspace_by_id_and_owner($conn, $workspace_id, $owner_id) {
    $sql = "SELECT * FROM workspaces 
            WHERE id = ? AND owner_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ii", $workspace_id, $owner_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}