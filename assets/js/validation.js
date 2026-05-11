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