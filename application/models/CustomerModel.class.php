<?php

class CustomerModel {

    public function login($email, $password){
        // récupération des information de l'utilisateur
        $customer = $this->get_by_email($email);

        // vérification du mot de passe ou du compte
        if(!$customer or !$this->check_password($password, $customer['password']))
            throw new DomainException("Mauvais login ou mot de passe");

        // on renvoit les infos du customer pour gérer la session ensuite
        return $customer;
    }

    /**
     * @param $lastname string
     * @param $firstname string
     * @param $address string
     * @param $city string
     * @param $zipCode int maximum 5 caractères
     * @param $phone int maximum 10 caractères
     * @param $email string doit être unique dans la base
     * @param $password string
     * @return int Customer_id
     */
    public function create($lastname, $firstname, $address, $city, $zipCode, $phone, $email, $password){

        // on vérifie que l'email est bien unique (si on ne le trouve pas en bdd)
        if( $this->get_by_email($email))
            throw new DomainException("Un compte avec cet email existe déjà");

        // hashage du mot de passe
        $password = $this->hash_password($password);


        // définition de la requête d'insertion de l'utilisateur
        $sql = "INSERT INTO customers (lastname, firstname, address, city, zipCode, phone, email, password, registerDate) 
                    VALUES (?,?,?,?,?,?,?,?,NOW())";

        // éxécution de la requête
        $db = new Database();
        $customer_id = $db->executeSql($sql, [$lastname, $firstname, $address, $city, $zipCode, $phone, $email, $password]);

        return $customer_id;
    }
    private function hash_password($password){
        /*
          * Génération du sel, nécessite l'extension PHP OpenSSL pour fonctionner.
          *
          * openssl_random_pseudo_bytes() va renvoyer n'importe quel type de caractères.
          * Or le chiffrement en blowfish nécessite un sel avec uniquement les caractères
          * a-z, A-Z ou 0-9.
          *
          * On utilise donc bin2hex() pour convertir en une chaîne hexadécimale le résultat,
          * qu'on tronque ensuite à 22 caractères pour être sûr d'obtenir la taille
          * nécessaire pour construire le sel du chiffrement en blowfish.
          */
        $salt = '$2y$11$' . substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

        return crypt($password, $salt);
    }

    // la fonction retourne un booléen, après vérification du mot de passe
    private function check_password($password_to_check, $hashed_password){
        // a gauche le mot de passe de la BDD, à droite le mot de passe du formulaire, réencodé
        return $hashed_password == crypt($password_to_check, $hashed_password);
    }

    public function get_by_email($email){
        $db = new Database();
        return $db->queryOne("SELECT * FROM customers WHERE email = ?", [$email]);
    }

    public function get($customer_id){
        $db = new Database();
        return $db->queryOne("SELECT * FROM customers WHERE id = ?", [$customer_id]);
    }

    private function get_all(){}
    private function update($customer_id){}
    private function delete($customer_id){}

}