function toggleEmail() {
    var email = document.getElementById("email");
    email.style.display = (email.style.display === "none") ? "block" : "none";
}

function sendAjax() {
    var input = document.getElementById("ajax-input").value;
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("ajax-result").innerHTML = this.responseText;
        }
    };
    
    xhttp.open("GET", "/echo.php?data=" + encodeURIComponent(input), true);
    xhttp.send();
}
