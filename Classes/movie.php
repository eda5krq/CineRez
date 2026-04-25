<?php

class Movie
{
    private $title;
    private $genre;
    private $duration;
    private $rating;
    private $price;

    public function __construct($title, $genre, $duration, $rating, $price)
    {
        $this->title = $title;
        $this->genre = $genre;
        $this->duration = $duration;
        $this->rating = $rating;
        $this->price = $price;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getPrice()
    {
        return $this->price;
    }
}