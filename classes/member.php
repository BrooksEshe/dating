<?php
/**
 * Created by PhpStorm.
 * User: brook
 * Date: 2/14/2019
 * Time: 11:03 AM
 */

class Member
{
    /**
     * @return mixed
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * @param mixed $fname
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * @return mixed
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * @param mixed $lname
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * @return mixed
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * @param mixed $seeking
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * @param mixed $bio
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }
    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Member constructor.
     * @param $_fname
     * @param $_lname
     * @param $_age
     * @param $_gender
     * @param $_phone
     */
    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }
}