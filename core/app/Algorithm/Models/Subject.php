<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 9/3/2016
 * Time: 9:42 PM
 */

namespace App\Algorithm\Models;


class Subject
{
    private $subjectID; // DB given ID
    private $subjectName; // Name of the Subject
    private $subjectCode; // Subject Code
    private $no_of_lectures; // no of lectures per week
    private $no_of_labs; // no of labs per week
    private $no_of_tutorials; // no of tutorials per week
    private $special = array(); // stores specially requested halls or labs for subjects

    /**
     * @return mixed
     */
    public function getSubjectID()
    {
        return $this->subjectID;
    }

    /**
     * @param mixed $subjectID
     */
    public function setSubjectID($subjectID)
    {
        $this->subjectID = $subjectID;
    }

    /**
     * @return mixed
     */
    public function getSubjectName()
    {
        return $this->subjectName;
    }

    /**
     * @param mixed $subjectName
     */
    public function setSubjectName($subjectName)
    {
        $this->subjectName = $subjectName;
    }

    /**
     * @return mixed
     */
    public function getSubjectCode()
    {
        return $this->subjectCode;
    }

    /**
     * @param mixed $subjectCode
     */
    public function setSubjectCode($subjectCode)
    {
        $this->subjectCode = $subjectCode;
    }

    /**
     * @return mixed
     */
    public function getNoOfLectures()
    {
        return $this->no_of_lectures;
    }

    /**
     * @param mixed $no_of_lectures
     */
    public function setNoOfLectures($no_of_lectures)
    {
        $this->no_of_lectures = $no_of_lectures;
    }

    /**
     * @return mixed
     */
    public function getNoOfLabs()
    {
        return $this->no_of_labs;
    }

    /**
     * @param mixed $no_of_labs
     */
    public function setNoOfLabs($no_of_labs)
    {
        $this->no_of_labs = $no_of_labs;
    }

    /**
     * @return mixed
     */
    public function getNoOfTutorials()
    {
        return $this->no_of_tutorials;
    }

    /**
     * @param mixed $no_of_tutorials
     */
    public function setNoOfTutorials($no_of_tutorials)
    {
        $this->no_of_tutorials = $no_of_tutorials;
    }

    /**
     * @return array
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * @param array $special
     */
    public function setSpecial($special)
    {
        $this->special = $special;
    }
}