<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table( name="User" )
 */

 class User {
    /**
     * @ORM\Column( type="integer" )
     * @ORM\Id
     * @ORM\GeneratedValue( strategy="AUTO" )
     */
    private $id;

    /**
     * @ORM\Column( type="string", length=100 )
     */
    private $name;
    /**
     * @ORM\Column( type="string", length=100 )
     */
    private $username;
    /**
     * @ORM\Column( type="string", length=100 )
     */
    private $password;

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setId( $id ){
        $this->id = $id;
    }

    public function setName( $name ){
        $this->name = $name;
    }

    public function setUsername( $username ){
        $this->username = $username;
    }

    public function setPassword( $password ){
        $this->password = $password;
    }

    public function toString(){
        return $this->name;
    }
    
    public function getRecords(){
        return $this;
    }
}