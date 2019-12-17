<?php
require_once __DIR__.'/../Classes/Classes.Categorie.php';
require_once __DIR__.'/../../Config/base.php';
require_once __DIR__.'/../../Helpers/encryption.php';


class CategorieRepository extends base
{
	#region BASE CRUD (Create Read Update Delete)
	public static function GetCategorie($id)
	{
		return CategorieRepository::GetCategories(array($id));
	}

	public static function GetCategories($ids)
	{
		$toReturn = array();

		foreach ($ids as $id)
		{
			//Création de la co
			$conn = parent::CreateConnexion();

			//Instanciation de la requête
			$request = $conn->prepare("SELECT Identifiant, Libelle FROM Categories WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $id, PDO::PARAM_INT);

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
		}
		return $toReturn;
	}

	public static function GetAllCategories()
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Libelle FROM Categories");

		//Mappage des champs variables
		//Pas de champs variables

		//Execution
		$count = $request->execute();

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

	public static function SetCategorie($Categorie)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Categorie->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Categories(Libelle) VALUES (:Libelle)");

			//Mappage des champs variables
			$request->bindValue('Libelle', $Categorie->Libelle, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			//UPDATE
			//Instanciation de la requête
			$request = $conn->prepare("UPDATE Categories SET Libelle = :Libelle WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $Categorie->Identifiant, PDO::PARAM_INT);
			$request->bindValue('Libelle', $Categorie->Libelle, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		return -1;
	}

	public static function DeleteCategorie($Categorie)
	{
		if ($Categorie->Identifiant == 0)
		{
			return 0;
		}
		else
		{
			return DeleteCategorieById($Categorie->Identifiant);
		}
		return -1;
	}



	public static function DeleteCategorieById($Categorieid)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		$categoriesForId = CategorieRepository::GetCategorie($Categorieid);

		if (count($categoriesForId) == 1)
		{
			$request = $conn->prepare("DELETE FROM Categories WHERE Identifiant = :Identifiant");

			$request->bindValue('Identifiant', $Categorieid, PDO::PARAM_INT);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			return count($categoriesForId);
		}
		return -1;
	}

	public static function GetNbPhotoByCategorie($Categorieid)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT COUNT(Photos.Identifiant) as 'count' FROM Photos INNER JOIN Categories ON Categories.Identifiant = Photos.Categorie WHERE Categories.Identifiant = :Categorieid");

		//Mappage des champs variables
		$request->bindValue('Categorieid', $Categorieid, PDO::PARAM_INT);

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

	public static function GetCategorieBySite($SiteId)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Libelle FROM Categories WHERE Site = :SiteId");

		//Mappage des champs variables
		$request->bindValue('SiteId', $SiteId, PDO::PARAM_INT);

		//Execution
		$count = $request->execute();

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

	public static function SetCategorieWithSite($Categorie, $Site)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Categorie->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Categories(Libelle, Site) VALUES (:Libelle, :Site)");

			//Mappage des champs variables
			$request->bindValue('Libelle', $Categorie->Libelle, PDO::PARAM_STR);
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
			$request = $conn->prepare("UPDATE Categories SET Libelle = :Libelle, Site = :Site WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $Categorie->Identifiant, PDO::PARAM_INT);
			$request->bindValue('Libelle', $Categorie->Libelle, PDO::PARAM_STR);
			$request->bindValue('Site', $Site, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		return -1;
	}


}
?>
