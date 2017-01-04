<?php
  $serverhost = "localhost";  // Det er svært få som kjører SQL servere pga sikkerhet rett opp mot nettet, derfor er host/server (tjener)
                              // normalt alltid "localhost eller 127.0.0.1 - da kan den ikke nås direkte fra andre enn de på systemet"
  $brukernavn = "prg_hsn";        // Brukernavnet spesifisert i DBHS-en, som med passordet under og rettigheter (DCL-delen av SQL)
  $passord = "pass2910";      // Eksempelpassord for dokumentasjonen - hvis du bruker slike passord, BYTT NÅ! (pass+min bursdag i dette tilfellet)
  $database = "prg17";    // Vi velger hvilken database vi skal jobbe opp mot

  // Denne filen inkluderer vi ved begynnelsen av hvert eneste php-script der vi skal utføre oppgaver mot databasen.
  // Ved å gjøre det på denne måten kan man vise frem kode uten å nødvendigvis vise passordet sitt til noen.
?>
