<?php

print_r(shell_exec("php -i|grep -i mysqli"));
 $hostname = 'localhost';
            $database = 'maalgaad_maalgaadinew';
            $username = 'maalgaad_vipul';
            $password = 'newtest@123';
$conn = mysqli_connect($hostname, $username, $password,$database) or die(mysql_error());