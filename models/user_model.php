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