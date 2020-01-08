<?php


class LogoutController{

    function httpGetMethod(Http $http){
        $session = new Session();
        $session->destroy();
        $http->redirectTo('');
    }}
