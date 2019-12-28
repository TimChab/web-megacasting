<?php

require_once __DIR__."/config.php";

class Base
{
	public static function CreateConnexion()
	{
		$url = $_SERVER['HTTP_HOST'];
		$length = strlen("test");
		$lengthLocal = strlen("localhost");

		if(substr($url, 0, $length) == "test" || substr($url, 0, $lengthLocal) == "localhost")
		{

		 	$PARAM_DBNAME = config::$PARAM_DBNAME_TEST;

		 	$PARAM_HOST = config::$PARAM_HOST_TEST;

		 	$PARAM_USER = config::$PARAM_USER_TEST;

		 	$PARAM_PWD = config::$PARAM_PWD_TEST;

		 	try
			{
				//return new PDO("sqlsrv:server=".$PARAM_HOST.";database=".$PARAM_DBNAME."", $PARAM_USER, $PARAM_PWD);
				return new PDO("sqlsrv:server=localhost;database=MegaProd", "MegaProd_User", "Not24get");
			}

			catch ( PDOException $e )
			{
				echo "<h1>Problème de connexion a la base de données</h1>".$e;
			}
		}

		else
		{
			$PARAM_DBNAME = config::$PARAM_DBNAME_PROD;
			$PARAM_HOST = config::$PARAM_HOST_PROD;
		 	$PARAM_USER = config::$PARAM_USER_PROD;
		 	$PARAM_PWD = config::$PARAM_PWD_PROD;


			// creation de la connexion afin d'executer les requetes
			try
			{
				return new PDO("sqlsrv:server=".$PARAM_HOST.";database=".$PARAM_DBNAME."", $PARAM_USER, $PARAM_PWD);
			}

			catch ( PDOException $e )
			{
				echo "<h1>Problème de connexion a la base de données</h1>".$e;
			}
		}
	}
}

?>
