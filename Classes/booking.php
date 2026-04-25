<?php

class Booking
{
    private $movieTitle;
    private $customerName;
    private $email;
    private $phone;
    private $tickets;

    public function __construct($movieTitle, $customerName, $email, $phone, $tickets)
    {
        $this->movieTitle = $movieTitle;
        $this->customerName = $customerName;
        $this->email = $email;
        $this->phone = $phone;
        $this->tickets = $tickets;
    }

    public function getMovieTitle()
    {
        return $this->movieTitle;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getTickets()
    {
        return $this->tickets;
    }
}