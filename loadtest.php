<?php
	$con=mysql_connect('localhost','maalgaadi_db','maalgaadi_db');
	$db=mysql_select_db('maalgaadi_db');

	for ($i=0; $i <5000 ; $i++) { 
		
		$res=mysql_query("SELECT * FROM `test_lat_long` LIMIT 5000");
		if($res)
		{
			while($result=mysql_fetch_array($res))
			{
				echo$result['lat'].$result['long1'];
			}
			
		}
	}

?>