<?php


class DishModel{

    public function get_all(){
        $sql = "SELECT id, title, description, pictureName, price FROM dishes";
        $database = new Database();
        return $database->query($sql);

    }

    public function get($id){
        $sql = "SELECT id, title, description, quantity AS quantityInStock, pictureName, price FROM dishes WHERE id=?";
        $database = new Database();
        return $database->queryOne($sql, [$id]);
    }

}