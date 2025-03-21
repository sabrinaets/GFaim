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
		} elseif ($action == "accueil") {
			$controleur = new AccueilDefaut();
		} else if ($action == "ajouterCommandeLivreur") {
			$controleur = new AjouterCommandeLivreur();
		} else if ($action == "terminerCommandeLivreur") {
			$controleur = new TerminerCommandeLivreur();
		} else if ($action == "voirCommandesDispoLivreur") {
			$controleur = new VoirCommandesDispoLivreur();
		}
		else {
			$controleur = new AccueilDefaut();
		}



		return $controleur;
	}
}
