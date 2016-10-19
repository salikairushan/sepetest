<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 9/3/2016
 * Time: 10:09 PM
 */

namespace App\Algorithm;


use App\Algorithm\Models\Batch;
use App\Algorithm\Models\Request;
use App\Algorithm\Models\Resource;
use App\Algorithm\Models\Subject;

class Generator
{
    // -----------------------------------------------------------------------------------------------------------------
    //                                      New Logic Implementation - 11-09-2016
    // -----------------------------------------------------------------------------------------------------------------

    public static $HALL_LIST = array(); // stores map of Hall list
    public static $LAB_LIST = array(); // stores map of Lab list
    public static $SUBJECT_LIST = array(); // stores map of Subject list
    public static $REQUEST_LIST = array(); // stores map of Request list
    public static $BATCH_LIST = array(); // stores map of Batch list

    private static $crr_subject_count = 1; // counts the current subject to be pushed into batch subjects array

    function __construct()
    {
        self::calculateTimeSlotsPerDay();
        self::calculateIntervalSlotNo();

        self::createHalls();
        self::createLabs();
        self::createSubjects();
        self::createBatches();
    }


    /**
     * Calculates time slots per day
     * according to user defined lecture start time and end time
     */
    private function calculateTimeSlotsPerDay()
    {
        Constants::$TIME_UNITS_PER_DAY = (Constants::$LECTURE_END - Constants::$LECTURE_START) / Constants::$TIME_SLOT_VALUE;
    }

    /**
     * Calculates the interval slot no for a day slots
     */
    private function calculateIntervalSlotNo(){
        Constants::$INTERVAL_TIME_SLOT = ((Constants::$INTERVAL_START - Constants::$LECTURE_START)/Constants::$TIME_SLOT_VALUE);
    }

    /**
     * Generate Halls list
     */
    private function createHalls()
    {
        for ($i = 1; $i <= Constants::$HALL_COUNT; $i++) {
            $resource = new Resource();
            $resource->setResourceID("@rid_#H0" . $i);
            $resource->setResourceCode("#RES_H_#_0" . $i);
            $resource->setType(Constants::$HALL);
            $resource->setCapacity(rand(50, 150));

            self::$HALL_LIST["#RES_H_#_0" . $i] = $resource;
        }
    }

    /**
     * Generate Labs list
     */
    private function createLabs()
    {
        for ($i = 1; $i <= Constants::$LAB_COUNT; $i++) {
            $resource = new Resource();
            $resource->setResourceID("@rid_#L0" . $i);
            $resource->setResourceCode("#RES_L_#_0" . $i);
            $resource->setType(Constants::$LAB);
            $resource->setCapacity(rand(70, 100));

            self::$LAB_LIST["#RES_L_#_0" . $i] = $resource;
        }
    }

    /**
     * Gennerate Subjects list
     */
    private function createSubjects()
    {
        for ($i = 1; $i <= Constants::$TOTAL_SUBJECT_COUNT; $i++) {
            $subject = new Subject();
            $subject->setSubjectID("@rid_#S0" . $i);
            $subject->setSubjectCode("#IT0" . $i);
            $subject->setSubjectName("SEP-II");
            $subject->setNoOfLectures(Constants::$NO_OF_LEC_HOURS);
            $subject->setNoOfLabs(Constants::$NO_OF_LAB_HOURS);
            $subject->setNoOfTutorials(Constants::$NO_OF_TUTORIAL_HOURS);

            $halls = array();
            $labs = array();
            // add special halls and labs
            if ($i <= Constants::$SPECIAL_COUNT) {
                // add halls
                for ($hl = 1; $hl <= rand(0, Constants::$SPECIAL_COUNT); $hl++) {
                    array_push($halls, self::$HALL_LIST["#RES_H_#_0" . rand(1, Constants::$HALL_COUNT)]);
                }
                // add labs
                for ($lb = 1; $lb <= rand(0, Constants::$SPECIAL_COUNT); $lb++) {
                    array_push($labs, self::$LAB_LIST["#RES_L_#_0" . rand(1, Constants::$LAB_COUNT)]);
                }
            }
            $subject->setSpecial(array(
                "halls" => $halls,
                "labs" => $labs
            ));

            self::$SUBJECT_LIST["#IT0" . $i] = $subject;
        }
    }

    /**
     * Generate Batches list
     */
    private function createBatches()
    {
        for ($y = 1; $y <= Constants::$YEAR_COUNT; $y++) {
            for ($i = 1; $i <= Constants::$BATCH_COUNT; $i++) {
                $batch = new Batch();
                $batch->setBatchID("@rid_#B0" . $y . $i);
                $batch->setBatchNo("#BATCH_" . $y . "_" . $i);
                $batch->setBatchType(Constants::$WEEKDAY);
                $batch->setYear($y);
                $batch->setStream(Constants::$STREAM_IT);
                $batch->setTotStudents(rand(50, 150));

                $subjectList = array();
                for ($s = 0; $s < Constants::$SUBJECT_COUNT; $s++) {
                    array_push($subjectList, self::$SUBJECT_LIST["#IT0" . (self::$crr_subject_count + $s)]->getSubjectCode());
                }

                $batch->setSubjectList($subjectList);

                self::$BATCH_LIST["#BATCH_" . $y . "_" . $i] = $batch;
            }
            self::$crr_subject_count += Constants::$SUBJECT_COUNT;
        }
    }

}