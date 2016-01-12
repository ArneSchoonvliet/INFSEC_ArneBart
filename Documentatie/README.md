#The making of the Wall of Sheep

##The early beginning

###Opdracht

Onze opdracht bestond er uit om een project van studenten van vorig jaar verder uit te werken ( of gewoon werkend te krijgen op de passieve mannier)
Hiervoor moesten we eerst hun verslag bekijken en konden we vastellen dat zij enkel een Wall of Sheep konden realiseren door actief het netwerk te gaan sniffen en via een hub.


###Verloop van de opdracht

Onze eerste bedoeling was om het netwerk passief te sniffen op packetten in de lucht. Uiteindelijk hebben ze dit niet kunnen doen gezien ze ettercap niet werkend kregen in promiscous mode. Daarna hebben we geprobeerd om een actieve ARP uit te voeren op het netwerk. Dit hebben we een aantal weken geprobeerd zonder succes. Ettercap was niet in staat om het netwerk te sniffen en dit naar een bestand te loggen. Op aanraden van een collega zijn we dan overgestapt naar Man-In-The-Middle-Framework. Dankzij deze overstap hebben we succesvol op het doelnetwerk onze sniff kunnen uitvoeren. Hierdoor waren we in staat om alle nuttige info die we konden gebruiken over te zetten in een logfile. Om deze logfile uit te lezen hebben we een php script geschreven dat op de apache server van de Raspberry pi draait. Indien men naar het adres van de pi surft kan men de ARP aanval starten, de logs binnenhalen van de aanval of de Raspberry pi uitschakelen. Hoe dit allemaal gebeurd wordt hieronder allemaal uitgelegd.

###Benodigdheden

* Router die ons netwerk voorstelt
* Raspberry pi ( onze hacking module )
* Target laptop waar we het verkeer van afluisteren

###Software die nodig was

####Laptop
* putty (programmeren van de Raspberry pi)
* tightvnc (remote desktop voor Raspberry pi)

####Raspberry pi
* Debian (linux distributie, KALI)
* ethercap ( vervangen door MITMF)
* tightvnc ( grafische weergave/ remote desktop )
* Apache
* Man-in-the-middle-framework

##Let's get to work

####Debian image op SD-card plaatsen
*Om dit te doen maken we gebruik van een tool voor de image op de SD-Card te zetten*
![Printscreen Tool](http://a.fsdn.com/con/app/proj/win32diskimager/screenshots/win32-imagewriter.png)

Wanneer dit gelukt is kunnen we de SD-card in de Rasberry pi plaatsen en hem booten met de nieuwe image.

###Next step

Als de Pi succesfull geboot is kunnen we er dingen op beginnen instellen:
* Remote desktop instellen zodat we het bureaublad kunnen zien (tightVNC)
* Drivers voor ethercap
* Apache (voor script en log op te laten verschijnen)
* Python script voor IP doorsturen

Bovenstaande moeten allemaal eerst gedownload worden, dit wil weggen dat de pi op een netwerk verbonden moet zijn.
Om dit te kunnen realiseren wordt op een laptop de internet verbinding gedeeld door hem als DHCP in te stellen, hierdoor ontvangt de pi een IP adress.

####tightvnc
*is een gratis remote controle [software](http://www.tightvnc.com/) packet*
Service die je kan starten op de Raspberry pi. Dit stelt de gebruiker in staat om op zijn computer een virtueel extern scherm te maken voor de reapBerry pi.

####ethercap
*software die op de Pi geïnstalleerd word*

Ethercap kan gebruikt worden voor passieve en actieve disectie van veel protocollen ( zelfs degene die geëndoceerd zijn).
Het bevat ook veel functies voor een analyse uit te voeren van een host of van het netwerk waar hij zich op bevind.
Wij gebruiken dit vooral voor pakketjes met gevoelige informatie uit de lucht te halen en deze te loggen in een bestand.

*Disclaimer: spijtig genoeg hebben wa na enkele weken geconstateerd dat we ettercap niet werkend kregen voor de toepassing die we voor ogen hadden.*

####Python

Om ons werk te vergemakelijken hebben we een python script geschreven dat het IP addres van de Pi doorstuurt naar een mailaddress van ons.
Hierdoor kunnen we rechtstreeks verbinding maken met de Pi en de php pagina bekijken met de gevoelige info.

![*Het script*](http://i63.tinypic.com/14y78jo.png)

Dit script wordt automatisch uitgevoerd wanneer de pi volledig is opgestart.

####Man-in-the-middle-framework

Dit is onze uiteindelijke keuze geworden omdat dit framework ons helpt met ons doel in dit project te bereiken.
Het in een one-stop-shop voor man-in-the-middle en network aanvallen. Het framework krijgt constant updates en verbeteringen voor bestaande aanvallen.

Normaal was dit framework ontworpen voor belangrijke tekortkomingen bij ettercap op te vangen. Op github is nu een volledige repo toegewijd aan een van nul opgebouwd framework. Het framework is ook zeer eenvoudig te gebruiken.

###Step 2

Nu we alle services en software hebben op onwe Raspberry gaan we hem instellen
# TO DO


