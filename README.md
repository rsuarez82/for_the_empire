# FOR THE EMPIRE
## Kursverwaltung

### Ausgangslage

Wir sind eine Webagentur und der größte Kunde, Imperial Engineering Corp für strukturelle Integrität und Verteidungsanlagen, hat uns mit der Erstellung einer Online-Lernplattform beauftragt.
Die bisherige Schulungssoftware-Lösung basiert auf einer lokal installierten Version und wurde leider aus unerfindlichen Gründen als “nichtmehr einsatzbereit” gemeldet. Ein Versuch auf die Off-Site-Backups in Endor zuzugreifen läuft aktuell noch, allerdings warten wir ebenfalls noch auf die Rückmeldung der dortigen Imperialen Truppen.

In den letzten Gesprächen hat unsere Agentur dem Kunden schon entlocken können, dass sie eine Lösung bevorzugen die von überall aus durchgeführt werden kann.

Unser Kunde hatte in der Vergangenheit wohl öfter mal “Probleme” mit auf den Schiffen und Raumstationen verwendeter Software gehabt. Da irgendein Konkurrent von ihnen eine allgemeinhin bekannte “Hackergruppe”, genannt die Rebellen, immer wieder auf unsere Agentur los lässt wollen sie jetzt eine Online-Lösung haben.

### Vorgaben
* PHP 8
* Framework (bevorzugt Symfony, Laravel als weitere Option)
* Docker oder lokal installierte Umgebung
* Lauffähig inkl Daten am Ende des Zeitraums via Github oder ähnlichen Diensten übermitteln
* Keine bestehende Lern/Kurs-Plattform umbauen (Moodle)

### Anmerkung

* ChatGPT oder ähnliches darf für die Generierung von Kurs/Testdaten verwendet werden, jedoch nicht für die Erstellung von Programmcode (PHP etc)
* Einsatz von Bootstrap oder ähnlichen Projekten (Alpine.js, tailwind css) erwünscht

### Aufgaben

* Erstelle eine Kursverwaltung für eine Lernplattform
* Kurse müssen über ein Admin-Interface verwaltet werden können
* CRUD
* Kurse müssen von Imperialen Truppen gebucht werden können (sie zielen mit der Maus besser wie mit Blastern)
* Eine Kursübersicht über die besuchten Kurse der einzelnen Truppen muss in deren Profil ersichtlich sein

### Gewünschte Datenstruktur

* Kurse
* * Titel
* * Kurs-Datum
* * Inhalt
* * Kurzbeschreibung
* * Kurs-Leiter
* * Freie Kursplätze

* Teilnehmer
* * Vor-/Nachname
* * E-Mailadresse (muss nicht real sein)
* * Einheit
* * Passwort