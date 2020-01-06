<?php
require_once __DIR__.'/../Classes/Classe.Offre.php';
require_once __DIR__.'/../../Config/base.php';
require_once __DIR__.'/../../Helpers/encryption.php';


class OffreRepository extends base
{
	#region BASE CRUD (Create Read Update Delete)
	public static function GetOffre($id)
	{
		return OffreRepository::GetOffres(array($id));
	}

	public static function GetOffres($ids)
	{
		$toReturn = array();

		foreach ($ids as $id)
		{
			//Création de la co
			$conn = parent::CreateConnexion();

			//Instanciation de la requête
			$request = $conn->prepare("SELECT Identifiant, Intitule FROM Offre WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $id, PDO::PARAM_INT);

			//Execution
			$request->execute();

			//Récupération des données dans une var
			$results = $request->fetchAll();

			//Récupération
			foreach ($results as $result)
			{
				$item = new Offre();
				$item->Identifiant = $result['Identifiant'];
				$item->Intitule = $result['Intitule'];

				array_push($toReturn, $item);
			}
		}
		return $toReturn;
	}

	public static function GetAllOffres()
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Intitule, Description_Poste, Description_Profil, Nombre_Poste FROM Offre");

		//Mappage des champs variables
		//Pas de champs variables

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Offre();

			$item->Identifiant = $result['Identifiant'];
			$item->Intitule = $result['Intitule'];
			$item->Description_Poste = $result['Description_Poste'];
			$item->Description_Profil = $result['Description_Profil'];
			$item->Nombre_Poste = $result['Nombre_Poste'];
			//$item->Url = $result['Url'];


			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function SetOffre($Offre)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Offre->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Offres(Intitule) VALUES (:Intitule)");

			//Mappage des champs variables
			$request->bindValue('Intitule', $Offre->Intitule, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			//UPDATE
			//Instanciation de la requête
			$request = $conn->prepare("UPDATE Offres SET Intitule = :Intitule WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $Offre->Identifiant, PDO::PARAM_INT);
			$request->bindValue('Intitule', $Offre->Intitule, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		return -1;
	}

	public static function DeleteOffre($Offre)
	{
		if ($Offre->Identifiant == 0)
		{
			return 0;
		}
		else
		{
			return DeleteOffreById($Offre->Identifiant);
		}
		return -1;
	}



	public static function DeleteOffreById($Offreid)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		$OffresForId = OffreRepository::GetOffre($Offreid);

		if (count($OffresForId) == 1)
		{
			$request = $conn->prepare("DELETE FROM Offres WHERE Identifiant = :Identifiant");

			$request->bindValue('Identifiant', $Offreid, PDO::PARAM_INT);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			return count($OffresForId);
		}
		return -1;
	}


	public static function SearchOffre($StringToSearch)
	{

		$paramLIKE = "%".$StringToSearch."%";
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Intitule, Description_Poste, Description_Profil, Nombre_Poste FROM Offre WHERE Description_Poste + Description_Profil + Intitule LIKE :paramLIKE");

		//Mappage des champs variables
		$request->bindValue('paramLIKE', $paramLIKE, PDO::PARAM_STR);

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Offre();

			$item->Identifiant = $result['Identifiant'];
			$item->Intitule = $result['Intitule'];
			$item->Description_Poste = $result['Description_Poste'];
			$item->Description_Profil = $result['Description_Profil'];
			$item->Nombre_Poste = $result['Nombre_Poste'];
			//$item->Url = $result['Url'];


			array_push($toReturn, $item);
		}
		return $toReturn;
	}

/*
	public static function GetNbPhotoByOffre($Offreid)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT COUNT(Photos.Identifiant) as 'count' FROM Photos INNER JOIN Offres ON Offres.Identifiant = Photos.Offre WHERE Offres.Identifiant = :Offreid");

		//Mappage des champs variables
		$request->bindValue('Offreid', $Offreid, PDO::PARAM_INT);

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

	public static function GetOffreBySite($SiteId)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Intitule FROM Offres WHERE Site = :SiteId");

		//Mappage des champs variables
		$request->bindValue('SiteId', $SiteId, PDO::PARAM_INT);

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{

			$item = new Offre();

			$item->Identifiant = $result['Identifiant'];
			$item->Intitule = $result['Intitule'];

			array_push($toReturn, $item);

		}
		return $toReturn;
	}

	public static function SetOffreWithSite($Offre, $Site)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Offre->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Offres(Intitule, Site) VALUES (:Intitule, :Site)");

			//Mappage des champs variables
			$request->bindValue('Intitule', $Offre->Intitule, PDO::PARAM_STR);
			$request->bindValue('Site', $Site, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			//UPDATE
			//Instanciation de la requête
			$request = $conn->prepare("UPDATE Offres SET Intitule = :Intitule, Site = :Site WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $Offre->Identifiant, PDO::PARAM_INT);
			$request->bindValue('Intitule', $Offre->Intitule, PDO::PARAM_STR);
			$request->bindValue('Site', $Site, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		return -1;
	}*/


}
?>
