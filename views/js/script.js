document.getElementById("total-users-box").addEventListener("click", function() {
    
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../controllers/fetchUsers.php", true); 
    xhr.onload = function() {
        if (xhr.status === 200) {
            const users = JSON.parse(xhr.responseText);
            const userListTable = document.getElementById("userListTable");

            userListTable.innerHTML = "<tr><th>ID</th><th>Name</th></tr>";

            users.forEach(function(user) {
                const row = userListTable.insertRow();
                const idCell = row.insertCell(0);
                const nameCell = row.insertCell(1);

                idCell.textContent = user.userId; 
                nameCell.textContent = user.fullName; 
            });

            document.getElementById("userModal").style.display = "block";
        } else {
            alert("Failed to fetch user data.");
        }
    };
    xhr.send();
});

document.querySelector(".close").addEventListener("click", function() {
    document.getElementById("userModal").style.display = "none";
});


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function acceptOrder(orderId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/accept.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert("Order accepted successfully!");
            location.reload(); 
        } else {
            alert("Error accepting order.");
        }
    };
    xhr.send("orderId=" + orderId);
}

function rejectOrder(orderId) {
    const note = document.getElementById('note-' + orderId).value;
    if (note === "") {
        alert("Please provide a rejection note.");
        return;
    }
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../controllers/reject.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert("Order rejected successfully!");
            location.reload(); 
        } else {
            alert("Error rejecting order.");
        }
    };
    xhr.send("orderId=" + orderId + "&note=" + encodeURIComponent(note));
}