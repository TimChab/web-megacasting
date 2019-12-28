<?php
require_once __DIR__.'/../Classes/Classes.Image.php';
require_once __DIR__.'/../../Config/base.php';
require_once __DIR__.'/../../Helpers/encryption.php';


class ImageRepository extends base
{
	#region BASE CRUD (Create Read Update Delete)
	public static function GetPhoto($id)
	{
		return ImageRepository::GetPhotos(array($id));
	}

	public static function GetPhotos($ids)
	{
		$toReturn = array();

		foreach ($ids as $id)
		{
			//Création de la co
			$conn = parent::CreateConnexion();

			//Instanciation de la requête
			$request = $conn->prepare("SELECT Identifiant, Data, Libelle, Categorie, Site FROM Photos WHERE Identifiant = :Identifiant");

			//Mappage des champs variables
			$request->bindValue('Identifiant', $id, PDO::PARAM_INT);

			//Execution
			$request->execute();

			//Récupération des données dans une var
			$results = $request->fetchAll();

			//Récupération
			foreach ($results as $result)
			{
				$item = new Image();
				$item->Identifiant = $result['Identifiant'];
				$item->Data = $result['Data'];
				$item->Libelle = $result['Libelle'];
				$item->Categorie = $result['Categorie'];
				$item->Site = $result['Site'];

				array_push($toReturn, $item);
			}
		}
		return $toReturn;
	}

	public static function GetAllPhotos()
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Data, Libelle, Categorie, Site FROM Photos");

		//Mappage des champs variables
		//Pas de champs variables

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Image();

			$item->Identifiant = $result['Identifiant'];
			$item->Data = $result['Data'];
			$item->Libelle = $result['Libelle'];
			$item->Categorie = $result['Categorie'];
			$item->Site = $result['Site'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function SetPhoto($Photo, $Categorie, $Site)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		if ($Photo->Identifiant == 0)
		{
			//INSERT
			//Instanciation de la requête
			$request = $conn->prepare("INSERT INTO Photos(Data, Libelle, Categorie, Site) VALUES (:Data, :Libelle, :Categorie, :Site)");

			//Mappage des champs variables
			$request->bindParam('Data', $Photo->Data, PDO::PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
			$request->bindValue('Libelle', $Photo->Libelle, PDO::PARAM_STR);
			$request->bindValue('Categorie', $Categorie, PDO::PARAM_STR);
			$request->bindValue('Site', $Site, PDO::PARAM_STR);

			if ($request->execute())
			{
				return 1;
			}
		}
		return -1;
	}

	public static function DeletePhoto($Photo)
	{
		if ($Photo->Identifiant == 0)
		{
			return 0;
		}
		else
		{
			return DeletePhotoById($Photo->Identifiant);
		}
		return -1;
	}



	public static function DeletePhotoById($Photoid)
	{
		//Création de la co
		$conn = parent::CreateConnexion();

		$photosForId = ImageRepository::GetPhoto($Photoid);

		if (count($photosForId) == 1)
		{
			$request = $conn->prepare("DELETE FROM Photos WHERE Identifiant = :Identifiant");

			$request->bindValue('Identifiant', $Photoid, PDO::PARAM_INT);

			if ($request->execute())
			{
				return 1;
			}
		}
		else
		{
			return count($photosForId);
		}
		return -1;
	}

	public static function GetAllPhotosBySite($idSite)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Data, Libelle, Categorie, Site FROM Photos WHERE Site = :idSite");

		//Mappage des champs variables
		$request->bindValue('idSite', $idSite, PDO::PARAM_INT);

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Image();

			$item->Identifiant = $result['Identifiant'];
			$item->Data = $result['Data'];
			$item->Libelle = $result['Libelle'];
			$item->Categorie = $result['Categorie'];
			$item->Site = $result['Site'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}

	public static function GetNbPhotosBySite($idSite)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT count(Identifiant) as 'count' FROM Photos WHERE Site = :idSite");

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

	public static function GetPhotoByCategorie($idCategorie)
	{
		$toReturn = array();

		//Création de la co
		$conn = parent::CreateConnexion();

		//Instanciation de la requête
		$request = $conn->prepare("SELECT Identifiant, Data, Libelle, Categorie, Site FROM Photos WHERE Photos.Categorie = :idCategorie");

		//Mappage des champs variables
		$request->bindValue('idCategorie', $idCategorie, PDO::PARAM_INT);

		//Execution
		$count = $request->execute();

		//Récupération des données dans une var
		$results = $request->fetchAll();

		//Récupération
		foreach ($results as $result)
		{
			$item = new Image();

			$item->Identifiant = $result['Identifiant'];
			$item->Data = $result['Data'];
			$item->Libelle = $result['Libelle'];
			$item->Categorie = $result['Categorie'];
			$item->Site = $result['Site'];

			array_push($toReturn, $item);
		}
		return $toReturn;
	}
}
?>
