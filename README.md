wahl-plattform
==============

Hier findet sich der Code einer Internetplattform, die zur Kommunalwahl umgesetzt wurde, um mehr Informationen und Bürgernähe zu erreichen. Es lassen sich darin sowohl vorgegebene Fragen stellen als auch das Publikum das tun lassen, die dann von den Kandidaten beantwortet werden.

Scheuen Sie sich nicht, uns bei Fragen sofort anzuschreiben...

Das ist nötig zum Funktionieren
===============================

Zunächst einmal sollten die Dateien in einem Unterverzeichnis auf einem PHP-fähigen Server landen. (Eine Anleitung, wie Sie Ihre Datenbank einrichten, sollte folgen!)

Fügen Sie anschließend eine E-Mail-Adresse in die Datei "php/config.php" zwischen die Anführungszeichen in der Zeile $contactMailAddress ein, die benachrichtigt wird, wenn bspw. neue Fragen eingereicht werden. Auf dieselbe Weise sollten Sie auch eine Absenderadresse unter $senderMailAddress angeben.

Die Zeilen $dbUsername und $dbPassword sollten Sie nutzen, um Ihre MySQL-Zugangsdaten einzutragen, die Zeile $dbDatabaseName für den Namen der Datenbank.

Weil bisher ein Sicherheitsmechanismus für das Registrieren neuer Kandidaten fehlt, sollten Sie die Datei "fragenportal/register.php", die zur Registrierung dient, in einen schwer zu erratenden Dateinamen abändern. Das ist KEINE sichere Lösung!1!!

Wenn Sie nun die Webseite aufrufen, werden Sie wahrscheinlich erst einmal kein Logo sehen. Daher sollten Sie im Hauptverzeichnis dieses Projektes eine Bilddatei mit dem Seitenlogo einfügen.

Viel Erfolg und Beteiligung!
