-- Création de la base de données
-- Auteur: Alexandre Gaudreau - GAUA01379801

CREATE DATABASE Gfaim CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Sélection de la base de données
USE Gfaim;

-- Création de la table des rôles
Create TABLE Role (
    idRole INT AUTO_INCREMENT PRIMARY KEY,
    roleName VARCHAR(50) NOT NULL
);

CREATE TABLE StatutCommande (
    idStatut INT AUTO_INCREMENT PRIMARY KEY,
    statut VARCHAR(50) NOT NULL
);

-- Création de la table des utilisateurs
-- idRole: 1 = Admin, 2 = Client, 3 = Restaurant, 4 = Livreur
CREATE TABLE Utilisateur (
    idUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    motDePasse VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    idRole INT NOT NULL,
    dateInscription DATETIME NOT NULL,
    FOREIGN KEY (idRole) REFERENCES Role(idRole) ON DELETE RESTRICT
);


-- Création de la table des restaurants
CREATE TABLE Restaurant (
    idRestaurant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    adresse VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    description TEXT NOT NULL
);

-- Création de la table des menus
-- idRestaurant: clé étrangère de la table Restaurant
CREATE TABLE Menu (
    idItem INT AUTO_INCREMENT PRIMARY KEY,
    idRestaurant INT NOT NULL,
    nom VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    prix DECIMAL(5, 2) NOT NULL,
    image VARCHAR(100) NOT NULL,
    FOREIGN KEY (idRestaurant) REFERENCES Restaurant(idRestaurant) ON DELETE CASCADE
);

-- Création de la table des commandes
-- idUtilisateur: clé étrangère de la table Utilisateur
-- idRestaurant: clé étrangère de la table Restaurant
-- listeItems: JSON contenant les items commandés
CREATE TABLE Commande (
    idCommande INT AUTO_INCREMENT PRIMARY KEY,
    idUtilisateur INT NOT NULL,
    idRestaurant INT,
    dateCommande DATETIME NOT NULL,
    prixTotal DECIMAL(5, 2) NOT NULL,
    listeItems TEXT NOT NULL,
    idStatut INT NOT NULL,
    FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur) ON DELETE CASCADE,
    FOREIGN KEY (idRestaurant) REFERENCES Restaurant(idRestaurant) ON DELETE SET NULL,
    FOREIGN KEY (idStatut) REFERENCES StatutCommande(idStatut) ON DELETE RESTRICT
);

-- Insertion des rôles dans la table Role
INSERT INTO Role (roleName) VALUES ('Admin'), ('Client'), ('Restaurant'), ('Livreur');

-- Insertion des statuts de commande dans la table StatutCommande
INSERT INTO StatutCommande (statut) VALUES ('En attente'), ('En préparation'), ('Prête'), ('Livrée');