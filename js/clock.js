// Update the clock in 12 hour time (such as 9:52 PM)
function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var date = now.getDate();
    var monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
                     ];
    var month = monthNames[now.getMonth()]
    
    var merid = "am";                // Parse am and pm hours
    if (hours > 12) {
      hours -= 12;
      merid = "pm";
    } else if (hours == 0) {
      hours = 12;
    }

    // Desired format: 10:38 pm ~ 06/22/2014
    time = '<font size=20>' + hours + ':' + (minutes < 10 ? '0' + minutes : minutes) + ' '
      + merid + '</font>' + '<br>' + '<font size=6>' + month + ' ' + date + ', ' + now.getFullYear() + '</font>';

    document.getElementById('time').innerHTML = ["", time].join('');
    setTimeout(updateClock, 1000);
}

window.onload = updateClock;
