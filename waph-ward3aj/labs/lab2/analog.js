function setDate() {
    const now = new Date();
    const seconds = now.getSeconds();
    const minutes = now.getMinutes();
    const hours = now.getHours();

    document.getElementById('sec').style.transform = `rotate(${((seconds/60) * 360) + 90}deg)`;
    document.getElementById('min').style.transform = `rotate(${((minutes/60) * 360) + 90}deg)`;
    document.getElementById('hour').style.transform = `rotate(${((hours/12) * 360) + 90}deg)`;
}
setInterval(setDate, 1000);
