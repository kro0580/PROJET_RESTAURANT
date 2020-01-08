<?php

class CartController {

    function httpGetMethod(Http $http,array $queryFields){

        $flashBag = new FlashBag();
        $session = new Session();
        if($session->isLogged() == false){
            $flashBag->add("Connectes toi");
            $http->redirectTo('');
        }

        $cartModel = new CartModel($session);

        if(array_key_exists("action", $queryFields)){
            $message = $this->cart_action($queryFields, $cartModel);
            $http->redirectTo('cart');
        }

        if(array_key_exists("ajax", $queryFields)){
            echo "salut";
            exit;
        }

        return [
            'dishes'  => $cartModel->get_full_cart(),
            'total'     => $cartModel->get_total()
        ];
    }


    private function cart_action(array $queryFields, CartModel $cartModel){

        $product_id = array_key_exists('id', $queryFields) ? intval($queryFields['id']) : 0;
        $quantity   = array_key_exists('quantity', $queryFields) ? intval($queryFields['quantity']) : 0;

        switch ($queryFields['action']){
            case "add":
                $cartModel->add_product($product_id, $quantity );
                return "Produit ajouté au panier";
                break;
            case "remove":
                $cartModel->remove_product($product_id);
                return "Produit enlevé du panier";
                break;
            case "clear":
                $cartModel->clear();
                return "Le panier à été vidé";
                break;
        }


    }
}