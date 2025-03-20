<?php

abstract class Controleur
{
	
	protected $messagesErreur = array();
	protected $acteur = "visiteur";


	public function __construct()
	{
		$this->determinerActeur();
	}

	public function getMessagesErreur(): array
	{
		return $this->messagesErreur;
	}
	public function getActeur(): string
	{
		return $this->acteur;
	}


	public function isAdmin(): bool
	{
		// Vérifie si l'utilisateur est connecté
		if ($this->acteur === "utilisateur" && isset($_SESSION['utilisateurConnecte'])) {
			$utilisateurConnecte = $_SESSION['utilisateurConnecte'];

			// Vérifie si l'objet est une instance de User et possède un rôle valide
			if ($utilisateurConnecte instanceof User && $utilisateurConnecte->getRole() instanceof Role) {
				return $utilisateurConnecte->getRole()->getRoleName() === "Admin";
			}
		}

		return false; // Retourne false par défaut
	}


	abstract public function executerAction();

	// ****************** Méthode privée
	private function determinerActeur(): void
	{
		//creation d'une session ou recuperation de la session existante
		session_start();
		//Si la session de l'utilisateur existe, le type d'utilisateur
		// devient, utilisateur, il est connecté
		if (isset($_SESSION['utilisateurConnecte'])) {
			$this->acteur = "utilisateur";
		}
	}

}
