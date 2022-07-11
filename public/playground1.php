<?php
 
// declare(strict_types=1);
 
class User
{
     const STATUS_ACTIVE = 'active';
     const STATUS_INACTIVE = 'inactive';

    public static $nombreUtilisateursInitialisés = 0;
 
    public function __construct( $username,  $status = self::STATUS_ACTIVE)
    {
        self::getTest();
    }
 
    public function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE])) {
            trigger_error(sprintf('Le status %s n\'est pas valide. Les status possibles sont : %s', $status, implode(', ', [self::STATUS_ACTIVE, self::STATUS_INACTIVE])), E_USER_ERROR);
        };

        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public static function getTest(): string
    {
        echo 'ok';
    }
}
class Admin extends User
{
    public static $nombreAdminInitialisés = 0;


    // mise à jours des valeurs des propriétés syatiques de la classe courante avec self, et de la classe parente avec 'parent'
    public static function nouvelleInitialisation()
    {
        self::$nombreAdminInitialisés++; // CLASSE ADMIN
        parent::$nombreUtilisateursInitialisés++; // CLASSE USER
    }

        // Ajout d'un tableau de rôles pour affiner les droits des administrateurs
    public function __construct( $username, $roles = [], $status = self::STATUS_ACTIVE)
    {
           
            
    }

    // Méthode d'ajout d'un rôle, puis on supprime les doublons aec array_filter
    public function addRole(string $role): void
    {
        $this->roles[] = $role;
        $this->roles = array_filter($this->roles);
    }

    // Méthode de renvoie des rôles, dans lequel on définit le rôle ADMIN par défaut
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ADMIN';

        return $roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function printStatus()
    {
        echo $this->status;
    }

    public function printCustomStatus()
    {
        echo "L'administrateur {$this->username} a pour statut : ";
        $this->printStatus(); // on appelle printStatus du parent depuis la classe enfant
    }

}


// $admin = new Admin('Titouan');
// $admin->printCustomStatus(); // affiche " l'administrateur Titouan a pour statut : active"
// $admin->printStatus(); // printStatus n'existe pas dans la classe Admin, donc printStatus de la classe User sera appelée grâce à l'héritage

// Admin::nouvelleInitialisation();
// echo '<pre>';
// var_dump(Admin::$nombreAdminInitialisés, Admin::$nombreUtilisateursInitialisés, User::$nombreUtilisateursInitialisés);
// echo "\n";
// var_dump(User::$nombreUtilisateursInitialisés);
// echo '</pre>';
User::getTest();

