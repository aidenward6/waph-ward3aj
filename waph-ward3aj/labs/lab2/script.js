function toggleEmail() {
    var email = document.getElementById("email");
    email.style.display = (email.style.display === "none") ? "block" : "none";
}

function sendAjax() {
    var input = document.getElementById("ajax-input").value;
    
    // validate input is not empty
    if (!input || input.trim().length === 0) return;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // use textcontent to render as plain text, not html
            document.getElementById("ajax-result").textContent = this.responseText;
        }
    };
    
    xhttp.open("GET", "/echo.php?data=" + encodeURIComponent(input), true);
    xhttp.send();
}
