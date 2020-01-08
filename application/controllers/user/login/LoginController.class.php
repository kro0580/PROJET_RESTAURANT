<?php


class LoginController {

    function httpGetMethod(Http $http){
        // affichage du formulaire vide
        return [
            '_form' => new LoginForm()
        ];
    }

    function httpPostMethod(Http $http, array $formfields){

        try{

            $password = $formfields['password'];
            $email = trim($formfields['email']);

            if(empty($email) or empty($password))
                throw new DomainException("Remplissez tous les champs");

            // récupération des infos de l'utilisateur
            $customerModel = new CustomerModel();

            // tentative de connexion
            $customer = $customerModel->login($email, $password);

            // si les étapes précédentes se sont correctement déroulées  j'essai de connecter l'utilisateur
            $session = new Session();
            $session->create($customer['firstname'], $customer['lastname'], $customer['id']);

            // enfin on redirige vers la page d'accueil avec un message
            $flashBag = new FlashBag();
            $flashBag->add("Bravo vous êtes bien connecté content de vous revoir ". $session->get_full_name());
            $http->redirectTo('');

        } catch (DomainException $exception){

            $form = new LoginForm();
            $form->setErrorMessage('<p>'.$exception->getMessage().'</p>');

            return [
                '_form' => $form
            ];
        }
    }
}