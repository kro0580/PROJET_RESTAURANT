'use strict';

/////////////////////////////////////////////////////////////////////////////////////////
// FONCTIONS                                                                           //
/////////////////////////////////////////////////////////////////////////////////////////

function checkForm(){

    /**
        on vérifie que le script à bien été chargé dans la page pour pouvoir
        instancier la classe de vérification de formulaire. cette méthode
        est très pratique car on peut choisir quand l'éxecuter seulement dans
        les pages ou il y a un formulaire qui a besoin d'être vérifié
     **/
    if(typeof FormValidator === "function"){
        var form = $('form');
        var formValidator = new FormValidator(form);
        formValidator.init();
    }
}



/////////////////////////////////////////////////////////////////////////////////////////
// CODE PRINCIPAL                                                                      //
/////////////////////////////////////////////////////////////////////////////////////////

$(function(){

    /// on affiche le bloc d'erreur s'il y'en a dans la page
    var errorMessage = $('.error-message');
    if( errorMessage.find('p').length > 0){
        errorMessage.fadeIn(1000);
    }

    // on masque le flashbag après 6420ms
    $('.notice').delay(3210).fadeOut(3210);


    // on lance la vérification du formulaire
    checkForm();

    manageCart();

});
