document.addEventListener("DOMContentLoaded", function () {
    var registerForm = document.getElementById("registerForm");
    var loginForm = document.getElementById("loginForm");

    if (registerForm) {
        registerForm.addEventListener("submit", function (e) {
            var isValid = true;

            var name = document.getElementById("name").value.trim();
            var email = document.getElementById("email").value.trim();
            var phone = document.getElementById("phone").value.trim();
            var role = document.getElementById("role").value;
            var companyName = document.getElementById("company_name").value.trim();
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            document.getElementById("nameError").innerText = "";
            document.getElementById("emailError").innerText = "";
            document.getElementById("phoneError").innerText = "";
            document.getElementById("roleError").innerText = "";
            document.getElementById("companyError").innerText = "";
            document.getElementById("passwordError").innerText = "";
            document.getElementById("confirmPasswordError").innerText = "";

            if (name === "") {
                document.getElementById("nameError").innerText = "Name is required.";
                isValid = false;
            }

            if (email === "") {
                document.getElementById("emailError").innerText = "Email is required.";
                isValid = false;
            } else if (!email.includes("@") || !email.includes(".")) {
                document.getElementById("emailError").innerText = "Please enter a valid email.";
                isValid = false;
            }

            if (phone === "") {
                document.getElementById("phoneError").innerText = "Phone is required.";
                isValid = false;
            }

            if (role === "") {
                document.getElementById("roleError").innerText = "Please select a role.";
                isValid = false;
            }

            if (role === "client" && companyName === "") {
                document.getElementById("companyError").innerText = "Company name is required for client.";
                isValid = false;
            }

            if (password === "") {
                document.getElementById("passwordError").innerText = "Password is required.";
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById("passwordError").innerText = "Password must be at least 6 characters.";
                isValid = false;
            }

            if (confirmPassword === "") {
                document.getElementById("confirmPasswordError").innerText = "Confirm password is required.";
                isValid = false;
            } else if (password !== confirmPassword) {
                document.getElementById("confirmPasswordError").innerText = "Passwords do not match.";
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            var isValid = true;

            var email = document.getElementById("login_email").value.trim();
            var password = document.getElementById("login_password").value;

            document.getElementById("loginEmailError").innerText = "";
            document.getElementById("loginPasswordError").innerText = "";

            if (email === "") {
                document.getElementById("loginEmailError").innerText = "Email is required.";
                isValid = false;
            }

            if (password === "") {
                document.getElementById("loginPasswordError").innerText = "Password is required.";
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});

var workspaceForm = document.getElementById("workspaceForm");

if (workspaceForm) {
    workspaceForm.addEventListener("submit", function (e) {
        var isValid = true;

        var name = document.getElementById("workspace_name").value.trim();
        var description = document.getElementById("workspace_description").value.trim();

        document.getElementById("workspaceNameError").innerText = "";
        document.getElementById("workspaceDescriptionError").innerText = "";

        if (name === "") {
            document.getElementById("workspaceNameError").innerText = "Workspace name is required.";
            isValid = false;
        }

        if (description === "") {
            document.getElementById("workspaceDescriptionError").innerText = "Workspace description is required.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

var projectForm = document.getElementById("projectForm");

if (projectForm) {
    projectForm.addEventListener("submit", function (e) {
        var isValid = true;

        var workspace = document.getElementById("project_workspace").value;
        var name = document.getElementById("project_name").value.trim();
        var description = document.getElementById("project_description").value.trim();
        var client = document.getElementById("project_client").value;
        var deadline = document.getElementById("project_deadline").value.trim();
        var color = document.getElementById("project_color").value.trim();
        var status = document.getElementById("project_status").value;
        var visibility = document.getElementById("project_visibility").value;

        document.getElementById("projectWorkspaceError").innerText = "";
        document.getElementById("projectNameError").innerText = "";
        document.getElementById("projectDescriptionError").innerText = "";
        document.getElementById("projectClientError").innerText = "";
        document.getElementById("projectDeadlineError").innerText = "";
        document.getElementById("projectColorError").innerText = "";
        document.getElementById("projectStatusError").innerText = "";
        document.getElementById("projectVisibilityError").innerText = "";

        if (workspace === "") {
            document.getElementById("projectWorkspaceError").innerText = "Workspace is required.";
            isValid = false;
        }

        if (name === "") {
            document.getElementById("projectNameError").innerText = "Project name is required.";
            isValid = false;
        }

        if (description === "") {
            document.getElementById("projectDescriptionError").innerText = "Project description is required.";
            isValid = false;
        }

        if (client === "") {
            document.getElementById("projectClientError").innerText = "Client is required.";
            isValid = false;
        }

        if (deadline === "") {
            document.getElementById("projectDeadlineError").innerText = "Deadline is required.";
            isValid = false;
        } else if (!/^\d{4}-\d{2}-\d{2}$/.test(deadline)) {
            document.getElementById("projectDeadlineError").innerText = "Deadline format must be YYYY-MM-DD.";
            isValid = false;
        }

        if (color === "") {
            document.getElementById("projectColorError").innerText = "Color label is required.";
            isValid = false;
        }

        if (status === "") {
            document.getElementById("projectStatusError").innerText = "Status is required.";
            isValid = false;
        }

        if (visibility === "") {
            document.getElementById("projectVisibilityError").innerText = "Visibility is required.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

var taskForm = document.getElementById("taskForm");

if (taskForm) {
    taskForm.addEventListener("submit", function (e) {
        var isValid = true;

        var project = document.getElementById("task_project").value;
        var title = document.getElementById("task_title").value.trim();
        var description = document.getElementById("task_description").value.trim();
        var assignedTo = document.getElementById("task_assigned_to").value;
        var priority = document.getElementById("task_priority").value;
        var status = document.getElementById("task_status").value;
        var dueDate = document.getElementById("task_due_date").value.trim();
        var estimatedHours = document.getElementById("task_estimated_hours").value.trim();

        document.getElementById("taskProjectError").innerText = "";
        document.getElementById("taskTitleError").innerText = "";
        document.getElementById("taskDescriptionError").innerText = "";
        document.getElementById("taskAssignedError").innerText = "";
        document.getElementById("taskPriorityError").innerText = "";
        document.getElementById("taskStatusError").innerText = "";
        document.getElementById("taskDueDateError").innerText = "";
        document.getElementById("taskEstimatedHoursError").innerText = "";

        if (project === "") {
            document.getElementById("taskProjectError").innerText = "Project is required.";
            isValid = false;
        }

        if (title === "") {
            document.getElementById("taskTitleError").innerText = "Task title is required.";
            isValid = false;
        }

        if (description === "") {
            document.getElementById("taskDescriptionError").innerText = "Task description is required.";
            isValid = false;
        }

        if (assignedTo === "") {
            document.getElementById("taskAssignedError").innerText = "Assigned member is required.";
            isValid = false;
        }

        if (priority === "") {
            document.getElementById("taskPriorityError").innerText = "Priority is required.";
            isValid = false;
        }

        if (status === "") {
            document.getElementById("taskStatusError").innerText = "Status is required.";
            isValid = false;
        }

        if (dueDate === "") {
            document.getElementById("taskDueDateError").innerText = "Due date is required.";
            isValid = false;
        } else if (!/^\d{4}-\d{2}-\d{2}$/.test(dueDate)) {
            document.getElementById("taskDueDateError").innerText = "Due date format must be YYYY-MM-DD.";
            isValid = false;
        }

        if (estimatedHours === "") {
            document.getElementById("taskEstimatedHoursError").innerText = "Estimated hours is required.";
            isValid = false;
        } else if (isNaN(estimatedHours) || Number(estimatedHours) <= 0) {
            document.getElementById("taskEstimatedHoursError").innerText = "Estimated hours must be a positive number.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

var milestoneForm = document.getElementById("milestoneForm");

if (milestoneForm) {
    milestoneForm.addEventListener("submit", function (e) {
        var isValid = true;

        var project = document.getElementById("milestone_project").value;
        var title = document.getElementById("milestone_title").value.trim();
        var description = document.getElementById("milestone_description").value.trim();
        var dueDate = document.getElementById("milestone_due_date").value.trim();
        var status = document.getElementById("milestone_status").value;
        var clientVisible = document.getElementById("milestone_client_visible").value;

        document.getElementById("milestoneProjectError").innerText = "";
        document.getElementById("milestoneTitleError").innerText = "";
        document.getElementById("milestoneDescriptionError").innerText = "";
        document.getElementById("milestoneDueDateError").innerText = "";
        document.getElementById("milestoneStatusError").innerText = "";
        document.getElementById("milestoneClientVisibleError").innerText = "";

        if (project === "") {
            document.getElementById("milestoneProjectError").innerText = "Project is required.";
            isValid = false;
        }

        if (title === "") {
            document.getElementById("milestoneTitleError").innerText = "Milestone title is required.";
            isValid = false;
        }

        if (description === "") {
            document.getElementById("milestoneDescriptionError").innerText = "Milestone description is required.";
            isValid = false;
        }

        if (dueDate === "") {
            document.getElementById("milestoneDueDateError").innerText = "Due date is required.";
            isValid = false;
        } else if (!/^\d{4}-\d{2}-\d{2}$/.test(dueDate)) {
            document.getElementById("milestoneDueDateError").innerText = "Due date format must be YYYY-MM-DD.";
            isValid = false;
        }

        if (status === "") {
            document.getElementById("milestoneStatusError").innerText = "Status is required.";
            isValid = false;
        }

        if (clientVisible === "") {
            document.getElementById("milestoneClientVisibleError").innerText = "Client visibility is required.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

var projectMemberForm = document.getElementById("projectMemberForm");

if (projectMemberForm) {
    projectMemberForm.addEventListener("submit", function (e) {
        var isValid = true;

        var project = document.getElementById("pm_project").value;
        var user = document.getElementById("pm_user").value;

        document.getElementById("pmProjectError").innerText = "";
        document.getElementById("pmUserError").innerText = "";

        if (project === "") {
            document.getElementById("pmProjectError").innerText = "Project is required.";
            isValid = false;
        }

        if (user === "") {
            document.getElementById("pmUserError").innerText = "Member is required.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    var userStatusForms = document.querySelectorAll(".admin-user-status-form");

    userStatusForms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            var userId = form.querySelector("input[name='user_id']").value;
            var status = form.querySelector("select[name='is_active']").value;

            if (userId === "" || isNaN(userId)) {
                alert("Invalid user selected.");
                e.preventDefault();
                return;
            }

            if (status !== "0" && status !== "1") {
                alert("Please select a valid user status.");
                e.preventDefault();
                return;
            }

            var statusText = status === "1" ? "activate" : "deactivate";

            if (!confirm("Are you sure you want to " + statusText + " this user?")) {
                e.preventDefault();
            }
        });
    });

    var userRoleForms = document.querySelectorAll(".admin-user-role-form");

    userRoleForms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            var userId = form.querySelector("input[name='user_id']").value;
            var role = form.querySelector("select[name='role']").value;

            var allowedRoles = ["member", "team_lead", "client", "admin"];

            if (userId === "" || isNaN(userId)) {
                alert("Invalid user selected.");
                e.preventDefault();
                return;
            }

            if (!allowedRoles.includes(role)) {
                alert("Please select a valid role.");
                e.preventDefault();
                return;
            }

            if (!confirm("Are you sure you want to change this user's role to " + role + "?")) {
                e.preventDefault();
            }
        });
    });

    var workspaceStatusForms = document.querySelectorAll(".admin-workspace-status-form");

    workspaceStatusForms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            var workspaceId = form.querySelector("input[name='workspace_id']").value;
            var status = form.querySelector("select[name='is_active']").value;

            if (workspaceId === "" || isNaN(workspaceId)) {
                alert("Invalid workspace selected.");
                e.preventDefault();
                return;
            }

            if (status !== "0" && status !== "1") {
                alert("Please select a valid workspace status.");
                e.preventDefault();
                return;
            }

            var statusText = status === "1" ? "activate" : "deactivate";

            if (!confirm("Are you sure you want to " + statusText + " this workspace?")) {
                e.preventDefault();
            }
        });
    });

    var workspaceDeleteForms = document.querySelectorAll(".admin-workspace-delete-form");

    workspaceDeleteForms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            var workspaceId = form.querySelector("input[name='workspace_id']").value;

            if (workspaceId === "" || isNaN(workspaceId)) {
                alert("Invalid workspace selected.");
                e.preventDefault();
                return;
            }

            if (!confirm("Are you sure you want to delete this workspace? This action cannot be undone.")) {
                e.preventDefault();
            }
        });
    });

    var workspaceMemberRemoveForms = document.querySelectorAll(".admin-workspace-member-remove-form");

    workspaceMemberRemoveForms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            var workspaceMemberId = form.querySelector("input[name='workspace_member_id']").value;
            var workspaceId = form.querySelector("input[name='workspace_id']").value;

            if (workspaceMemberId === "" || isNaN(workspaceMemberId)) {
                alert("Invalid workspace member selected.");
                e.preventDefault();
                return;
            }

            if (workspaceId === "" || isNaN(workspaceId)) {
                alert("Invalid workspace selected.");
                e.preventDefault();
                return;
            }

            if (!confirm("Are you sure you want to remove this member from the workspace?")) {
                e.preventDefault();
            }
        });
    });
});