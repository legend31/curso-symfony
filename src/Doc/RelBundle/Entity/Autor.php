<?php

namespace Doc\RelBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Autor
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param mixed $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }
    public $genero;
}