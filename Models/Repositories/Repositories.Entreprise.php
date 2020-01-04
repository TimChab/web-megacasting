<?php
require_once __DIR__.'/../Classes/Classe.Entreprise.php';
require_once __DIR__.'/../../Config/base.php';
require_once __DIR__.'/../../Helpers/encryption.php';


class EntrepriseRepository extends base
{
	#region BASE CRUD (Create Read Update Delete)
	public static function GetEntreprise($id)
	{
		return EntrepriseRepository::GetEntreprises(array($id));
	}

	public static function GetEntreprises($ids)
	{
		$toReturn = array();

		foreach ($ids as $id)
		{
			//Création de la co
			$conn = parent::CreateConnexion();

			//Instanciation de la requête
			$request = $conn->prepare("SELECT Identifiant, Libelle FROM Entreprise WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $id, PDO::PARAM_INT);

			//Execution
			$request->execute();

			//Récupération des données dans une var
			$results = $request->fetchAll();

			//Récupération
			foreach ($results as $result)
			{
				$item = new Entreprise();
				$item->Identifiant = $result['Identifiant'];
				$item->Libelle = $result['Libelle'];

				array_push($toReturn, $item);
			}
		}
		return $toReturn;
	}

	public static function GetAllEntreprises()
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Libelle, Telephone, Email, Siret FROM Entreprise");

		//Mappage des champs variables
		//Pas de champs variables

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Entreprise();

			$item->Identifiant = $result['Identifiant'];
			$item->Libelle = $result['Libelle'];
			$item->Telephone = $result['Telephone'];
			$item->Email = $result['Email'];
			$item->Siret = $result['Siret'];
			//$item->Url = $result['Url'];


			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function SetEntreprise($Entreprise)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Entreprise->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Entreprises(Libelle) VALUES (:Libelle)");

			//Mappage des champs variables
			$request->bindValue('Libelle', $Entreprise->Libelle, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			//UPDATE
			//Instanciation de la requête
			$request = $conn->prepare("UPDATE Entreprises SET Libelle = :Libelle WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $Entreprise->Identifiant, PDO::PARAM_INT);
			$request->bindValue('Libelle', $Entreprise->Libelle, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		return -1;
	}

	public static function DeleteEntreprise($Entreprise)
	{
		if ($Entreprise->Identifiant == 0)
		{
			return 0;
		}
		else
		{
			return DeleteEntrepriseById($Entreprise->Identifiant);
		}
		return -1;
	}



	public static function DeleteEntrepriseById($Entrepriseid)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		$EntreprisesForId = EntrepriseRepository::GetEntreprise($Entrepriseid);

		if (count($EntreprisesForId) == 1)
		{
			$request = $conn->prepare("DELETE FROM Entreprises WHERE Identifiant = :Identifiant");

			$request->bindValue('Identifiant', $Entrepriseid, PDO::PARAM_INT);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			return count($EntreprisesForId);
		}
		return -1;
	}

/*
	public static function GetNbPhotoByEntreprise($Entrepriseid)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT COUNT(Photos.Identifiant) as 'count' FROM Photos INNER JOIN Entreprises ON Entreprises.Identifiant = Photos.Entreprise WHERE Entreprises.Identifiant = :Entrepriseid");

		//Mappage des champs variables
		$request->bindValue('Entrepriseid', $Entrepriseid, PDO::PARAM_INT);

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

	public static function GetEntrepriseBySite($SiteId)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Libelle FROM Entreprises WHERE Site = :SiteId");

		//Mappage des champs variables
		$request->bindValue('SiteId', $SiteId, PDO::PARAM_INT);

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{

			$item = new Entreprise();

			$item->Identifiant = $result['Identifiant'];
			$item->Libelle = $result['Libelle'];

			array_push($toReturn, $item);

		}
		return $toReturn;
	}

	public static function SetEntrepriseWithSite($Entreprise, $Site)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Entreprise->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Entreprises(Libelle, Site) VALUES (:Libelle, :Site)");

			//Mappage des champs variables
			$request->bindValue('Libelle', $Entreprise->Libelle, PDO::PARAM_STR);
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
			$request = $conn->prepare("UPDATE Entreprises SET Libelle = :Libelle, Site = :Site WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $Entreprise->Identifiant, PDO::PARAM_INT);
			$request->bindValue('Libelle', $Entreprise->Libelle, PDO::PARAM_STR);
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
