<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 9/3/2016
 * Time: 9:26 PM
 */

namespace App\Algorithm\Models;


class Request
{
    private $requestID; // request ID
    private $priorityLevel; // DB priority ID
    private $date; // date of request
    private $subjectCode; // requested subject ID
    private $lectureID; // requested Lecture ID
    private $day; // requested day
    private $timeSlot; // requested time Slot
    private $type; // requested for Lecture / Tutorial / Lab
    private $success; // status of request acceptance

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function getPriorityLevel()
    {
        return $this->priorityLevel;
    }

    /**
     * @param mixed $priorityLevel
     */
    public function setPriorityLevel($priorityLevel)
    {
        $this->priorityLevel = $priorityLevel;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
    public function getRequestID()
    {
        return $this->requestID;
    }

    /**
     * @param mixed $requestID
     */
    public function setRequestID($requestID)
    {
        $this->requestID = $requestID;
    }

    /**
     * @return mixed
     */
    public function getLectureID()
    {
        return $this->lectureID;
    }

    /**
     * @param mixed $lectureID
     */
    public function setLectureID($lectureID)
    {
        $this->lectureID = $lectureID;
    }

    /**
     * @return mixed
     */
    public function getTimeSlot()
    {
        return $this->timeSlot;
    }

    /**
     * @param mixed $timeSlot
     */
    public function setTimeSlot($timeSlot)
    {
        $this->timeSlot = $timeSlot;
    }

    

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
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
}