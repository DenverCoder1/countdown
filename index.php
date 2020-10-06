<?php

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
}
else {
	$msg = "Countdown to Deadline";
}
if (isset($_GET['tz'])) {
	$tz = (float) ($_GET['tz']);
	$tz_unset = 0;
}
else {
	$tz = 0;
	$tz_unset = 1;
}
if (isset($_GET['font'])) {
	$font = $_GET['font'];
}
else {
	$font = "Open Sans";
}
if (isset($_GET['bg'])) {
	$bg = $_GET['bg'];
	if (strlen($_GET['bg']) == 0) {
		$bg = "#dddddd";
	}
	$bgCss = $bg;
	if ($_GET['bg'][0] != "#" && strlen($_GET['bg']) != 4 && strlen($_GET['bg']) != 7) {
		$bgCss = "url(\"" . $_GET['bg'] . "\")";
	}
}
else {
	$bg = "#dddddd";
	$bgCss = $bg;
}
?>
<html>

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-37346108-11"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-37346108-11');
	</script>

	<title><?= $msg; ?></title>

	<link href="https://fonts.googleapis.com/css?family=<?= $font; ?>" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" type="image/png" href="favicon.png" />
	<script src="dayjs.min.js"></script>
	<link rel="stylesheet" href="countdownStyle.css" />
	<style>
		html {
			background-color: #dddddd;
			background: <?= $bgCss; ?>;
			background-repeat: repeat;
			background-size: auto 100%;
			background-position: center top;
			background-attachment: fixed;
		}

		body,
		input[type="text"],
		input[type="number"],
		input[type="date"],
		input[type="time"],
		input[type="button"] {
			font-family: "<?= $font; ?>", "Open Sans", "Roboto", sans-serif;
		}
	</style>
</head>

<body>
	<?php
	if ((isset($_GET['d'])) and (preg_match("/\d{8}T\d{4}/", $_GET['d'])) and (!isset($_GET['create']))) {
		$cdDate = preg_replace('/(\d{4})(\d{2})(\d{2})T(\d{2})(\d{2})/', '$1/$2/$3 $4:$5', $_GET['d']);
		$nowDT = strtotime(gmdate("Y-m-d H:i:s"));
		$cdDT = strtotime($cdDate) - ($tz * 60 * 60);
		$distance = ($cdDT - $nowDT - 2) * 1000;
		$home_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if ($distance > 0) {
			$days = floor($distance / (1000 * 60 * 60 * 24));
			$remaining = $distance / (1000 * 60 * 60 * 24) - $days;
			$hours = floor($remaining * 24);
			$remaining = $remaining * 24 - $hours;
			$minutes = floor($remaining * 60);
			$remaining = $remaining * 60 - $minutes;
			$seconds = floor($remaining * 60);
		} else {
			$days = 0;
			$hours = 0;
			$minutes = 0;
			$seconds = 0;
		}
		echo "
	<div id='content'>
		<h2>" . $msg . "</h2>

		<div class='cd'>
			<p id='days' class='d'>" . $days . "</p>
			<p id='daysLabel' class='l'>DAY" . ($days != 1 ? "S" : "") . "</p>
		</div>
		<div class='cd'>
			<p id='hours' class='d'>" . $hours . "</p>
			<p id='hoursLabel' class='l'>HOUR" . ($hours != 1 ? "S" : "") . "</p></div>
		<div class='cd'>
			<p id='minutes' class='d'>" . $minutes . "</p>
			<p id='minutesLabel' class='l'>MINUTE" . ($minutes != 1 ? "S" : "") . "</p>
		</div>
		<div class='cd'>
			<p id='seconds' class='d'>" . $seconds . "</p>
			<p id='secondsLabel' class='l'>SECOND" . ($seconds != 1 ? "S" : "") . "</p>
		</div>

		<p id='date'>..</p>

		<p id='timezone'>..</p>

		<input type='button' onclick='changeTimezone();' value='Change Timezone' id='changeTzButton'>
	</div>
	<a href='" . $home_link . ((strpos($home_link, '?') !== false) ? "&create" : "?create") . "' class='home'>+</a>";
	} else {
		$cdDate = "unset";
		if (isset($_GET['d']) and preg_match("/^(\d{4})(\d{2})(\d{2})T(\d{2})(\d{2})$/", $_GET['d'])) {
			$datetime = explode("T",$_GET["d"],2);
			$date = preg_replace("/^(\d{4})(\d{2})(\d{2})$/", "$1-$2-$3", $datetime[0]);
			$time = preg_replace("/^(\d{2})(\d{2})$/", "$1:$2", $datetime[1]);
		}
		else {
			$date = date("Y-m-d");
			$time = "23:59";
		}
		echo "
	<div id='content' style='text-align:left; font-size: 130%;'>
		<style>
		input {
			display: inline;
			margin: 8px 0 8px 8px;
			left: 0px !important;
		}
		@media only screen and (max-width: 565px) {
			input {
				display: block !important;
				margin: 14px 0 10px 0 !important;
			}
			#content br {
				display: none !important;
			}
		}
		</style>
		<script>
		function createCountdown() {
			var d = new Date(document.querySelector('#d').value + ' ' +document.querySelector('#t').value);
			d = dayjs(d).format('YYYYMMDDTHHmm');
			var utc = document.querySelector('#utcInput').value;
			var msg = document.querySelector('#msg').value;
			var font = document.querySelector('#font').value;
			var bg = document.querySelector('#bg').value;
			var newUrl = window.location.origin + window.location.pathname + '?d=' + d;
			if (utc != '') { newUrl += '&tz='+encodeURIComponent(utc); }
			if (msg != '') { newUrl += '&msg='+encodeURIComponent(msg); }
			if (font != '') { newUrl += '&font='+encodeURIComponent(font); }
			if (bg != '') { newUrl += '&bg='+encodeURIComponent(bg); }
			window.location.href = newUrl.replace(/ +/g,'+');
		}
		var tzValue = '';
		function checkTzValue(input){
			if (input.value.match(/^[+-](\d+(\.)?(\d+)?)?$/) == null && input.value != '') {
				input.value = tzValue;
			} else {
				tzValue = input.value;
			}
		}
		</script>
		<h2 style='font-size: 35px;margin-bottom: 17px;padding: 0;'>Create a Countdown</h2>
		Date: <input type='date' value='" . $date ."' id='d'>
		<br>
		Time: <input type='time' value='" . $time ."' id='t'>
		<br>
		UTC Offset: <input type='text' onkeyup='checkTzValue(this);' value='" . ($tz >= 0 ? "+$tz" : "$tz") . "' id='utcInput'>
		<br>
		Message: <input type='text' value='" . $msg . "' id='msg'>
		<br>
		Font (from Google Fonts): <input type='text' value='" . $font . "' id='font'>
		<br>
		Background image URL or hex code: <input type='text' value='" . $bg . "' id='bg' onkeyup='updateBackground(this);'>
		<br><br>
		<input type='button' onclick='createCountdown()' value='Create Countdown'>
	</div>";
	}
	?>

	<script src="countdown.js"></script>

	<script>
		function setLocalDate() {
			var countdownDate = new Date("<?= $cdDate; ?>");
			var countdownTimezone = (!<?= $tz_unset ?>) ? <?= $tz; ?> : (new Date().getTimezoneOffset()) / (-60);
			var hOffset = timezoneDiff - countdownTimezone;
			countdownDate.setTime(countdownDate.getTime() + (hOffset * 60 * 60 * 1000));
			document.querySelector("#date").innerHTML = "Countdown to " + dayjs(countdownDate).format("dddd, MMM D, YYYY h:mm A");
			return countdownDate;
		}

		function getTimezone() {
			// if valid date
			if ("<?= $cdDate; ?>" != "unset") {
				var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
				timezoneDiff = (new Date().getTimezoneOffset()) / (-60);
				countdownDate = setLocalDate();
				tz = tz + checkDST();
				document.querySelector("#timezone").innerHTML = timezoneDiff >= 0 ? "Timezone: " + tz + " (UTC&#x2060;+" + timezoneDiff + ")." : "Timezone: " + tz + " (UTC&#x2060;" + timezoneDiff + ").";
				countdown(countdownDate);
			} else {
				if (<?= $tz_unset; ?>) {
					var tz = new Date().getTimezoneOffset() / (-60);
					var tzText = (tz >= 0) ? "+" + tz : tz;
					document.querySelector("#utcInput").value = tzText;
					tzValue = tzText;
				}
				resizeCountdowns();
			}
		}

		function changeTimezone() {
			if (document.body.contains(document.querySelector("#utcInput"))) {
				timezoneDiff = document.querySelector("#utcInput").value;
				if (timezoneDiff == "") {
					timezoneDiff = 0;
				} else {
					timezoneDiff = parseFloat(timezoneDiff);
				}
				if (isNaN(timezoneDiff)) {
					alert("Invalid Timezone. Please enter a number.")
				} else {
					document.querySelector("#changeTzButton").value = "Change Timezone";
					document.getElementById("timezone").innerHTML = timezoneDiff >= 0 ?
						"Timezone: " + "UTC&#x2060;+" + timezoneDiff + "." :
						"Timezone: UTC&#x2060;" + timezoneDiff + ".";
					setLocalDate();
				}
			} else {
				timezoneDiffText = timezoneDiff >= 0 ? "+" + timezoneDiff : timezoneDiff;
				document.querySelector("#timezone").innerHTML = "Timezone: UTC" + "<input type='text' value='" + timezoneDiffText + "' id='utcInput'></input>";
				document.querySelector("#changeTzButton").value = "Set Timezone";
				document.querySelector("#utcInput").focus();
				document.querySelector("#utcInput").select();
				document.querySelector("#utcInput").addEventListener('keyup', function(e) {
					if (e.keyCode == 13 || e.which == 13) {
						changeTimezone();
					}
				});
			}
		}

		function checkDST() {
			var today = new Date();
			return today.dst() ? " DST" : "";
		}

		Date.prototype.stdTimezoneOffset = function() {
			var jan = new Date(this.getFullYear(), 0, 1);
			var jul = new Date(this.getFullYear(), 6, 1);
			return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
		}

		Date.prototype.dst = function() {
			return this.getTimezoneOffset() < this.stdTimezoneOffset();
		}

		function updateBackground(e) {
			var value = e.value;
			var html = document.querySelector("html");
			if (/^#([0-9A-F]{3}|[0-9A-F]{6})$/gi.test(value)) {
				html.style.background = value;
			} else if (/^http/gi.test(value)) {
				html.style.background = "url(" + value + ")";
				html.style.backgroundRepeat = "repeat";
				html.style.backgroundSize = "auto 100%";
				html.style.backgroundPosition = "center top";
				html.style.backgroundAttachment = "fixed";
			}
		}

		window.onload = function() {
			getTimezone();
		}
	</script>

</body>

</html>
