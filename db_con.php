<?php 

//forbindelse til mySQL serveren ved brug af mySQLi metode.

//1. Variabler (konstanter) til forbindelsen.


const HOSTNAME = 'tlp-media.com.mysql'; //Server
const MYSQLUSER = 'tlp_media_com'; //SuperBruger
const MYSQLPASS = '6MMS8eiD'; //password
const MYSQLDB = 'tlp_media_com'; //Database navn

//2. Forbindelsen via mySQLi metode

$con = new MySQLi(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

//for at sikre sig, at alle utf-8 tegn kan blive brugt i forbindelsen.
$con->set_charset ('utf-8');

//3. Tjek:
//hvis der er fejl i forbindelsen,
if($con->connect_error){
	die($con->connect_error);
//hvis der er hul igennem:
} else {
	;
}


//php slut tag kan undlades, hvis filen indenholder rent php.