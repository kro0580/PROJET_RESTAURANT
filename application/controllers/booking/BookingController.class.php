<?php

class BookingController {

    function httpGetMethod(Http $http){
        $session = new Session();
        if(!$session->isLogged()){
            $flashBag = new FlashBag();
            $flashBag->add("Vous devez être connecté pour accéder à cette page");
            $http->redirectTo('');
        }

    }

    function httpPostMethod(Http $http,array $formFields){

        // on redirige l'utilisateur s'il n'est pas logué
        $session = new Session();
        if(!$session->isLogged()){
            $flashBag = new FlashBag();
            $flashBag->add("Vous devez être connecté pour accéder à cette page");
            $http->redirectTo('');
        }

        try{
            // le champ date n'est pas rempli
            if(empty($formFields['bookDate']))
                throw new DomainException("Vous devez spécifier une date");

            $bookDate = $formFields['bookDate'] .' '. $formFields['hours'] .':'. $formFields['minutes'];

            // enregistrement de la réservations
            $bookingModel = new BookingModel();
            $bookingModel->create($bookDate, $formFields['numberSeats'], $session->get_customer_id() );

            // message de confirmation et redirection
            $flashBag = new FlashBag();
            $flashBag->add("Merci, votre réservation à bien été prise en compte");
            $http->redirectTo("");


        } catch(DomainException $exception){

            // on réaffiche le formulaire s'il y a eu une erreur
            $form = new BookingForm();
            $form->setErrorMessage($exception->getMessage());

            return [
                '_form' => $form
            ];
        }







    }
}