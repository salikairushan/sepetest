<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 9/3/2016
 * Time: 9:42 PM
 */

namespace App\Algorithm\Models;


class Batch
{
    private $batchID; // ID given by DB
    private $batchNo; // batch number given for relevant Year
    private $batchType; // WeekEnd / WeekDay
    private $stream; // IT / SE / ENG
    private $year; // batch Year
    private $totStudents; // total enrolled students
    private $subjectList = array(); // stores list of subjects for each batch

    /**
     * @return mixed
     */
    public function getBatchID()
    {
        return $this->batchID;
    }

    /**
     * @param mixed $batchID
     */
    public function setBatchID($batchID)
    {
        $this->batchID = $batchID;
    }

    /**
     * @return mixed
     */
    public function getBatchNo()
    {
        return $this->batchNo;
    }

    /**
     * @param mixed $batchNo
     */
    public function setBatchNo($batchNo)
    {
        $this->batchNo = $batchNo;
    }

    /**
     * @return mixed
     */
    public function getBatchType()
    {
        return $this->batchType;
    }

    /**
     * @param mixed $batchType
     */
    public function setBatchType($batchType)
    {
        $this->batchType = $batchType;
    }

    /**
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @param mixed $stream
     */
    public function setStream($stream)
    {
        $this->stream = $stream;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getTotStudents()
    {
        return $this->totStudents;
    }

    /**
     * @param mixed $totStudents
     */
    public function setTotStudents($totStudents)
    {
        $this->totStudents = $totStudents;
    }

    /**
     * @return array
     */
    public function getSubjectList()
    {
        return $this->subjectList;
    }

    /**
     * @param array $subjectList
     */
    public function setSubjectList($subjectList)
    {
        $this->subjectList = $subjectList;
    }
}