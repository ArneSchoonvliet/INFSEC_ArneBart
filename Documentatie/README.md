#The making of the Wall of Sheep

##The early beginning

###Opdracht

Onze opdracht bestond er uit om een project van studenten van vorig jaar verder uit te werken ( of gewoon werkend te krijgen op de passieve mannier)
Hiervoor moesten we eerst hun verslag bekijken en konden we vastellen dat zij enkel een Wall of Sheep konden realiseren door actief het netwerk te gaan sniffen.

Wij willen dit realiseren op de passieve mannier met een gewone ethercap methode. Wij luisteren naar al het verkeer dat over de wifi gaat waar we met verbonden zijn.
In een document loggen we dan alle unsecure data waar we een username en wachtwoord uit kunnen halen.
Vervolgens posten we dit naar onze php server waar een lijst terecht komt met alle gebruikersnamen en wachtwoorden. (Wall of sheep)

###Benodigdheden

* Router die ons netwerk voorstelt
* Raspberry pi ( onze hacking module )
* Alfa ( verbind de Raspberry met het internet -> router )
* Target laptop waar we het verkeer van afluisteren
* php server ( hier komt de wall of sheep op terecht )

###Software die nodig was

####Laptop
* Xamp ( simuleren van php server)

####Raspberry pi
* Debian (linux distributie, KALI)
* ethercap
* tightvnc ( grafische weergave/ remote desktop )
* Apache

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
Hierdoor kan je van een apparaat op afstand de desktop bekijken en acties uitvoeren alsof je op het apparaat zelf zit.

####ethercap
*software die op de Pi geïnstalleerd word*

Ethercap kan gebruikt worden voor passieve en actieve disectie van veel protocollen ( zelfs degene die geëndoceerd zijn).
Het bevat ook veel functies voor een analyse uit te voeren van een host of van het netwerk waar hij zich op bevind.

Wij gebruiken dit vooral voor pakketjes met gevoelige informatie uit de lucht te halen en deze te loggen in een bestand.

####Python

Om ons werk te vergemakelijken hebben we een python script geschreven dat het IP addres van de Pi doorstuurt naar een mailaddress van ons.
Hierdoor kunnen we rechtstreeks verbinding maken met de Pi en de php pagina bekijken met de gevoelige info.


![*Het script*](http://i63.tinypic.com/14y78jo.png)
