<?php
//require "config.php";

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD','');
//define('DB_NAME', 'school');
try
{
	$connection = new PDO("mysql:host=". DB_SERVER, DB_USERNAME, DB_PASSWORD);
	$connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = file_get_contents("data/init.sql");
	$connection->exec($sql);
	$sql2 = file_get_contents("data2/init.sql");
	$connection->exec($sql2);
	$sql3 = file_get_contents("data2/init2.sql");
	$connection->exec($sql3);

	echo "Database and table users created successfully.";
}
catch(PDOException $error)
{
	echo $sql . "<br>" . $error->getMessage();
}
?>
