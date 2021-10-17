<?php

class Course
{
    private $name;
    private $day;
    private $start;
    private $total;
    private $room;

    public function __construct($name, $day, $start, $total, $room = '...')
    {
        $this->name = $name;
        $this->day = $day;
        $this->start = $start;
        $this->total = $total;
        $this->room = $room;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setDay($day)
    {
        $this->day = $day;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setRoom($room)
    {
        $this->room = $room;
    }

    public function getRoom()
    {
        return $this->room;
    }
}
