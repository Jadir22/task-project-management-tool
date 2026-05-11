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