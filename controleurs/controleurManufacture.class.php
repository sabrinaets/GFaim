<?php

include_once("controleurs/controleurAccueilDefaut.class.php");
include_once("controleurs/controleurCommande.class.php");
include_once("controleurs/controleurConfirmation.class.php");
include_once("controleurs/controleurSeConnecter.class.php");
include_once("controleurs/controleurSeDeconnecter.class.php");
include_once("controleurs/controleurSeInscrire.class.php");
include_once("controleurs/controleurGestionAPI.class.php");
include_once("controleurs/controleurVoirRestos.php");
include_once("controleurs/controleurVoirMenu.php");
include_once("controleurs/controleurVoirCommandesDispoLivreur.php");
include_once("controleurs/controleurVoirCommandesALivrerLivreur.php");
include_once("controleurs/controleurAjouterCommandeLivreur.php");
include_once("controleurs/controleurVoirCommandesResto.php");
include_once("controleurs/controleurVoirCommandesClient.php");
include_once("controleurs/controleurVoirMonMenu.php");
include_once("controleurs/controleurAjouterProduit.php");
include_once("controleurs/controleurEditProduct.php");
include_once("controleurs/controleurVoirMesRestos.php");
include_once("controleurs/controleurAjouterResto.php");
include_once("controleurs/controleurModifierResto.php");
include_once("controleurs/controleurVoirStats.php");
include_once("controleurs/controleurLocaliserClient.php");
include_once("controleurs/controleurAnnulerCommandeLivreur.php");
include_once("controleurs/controleurTerminerCommande.php");
include_once("controleurs/controleurAnnulerCommande.php");

class ManufactureControleur
{
	//  Méthode qui crée une instance du controleur associé à l'action
	//  et le retourne
	public static function creerControleur($action): Controleur
	{
		$controleur = null;
		 if ($action == "commande") {
			$controleur = new Commande();
		} elseif ($action == "confirmation") {
			$controleur = new Confirmation();
		} elseif ($action == "seConnecter") {
			$controleur = new SeConnecter();
		} elseif ($action == "seDeconnecter") {
			$controleur = new SeDeconnecter();
		} elseif ($action == "creerCompte") {
			$controleur = new SeInscrire();
		} elseif ($action == "gestionApi") {
			$controleur = new GestionAPI();
		} elseif ($action=="voirRestos"){
			$controleur = new voirRestos();
		} elseif ($action=="voirMenu"){
			$controleur = new voirMenu();
		} elseif($action=="terminerCommande"){
			$controleur = new terminerCommande();
		}
		
		elseif ($action == "accueil") {
			$controleur = new AccueilDefaut();
		} else if ($action == "ajouterCommandeLivreur") {
			$controleur = new AjouterCommandeLivreur();
		} else if ($action == "terminerCommandeLivreur") {
			$controleur = new TerminerCommandeLivreur();
		} else if ($action == "voirCommandesDispoLivreur") {
			$controleur = new VoirCommandesDispoLivreur();
		} else if ($action == "voirCommandeALivrerLivreur") {
			$controleur = new VoirCommandesALivrerLivreur();
		} elseif($action=="voirCommandesResto"){
			$controleur = new voirCommandesResto();
		}
		elseif($action == "voirCommandesClient"){
			$controleur = new voirCommandesClient();
		}
		elseif($action == "annulerCommandeLivreur"){
			$controleur = new annulerCommandeLivreur;
		}
		elseif($action == "annulerCommande"){
			$controleur = new annulerCommande;
		}
		elseif($action == "voirMonMenu"){
			$controleur = new voirMonMenu();
		}
		elseif($action == "editArticle"){
			$controleur = new editProduct();
		}
		elseif($action == "ajouterProduit"){
			$controleur = new ajouterProduit();
		}
		elseif($action == "voirMesRestos"){
			$controleur = new voirMesRestos();
		}
		elseif($action == "modifierResto"){
			$controleur = new modifierResto();
		}
		elseif($action == "ajouterResto"){
			$controleur = new ajouterResto();
		}
		elseif($action == "voirStats"){
			$controleur = new voirStats();
		}
		elseif($action == "localiser"){
			$controleur = new localiserClient();
		}
		else {
			$controleur = new AccueilDefaut();
		}



		return $controleur;
	}
}
