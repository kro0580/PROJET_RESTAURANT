<?php

class Session {

    public function __construct() {
        // on vérifie que la session existe ou on la crée pour pouvoir accéder à $_SESSION
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
    }

    public function create($firstname, $lastname, $customer_id){
        $_SESSION = [
            'user' => [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'id' => $customer_id
            ],
            'cart' => [],
            'isLogged' => true
        ] ;
    }

    public function isLogged() {
        return array_key_exists('isLogged', $_SESSION) and $_SESSION['isLogged'];
    }

    public function get_full_name(){
        return $_SESSION['user']['firstname'] .' '. $_SESSION['user']['lastname'];
    }

    public function get_customer_id(){
        return intval($_SESSION['user']['id']);
    }

    public function destroy(){
        // destruction de la session
        $_SESSION = [];
        session_destroy();
    }

    public function save_cart(array $cart){
        $_SESSION['cart'] = $cart;
    }

    public function get_cart(){
        return $_SESSION['cart'];
    }
}

