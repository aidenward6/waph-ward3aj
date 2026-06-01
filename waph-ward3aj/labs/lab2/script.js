function toggleEmail() {
    var email = document.getElementById("email");
    email.style.display = (email.style.display === "none") ? "block" : "none";
}

function sendAjax() {
    var input = document.getElementById("ajax-input").value;
    var xhttp = new XMLHttpRequest();
    
    // Define what to do when the server responds
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Display the response from echo.php inside your <div>
            document.getElementById("ajax-result").innerHTML = this.responseText;
        }
    };
    
    // Construct the GET request
    xhttp.open("GET", "/echo.php?data=" + encodeURIComponent(input), true);
    xhttp.send();
}
