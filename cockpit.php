<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>TimeTravel Dispatcher Project</title>
		<link rel="icon" type="img/png" href="favicon.png"/>
		<link rel="stylesheet" type="text/css" href="cockpit.css"/>
		<script>
		<?php
		if(isset($_GET['k'])){?>
			var t=2;
		<?php }elseif(isset($_GET['v'])){?>
			var t=0.5;
		<?php }else{?>
			var t=1;
		<?php } ?>
		</script>
		<script type="text/javascript" src="cockpit-style.js"></script>
	</head>
	<body>
		<div id="hl">TimeTravel Dispatcher Project</div><div id="hlb">Latein</div>
		<div id="msg"><div class="cls"></div></div>
		<div id="inbox" class="mitem" onclick="frame(this)" data-frame="false"><div class="top"></div><div class="right"></div><div class="bottom"></div><div class="left"></div><img src="icons/email.svg"><div class="line"></div></div>
		<div id="done" class="mitem" onclick="frame(this)" data-frame="false"><div class="top"></div><div class="right"></div><div class="bottom"></div><div class="left"></div><img src="icons/question.svg"><div class="line"></div></div>
		<div id="user" class="mitem" onclick="frame(this)" data-frame="false"><div class="top"></div><div class="right"></div><div class="bottom"></div><div class="left"></div><img src="icons/customer-service-1.svg"><div class="line"></div></div>
		<div id="answer" class="mitem" onclick="frame(this)" data-frame="false"><div class="top"></div><div class="right"></div><div class="bottom"></div><div class="left"></div><img src="icons/customer-service-7.svg"><div class="line"></div></div>
		<div id="help" class="mitem" onclick="frame(this)" data-frame="false"><div class="top"></div><div class="right"></div><div class="bottom"></div><div class="left"></div><img src="icons/help.svg"><div class="line"></div></div>
		<div id="logout" class="mitem" onclick="frame(this)" data-frame="false"><div class="top"></div><div class="right"></div><div class="bottom"></div><div class="left"></div><img src="icons/logout.svg"></div>
		<div id="left">
			<div class="empty">(leer)</div>
			<div id="containermessage" class="lcont"></div>
			<div id="containerdone" class="lcont"></div>
			<div class="ritem user">
				<strong>Information</strong>
					<p>Das TimeTravel Dispatcher Project ist ein Projekt der Institution TimeTravel&trade;.</p><br>
					<p>Detaillierte Informationen über dieses Project und TimeTravel findest du <a href="/about">hier</a>.
			</div>
		</div>
		<div id="right">
			<div class="empty">(leer)</div>
			<div class="ritem help">
				<p>Toll, dass du dich als Freiwilliger Dispatcher für unseren Zeitreise-Service angemeldet hast.<br>Aber du weißt nicht mehr weiter...<br>
					Keine Sorge -  wir helfen dir:
				</p>
				<p>
					Wenn alles funktioniert, siehst du vor dir eine Benutzeroberﬂäche mit sechs Toolbuttons und zwei großen Feldern.
				</p>
				<p>
					Deine Aufgabe ist es, Zeitreisenden zwischen 753 v.Chr. und 1700 Fragen zur Lateinischen Sprache zu beantworten.
				</p>
				<p>
					Eingegangene Fragen ﬁndest du mit dem Tool oben Links - ein Symbol mit einem Brief. Wenn du dieses Tool anklickst öffnet sich im linken Feld eine Spalte mit all deinen unbeantworteten Fragen von TimeTravel™ Mitgliedern. Im rechten Feld öffnet sich automatisch und synchron zum Fragen-Tool, das Antworten-Tool, was sich rechts-oben beﬁndet - eine Person mit einem Headset. Nun kannst du die eingegangen Fragen im linken Feld öffnen und im rechten Feld beantworten.
					Klicke dann auf Senden und verschicke deine Antwort.<br>
					Wenn du mit einer Frage nicht weiter weist lass sie erst einmal in deinem Posteingang. Vielleicht fällt dir die Antwort später noch ein. Leere Antworten kannst du nicht absenden.
				</p>
				<p>
					Wenn du einen Überblick über all deine Beantworteten Fragen haben willst, nutze das mittlere Tool auf der linken Seite. Ihr kannst du alle Antworten und Fragen einsehen.
				</p>
				<p>
					Wenn du eine Frage optimal für den Zeitreisenden beantwortet hast steigt dein Quality-Score in der Fortschritts-Anzeige unten in der Mitte. Wenn die Anzeige voll ist, hast du das Zeug zu einem echten Latein-Supporter in unserer TimeTravel™ Community.
				</p>
				<p>
					Mit dem untersten Tool auf der linken Seite kannst du weitere Features aufrufen, die dir eventuell helfen können. Später soll hier mal dein eigenes Dispatcher-Proﬁl erscheinen.
				</p>
				<p>
					Auf der rechten Seite hast du noch die Möglichkeit zum Support zu gelangen. Vermutlich hast die diese Funktion auch genutzt, um diese Hilfestellung hier zu lesen.
				</p>
				<p>
					Mit dem untersten Tool auf der rechten Seite kannst du dich von deine Terminal abmelden. Aber Achtung: Dein gesamter Quality-Score wird gelöscht und du musst später noch einmal von Vorne anfangen. Nur Latein-Supporter der TimeTravel™ Community können ihren Aufgaben-Stand abspeichern.
				</p>
				<p>
					Wenn du weitere Fragen hast, wende dich bitte an unser 24/7-Hilfe-Team per Mail:<br>
					<strong><a href="mailto:timetravel@gmx-topmail.de">timetravel@gmx-topmail.de</a></strong>
				</p>
				<p>
					Danke für deine Unterstützung der TimeTravel™ Community.<br>
				</p>
				<p>
					Ohne diese Menschen wäre TimeTravel undenkbar gewesen:<br>
					Johann Galle<br>
					<i>Programmierung, Umsetzung, Datenverwaltung</i><br>
					Marc Eric Mitzscherling<br>
					<i>Idee, Konzept, Design</i><br>
					Projekt im Rahmen eines Latein-Projektes.<br>
					Die oben genanten Verantwortlichen sind erreichbar unter:<br>
					<a href="mailto:timetravel@gmx-topmail.de">timetravel@gmx-topmail.de</a>
				</p>
			</div>
		</div>
		<img id="scoreimg" src="icons/success.svg">
		<div id="scorewrap"><div id="score"></div><div id="scorecnt">0%</div></div>
	</body>
</html>
