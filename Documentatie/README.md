#The making of the Wall of Sheep

##The early beginning

###Opdracht

Onze opdracht bestond er uit om een project van studenten van vorig jaar verder uit te werken ( of gewoon werkend te krijgen op de passieve manier)
Hiervoor moesten we eerst hun verslag bekijken en konden we vaststellen dat zij enkel een Wall of Sheep konden realiseren door actief het netwerk te gaan sniffen en via een hub.


###Verloop van de opdracht

Onze eerste bedoeling was om het netwerk passief te sniffen op packetten in de lucht. Uiteindelijk hebben ze dit niet kunnen doen gezien ze ettercap niet werkend kregen in promiscous mode. Daarna hebben we geprobeerd om een actieve ARP uit te voeren op het netwerk. Dit hebben we een aantal weken geprobeerd zonder succes. Ethercap was niet in staat om het netwerk te sniffen en dit naar een bestand te loggen. Op aanraden van een collega zijn we dan overgestapt naar Man-In-The-Middle-Framework. Dankzij deze overstap hebben we succesvol op het doelnetwerk onze sniff kunnen uitvoeren. Hierdoor waren we in staat om alle nuttige info die we konden gebruiken over te zetten in een logfile. Om deze logfile uit te lezen hebben we een php script geschreven dat op de apache server van de Raspberry pi draait. Indien men naar het adres van de pi surft kan men de ARP aanval starten, de logs binnenhalen van de aanval of de Raspberry pi uitschakelen. Hoe dit allemaal gebeurd wordt hieronder allemaal uitgelegd.

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

Als de Pi succesvol geboot is kunnen we er dingen op beginnen instellen:
* Remote desktop instellen zodat we het bureaublad kunnen zien (tightVNC)
* Drivers voor ethercap
* Apache (voor script en log op te laten verschijnen)
* Python script voor IP doorsturen

Bovenstaande moeten allemaal eerst gedownload worden, dit wil weggen dat de pi op een netwerk verbonden moet zijn.
Om dit te kunnen realiseren wordt op een laptop de internet verbinding gedeeld door hem als DHCP in te stellen, hierdoor ontvangt de pi een IP adres.

####tightvnc
*is een gratis remote controle [software](http://www.tightvnc.com/) packet*
Service die je kan starten op de Raspberry pi. Dit stelt de gebruiker in staat om op zijn computer een virtueel extern scherm te maken voor de Raspberry pi.

####ethercap
*software die op de Pi geïnstalleerd word*

Ethercap kan gebruikt worden voor passieve en actieve dissectie van veel protocollen ( zelfs degene die gecodeerd zijn).
Het bevat ook veel functies voor een analyse uit te voeren van een host of van het netwerk waar hij zich op bevind.
Wij gebruiken dit vooral voor pakketjes met gevoelige informatie uit de lucht te halen en deze te loggen in een bestand.

*Disclaimer: spijtig genoeg hebben we na enkele weken geconstateerd dat we ethercap niet werkend kregen voor de toepassing die we voor ogen hadden.*

####Python

Om ons werk te vergemakkelijken hebben we een python script geschreven dat het IP adres van de Pi doorstuurt naar een mailadres van ons.
Hierdoor kunnen we rechtstreeks verbinding maken met de Pi en de php pagina bekijken met de gevoelige info.

![*Het script*](http://i63.tinypic.com/14y78jo.png)

Dit script wordt automatisch uitgevoerd wanneer de pi volledig is opgestart.

####Man-in-the-middle-framework

Dit is onze uiteindelijke keuze geworden omdat dit framework ons helpt met ons doel in dit project te bereiken.
Het in een one-stop-shop voor man-in-the-middle en netwerk aanvallen. Het framework krijgt constant updates en verbeteringen voor bestaande aanvallen.

Normaal was dit framework ontworpen voor belangrijke tekortkomingen bij ethercap op te vangen. Op github is nu een volledige repo toegewijd aan een van nul opgebouwd framework. Het framework is ook zeer eenvoudig te gebruiken.

##De volgende stap

Nu we alle services en software hebben op onze Raspberry gaan we hem instellen

###Putty
Eerst maken we verbinding met de Raspberry pi. Dit doen we door onze email na te kijken, hier krijgen we een mail met het IP van de Raspberry pi eenmaal deze is opgestart. Vervolgens gebruiken we dit IP-addres om te verbinden via putty.

####foto putty hier

Dan inloggen als admin. Inloggegevens:  
* User: root 
* password: toor

###tightvnc 
Natuurlijk willen we iets zien buiten een commando scherm, daarom starten we tightvncserver op.
#### foto tightvnc pc als pi

##Schrijven van de code

###Shell script Start.sh

Het bestand start.sh bevat onze volledige code voor de ARP spoofing te starten.
Eerst gaan we kijken of er nog een log file staat van de vorige keer dat de aanval werd uitgevoerd.
Dit bestand kan oude data bevatten en daarom verwijderen we dit.
Nadat dit gebeurd is starten we de ARP spoofing met een simpel commando.
```python
if [ ! -f /usr/share/mimtf/logs/mitmf.log]
then
echo "file not found";
else
rm /usr/share/mitmf/logs/mitmf.log
fi

mitmf -i eth0 --gateway 192.168.2.1 -- spoof --arp //magic line that makes it run
```

We gebruiken de *[START](#vragenobject)* knop op de index.php pagina om dit uit te laten voeren. *(later hier meer over)*


###Apache
Nu hebben we volledige toegang tot de Raspberry pi en kunnen we verder met de instellingen. 
Om onze logs weer te geven gaan we deze op een php pagina posten. Hiervoor moeten we eerst de apache server die we daarstraks hebben gedownload starten. 

```linux
service apache2 start
```
Elke keer als de Raspberry pi opstart moeten we de server ook terug moeten opstarten. Omdat dit in de praktijk moeilijk gaat laten we de apache server ook opstarten wanneer de pi klaar is met booten. Dit bespaart ons veel tijd en moeite uit en kunnen we direct verbinden maken met de apache server zonder eerst te moeten verbinden met de site.

```linux
update-rc.d apache2 defaults
```
###Index.PHP

Als we nu naar de site zouden gaan die op de php server staat is deze leeg. We gaan alles in php schrijven om de aanval vanuit deze pagina te kunnen doen. Dit houd in: een *[START](#START)* knop om de aanval te starten, een *[LOG](#LOG)* knop waar we de log bestanden mee opvragen en een *[STOP](#STOP)* knop om de aanval te stoppen. 

####HTML 

Knoppen waar we alle functies mee gaan uitvoeren.

```html
<form method="GET" action =''>
<input type = submit name='ARP' value = "Start ARP">
<input type = submit name='LOG' value = "GET LOG">
<input type = submit name='STOP' value = "STOP">
</form>
```

####PHP 

VOOR MORGE SCHUP AFGEKUIST


