<?php
/**
 * Created by PhpStorm.
 * User: brook
 * Date: 2/14/2019
 * Time: 11:06 AM
 */

class PremiumMember extends Member
{

    private $_inDoorInterests;
    private $_outDoorInterests;


    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        parent::__construct($fname,$lname,$age,$gender,$phone);
    }

    /**
     * @return mixed
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * @param mixed $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * @return mixed
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * @param mixed $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }
}