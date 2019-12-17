<?php
require_once __DIR__.'/../Classes/Classes.Site.php';
require_once __DIR__.'/../Classes/Classes.Utilisateur.php';
require_once __DIR__.'/../../Config/base.php';
require_once __DIR__.'/../../Helpers/encryption.php';


class SiteRepository extends base
{
	#region BASE CRUD (Create Read Update Delete)
	public static function GetSite($id)
	{
		return SiteRepository::GetSites(array($id));
	}

	public static function GetSites($ids)
	{
		$toReturn = array();

		foreach ($ids as $id)
		{
			//Création de la co
			$conn = parent::CreateConnexion();

			//Instanciation de la requête
			$request = $conn->prepare("SELECT Identifiant, Url, Logo, Libelle FROM Sites WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $id, PDO::PARAM_INT);

			//Execution
			$request->execute();

			//Récupération des données dans une var
			$results = $request->fetchAll();

			//Récupération
			foreach ($results as $result)
			{
				$item = new Site();
				$item->Identifiant = $result['Identifiant'];
				$item->Url = $result['Url'];
				$item->Logo = $result['Logo'];
				$item->Libelle = $result['Libelle'];

				array_push($toReturn, $item);

			}
		}
		return $toReturn;
	}

	public static function GetAllSites()
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Url, Logo, Libelle FROM Sites");

		//Mappage des champs variables
		//Pas de champs variables

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Site();

			$item->Identifiant = $result['Identifiant'];
			$item->Url = $result['Url'];
			$item->Logo = $result['Logo'];
			$item->Libelle = $result['Libelle'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function SetSite($Site)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Site->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Sites(Url, Logo, Libelle) VALUES (:Url, :Logo, :Libelle)");

			//Mappage des champs variables
			$request->bindValue('Url', $Site->Url, PDO::PARAM_STR);
			$request->bindParam('Logo', $Site->Logo, PDO::PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
			$request->bindValue('Libelle', $Site->Libelle, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			//UPDATE
			//Instanciation de la requête
			if ($Site->Logo != 'null') {
				$request = $conn->prepare("UPDATE Sites SET Url = :Url, Libelle = :Libelle, Logo = :Logo WHERE Identifiant = :Identifiant");
			} else {
				$request = $conn->prepare("UPDATE Sites SET Url = :Url, Libelle = :Libelle WHERE Identifiant = :Identifiant");
			}
			//Mappage des champs variables
			$request->bindValue('Identifiant', $Site->Identifiant, PDO::PARAM_INT);
			$request->bindValue('Url', $Site->Url, PDO::PARAM_STR);
			$request->bindValue('Libelle', $Site->Libelle, PDO::PARAM_STR);
			if ($Site->Logo != 'null') {
				$request->bindParam('Logo', $Site->Logo, PDO::PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
			}

			if ($request->execute())
			{
				return 1;
			}
		}
		return -1;
	}

	public static function DeleteSite($Site)
	{
		if ($Site->Identifiant == 0)
		{
			return 0;
		}
		else
		{
			return DeleteSiteById($Site->Identifiant);
		}
		return -1;
	}



	public static function DeleteSiteById($Siteid)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		$sitesForId = SiteRepository::GetSite($Siteid);

		if (count($sitesForId) == 1)
		{
			$request = $conn->prepare("DELETE FROM Sites WHERE Identifiant = :Identifiant");

			$request->bindValue('Identifiant', $Siteid, PDO::PARAM_INT);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			return count($sitesForId);
		}
		return -1;
	}

	#endregion

	public static function SiteAlreadyExits($url)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant FROM Sites WHERE Url = :url");

		//Mappage des champs variables
		$request->bindValue('url', $url, PDO::PARAM_STR);

		//Execution
		if ($request->execute())
		{
			//Récupération des données dans une var
			$results = $request->fetchAll();
			$count = count($results);
			echo $count;

			if ($count == 0)
			{
				return 0;
			}
			else if ($count >= 1)
			{
				return 1;
			}
		}
		return -1;
	}

	public static function GetSitesOfUser($idUser)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Url, Logo, Libelle FROM Sites inner join Sites_Utilisateurs on Sites_Utilisateurs.IdSite = Sites.Identifiant WHERE Sites_Utilisateurs.IdUtilisateur = :idUser");

		//Mappage des champs variables
		$request->bindValue('idUser', $idUser, PDO::PARAM_INT);

		//Execution
		$request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Site();

			$item->Identifiant = $result['Identifiant'];
			$item->Url = $result['Url'];
			$item->Logo = $result['Logo'];
			$item->Libelle = $result['Libelle'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function AddUserOfSite($idSite)
	{
		$conn = parent::CreateConnexion();


		$request = $conn->prepare("INSERT INTO Sites_Utilisateurs (IdSite, IdUtilisateur) VALUES (:idSite, (SELECT MAX(Identifiant) FROM Utilisateurs))");

		$request->bindValue('idSite', $idSite, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
		return -1;
	}

	public static function SetUserOfSite($idSite, $idUser)
	{
		$conn = parent::CreateConnexion();


		$request = $conn->prepare("INSERT INTO Sites_Utilisateurs (IdSite, IdUtilisateur) VALUES (:idSite, :idUser)");

		$request->bindValue('idSite', $idSite, PDO::PARAM_INT);
		$request->bindValue('idUser', $idUser, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
		return -1;
	}

	Public static function UpdateUserOfSite($idUs, $idSit)
	{
		$conn = parent::CreateConnexion();

		$request = $conn->prepare("UPDATE Sites_Utilisateurs SET IdUtilisateur = :IdUtilisateur WHERE IdSite = :IdSite");
		$request->bindValue('IdSite', $idSit, PDO::PARAM_INT);
		$request->bindValue('IdUtilisateur', $idUs, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
			return -1;
	}

	Public static function DeleteUserOfSite($idSit)
	{
		$conn = parent::CreateConnexion();

		$request = $conn->prepare("DELETE FROM Sites_Utilisateurs WHERE  IdSite =:IdSite");

		$request->bindValue('IdSite', $idSit, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
			return -1;
	}

	public static function GetCategorieBySite($idSit)
	{
		$toReturn = array();


		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Categories.Identifiant, Categories.Libelle FROM Categories inner join Sites on Categories.Site = Sites.Identifiant WHERE Sites.Identifiant = :idSit");

		//Mappage des champs variables
		$request->bindValue('idSit', $idSit, PDO::PARAM_INT);

		//Execution
		$request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Categorie();

			$item->Identifiant = $result['Identifiant'];
			$item->Libelle = $result['Libelle'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	Public static function DeleteSiteLinkedToUser($idUser)
	{
		$conn = parent::CreateConnexion();

		$request = $conn->prepare("DELETE FROM Sites_Utilisateurs WHERE IdUtilisateur = :idUser");

		$request->bindValue('idUser', $idUser, PDO::PARAM_INT);

		if ($request->execute())
		{
			return 1;
		}
		else
			return -1;
	}

	public static function GetNbUserBySite($idSite)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT count(idUtilisateur) as count FROM Sites_Utilisateurs WHERE IdSite = :idSite");

		//Mappage des champs variables
		$request->bindValue('idSite', $idSite, PDO::PARAM_INT);

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{

			return $result;

		}
	}

}
?>
