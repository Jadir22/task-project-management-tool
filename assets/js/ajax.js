document.addEventListener("DOMContentLoaded", function () {
    var statusSelects = document.querySelectorAll(".task-status-select");

    statusSelects.forEach(function (select) {
        select.addEventListener("change", function () {
            var taskId = this.getAttribute("data-task-id");
            var newStatus = this.value;
            var messageBox = document.getElementById("task-status-message-" + taskId);

            messageBox.innerText = "Updating...";

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../../api/update_task_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);

                        if (response.success) {
                            messageBox.style.color = "green";
                            messageBox.innerText = response.message;
                        } else {
                            messageBox.style.color = "red";
                            messageBox.innerText = response.message;
                        }
                    } catch (e) {
                        messageBox.style.color = "red";
                        messageBox.innerText = "Invalid server response.";
                    }
                } else {
                    messageBox.style.color = "red";
                    messageBox.innerText = "Request failed.";
                }
            };

            xhr.send("task_id=" + encodeURIComponent(taskId) + "&status=" + encodeURIComponent(newStatus));
        });
    });
});