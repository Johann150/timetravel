# TimeTravel Dispatcher Project

Dies ist ein ehemaliges Schulprojekt zum Erlernen von Latein; _mit Spaß!_<br>
Es entstand im Rahmen des Unterrichts und wurde nun hier veröffentlicht, in der Hoffnung, dass es noch jemand sinnvoll nutzen wird. Dieses Projekt wird nicht mehr aktiv weiterentwickelt; natürlich werde ich trotzdem versuchen, gemeldete Fehler zu beheben!

Dahinter steckt die Idee, dass Zeitreisen möglich sind. Als Konsequenz gibt es Dienstleister, die diese Zeitreisen organisieren und auch sogenannte **Dispatcher**, welche den Zeitreisenden über die Sprachbarriere helfen sollen. Denn es möchte ja nicht jeder, der nur einmal Julius Caesar sehen möchte, eine Latein-Prüfung ablegen!

Und in die Rolle eines solchen Dispatchers kann man nun schlüpfen.

## Installation
Für dieses Projekt benötigt man einen MySQL- u. PHP-fähigen Server, z.B. [XAMPP](https://www.apachefriends.org/de/index.html).
1. In das Server-Verzeichnis (bei XAMPP ist es `htdocs`) alle Dateien kopieren, bis auf `init.sql`
2. Diese Datei muss in die MySQL-Datenbank importiert werden. _(Geht am besten mit einem Werkzeug wie phpMyAdmin, das schon mit XAMPP installiert ist.)_
3. Und dann kann es losgehen! **Viel Spaß!**

## Erweiterbarkeit
Es ist prinzipiell möglich, das _TimeTravel Dispatcher Projekt_ **auch für eine andere Sprache** wie z.B. Griechisch zu nutzen. Dazu müssten allerdings die entsprechenden Vokabeln eingegeben und die Fragen geändert werden.

Es ist natürlich auch möglich, das _TimeTravel Dispatcher Projekt_ für eine moderne(re) Sprache zu nutzen, allerdings ist die grundsätzliche Idee in diesem Fall wahrscheinlich nicht passend und es müsste eine neue Idee erdacht werden. Aber wie gesagt: **Es ist möglich**, aber mit etwas mehr Aufwand verbunden, als auf eine andere altertümliche Sprache unzusatteln.

## Weitere Informationen
Weitere Informationen zum Projekt finden sich unter [Über - Timetravel Dispatcher Project](http://timetravel.bplaced.de/about/) oder auf [Behance](https://www.behance.net/gallery/54349201/TimeTravel-Dispatcher-Project).

Außerdem kann unter <https://timetravel.bplaced.com/> eine laufende Demo-Version genutzt werden.

# Daten-Formate
## Fragen

Alle Fragen sind in der Datei `questions.csv` enthalten. Dabei gilt das generelle Format

```
<Widget-Typ>;<Betreff>;<Inhalt>;[<richtige Antwort>]
```

Dabei ist die richtige Antwort also optional, jedoch nicht das Semikolon.
Innerhalb des Betreffs, des Inhaltes und der Antwort können folgende Plattzhalter genutzt werden, die dann vom Programm entsprechend ersetzt werden:<br>
(für genauere Referenzzwecke siehe die Funktion `process` in `data.php`)

Platzhalter|Ersetzung
---|---
`$n`|ein **N**omen <sup>(1)</sup>
`$v`|ein **Verb** <sup>(1)</sup>
`$s`|ein **S**atz bzw. **S**pruch <sup>(1)</sup>
`$t`|die entsprechende deutsche Übersetzung (**t**ranslation) zu `$n`, `$v` oder `$s`.
`$f`|der Name einer zu `$n`, `$v` oder `$s` vorhandenen **F**orm <sup>(3)</sup>
`$e`|die gebildete Form von `$n`, `$v` oder `$s`, die von `$f` angegeben ist <sup>(3)</sup>
`$p`|ein zufälliger **P**ersonenname <sup>(2)</sup>

<sup>(1)</sup> auf Latein, wird zufällig aus der Liste von entsprechenden vorhandenen Elementen ausgewählt.<br>
<sup>(2)</sup> wird aus den Namenslisten in `names` generiert, weibliche u. männliche Namen möglich<br>
<sup>(3)</sup> wird aus dem Feld `forms` in der Tabelle `latin` erstellt

Da diese Platzhalter alle mit einem Dollarzeichen beginnen, wird ein Dollarzeichen, welches nicht einen der Platzhalter markiert, nicht ausgegeben werden.

Ein kleiner Trick ist noch, dass durch eine Großschreibung der Platzhalter eine Neugenerierung geschieht (es gibt allerdings kein `$T`, es sollte nur eine Übersetzung geben).<br>
Dabei ist zu beachten, dass die Zeile in der CSV-Datei von links nach rechts verarbeitet wird. Somit bezieht sich beispielsweise ein `$t`, `$f` oder `$e` jeweils auf das letzte links davon verwendete `$n`, `$v` oder `$s` (oder natürlich eine großgeschriebene Variante). Eine Ausnahme bildet der Anfang der Zeile, an welchem das erste folgende `$n`, `$v` oder `$s` als Bezug gilt.

## Antworten

Zu den Fragen gibt es meist entsprechende Antworten. Dabei kann eine Frage natürlich richtig oder falsch beantwortet werden und sind dementsprechend in den Dateien `right_answers.csv` und `wrong_answers.csv` gespeichert.<br>
In diesen alle Platzhalter wie oben und zusätzlich der Platzhalter `$a` (richtige **A**ntwort) verwendet werden.

Auch hier sind wieder die Großschreibungs-Varianten der Platzhalter möglich, jedoch nicht für `$t` oder `$a`. Diese sollten allerdings nicht verwendet werden, da sich die Platzhalter in der falschen Antwort auf die evtl. neu generierten Platzhalter in der richtigen Antwort beziehen.

## Formen von Vokabeln

Die Formen der Vokabeln werden in JSON angegeben, und zwar als ein einfaches Objekt für jede Vokabel. Dabei ist der Schlüssel einer Eigenschaft jeweils der Name der Form (`$f`) und der Wert der Eigenschaft die entsprechende gebildete Form (`$e`). Die Anzahl der Eigenschaften bzw. Formen ist nur praktisch-technisch durch das Datenbanksystem eingeschränkt.
