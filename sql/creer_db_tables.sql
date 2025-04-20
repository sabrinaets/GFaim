-- Création de la base de données
-- Auteur: Alexandre Gaudreau - GAUA01379801

--CREATE DATABASE Gfaim CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

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
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    codepostal VARCHAR(10) NOT NULL,
    roleId INT NOT NULL,
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    FOREIGN KEY (roleId) REFERENCES Role(idRole) ON DELETE RESTRICT,
    
);


-- Création de la table des restaurants
CREATE TABLE Restaurant (
    idRestaurant INT AUTO_INCREMENT PRIMARY KEY,
    idProprietaire INT NOT NULL,
    nom VARCHAR(50) NOT NULL,
    adresse VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (idProprietaire) REFERENCES Utilisateur(idUtilisateur) ON DELETE CASCADE
);

-- Création de la table des menus
-- idRestaurant: clé étrangère de la table Restaurant
CREATE TABLE Item (
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
    idClient INT NOT NULL,
    idRestaurant INT,
    idLivreur INT,
    prixTotal DECIMAL(5, 2) NOT NULL,
    idStatut INT NOT NULL,
    FOREIGN KEY (idClient) REFERENCES Utilisateur(idUtilisateur) ON DELETE CASCADE,
    FOREIGN KEY (idLivreur) REFERENCES Utilisateur(idUtilisateur) ON DELETE SET NULL,
    FOREIGN KEY (idRestaurant) REFERENCES Restaurant(idRestaurant) ON DELETE SET NULL,
    FOREIGN KEY (idStatut) REFERENCES StatutCommande(idStatut) ON DELETE RESTRICT
);

CREATE TABLE CommandeItem (
    idCommandeItem INT AUTO_INCREMENT PRIMARY KEY,
    idCommande INT NOT NULL,
    idItem INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    FOREIGN KEY (idCommande) REFERENCES Commande(idCommande) ON DELETE CASCADE,
    FOREIGN KEY (idItem) REFERENCES Item(idItem) ON DELETE CASCADE
);

-- Insertion des rôles dans la table Role
INSERT INTO Role (roleName) VALUES ('Admin'), ('Client'), ('Restaurant'), ('Livreur');

-- Insertion des statuts de commande dans la table StatutCommande
INSERT INTO StatutCommande (statut) VALUES ('En attente'), ('En préparation'), ('Prête'), ('Livrée');

INSERT INTO `Utilisateur` (`idUtilisateur`, `username`, `email`, `password`, `phone`, `codepostal`, `roleId`) 
VALUES (NULL, 'Jordan', 'jord199@gmail.com', 'jojo', '4508443963', 'j5l2r8', '4');

INSERT INTO `Utilisateur` (`idUtilisateur`, `username`, `email`, `password`, `phone`, `codepostal`, `roleId`) 
VALUES (NULL, 'AlexG', 'alexgaudfallout@gmail.com', 'root', '4508483903', 'j8l1e0', '3');

INSERT INTO `Utilisateur` (`idUtilisateur`, `username`, `email`, `password`, `phone`, `codepostal`, `roleId`) 
VALUES (NULL, 'Maxime', 'max2001@gmail.com', 'tarkov', '4502586963', 'j8l1e0', '2');