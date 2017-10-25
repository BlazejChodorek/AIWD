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

    /**
     * @var string
     *
     * @ORM\Column(name="createdAt", type="string", length=80, nullable=false)
     */
    private $createdat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="original", type="boolean", nullable=false)
     */
    private $original;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible;


    public function __construct($brand = null, $model = null, $enginepower = null, $acceleration = null, $original = null)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->enginepower = $enginepower;
        $this->acceleration = $acceleration;
        $this->createdat = date('Y-m-d H:i:s');
        $this->original = $original;
        $this->visible = true;
    }

    public function getAllCars($em)
    {
        $cars = $em->getRepository('AppBundle:Car')
            ->createQueryBuilder('p')
            ->where('p.visible = true')
            ->getQuery()
            ->getResult();

        return $cars;
    }

    public function getOriginalCars($em)
    {
        $cars = $em->getRepository('AppBundle:Car')
            ->createQueryBuilder('p')
            ->where('p.original = true')
            ->andWhere('p.visible = true')
            ->getQuery()
            ->getResult();

        return $cars;
    }

    public function getProcessedCars($em)
    {
        $cars = $em->getRepository('AppBundle:Car')
            ->createQueryBuilder('p')
            ->where('p.original = false')
            ->andWhere('p.visible = true')
            ->getQuery()
            ->getResult();

        return $cars;
    }

    public function deleteAllCars($em)
    {
        $cars = $this->getAllCars($em);

        foreach ($cars as $car) {
            $updatedCar = $em->getRepository('AppBundle:Car')->find($car->getId());
            $updatedCar->setVisible(false);
            $em->persist($updatedCar);
            $em->flush();
        }

    }

    public function deleteOriginalCars($em)
    {
        $cars = $this->getOriginalCars($em);

        foreach ($cars as $car) {
            $updatedCar = $em->getRepository('AppBundle:Car')->find($car->getId());
            $updatedCar->setVisible(false);
            $em->persist($updatedCar);
            $em->flush();
        }
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
     * Set createdat
     *
     * @param string $createdat
     *
     * @return Car
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return string
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * Set original
     *
     * @param boolean $original
     *
     * @return Car
     */
    public function setOriginal($original)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * Get original
     *
     * @return boolean
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Car
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
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
