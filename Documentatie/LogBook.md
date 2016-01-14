#19/11/2015
* Bekijken + bestuderen naslag werk vorig jaar
* Downloaden raspian + flashen naar SD card
* RPI booten 

#26/11/2015
* Overstap van raspian naar kali gedaan. Met gedachte gang dat dit geoptimaliseerd zou zijn voor onze toepassing
* apache op raspberry pi geïnstalleerd en getest. Mailer script laten werken met druk op de knop via php
* Mailer script toegevoegd en via crontab ervoor gezorgt dat deze word uigevoerd bij boot

#27/11/2015
* Alfa aansluiten en verbinding maken via commandline 
* testing mailerscript en php coding

#03/12/2015
* testing ettercap: geïnstalleerd en bekend worden met het programma

#07/12/2015
* testing ettercap: Tip gekregen om wifi adapter in promiscus mode te zetten ==> geen success

#10/12/2015
* testing ettercap, does this even work? Verschillende bronnen en tutorials gevolgd maar we krijgen maar geen data binnen. Over geschakeld 
naar ethernet poort. We krijgen nu iets binnen, tijd voor analyseren van data.

#17/12/2015
* Ettercap werkend krijgen voor passwoorden en usernames weg te schrijven naar log file. We kunnen data schrijven naar een file.
Maar deze data is gecodeerd en niet nuttig 

#08/01/2016
* ettercap buitenggegooid en overgestapt naar mimtf, dit werkt (veel beter).
* logfile proberen weg te schrijven
* informatie uit logfile halen

#09/01/2016 
* logfile uit mitmf halen en verplaatsen naar php map
* logfile in php filteren op gewenste info
* gewenste info tonen op de php server
* wachtwoorden enkele letters laten zien zonder volledig passwoord

#10/01/2016
* aansturen met knoppen 
* apache starten bij boot-up

#11/01/2016
*Proberen sniffen van https wachtwoorden, lukt bijna maar door tijdsgebrek niet verder kunnen zoeken
*push refresh webpagina

