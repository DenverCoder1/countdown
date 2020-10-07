function countdown(t) {
  resizeCountdowns();
  countdownDate = new Date(t).getTime();
  setTimeout(resizeCountdowns, 1000);
  var countdownUpdate = setInterval(function () {
    var now = new Date().getTime();
    var distance = countdownDate - now;
    if (distance < 0) {
      clearInterval(countdownUpdate);
      days = 0;
      hours = 0;
      minutes = 0;
      seconds = 0;
      var el = document.querySelectorAll(".l");
      var ed = document.querySelectorAll(".d");
      for (var i = 0; i < 4; i++) {
        el[i].style.color = "#ff2b2b";
        ed[i].style.color = "#ff2b2b";
      }
    } else {
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    }
    document.querySelector("#days").innerHTML = days;
    document.querySelector("#hours").innerHTML = hours;
    document.querySelector("#minutes").innerHTML = minutes;
    document.querySelector("#seconds").innerHTML = seconds;
    days != 1
      ? (document.querySelector("#daysLabel").innerHTML = "DAYS")
      : (document.querySelector("#daysLabel").innerHTML = "DAY");
    hours != 1
      ? (document.querySelector("#hoursLabel").innerHTML = "HOURS")
      : (document.querySelector("#hoursLabel").innerHTML = "HOUR");
    minutes != 1
      ? (document.querySelector("#minutesLabel").innerHTML = "MINUTES")
      : (document.querySelector("#minutesLabel").innerHTML = "MINUTE");
    seconds != 1
      ? (document.querySelector("#secondsLabel").innerHTML = "SECONDS")
      : (document.querySelector("#secondsLabel").innerHTML = "SECOND");
  }, 1000);
}

function resizeCountdowns() {
  //resize text
  if (document.querySelector(".cd")) {
    var cdWidth = document.querySelectorAll(".cd")[0].clientWidth;
    document.body.style.fontSize = cdWidth / 5.5;
    for (var i = 0; i < 4; i++) {
      document.querySelectorAll(".d")[i].style.fontSize = cdWidth / 1.5;
      document.querySelectorAll(".l")[i].style.fontSize = cdWidth / 5.5;
    }
  }
  //resize body
  document.body.style.height = document.querySelector("#content").clientHeight;
}

window.addEventListener("resize", function () {
    resizeCountdowns();
  }, true);
