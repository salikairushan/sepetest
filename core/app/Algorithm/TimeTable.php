<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 9/4/2016
 * Time: 10:23 PM
 */

namespace App\Algorithm;


use App\Algorithm\Models\TimeSlot;
use Illuminate\Support\Facades\Log;

class TimeTable
{
    // -----------------------------------------------------------------------------------------------------------------
    //                                      New Logic Implementation - 11-09-2016
    // -----------------------------------------------------------------------------------------------------------------

    private $MAIN_SCHEDULE = array();
    private $BATCH_SCHEDULES = array();
    private $HALL_SCHEDULES = array();
    private $LAB_SCHEDULES = array();

    private $PENDING_BATCH_SUBJECT = array();

    public function initialize()
    {
        new Generator();
        self::initArrays();

        Log::info('Time Table Initialized');
    }

    /**
     * initialize main arrays structures
     * with empty attributes
     */
    private function initArrays()
    {
        // init batches array
        foreach (Generator::$BATCH_LIST as $batch) {
            foreach (Constants::$DAYS as $day) {
                for ($time = 0; $time < Constants::$TIME_UNITS_PER_DAY; $time++) {
                    $this->BATCH_SCHEDULES[$batch->getBatchNo()][$day][$time] = "";
                }
            }
        }

        // init halls array
        foreach (Generator::$HALL_LIST as $hall) {
            foreach (Constants::$DAYS as $day) {
                for ($time = 0; $time < Constants::$TIME_UNITS_PER_DAY; $time++) {
                    $this->HALL_SCHEDULES[$hall->getResourceCode()][$day][$time] = "";
                }
            }
        }

        // init labs array
        foreach (Generator::$LAB_LIST as $lab) {
            foreach (Constants::$DAYS as $day) {
                for ($time = 0; $time < Constants::$TIME_UNITS_PER_DAY; $time++) {
                    $this->LAB_SCHEDULES[$lab->getResourceCode()][$day][$time] = "";
                }
            }
        }

        Log::info('Time Table Input arrays mapped with defaults');
    }

    /**
     * Create main time table logic
     *
     * @param $batchList
     */
    public function createTimeTable($batchList)
    {
        // go through $batch list
        foreach ($batchList as $batch) {
            // check for subjects
            foreach ($batch->getSubjectList() as $subjectKey) {
                $subject = Generator::$SUBJECT_LIST[$subjectKey]; // get subject

                // resolve Lecture
                self::resolveResource($subject, $subjectKey, $batch, Constants::$TYPE_LECTURE);

                // resolve Tutorial
                self::resolveResource($subject, $subjectKey, $batch, Constants::$TYPE_TUTORIAL);

                // resolve Labs
                self::resolveLab($subject, $subjectKey, $batch, Constants::$TYPE_LAB);
            }
        }

        Log::info('Run createTimeTable');
    }


    /**
     * Resolve Labs
     *
     * @param $subject
     * @param $subjectKey
     * @param $batch
     * @param $type
     */
    private function resolveLab($subject, $subjectKey, $batch, $type)
    {
        // -------------------------------------------------------------------------------------------------------------
        //                                              Start Checking Lab
        // -------------------------------------------------------------------------------------------------------------

        // check for subject requested labs
        if (isset($subject->getSpecial()["labs"])) {
            $resFound = false; // matching resource found status

            // go through special labs list
            foreach ($subject->getSpecial()["labs"] as $labs) {

                // go through resources
                // labs
                $resFound = self::resolveResourceHallOrLab($labs, $batch, $type, $subjectKey);

                if ($resFound) {
                    break;
                }
            }

            // not matching labs found in special lab list
            if (!$resFound) {
                $resFound = false;
                // go through main lab list
                foreach (Generator::$LAB_LIST as $labs) {
                    if ($labs->getCapacity() >= $batch->getTotStudents()) {
                        $res = self::checkResourceAvailability($this->LAB_SCHEDULES, $labs->getResourceCode(), $type);
                        if ($res != "") {
                            $timeSlot = self::createTimeSlot(
                                $res["startTime"],
                                $res["endTime"],
                                $subjectKey,
                                $labs->getResourceCode(),
                                null,
                                $type,
                                $res["day"],
                                $batch->getBatchNo()
                            );
                            // add to Lab Schedule list
                            self::assignTimeSlots($type, $labs, $res, $timeSlot, $batch);

                            $resFound = true;
                            break;
                        }
                    }
                }

                // yet not found matching lab for Lecture
                if (!$resFound) {
                    // add to pending subject list
                    $this->PENDING_BATCH_SUBJECT[$batch->getBatchNo()][$subjectKey][$type] = $subject;
                }
            }

        } else {
            // no special labs found
            $resFound = false;
            // go through main lab list
            foreach (Generator::$LAB_LIST as $labs) {
                if ($labs->getCapacity() >= $batch->getTotStudents()) {
                    $res = self::checkResourceAvailability($this->LAB_SCHEDULES, $labs->getResourceCode(), $type);
                    if ($res != "") {
                        $timeSlot = self::createTimeSlot(
                            $res["startTime"],
                            $res["endTime"],
                            $subjectKey,
                            $labs->getResourceCode(),
                            null,
                            $type,
                            $res["day"],
                            $batch->getBatchNo()
                        );
                        // add to Hall Schedule list
                        self::assignTimeSlots($type, $labs, $res, $timeSlot, $batch);

                        $resFound = true;
                        break;
                    }
                }
            }

            // yet not found matching hall for Lecture
            if (!$resFound) {
                // add to pending subject list
                $this->PENDING_BATCH_SUBJECT[$batch->getBatchNo()][$subjectKey][$type] = $subject;
            }
        }

        // -------------------------------------------------------------------------------------------------------------
        //                                                  End of Lab
        // -------------------------------------------------------------------------------------------------------------
    }

    /**
     * Resolve Hall or Lab
     *
     * @param $hallS
     * @param $batch
     * @param $type
     * @param $subjectKey
     * @return bool
     */
    private function resolveResourceHallOrLab($hallS, $batch, $type, $subjectKey)
    {
        $resFound = false;
        if($type == Constants::$TYPE_LECTURE || $type == Constants::$TYPE_TUTORIAL) {

            foreach (Generator::$HALL_LIST as $hall) {

                // check for matching resource code and capacity
                if ($hallS->getResourceCode() == $hall->getResourceCode() && $hall->getCapacity() >= $batch->getTotStudents()) {
                    $res = self::checkResourceAvailability($this->HALL_SCHEDULES, $hall->getResourceCode(), $type);
                    if ($res != "") {
                        $timeSlot = self::createTimeSlot(
                            $res["startTime"],
                            $res["endTime"],
                            $subjectKey,
                            $hall->getResourceCode(),
                            null,
                            $type,
                            $res["day"],
                            $batch->getBatchNo()
                        );
                        // add to Hall Schedule list
                        self::assignTimeSlots($type, $hall, $res, $timeSlot, $batch);

                        $resFound = true;
                        break;
                    }
                }
            }

        } else if($type == Constants::$TYPE_LAB){

            foreach (Generator::$LAB_LIST as $lab) {

                // check for matching resource code and capacity
                if ($hallS->getResourceCode() == $lab->getResourceCode() && $lab->getCapacity() >= $batch->getTotStudents()) {
                    $res = self::checkResourceAvailability($this->LAB_SCHEDULES, $lab->getResourceCode(), $type);
                    if ($res != "") {
                        $timeSlot = self::createTimeSlot(
                            $res["startTime"],
                            $res["endTime"],
                            $subjectKey,
                            $lab->getResourceCode(),
                            null,
                            $type,
                            $res["day"],
                            $batch->getBatchNo()
                        );
                        // add to Hall Schedule list
                        self::assignTimeSlots($type, $lab, $res, $timeSlot, $batch);

                        $resFound = true;
                        break;
                    }
                }
            }

        }

        return $resFound;
    }

    /**
     * Resolve Resources
     *
     * @param $subject
     * @param $subjectKey
     * @param $batch
     */
    private function resolveResource($subject, $subjectKey, $batch, $type)
    {
        // -------------------------------------------------------------------------------------------------------------
        //                                  Start Checking Lecture / Tutorial halls
        // -------------------------------------------------------------------------------------------------------------

        // check for subject requested halls
        if (isset($subject->getSpecial()["halls"])) {
            $resFound = false; // matching resource found status

            // go through special halls list
            foreach ($subject->getSpecial()["halls"] as $hallS) {

                // go through resources
                // halls
                $resFound = self::resolveResourceHallOrLab($hallS, $batch, $type, $subjectKey);

                if ($resFound) {
                    break;
                }
            }

            // not matching halls found in special hall list
            if (!$resFound) {
                $resFound = false;
                // go through main hall list
                foreach (Generator::$HALL_LIST as $hall) {
                    if ($hall->getCapacity() >= $batch->getTotStudents()) {
                        $res = self::checkResourceAvailability($this->HALL_SCHEDULES, $hall->getResourceCode(), $type);
                        if ($res != "") {
                            $timeSlot = self::createTimeSlot(
                                $res["startTime"],
                                $res["endTime"],
                                $subjectKey,
                                $hall->getResourceCode(),
                                null,
                                $type,
                                $res["day"],
                                $batch->getBatchNo()
                            );
                            // add to Hall Schedule list
                            self::assignTimeSlots($type, $hall, $res, $timeSlot, $batch);

                            $resFound = true;
                            break;
                        }
                    }
                }

                // yet not found matching hall for Lecture
                if (!$resFound) {
                    // add to pending subject list
                    $this->PENDING_BATCH_SUBJECT[$batch->getBatchNo()][$subjectKey][$type] = $subject;
                }
            }

        } else {
            // no special halls found
            $resFound = false;
            // go through main hall list
            foreach (Generator::$HALL_LIST as $hall) {
                if ($hall->getCapacity() >= $batch->getTotStudents()) {
                    $res = self::checkResourceAvailability($this->HALL_SCHEDULES, $hall->getResourceCode(), Constants::$TYPE_LECTURE);
                    if ($res != "") {
                        $timeSlot = self::createTimeSlot(
                            $res["startTime"],
                            $res["endTime"],
                            $subjectKey,
                            $hall->getResourceCode(),
                            null,
                            Constants::$TYPE_LECTURE,
                            $res["day"],
                            $batch->getBatchNo()
                        );
                        // add to Hall Schedule list
                        self::assignTimeSlots($type, $hall, $res, $timeSlot, $batch);

                        $resFound = true;
                        break;
                    }
                }
            }

            // yet not found matching hall for Lecture
            if (!$resFound) {
                // add to pending subject list
                $this->PENDING_BATCH_SUBJECT[$batch->getBatchNo()][$subjectKey][$type] = $subject;
            }
        }

        // -------------------------------------------------------------------------------------------------------------
        //                                  End of Lecture / Tutorial halls searching
        // -------------------------------------------------------------------------------------------------------------
    }


    /**
     * Assign time-slots to Schdules
     *
     * @param $type
     * @param $hall
     * @param $res
     * @param $timeSlot
     * @param $batch
     */
    private function assignTimeSlots($type, $hall, $res, $timeSlot, $batch)
    {
        if ($type == Constants::$TYPE_LECTURE || $type == Constants::$TYPE_LAB) {
            for ($x = 0; $x < Constants::$NO_OF_LEC_HOURS; $x++) {
                if ($type == Constants::$TYPE_LECTURE) {
                    $this->HALL_SCHEDULES[$hall->getResourceCode()][$res["day"]][$res["slot"] + $x] = self::convertTimeSlotToArray($timeSlot);
                } else {
                    $this->LAB_SCHEDULES[$hall->getResourceCode()][$res["day"]][$res["slot"] + $x] = self::convertTimeSlotToArray($timeSlot);
                }
                $this->BATCH_SCHEDULES[$batch->getBatchNo()][$res["day"]][$res["slot"] + $x] = self::convertTimeSlotToArray($timeSlot);
            }
        } else {
            $this->HALL_SCHEDULES[$hall->getResourceCode()][$res["day"]][$res["slot"]] = self::convertTimeSlotToArray($timeSlot);
            $this->BATCH_SCHEDULES[$batch->getBatchNo()][$res["day"]][$res["slot"]] = self::convertTimeSlotToArray($timeSlot);
        }
    }


    /**
     * Create array type timeslot
     *
     * @param $timeSlot
     * @return mixed
     */
    private function convertTimeSlotToArray($timeSlot)
    {
        $slot['startTime'] = $timeSlot->getStartTime();
        $slot['endTime'] = $timeSlot->getEndTime();
        $slot['subjectCode'] = $timeSlot->getSubjectCode();
        $slot['resource'] = $timeSlot->getResource();
        $slot['request'] = $timeSlot->getRequest();
        $slot['type'] = $timeSlot->getType();
        $slot['day'] = $timeSlot->getDay();
        $slot['batch'] = $timeSlot->getBatch();

        return $slot;
    }

    /**
     * Checks for resource availability
     *
     * @param $resourceArray
     * @param $resCode
     * @param $type
     * @return array
     */
    private function checkResourceAvailability($resourceArray, $resCode, $type)
    {
        $res = "";

        foreach ($resourceArray[$resCode] as $key => $resPerDay) {
            $status = false; // matching slot found status
            for ($s = 0; $s < sizeof($resPerDay); $s++) {
                if ($s != Constants::$INTERVAL_TIME_SLOT) {
                    if ($type == Constants::$TYPE_LECTURE || $type == Constants::$TYPE_LAB) {
                        // free slot
                        if ($s != (sizeof($resPerDay) - 1) && ($s != Constants::$INTERVAL_TIME_SLOT) && ($s + 1 != Constants::$INTERVAL_TIME_SLOT) && $resPerDay[$s] == "" && $resPerDay[$s + 1] == "") {
                            $res = array(
                                "startTime" => (Constants::$LECTURE_START + $s * Constants::$TIME_SLOT_VALUE),
                                "endTime" => (Constants::$LECTURE_START + ($s + Constants::$NO_OF_LEC_HOURS) * Constants::$TIME_SLOT_VALUE),
                                "day" => $key,
                                "slot" => $s
                            );

                            $status = true;
                        }
                    } else if ($type == Constants::$TYPE_TUTORIAL) {
                        // free slot
                        if ($resPerDay[$s] == "" && $s != Constants::$INTERVAL_TIME_SLOT) {
                            $res = array(
                                "startTime" => (Constants::$LECTURE_START + $s * Constants::$TIME_SLOT_VALUE),
                                "endTime" => (Constants::$LECTURE_START + ($s + Constants::$NO_OF_TUTORIAL_HOURS) * Constants::$TIME_SLOT_VALUE),
                                "day" => $key,
                                "slot" => $s
                            );

                            $status = true;
                        }
                    }
                }

                if ($status) {
                    break;
                }
            }

            if ($status) {
                break;
            }
        }

        return $res;
    }


    /**
     * Create Time Slot
     *
     * @param $startTime
     * @param $endTime
     * @param $subjectCode
     * @param $resourceCode
     * @param $request
     * @param $type
     * @param $day
     * @param $batch
     * @return TimeSlot
     */
    private function createTimeSlot($startTime, $endTime, $subjectCode, $resourceCode, $request, $type, $day, $batch)
    {
        $timeSlot = new TimeSlot();

        $timeSlot->setStartTime($startTime);
        $timeSlot->setEndTime($endTime);
        $timeSlot->setSubjectCode($subjectCode);
        $timeSlot->setResource($resourceCode);
        $timeSlot->setRequest($request);
        $timeSlot->setType($type);
        $timeSlot->setDay($day);
        $timeSlot->setBatch($batch);

        return $timeSlot;
    }

    /**
     * @return array
     */
    public function getMAINSCHEDULE()
    {
        return $this->MAIN_SCHEDULE;
    }

    /**
     * @return array
     */
    public function getBATCHSCHEDULES()
    {
        return $this->BATCH_SCHEDULES;
    }

    /**
     * @return array
     */
    public function getHALLSCHEDULES()
    {
        return $this->HALL_SCHEDULES;
    }

    /**
     * @return array
     */
    public function getLABSCHEDULES()
    {
        return $this->LAB_SCHEDULES;
    }


    /**
     * Check for row Tutorial present
     *
     * @param $data
     * @param $rowNo
     * @return bool
     */
    public static function checkTutorial($data, $rowNo)
    {
        foreach ($data as $key => $value) {
            if (isset($data[$key][$rowNo]) && $data[$key][$rowNo] != "") {
                if ($data[$key][$rowNo]['type'] == Constants::$TYPE_TUTORIAL) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get Start Time
     *
     * @param $start
     * @return int
     */
    public static function getStartTime($start)
    {
        return self::getTimeString((Constants::$LECTURE_START + ($start * Constants::$TIME_SLOT_VALUE)));
    }

    /**
     * Get End Time
     *
     * @param $start
     * @return int
     */
    public static function getEndTime($start)
    {
        $addCount = Constants::$NO_OF_LEC_HOURS;
        if((Constants::$LECTURE_START + ($start * Constants::$TIME_SLOT_VALUE)) == Constants::$INTERVAL_START)
            $addCount = 1;

        return self::getTimeString(Constants::$LECTURE_START + (($start + $addCount) * Constants::$TIME_SLOT_VALUE));
    }

    /**
     * Get String type Time format
     *
     * @param $time
     * @return string
     */
    public static function getTimeString($time)
    {
        $string = "";
        if ($time < 1000) {
            $string = "0" . $time;
            $string = substr($string, 0, 2) . ":" . substr($string, 2, 2);
        } else {
            $string = $time;
            $string = substr($string, 0, 2) . ":" . substr($string, 2, 2);
        }

        if ($time < 1200) {
            $string = $string . " AM";
        } else {
            $string = $string . " PM";
        }

        return $string;
    }
}