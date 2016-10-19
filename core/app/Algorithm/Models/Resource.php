<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 9/3/2016
 * Time: 9:36 PM
 */

namespace App\Algorithm\Models;


class Resource
{
    private $resourceID; // ID given by the DB
    private $type; // type of the resource (HALL/LAB)
    private $resourceCode; // resource Code
    private $capacity; // capacity of the resource

    /**
     * @return mixed
     */
    public function getResourceID()
    {
        return $this->resourceID;
    }

    /**
     * @param mixed $resourceID
     */
    public function setResourceID($resourceID)
    {
        $this->resourceID = $resourceID;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param mixed $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return mixed
     */
    public function getResourceCode()
    {
        return $this->resourceCode;
    }

    /**
     * @param mixed $resourceCode
     */
    public function setResourceCode($resourceCode)
    {
        $this->resourceCode = $resourceCode;
    }
}