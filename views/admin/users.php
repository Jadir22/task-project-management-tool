<?php

include "../../includes/auth_check.php";
include "../../includes/role_check.php";

check_role(["admin"]);

include "../../config/db.php";
include "../../models/user_model.php";

$search = trim($_GET["search"] ?? "");
$users = get_all_users($conn, $search);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

    <h1>Manage Users</h1>

    <p>
        <a href="dashboard.php">Dashboard</a> |
        <a href="../../logout.php">Logout</a>
    </p>

    <hr>

    <?php
    if (isset($_SESSION["errors"])) {
        echo "<div style='color:red;'>";
        foreach ($_SESSION["errors"] as $error) {
            echo "<p>" . htmlspecialchars($error) . "</p>";
        }
        echo "</div>";
        unset($_SESSION["errors"]);
    }

    if (isset($_SESSION["success"])) {
        echo "<div style='color:green;'>";
        echo "<p>" . htmlspecialchars($_SESSION["success"]) . "</p>";
        echo "</div>";
        unset($_SESSION["success"]);
    }
    ?>

    <h2>Search Users</h2>

    <form method="GET" action="users.php">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by name, email, phone or role">
        <button type="submit">Search</button>
        <a href="users.php">Reset</a>
    </form>

    <hr>

    <h2>User List</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Company</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Change Status</th>
            <th>Change Role</th>
        </tr>

        <?php if ($users && mysqli_num_rows($users) > 0): ?>
            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?php echo $user["id"]; ?></td>
                    <td><?php echo htmlspecialchars($user["name"]); ?></td>
                    <td><?php echo htmlspecialchars($user["email"]); ?></td>
                    <td><?php echo htmlspecialchars($user["phone"]); ?></td>
                    <td><?php echo htmlspecialchars($user["company_name"] ?? ""); ?></td>
                    <td><?php echo htmlspecialchars($user["role"]); ?></td>
                    <td>
                        <?php
                        if ($user["is_active"] == 1) {
                            echo "Active";
                        } else {
                            echo "Inactive";
                        }
                        ?>
                    </td>
                    <td><?php echo $user["created_at"]; ?></td>

                    <td>
                        <form action="../../controllers/admin_user_controller.php" method="POST">
                            <input type="hidden" name="action" value="change_status">
                            <input type="hidden" name="user_id" value="<?php echo $user["id"]; ?>">

                            <select name="is_active">
                                <option value="1" <?php if ($user["is_active"] == 1) echo "selected"; ?>>Active</option>
                                <option value="0" <?php if ($user["is_active"] == 0) echo "selected"; ?>>Inactive</option>
                            </select>

                            <button type="submit">Update</button>
                        </form>
                    </td>

                    <td>
                        <form action="../../controllers/admin_user_controller.php" method="POST">
                            <input type="hidden" name="action" value="change_role">
                            <input type="hidden" name="user_id" value="<?php echo $user["id"]; ?>">

                            <select name="role">
                                <option value="member" <?php if ($user["role"] == "member") echo "selected"; ?>>Member</option>
                                <option value="team_lead" <?php if ($user["role"] == "team_lead") echo "selected"; ?>>Team Lead</option>
                                <option value="client" <?php if ($user["role"] == "client") echo "selected"; ?>>Client</option>
                                <option value="admin" <?php if ($user["role"] == "admin") echo "selected"; ?>>Admin</option>
                            </select>

                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="10">No users found.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>