<?php
include("db-login.php");
  // Inkluderer tilkoblingsinformasjon

$dblink = mysqli_connect($serverhost, $brukernavn, $passord, $database);
  // Vi setter en variabel til å være linken mellom programmet og databasen.

if (!$dblink) { // Hvis ikke(!) $dblink er true
  die("Kunne ikke koble til database: " . mysqli_connect_error() );
  // Klarer vi ikke koble til databasen skriver vi ut feilmelding og dør
}

$sql = "CREATE TABLE fag (
  fagkode CHAR(7) NOT NULL,
  fagnavn VARCHAR(75) NOT NULL,
  fagforeleser VARCHAR(75) NOT NULL,
  PRIMARY KEY (fagkode)
)";  // SQL-kode for å opprette en ny tabell som heter fag, med tre forskjellige kolonner.
    // Vi vet at fagkode alltid er 7 tegn, derfor bruker vi char der.
    // Kolonnen fagkode blir satt til å være primærnøkkel.

if (mysqli_query($dblink, $sql)) { // Vi kjører spørringen mot databasen via $dblink
  print("Tabellen \"fag\" ble opprettet i databasen \"$database\".\n<br>");
} else { // Ev. feilmelding blir skrevet ut. Vanlig feil her er at tabellen allerede eksisterer.
  print "Feil ved registrering av tabell, feilmelding fra mysql:\"" . mysqli_error($dblink) . "\".<br>";
}

$sql = "CREATE TABLE oppgave (
  fagkode CHAR(7) NOT NULL,
  oppgavenr TINYINT(3) UNSIGNED NOT NULL,
  tidsfrist DATE,
  PRIMARY KEY(fagkode,oppgavenr),
  FOREIGN KEY(fagkode) REFERENCES fag(fagkode)
)"; // SQL-kode for å opprette en tabell til, oppgave, som har tre kolonner og en primærnøkkel som består
    // av data fra to forskjellige kolonner, fagkode og oppgavenr. I tillegg er det satt en fremmednøkkel, som
    // er en referanse til primørnøkkelen i tabellen fag, som er fagkode-kolonnen.

if (mysqli_query($dblink, $sql)) { // Vi utfører spørringen, og skriver ut ev. feilmeldinger vi måtte få.
  print("Tabellen \"oppgave\"ble opprettet i databasen \"$database\".\n<br>");
} else { // Ev. feilmelding blir skrevet ut. Vanlig feil her er at tabellen allerede eksisterer.
  print "Feil ved registrering av tabell: " . mysqli_error($dblink) . "<br>";
}
// Slutt på deklarasjon av tabeller, slutt på DDL-delen av SQL og over til DML-delen
// "Data Definition" vs "Data Manumpliation"

$sql = "INSERT INTO fag
  (fagkode, fagnavn, fagforeleser) VALUES
  ('INF1000', 'Informasjonssystemer', 'Shegaw Mengiste')";
  // Her bygger vi en SQL-spørring for å legge til Shegaw

if (mysqli_query($dblink, $sql)) { // Vi utfører spørringen
  print("Shegaw registrert.<br>");
} else { // Skriver ut ev. feilmelding fra mysql DBHS-en
  print("Noe gikk feil: " . mysqli_error($dblink) . "<br>\n");
}

$sql = "INSERT INTO fag
  (fagkode, fagnavn, fagforeleser) VALUES
  ('PRG1000', 'Programmering 1', 'Geir Bjarvin')";
  // Her bygger vi en SQL-spørring for å legge til Geir

if (mysqli_query($dblink, $sql)) {
  print("Geir registrert.<br>");
} else {
  print("Noe gikk feil: " . mysqli_error($dblink) . "<br>\n");
} // If-setningen sjekker om spørringen ble utført greit, eller om det kom feil fra mysqli_query

$sql = "INSERT INTO fag
  (fagkode, fagnavn, fagforeleser) VALUES
  ('SYS1000', 'Systemutvikling', 'Marius Johannessen')";
// Her bygger vi en SQL-spørring for å legge til Marius

if (mysqli_query($dblink, $sql)) {
  print("Marius registrert.<br>");
} else {
  print("Noe gikk feil: " . mysqli_error($dblink) . "<br>\n");
} // If-setningen sjekker om spørringen ble utført greit, eller om det kom feil fra mysqli_query

// Til nå har vi registrert tre forelesere, med hver sin sql-setning som blir utført av mysqli_query.
// Under skal vi gjøre det på en langt mer effektiv måte. Legg merke til bruken av concatenation-operatøren . (punktum)

$sql = "INSERT INTO oppgave (fagkode, oppgavenr, tidsfrist) VALUES
('INF1000', '1', '2017-11-01');";
$sql .= "INSERT INTO oppgave (fagkode, oppgavenr, tidsfrist) VALUES
('INF1000', '2', '2017-12-01');";
$sql .= "INSERT INTO oppgave (fagkode, oppgavenr, tidsfrist) VALUES
('PRG1000', '1', '2017-11-01');";
$sql .= "INSERT INTO oppgave (fagkode, oppgavenr, tidsfrist) VALUES
('PRG1000', '2', '2017-12-01')";

if (mysqli_multi_query($dblink, $sql)) {
    echo "De nye radene ble registrert med INSERT INTO.<br>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn) . ".<br>\n";
}
// Over bruker vi mysqli_multi_query for å utføre flere enn en spørring på en gang, og legger til alle oppføringene
// i tabellen "oppgaver" ved hjelp av en enkelt mysqli-kommando.
mysqli_close($dblink);
?>
