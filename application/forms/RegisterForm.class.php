<?php


class RegisterForm extends Form {

    function build() {
        $this->addFormField('lastname');
        $this->addFormField('firstname');
        $this->addFormField('address');
        $this->addFormField('city');
        $this->addFormField('zipCode');
        $this->addFormField('phone');
        $this->addFormField('email');
        $this->addFormField('password');
    }
}
