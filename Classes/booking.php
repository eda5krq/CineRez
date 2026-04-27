<?php
class Booking
{
    private $movieId;
    private $userName;
    private $seats;
    private $date;
    private $time;
    private $totalPrice;

    public function __construct($movieId, $userName, $seats, $date, $time, $totalPrice)
    {
        $this->movieId = $movieId;
        $this->userName = $userName;
        $this->seats = $seats;
        $this->date = $date;
        $this->time = $time;
        $this->totalPrice = $totalPrice;
    }

    public function getMovieId()
    {
        return $this->movieId;
    }

    public function setMovieId($movieId)
    {
        $this->movieId = $movieId;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getSeats()
    {
        return $this->seats;
    }

    public function setSeats($seats)
    {
        $this->seats = $seats;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    public function generateReservationCode()
    {
        return 'CRZ-' . date('Y') . '-' . random_int(1000, 9999);
    }

    public function getBookingSummary()
    {
        $seatsText = is_array($this->seats) ? implode(', ', $this->seats) : $this->seats;
        return 'Movie ID: ' . $this->movieId . ' | Name: ' . $this->userName . ' | Seats: ' . $seatsText .
            ' | Date: ' . $this->date . ' | Time: ' . $this->time . ' | Total: EUR ' . number_format($this->totalPrice, 2);
    }
}
