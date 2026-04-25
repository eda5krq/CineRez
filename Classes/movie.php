<?php
class Movie
{
    private $id;
    private $title;
    private $genre;
    private $duration;
    private $rating;
    private $price;

    public function __construct($id, $title, $genre, $duration, $rating, $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
        $this->duration = $duration;
        $this->rating = $rating;
        $this->price = $price;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getShortInfo()
    {
        return $this->title . ' (' . $this->genre . ') - ' . $this->duration . ' min, Rating: ' . $this->rating;
    }
}
