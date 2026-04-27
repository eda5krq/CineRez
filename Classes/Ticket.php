<?php
class Ticket
{
    private $type;
    private $seat;
    private $price;

    public function __construct($type, $seat, $price)
    {
        $this->type = $type;
        $this->seat = $seat;
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getSeat()
    {
        return $this->seat;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getTicketInfo()
    {
        return strtoupper($this->type) . ' - Seat ' . $this->seat . ' - EUR ' . number_format($this->price, 2);
    }
}