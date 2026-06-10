$(document).ready(function() {
    setInterval(() => {
        $('#digital-clock').text(new Date().toLocaleTimeString());
    }, 1000);

    function drawAnalogClock() {
        const canvas = document.getElementById("analog-canvas");
        if (!canvas) return;
        const ctx = canvas.getContext("2d");
        let radius = canvas.height / 2;
        ctx.translate(radius, radius);
        radius = radius * 0.90;

        function draw() {
            ctx.beginPath();
            ctx.arc(0, 0, radius, 0, 2 * Math.PI);
            ctx.fillStyle = $('#main-body').hasClass('dark-mode') ? '#333' : 'white';
            ctx.fill();
            ctx.strokeStyle = $('#main-body').hasClass('dark-mode') ? '#fff' : '#333';
            ctx.lineWidth = 4;
            ctx.stroke();

            const now = new Date();
            let hour = now.getHours() % 12;
            let minute = now.getMinutes();
            let second = now.getSeconds();

            hour = (hour*Math.PI/6) + (minute*Math.PI/(6*60)) + (second*Math.PI/(360*60));
            drawHand(ctx, hour, radius*0.5, 4);
            minute = (minute*Math.PI/30) + (second*Math.PI/(30*60));
            drawHand(ctx, minute, radius*0.8, 3);
            second = (second*Math.PI/30);
            drawHand(ctx, second, radius*0.9, 1, 'red');
        }

        function drawHand(ctx, pos, length, width, color) {
            ctx.beginPath();
            ctx.lineWidth = width;
            ctx.lineCap = "round";
            ctx.strokeStyle = color || ($('#main-body').hasClass('dark-mode') ? '#fff' : '#333');
            ctx.moveTo(0,0);
            ctx.rotate(pos);
            ctx.lineTo(0, -length);
            ctx.stroke();
            ctx.rotate(-pos);
        }
        setInterval(draw, 1000);
        draw();
    }
    drawAnalogClock();

    $('#show-email-btn').click(function() {
        $('#email-address').toggle();
    });

    $('#dark-mode-btn').click(function() {
        $('#main-body').toggleClass('dark-mode');
    });

    function fetchJoke() {
        $.ajax({
            url: "https://v2.jokeapi.dev/joke/Any",
            success: (data) => {
                let joke = data.type === "single" ? data.joke : `${data.setup} ... ${data.delivery}`;
                $('#joke-container').text(joke);
            },
            error: () => {
                $('#joke-container').text("API Error.");
            }
        });
    }
    setInterval(fetchJoke, 60000); 
    fetchJoke();

    function fetchDog() {
        $.ajax({
            url: "https://dog.ceo/api/breeds/image/random",
            success: (data) => {
                $('#random-dog').attr('src', data.message).show();
            }
        });
    }
    fetchDog();

    function checkCookie() {
        let lastVisit = Cookies.get('lastVisit');
        let now = new Date().toLocaleString();
        if (!lastVisit) {
            alert("Welcome to my homepage for the first time!");
        } else {
            alert("Welcome back! Your last visit was " + lastVisit);
        }
        Cookies.set('lastVisit', now, { expires: 365, path: '/' });
    }
    setTimeout(checkCookie, 500); 
});