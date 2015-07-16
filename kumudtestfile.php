<?php
$hostname = 'localhost';
         $database = 'maalgaadi_db';
         $username = 'maalgaadi_db';
         $password = 'maalgaadi_db';

 $connection = mysql_connect($hostname, $username, $password) or die("Error test : ".mysql_error());
 mysql_select_db($database, $connection);
 $query = mysql_query("select * from location_view"); 
 while ($result = mysql_fetch_array($query)) {
	echo $result['latitute'];
	echo '<br>';
 }

?>