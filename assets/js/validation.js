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