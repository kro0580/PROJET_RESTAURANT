"use strict";




function manageCart(){
    $('.ajax-cart').click(function(event){
        event.preventDefault();

        var data = {
            id : this.dataset.id,
            quantity : this.dataset.quantity,
            action : this.dataset.action,
            ajax : ''
        };


        $.get(this.href + "ajax=1");
        //$.get(getRequestUrl()+'/cart', data);
    })
}