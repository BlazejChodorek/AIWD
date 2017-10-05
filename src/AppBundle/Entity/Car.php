<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity
 */
class Car
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="text", length=65535, nullable=false)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="text", length=65535, nullable=false)
     */
    private $model;

    /**
     * @var integer
     *
     * @ORM\Column(name="enginePower", type="integer", nullable=false)
     */
    private $enginepower;

    /**
     * @var integer
     *
     * @ORM\Column(name="acceleration", type="integer", nullable=false)
     */
    private $acceleration;


    public function __construct($brand, $model, $enginepower, $acceleration)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->enginepower = $enginepower;
        $this->acceleration = $acceleration;
    }


    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return Car
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set enginepower
     *
     * @param integer $enginepower
     *
     * @return Car
     */
    public function setEnginepower($enginepower)
    {
        $this->enginepower = $enginepower;

        return $this;
    }

    /**
     * Get enginepower
     *
     * @return integer
     */
    public function getEnginepower()
    {
        return $this->enginepower;
    }

    /**
     * Set acceleration
     *
     * @param integer $acceleration
     *
     * @return Car
     */
    public function setAcceleration($acceleration)
    {
        $this->acceleration = $acceleration;

        return $this;
    }

    /**
     * Get acceleration
     *
     * @return integer
     */
    public function getAcceleration()
    {
        return $this->acceleration;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
