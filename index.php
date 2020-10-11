<?php

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
} else {
	$msg = "Countdown to Deadline";
}
if (isset($_GET['tz'])) {
	$tz = (float) ($_GET['tz']);
	$tz_unset = 0;
} else {
	$tz = 0;
	$tz_unset = 1;
}
if (isset($_GET['font'])) {
	$font = $_GET['font'];
} else {
	$font = "Open Sans";
}
if (isset($_GET['fontColor'])) {
	$fontColor = $_GET['fontColor'];
}
else {
	$fontColor = "#00796b";
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
} else {
	$bg = "#dddddd";
	$bgCss = $bg;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

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

	<title><?php echo $msg; ?></title>

	<link href="https://fonts.googleapis.com/css?family=<?php echo $font; ?>" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" type="image/png" href="favicon.png" />
	<script src="dayjs.min.js"></script>
	<link rel="stylesheet" href="countdownStyle.css" />
	<style>
		html {
			background-color: #dddddd;
			background: <?php echo $bgCss; ?>;
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
			font-family: "<?php echo $font; ?>", "Open Sans", "Roboto", sans-serif;
		}
		.cd p {
			color: <?php echo $fontColor; ?>;
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
			$datetime = explode("T", $_GET["d"], 2);
			$date = preg_replace("/^(\d{4})(\d{2})(\d{2})$/", "$1-$2-$3", $datetime[0]);
			$time = preg_replace("/^(\d{2})(\d{2})$/", "$1:$2", $datetime[1]);
		} else {
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
				margin: 14px 0 10px 0 !important;
			}
			
		}
		</style>
		<script>
		function createCountdown() {
			var d = new Date(
			  document.querySelector('#d').value +
				' ' +
				document.querySelector('#t').value
			);
			d = dayjs(d).format('YYYYMMDDTHHmm');
			var utc = document.querySelector('#utcInput').value;
			var parts = utc.split(':');
			if (parts.length == 2) {
			  var hours = parseInt(parts[0]);
			  var minutes = parseInt(parts[1]);
			  utc = hours + minutes / 60;
			}
			var msg = document.querySelector('#msg').value;
			var font = document.querySelector('#font').value;
			var fontColor = document.querySelector('#fontColor').value;
			var bg = document.querySelector('#bg').value;
			var newUrl = window.location.origin + window.location.pathname + '?d=' + d;
			if (utc != '') {
			  newUrl += '&tz=' + encodeURIComponent(utc);
			}
			if (msg != '') {
			  newUrl += '&msg=' + encodeURIComponent(msg);
			}
			if (font != '') {
			  newUrl += '&font=' + encodeURIComponent(font);
			}
			if (fontColor != '') {
			  newUrl += '&fontColor=' + encodeURIComponent(fontColor);
			}			
			if (bg != '') {
			  newUrl += '&bg=' + encodeURIComponent(bg);
			}
			window.location.href = newUrl.replace(/ +/g, '+');
		  }		  
		</script>
		<h2 style='font-size: 35px;margin-bottom: 17px;padding: 0;'>Create a Countdown</h2>

		<div>
			Date: <input type='date' value='" . $date . "' id='d'>
		</div>
	
		<div>
			Time: <input type='time' value='" . $time . "' id='t'>
		</div>
	
		<div>
			UTC Offset: <input type='text' onkeyup='checkTzValue(this, false);' onblur='checkTzValue(this, true);'
				value='" . ($tz >= 0 ? "+$tz" : "$tz") . "' id='utcInput'>
			<a href='#' class='tooltip'>?
				<span class='tooltiptext'>UTC Offset must be a valid timezone, for example -6 or +5:30.</span>
			</a>
		</div>
	
		<div>
			Message: <input type='text' value='" . $msg . "' id='msg'>
		</div>
	
		<div>
			Font (from Google Fonts): <input type='text' value='" . $font . "' id='font'>
		</div>

		<div>
			Font Color: <input type='text' value='" . $fontColor . "' id='fontColor'>
		</div>
	
		<div>
			Background image URL or hex code: <input type='text' value='" . $bg . "' id='bg' onkeyup='updateBackground(this);'>
			<a href='#' class='tooltip'>?
				<span class='tooltiptext'>A hex code is specified with #RRGGBB format, for example #ffffff or #000000.</span>
			</a>
		</div>
	
		<br>
		<input type='button' onclick='createCountdown()' value='Create Countdown'>
	</div>";
	}
	?>

	<script src="countdown.js"></script>

	<script>
		var tzHour = '';
		var tzMin = '';
		function checkTzValue(input, onblur) {
			var val = input.value.split(':');
		  
			var h = val[0].match(/^([+-](\d+)?)?$/);
			if (h == null) {
				input.value = tzHour;
				tzMin = '';
				return;
			}
		  
			h = parseInt(h[0]);
			if (isNaN(h) || (h <= 14 && h >= -12)) {
			  	tzHour = val[0];
			} else {
				input.value = tzHour;
				tzMin = '';
				return;
			}
		  
			if (val.length == 1) {
			  	return;
			} else if (Math.abs(h) != 9 && Math.abs(h) != 3 && !(h > 3 && h <= 6) && h != 8 && h != 10 && h != 12) {
				input.value = tzHour;
				return;
			}
		  
			var m = val[1];
			if (h == 8 || h == 12) {
				if (m.match(/^(4(5)?)?$/) != null) {
					tzMin = onblur ? '45' : m;
				}
			} else if (h == 5) {
				if (m.match(/^4(5)?$/) != null) {
					tzMin = onblur ? '45' : m;
				} else if (m.match(/^3(0)?$/) != null) {
					tzMin = onblur ? '30' : m;
				} else {
					tzMin = m.length == 2 ? m.match(/^\d/)[0] : '';
				}
			} else if (m.match(/^(3(0)?)?$/) != null) {
			  	tzMin = onblur ? '30' : m;
			} else if (onblur) {
			  	tzMin = '';
			}
		  
			if (onblur && tzMin != '30' && tzMin != '45') {
			  	input.value = tzHour;
			} else {
			  	input.value = tzHour + ':' + tzMin;
			}
		}

		function convertOffsetNotation(dotNotation) {
			//Convert . notation to : in the #utcInput
			var hours = Math.trunc(dotNotation);
			hours = (hours >= 0) ? "+" + hours : hours;
			var minutes = Math.trunc((Math.abs(dotNotation) % 1) * 60);
			document.querySelector("#utcInput").value = hours + (minutes == 0 ? '' : ":" + minutes);
			tzHours = hours;
			tzMin = (minutes == 0) ? '' : minutes;
			checkTzValue(document.querySelector("#utcInput"), true);
		}

		function setLocalDate() {
			var countdownDate = new Date("<?php echo $cdDate; ?>");
			var countdownTimezone = (!<?php echo $tz_unset ?>) ? <?php echo $tz; ?> : (new Date().getTimezoneOffset()) / (-60);
			var hOffset = timezoneDiff - countdownTimezone;
			countdownDate.setTime(countdownDate.getTime() + (hOffset * 60 * 60 * 1000));
			document.querySelector("#date").innerHTML = "Countdown to " + dayjs(countdownDate).format("dddd, MMM D, YYYY h:mm A");
			return countdownDate;
		}

		function getTimezone() {
			// if valid date
			if ("<?php echo $cdDate; ?>" != "unset") {
				var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
				timezoneDiff = (new Date().getTimezoneOffset()) / (-60);
				countdownDate = setLocalDate();
				tz = tz + checkDST();
				document.querySelector("#timezone").innerHTML = timezoneDiff >= 0 ? "Timezone: " + tz + " (UTC&#x2060;+" + timezoneDiff + ")." : "Timezone: " + tz + " (UTC&#x2060;" + timezoneDiff + ").";
				countdown(countdownDate);
			} else {
				var tz;
				if (<?php echo $tz_unset; ?>) {
					tz = new Date().getTimezoneOffset() / (-60);
				} else {
					tz = <?php echo $tz; ?>;
				}
				convertOffsetNotation(tz);
				resizeCountdowns();
			}
		}

		function changeTimezone() {
			if (document.body.contains(document.querySelector("#utcInput"))) {
				checkTzValue(document.querySelector("#utcInput"), true);
				document.querySelector("#changeTzButton").value = "Change Timezone";
				var input = document.querySelector("#utcInput").value.split(':');
				var h = parseInt(input[0]);
				if (isNaN(h)) { h = 0; }
				var min = '';
				if (input.length == 2) { min = input[1]; }
				document.getElementById("timezone").innerHTML = "Timezone: " + "UTC&#x2060;" + 
					(h >= 0 ? '+' + h : h) + (min == '' ? '' : ':' + min) + ".";
				timezoneDiff = h + (min == '' ? 0 : parseInt(min) / 60);
				setLocalDate();
			} else {
				document.querySelector("#timezone").innerHTML = "Timezone: UTC" + 
					"<input type='text' onkeyup='checkTzValue(this,false)' onblur='checkTzValue(this,true)' value='' id='utcInput'></input> " +
					"<a href='#' class='tooltip'>?" +
					"<span class='tooltiptext'>UTC-Offset must be a valid timezone for example -6 or +5:30.</span>\n" +
					"</a>";
				convertOffsetNotation(timezoneDiff);
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
