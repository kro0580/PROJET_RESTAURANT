<?php

class HomeController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {

        $dishes = new DishModel();

        return [
            'dishes' => $dishes->get_all(),
            'flashBag' => new FlashBag()
        ];
    }

    public function httpPostMethod(Http $http, array $formFields)
    {

    }
}