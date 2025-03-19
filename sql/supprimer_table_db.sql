-- Fichier sql pour supprimer les tables de la base de données Gfaim

-- Supression des données et de la table Utilisateur
DELETE FROM Utilisateur;
DROP TABLE Utilisateur;

-- Supression des données et de la table Commande
DELETE FROM Commande;
DROP TABLE Commande;

-- Supression des données et de la table Menu
DELETE FROM Menu;
DROP TABLE Menu;

-- Supression des données et de la table Restaurant
DELETE FROM Restaurant;
DROP TABLE Restaurant;

-- Supression des données et de la table Role
DELETE FROM Role;
DROP TABLE Role;

-- Supression des données et de la table StatutCommande
DELETE FROM StatutCommande;
DROP TABLE StatutCommande;

-- Supression de la base de données Gfaim
DROP DATABASE Gfaim;