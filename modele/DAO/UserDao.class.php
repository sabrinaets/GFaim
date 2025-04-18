<?php

include_once(__DIR__ . "/DAO.interface.php");
include_once(__DIR__ . "/../monUser.class.php");
include_once(__DIR__ . "/../monRole.class.php");

class UserDAO implements DAO {

    /**
     * Recherche un utilisateur par ID
     * @param int $id
     * @return User|null
     */
    static public function findById(int $id): ?monUser {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $user = null;
        $requete = $connexion->prepare(
            "SELECT u.*, r.roleName 
             FROM Utilisateur u 
             JOIN Role r ON u.roleID = r.idRole
             WHERE u.idUtilisateur= :id"
        );
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->execute();

        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            $user = new monUser(
                $enr['idUtilisateur'],
                $enr['username'],
                new monRole($enr['roleId'], $enr['roleName']),
                $enr['codepostal'],
                $enr['phone'],
                $enr['email'],
                $enr['password'],

                
            );
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $user;
    }

    /**
     * Retourne tous les utilisateurs
     * @return array
     */
    static public function findAll(): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $users = [];
        $requete = $connexion->prepare(
            "SELECT u.*, r.RoleName 
             FROM Utilisateur u 
             JOIN Role r ON u.RoleID = r.RoleID"
        );
        $requete->execute();

        foreach ($requete as $enr) {
            $users[] = new monUser(
                $enr['UserID'],
                $enr['username'],
                new monRole($enr['RoleID'], $enr['role']),
                $enr['codepostal'],
                $enr['phone'],
                $enr['email'],
                $enr['password'],
            );
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $users;
    }

    /**
     * Insère un nouvel utilisateur dans la base de données
     * @param User $user
     * @return bool
     */
    static public function save(object $user): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        // Stockage dans des variables intermédiaires
        $username = $user->getUserName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $phone = $user->getPhone();
        $codepostal = $user->getCodePostal();
        $roleId = $user->getRole()->getId()??3; // Par défaut, "Client"
    
        if (strlen($password) < 60) { // Les mots de passe hachés avec bcrypt ont une longueur de 60 caractères
            $password = password_hash($password, PASSWORD_BCRYPT); // Hachage si nécessaire
        }

        $requete = $connexion->prepare(
            "INSERT INTO Utilisateur (username, email,password,phone,codepostal,roleId ) 
             VALUES (:username,:email, :password, :phone, :codepostal, :roleId)"
        );

        // Liaison des paramètres
        $requete->bindParam(':username', $username, PDO::PARAM_STR);
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->bindParam(':password', $password, PDO::PARAM_STR);
        $requete->bindParam(':phone', $phone, PDO::PARAM_STR);
        $requete->bindParam(':codepostal', $codepostal, PDO::PARAM_STR);
        $requete->bindParam(':roleId', $roleId, PDO::PARAM_INT);

        $success = $requete->execute();
        if ($success) {
            $user->setId((int)$connexion->lastInsertId());
        }

        return $success;
    }

    /**
     * Met à jour un utilisateur existant
     * @param User $user
     * @return bool
     */
    static public function update(object $user): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }
    
        // Stockage dans des variables intermédiaires
        $id = $user->getId();
        $username = $user->getUserName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $phone = $user->getPhone();
        $codepostal = $user->getCodePostal();
        $roleId = $user->getRole()->getId();
    
        // Vérifier si le mot de passe est déjà haché
        if (strlen($password) < 60) { // Les mots de passe hachés avec bcrypt ont une longueur de 60 caractères
            $password = password_hash($password, PASSWORD_BCRYPT); // Hachage si nécessaire
        }
    
        $requete = $connexion->prepare(
            "UPDATE User 
             SET FirstName = :firstName, LastName = :lastName, Email = :email, 
                 Password = :password, Phone = :phone, Address = :address, RoleID = :roleId 
             WHERE UserID = :id"
        );
    
        // Liaison des paramètres
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $requete->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->bindParam(':password', $password, PDO::PARAM_STR);
        $requete->bindParam(':phone', $phone, PDO::PARAM_STR);
        $requete->bindParam(':codepostal', $codepostal, PDO::PARAM_STR);
        $requete->bindParam(':roleId', $roleId, PDO::PARAM_INT);
    
        return $requete->execute();
    }
    

    /**
     * Supprime un utilisateur de la base de données
     * @param User $user
     * @return bool
     */
    static public function delete(object $user): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        // Stockage dans une variable intermédiaire
        $id = $user->getId();

        $requete = $connexion->prepare("DELETE FROM User WHERE UserID = :id");

        // Liaison du paramètre
        $requete->bindParam(':id', $id, PDO::PARAM_INT);

        return $requete->execute();
    }

    static public function findByEmail(string $email): ?monUser {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }
    
        $requete = $connexion->prepare(
            "SELECT u.*, r.roleName 
             FROM Utilisateur u 
             JOIN Role r ON u.roleId = r.idRole 
             WHERE u.Email = :email"
        );
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->execute();
    
        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            return new monUser(
                $enr['idUtilisateur'],
                $enr['username'],
                new monRole($enr['roleId'], $enr['roleName']),
                $enr['codepostal'],
                $enr['phone'],
                $enr['email'],
                $enr['password']
            );
        }
    
        return null; // Retourne null si aucun utilisateur trouvé
    }
    

    static public function existsByEmail(string $email): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }
    
        $requete = $connexion->prepare(
            "SELECT COUNT(*) as count FROM User WHERE Email = :email"
        );
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->execute();
    
        $result = $requete->fetch();
        return $result['count'] > 0;
    }
    
    public static function findByDescription(string $filter): array{
        $tableau = [];
        return $tableau;  
    }
}