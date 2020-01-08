<?php


class RegisterController {
    function httpGetMethod (){

        return [
            // revoies les variables vides dans le formulaire ($firstname...)
            '_form' => new RegisterForm()
        ];
    }

    function httpPostMethod (Http $http, array $formFields){

        try{

            // vérification des champs
            if(empty($formFields['lastname']) or empty($formFields['firstname']) or empty($formFields['email']) or empty($formFields['password']))
                throw new DomainException('tous les champs * doivent être remplis');

            // création de l'utilisateur
            $customerModel = new CustomerModel();
            $customer_id = $customerModel->create(
                $formFields['lastname'],
                $formFields['firstname'],
                $formFields['address'],
                $formFields['city'],
                $formFields['zipCode'],
                $formFields['phone'],
                $formFields['email'],
                $formFields['password']);

            // une fois que c'est fait je le connecte
            $session = new Session();
            $session->create($formFields['firstname'], $formFields['lastname'], $customer_id);

            // enfin on redirige vers la page d'accueil avec un message
            $flashBag = new FlashBag();
            $flashBag->add("Bravo ! Votre inscription est terminé. Bienvenue ". $session->get_full_name());
            $http->redirectTo('');

        } catch (DomainException $exception){
            /**
             * une fois le formulaire envoyé, si l'utilisateur à commmis une erreur, il faut
             * lui réafficher le formulaire avec le message d'erreur et tous les champs qu'il
             * a déjà rempli. Afin qu'il n'ai pas a refaire le boulot 2x.
             *
             * pour renvoyer les champs du formulaire à la vue, on renvoit une instance
             * de la classe Form dans vue avec "_form" , le framework va automatiquement
             * générer les variables correspondant aux inputs
             * **/
            $form = new RegisterForm();
            $form->bind($formFields);

            // on récupère le message qui à été déclenché par un throw new DomainException
            $form->setErrorMessage('<p>'.$exception->getMessage() .'</p>');

            return [
                '_form' => $form
            ];
        }
    }
}