<?php

require_once __DIR__.'/../Classes/Classes.Site.php';
require_once __DIR__.'/../Classes/Classes.Utilisateur.php';
require_once __DIR__.'/../../Config/base.php';
require_once __DIR__.'/../../Helpers/encryption.php';

class UtilisateurRepository extends base
{
	#region BASE CRUD (Create Read Update Delete)
	public static function GetUser($id)
	{
		return UtilisateurRepository::GetUsers(array($id));
	}

	public static function GetUsers($ids)
	{
		$toReturn = array();

		foreach ($ids as $id)
		{
			//Création de la co
			$conn = parent::CreateConnexion();

			//Instanciation de la requête
			$request = $conn->prepare("SELECT Identifiant, Nom, Prenom, Numero, Email, IsAdmin, Login, Password FROM Utilisateurs WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $id, PDO::PARAM_INT);

			//Execution
			$request->execute();

			//Récupération des données dans une var
			$results = $request->fetchAll();

			//Récupération
			foreach ($results as $result)
			{
				$item = new Utilisateur();

				$item->Identifiant = $result['Identifiant'];
				$item->Nom = $result['Nom'];
				$item->Prenom = $result['Prenom'];
				$item->Numero = $result['Numero'];
				$item->Email = $result['Email'];
				$item->IsAdmin = $result['IsAdmin'];
				$item->Login = $result['Login'];
				$item->Password = $result['Password'];

				array_push($toReturn, $item);
			}
		}
		return $toReturn;
	}

	public static function GetAllUsers()
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Nom, Prenom, Numero, Email, IsAdmin, Login, Password FROM Utilisateurs");

		//Mappage des champs variables
		//Pas de champs variables

		//Execution
		$request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Utilisateur();

			$item->Identifiant = $result['Identifiant'];
			$item->Nom = $result['Nom'];
			$item->Prenom = $result['Prenom'];
			$item->Numero = $result['Numero'];
			$item->Email = $result['Email'];
			$item->IsAdmin = $result['IsAdmin'];
			$item->Login = $result['Login'];
			$item->Password = $result['Password'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function GetAllAdmins()
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Nom, Prenom, Numero, Email, IsAdmin, Login, Password FROM Utilisateurs WHERE IsAdmin = 1");

		//Mappage des champs variables
		//Pas de champs variables

		//Execution
		$request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Utilisateur();

			$item->Identifiant = $result['Identifiant'];
			$item->Nom = $result['Nom'];
			$item->Prenom = $result['Prenom'];
			$item->Numero = $result['Numero'];
			$item->Email = $result['Email'];
			$item->IsAdmin = $result['IsAdmin'];
			$item->Login = $result['Login'];
			$item->Password = $result['Password'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function GetAllNonAdmins()
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Nom, Prenom, Numero, Email, IsAdmin, Login, Password FROM Utilisateurs WHERE IsAdmin = 0");

		//Mappage des champs variables
		//Pas de champs variables

		//Execution
		$request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Utilisateur();

			$item->Identifiant = $result['Identifiant'];
			$item->Nom = $result['Nom'];
			$item->Prenom = $result['Prenom'];
			$item->Numero = $result['Numero'];
			$item->Email = $result['Email'];
			$item->IsAdmin = $result['IsAdmin'];
			$item->Login = $result['Login'];
			$item->Password = $result['Password'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function SetUser($Utilisateur)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Utilisateur->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Utilisateurs(Nom, Prenom, Numero, Email, IsAdmin, Login, Password) VALUES (:Nom, :Prenom, :Numero, :Email, :IsAdmin, :Login, :Password)");

			//Mappage des champs variables
			$request->bindValue('Nom', $Utilisateur->Nom, PDO::PARAM_STR);
			$request->bindValue('Prenom', $Utilisateur->Prenom, PDO::PARAM_STR);
			$request->bindValue('Numero', $Utilisateur->Numero, PDO::PARAM_STR);
			$request->bindValue('Email', $Utilisateur->Email, PDO::PARAM_STR);
			$request->bindValue('IsAdmin', $Utilisateur->IsAdmin, PDO::PARAM_STR);
			$request->bindValue('Login', $Utilisateur->Login, PDO::PARAM_STR);
			$request->bindValue('Password', encryption::Encrypt($Utilisateur->Password), PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			//UPDATE
			//Instanciation de la requête
			$request = $conn->prepare("UPDATE Utilisateurs SET Nom = :Nom, Prenom = :Prenom,Numero = :Numero, Email = :Email, IsAdmin = :IsAdmin, Login = :Login WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $Utilisateur->Identifiant, PDO::PARAM_INT);
			$request->bindValue('Nom', $Utilisateur->Nom, PDO::PARAM_STR);
			$request->bindValue('Prenom', $Utilisateur->Prenom, PDO::PARAM_STR);
			$request->bindValue('Numero', $Utilisateur->Numero, PDO::PARAM_STR);
			$request->bindValue('Email', $Utilisateur->Email, PDO::PARAM_STR);
			$request->bindValue('IsAdmin', $Utilisateur->IsAdmin, PDO::PARAM_STR);
			$request->bindValue('Login', $Utilisateur->Login, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		return -1;
	}

	public static function UpdateMDPuser($id, $Password)
	{
		$conn = parent::CreateConnexion();

		$request = $conn->prepare("UPDATE Utilisateurs SET Password = :Password WHERE Identifiant = :Identifiant");

		//Mappage des champs variables
		$request->bindValue('Identifiant', $id, PDO::PARAM_INT);
		$request->bindValue('Password', encryption::Encrypt($Password), PDO::PARAM_STR);

		if ($request->execute())
		{
			return 1;
		}

		return -1;
	}

	public static function DeleteUser($Utilisateur)
	{
		if ($Utilisateur->Identifiant == 0)
		{
			return 0;
		}
		else
		{
			return DeleteUserById($Utilisateur->identifiant);
		}
		return -1;
	}

	public static function DeleteUserById($userid)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		$usersForId = UtilisateurRepository::GetUser($userid);

		if (count($usersForId) == 1)
		{
			//UPDATE
			//Instanciation de la requête
			$request = $conn->prepare("DELETE FROM Utilisateurs WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $userid, PDO::PARAM_INT);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			return count($usersForId);
		}
		return -1;
	}

	#endregion

	#region Specifics funcs
	public static function GetLogin($Login, $Password)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant FROM Utilisateurs WHERE Login = :Login AND Password = :Password");

		//Mappage des champs variables
		$request->bindValue('Login', $Login, PDO::PARAM_STR);
		$request->bindValue('Password', encryption::Encrypt($Password), PDO::PARAM_STR);

		//Execution
		if ($request->execute())
		{
			//Récupération des données dans une var
			$results = $request->fetchAll();

			$count = count($results);

			if ($count == 0)
			{
				return 0;
			}
			else if ($count > 1)
			{
				return -2;
			}
			else
			{
				//Récupération
				foreach ($results as $result)
				{
					return $result['Identifiant'];
				}
			}
		}
		return -1;
	}

	public static function UserAlreadyExist($Login, $Password)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant FROM Utilisateurs WHERE Login = :Login");

		//Mappage des champs variables
		$request->bindValue('Login', $Login, PDO::PARAM_STR);

		//Execution
		if ($request->execute())
		{
			//Récupération des données dans une var
			$results = $request->fetchAll();

			$count = count($results);

			if ($count == 0)
			{
				return 0;
			}
			else if ($count >= 1)
			{
				return -2;
			}

		}
		return -1;
	}

	public static function IsAdmin($id)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT IsAdmin FROM Utilisateurs WHERE Identifiant = :Identifiant");

		//Mappage des champs variables
		$request->bindValue('Identifiant', $id, PDO::PARAM_STR);

		if ($request->execute())
		{
			//Récupération des données dans une var
			$results = $request->fetchAll();

			$count = count($results);

			if ($count == 0)
			{
				return 0;
			}
			else if ($count >= 1)
			{
				foreach ($results as $result) {
					return $result['IsAdmin'];
				}
			}

		}
		return -1;
	}

	public static function GetLastCreated() {

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT MAX(Identifiant) FROM Utilisateurs");

		if ($request->execute())
		{
			//Récupération des données dans une var
			$results = $request->fetchAll();

			return $results[0];

		}
		return -1;
	}

	public static function AddSiteOfUser($idUser)
	{
		$conn = parent::CreateConnexion();


		$request = $conn->prepare("INSERT INTO Sites_Utilisateurs (IdUtilisateur, IdSite) VALUES (:idUser, (SELECT MAX(Identifiant) FROM Sites))");

		$request->bindValue('idUser', $idUser, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
		return -1;
	}

	public static function SetSiteOfUser($idSite, $idUser)
	{
		$conn = parent::CreateConnexion();


		$request = $conn->prepare("INSERT INTO Sites_Utilisateurs (IdUtilisateur, IdSite) VALUES (:idUser, :idSite)");

		$request->bindValue('idSite', $idSite, PDO::PARAM_INT);
		$request->bindValue('idUser', $idUser, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
		return -1;
	}

	public static function GetUserOfSite($idSite) {

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT * FROM Utilisateurs INNER JOIN Sites_Utilisateurs ON Sites_Utilisateurs.IdUtilisateur = Utilisateurs.Identifiant WHERE Sites_Utilisateurs.IdSite = :idSite");

		//Mappage des champs variables
		$request->bindValue('idSite', $idSite, PDO::PARAM_STR);

		if ($request->execute())
		{
			//Récupération des données dans une var
			$results = $request->fetchAll();

			return $results;

		}
		return -1;
	}

	Public static function DeleteSiteUser($idSite,$idUser)
	{
		$conn = parent::CreateConnexion();

		$request = $conn->prepare("DELETE FROM Sites_Utilisateurs WHERE  IdUtilisateur =:idUser AND IdSite = :idSite");

		$request->bindValue('idUser', $idUser, PDO::PARAM_INT);
		$request->bindValue('idSite', $idSite, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
			return -1;
	}

	Public static function DeleteUserLinkedToSite($idSite)
	{
		$conn = parent::CreateConnexion();

		$request = $conn->prepare("DELETE FROM Sites_Utilisateurs WHERE IdSite = :idSite");

		$request->bindValue('idSite', $idSite, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
			return -1;
	}

}

?>
