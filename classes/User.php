<?php

class User
{
    public function __construct(
        private $email,
        private $name,
        private $password,
        private $room,
        private $profPic
    ) {}

    //Getting User Email
    public function getEmail()
    {
        return $this->email;
    }

    //Getting User name
    public function getName()
    {
        return $this->name;
    }

    //Getting User Room
    public function getRoom()
    {
        return $this->room;
    }

    //Getting User Password
    public function getPassword()
    {
        return $this->password;
    }

    //Getting User Profile Image
    public function getProfPic()
    {
        return $this->profPic;
    }

    //Set User Name
    public function setName($name)
    {
        $this->name = $name;
    }

    //Set User Password
    public function setPassword($password)
    {
        $this->password = $password;
    }

    //Set User room
    public function setRoom($room)
    {
        $available_rooms = ['Application1', 'Application2', 'Cloud'];
        if (in_array($room, $available_rooms)) {
            $this->room = $room;
        }
    }

    //Set User Profile Image
    public function setProfPic($profPic)
    {
        $this->profPic = $profPic;
    }

    
}
