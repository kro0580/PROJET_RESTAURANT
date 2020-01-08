<?php

class CartModel {
    private $session;

    public function __construct(Session $userSession) {
        $this->session = $userSession;
    }


    public function add_product($id, $quantity){
        $cart = $this->get_cart();

        if(!array_key_exists($id, $cart)){
            // si le produit n'existe pas je le crée
            $cart[$id] = $quantity;

        } else {
            // sinon j'incrémente sa quantité
            $cart[$id] += $quantity;
        }

        // si la quantité est nulle on supprime le produit du panier
        if($cart[$id] >= 0 )
            $this->save_cart($cart);

    }


    public function get_qty_total_product(){
        $dishes = $this->get_cart();
        $total = 0;
        foreach ($dishes as $dish_id => $quantity){
            $total += $quantity;
        }
        return $total;
    }

    public function get_full_cart(){
        $cart = $this->get_cart();
        $dishes = [];

        $dishModel = new DishModel();

        foreach($cart as $dish_index => $quantity){
            if($quantity <=0)
                continue;

            // on rempli le pannier avec les infos de la base
            $dishes[$dish_index] =  $dishModel->get($dish_index);

            // on oublie pas de rajouter la quantité qui était là à la base
            $dishes[$dish_index]['quantity'] = $quantity;
        }

        return $dishes;

    }

    public function get_product_cart(){}

    public function remove_product($id){
        $cart = $this->get_cart();

        // on vire du tableau la ligne correspondante
        array_splice($cart,$id,1);

        $this->save_cart($cart);
    }


    public function get_total(){
        $dishes = $this->get_full_cart();
        $total = 0;

        foreach ($dishes as $dish) {
            $total += $dish['quantity'] *  $dish['price'];
        }

        return $total;
    }

    public  function clear(){$this->save_cart([]);}

    private function get_cart(){return $this->session->get_cart();    }
    private function save_cart(array $cart){$this->session->save_cart($cart);    }

}
