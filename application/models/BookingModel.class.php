<?php

class BookingModel {
    function create($bookingDate, $numberSeats, $customers_id){
        $db = new Database();
        $sql = "INSERT INTO bookings (bookDate, numberSeats, customers_id) VALUES (?,?,?)";
        $db->executeSql($sql, [$bookingDate, $numberSeats, $customers_id]);
    }
}