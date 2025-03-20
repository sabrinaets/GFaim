<?php
class User
{
    private ?int $id;
    private string $username;
    private string $email;
    private string $password;
    private ?string $phone;
    private ?string $address;
    private Role $role;

       // Constructor
       public function __construct(
        ?int $id,
        string $username,
        string $email,
        string $password,
        ?string $phone,
        ?string $address,
        Role $role
    ) {
        $this->id = $id;
        $this->username=$username;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->address = $address;
        $this->role = $role;
    }

    // Getters and Setters for $id
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Getters and Setters for $firstName
    public function getUserName(): string
    {
        return $this->username;
    }

    public function setUserName(string $username): void
    {
        $this->username = $username;
    }

    // Getters and Setters for $email
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Getters and Setters for $password
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    // Getters and Setters for $phone
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    // Getters and Setters for $address
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    // Getters and Setters for $role
    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }


     // Method to verify password
     public function verifyPassword(string $password): bool
     {
         // Assuming $this->password is a hashed password (e.g., bcrypt)
         return password_verify($password, $this->password);
     }

     // Méthode pour hacher le mot de passe 
     public function hashPassword(): void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    
    // __toString method
    public function __toString(): string
    {
        return sprintf(
            "[User #%d] %s %s - %s (%s, %s)",
            $this->id,
            $this->username,
            $this->email,
            $this->phone ?? "No phone",
            $this->role->getRoleName()
        );
    }
}
?>