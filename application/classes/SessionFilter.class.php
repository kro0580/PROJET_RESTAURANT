<?php


class SessionFilter implements InterceptingFilter {

    function run(Http $http, array $queryFields, array $formFields) {

        // renvoi des variables accessible dans toutes les vues
        // cf. design pattern : filtres d'interception

        $session = new Session();

        if ($session->isLogged()){
            $cart = new CartModel($session);
            $total_in_cart = $cart->get_qty_total_product();
        } else {
            $total_in_cart = 0;
        }

        return [
            'session' => new Session(),
            'total_in_cart' => $total_in_cart
        ];
    }
}