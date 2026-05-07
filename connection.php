<?php
// mysql_connection('HOSTNAME', 'DATABASE USER', 'DATABASE PASSWORD','DATABASE NAME');

$con = mysqli_connect("localhost", "root", "", "versity_project");

if ($con === false) {
	echo "<h1> Database Connection Failed</h1>";
}
