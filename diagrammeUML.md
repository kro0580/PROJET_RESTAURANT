## Diagramme UML

site e-commerce Restaurant
Livre et vends des repas, permet également de réserver une table

Moteur : innoDB
Encodage : utf-8 general_ci

DISHES
-----------------------------------------------
id                 int      AI      primary        
title              varchar (128)                
price              double           null  
type               varchar (32)     
pictureName        varchar (32)     null       
quantity           int              null
description        text             null            

CUSTOMERS
----------------------------------------------
id                 int  primary AI
lastName           varchar (32)
firstName          varchar (32)
address            varchar (256)
zipCode            int     (5)     unsigned
city               varchar (32)
phone	           int     (10)    unsigned
email              varchar (64)    unique
password           varchar (64)
registerDate       datetime

ORDERS
-----------------------------------------------
id                 int  primary AI
orderDate	       datetime
status	           varchar (16)	
paymentMethod      varchar (16)
customers_id       int  index

ORDERDETAILS
----------------------------------------------
id                 int  primary AI
quantityOrdered    int  unsigned
priceEach          double
orders_id          int  index
dishes_id          int  index

BOOKINGS
---------------------------------------------
id                 int  primary AI
bookDate           datetime
numberSeats        int(2) unsigned
customers_id        int  index

     
     
    Possibilités d'améliorations :
    - préférences localisation table réservée (intérieur, extérieur...)



