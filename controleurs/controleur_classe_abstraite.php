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
			if ($utilisateurConnecte instanceof monUser && $utilisateurConnecte->getRole() instanceof monRole) {
				return $utilisateurConnecte->getRole()->getRoleName() === "Admin";
			}
		}

		return false; 
	}


	abstract public function executerAction();

	
	private function determinerActeur(): void
	{
		
		if (isset($_SESSION['utilisateurConnecte'])) {
			$this->acteur = "utilisateur";
		}
	}

}
