<?php

function get_user_by_email($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function create_user($conn, $name, $email, $password_hash, $phone, $role, $company_name = null) {
    $sql = "INSERT INTO users (name, email, password_hash, phone, role, company_name) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $password_hash, $phone, $role, $company_name);

    return mysqli_stmt_execute($stmt);
}

function count_all_users($conn) {
    $sql = "SELECT COUNT(*) AS total FROM users";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)["total"];
}

function count_users_by_role($conn, $role) {
    $sql = "SELECT COUNT(*) AS total FROM users WHERE role = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return 0;
    }

    mysqli_stmt_bind_param($stmt, "s", $role);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row["total"];
}

function get_users_by_role($conn, $role) {
    $sql = "SELECT * FROM users 
            WHERE role = ? AND is_active = 1 
            ORDER BY name ASC";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $role);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}