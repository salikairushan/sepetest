<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 9/1/2016
 * Time: 9:59 PM
 */

namespace App\Http\Controllers\TimeTableController;

use App\Algorithm\Generator;
use App\Algorithm\TimeTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * User: Buwaneka Boralessa
 *
 * Class AlgorithmController
 * @package App\Http\Controllers\TimeTableController
 */
class AlgorithmController extends Controller
{
//    public function viewResult(Request $request)
//    {
//        $timeTable = new TimeTable();
//        $timeTable->initialize();
//
//        $timeTable->resolvePriorities();
//
//        echo "<h3>Time Table</h3>";
//        self::viewTable($timeTable->getSchedule());
//
//        echo "<h3>Pending Requests</h3>";
//        self::viewPending($timeTable->getPendingRequestStack());
//
//        echo "<h3>Av Subjects to arrange</h3>";
//        $timeTable->resolveSubjects($timeTable->getGenerate()->getSubjectList(), $timeTable->getGenerate()->getPriorityList());
//    }
//
//    /**
//     * ~~~ TESTING ~~~
//     * View output as table
//     *
//     * @param $mainArray
//     */
//    private function viewTable($mainArray)
//    {
//        echo "Size = " . sizeof($mainArray) . " days";
//        echo "<table border='2'>";
//        foreach ($mainArray as $day) {
//            if (isset($day)) {
//                foreach ($day as $hall) {
//                    if (isset($hall)) {
//                        echo "<tr>";
//                        $t = 1;
//                        $slotCount = 1;
//                        foreach ($hall as $timeSlot) {
//                            if ($timeSlot != "") {
//                                echo "<td>";
//                                echo "<table border='1'><tr>";
//                                echo "<td>Day : " . $timeSlot->getDay() . "</td>";
//                                echo "<td>Req : " . $timeSlot->getRequestType() . "</td>";
//                                echo "<td>Slot ID : " . $slotCount . "</td>";
//                                echo "<td>Start Time : " . $timeSlot->getStartTime() . "</td>";
//                                echo "<td>End Time : " . $timeSlot->getEndTime() . "</td>";
//                                echo "<td>Subject Code : " . $timeSlot->getSubjectCode() . "</td>";
//                                echo "<td>Type : " . $timeSlot->getType() . "</td>";
//                                echo "<td>Hall ID : " . $timeSlot->getHallID() . "</td>";
//                                echo "</tr></table>";
//                                echo "</td>";
//
//                                // checks for slot count
//                                if ($timeSlot->getType() == Constants::getTYPELECTURE() || $timeSlot->getType() == Constants::getTYPELAB()) {
//                                    if ($t % 2 == 0) {
//                                        $slotCount++;
//                                    }
//                                } else {
//                                    $slotCount++;
//                                }
//                            }
//                            $t++;
//                        }
//                        echo "</tr>";
//                    }
//                }
//            }
//        }
//        echo "</table>";
//    }
//
//    /**
//     * View pending requests
//     * @param $pendingArray
//     */
//    public function viewPending($pendingArray)
//    {
//        echo "Size = " . sizeof($pendingArray);
//        echo "<table border='1'>";
//        foreach ($pendingArray as $pending) {
//            echo "<tr>";
//            echo "<td>Request ID : " . $pending->getRequestID() . "</td>";
//            echo "<td>Priority Level : " . $pending->getPriorityLevel() . "</td>";
//            echo "<td>Date : " . $pending->getDate() . "</td>";
//            echo "<td>Subject Code : " . $pending->getSubjectCode() . "</td>";
//            echo "<td>Lecture ID ID : " . $pending->getLectureID() . "</td>";
//            echo "<td>Day : " . $pending->getDay() . "</td>";
//            echo "<td>TimeSlot : " . $pending->getTimeSlot() . "</td>";
//            echo "<td>Type : " . $pending->getType() . "</td>";
//            echo "<td>Success : " . $pending->getSuccess() . "</td>";
//            echo "</tr>";
//        }
//        echo "</table>";
//    }


    // -----------------------------------------------------------------------------------------------------------------
    //                                      New Logic Implementation - 11-09-2016
    // -----------------------------------------------------------------------------------------------------------------

    public function viewResult(Request $request)
    {
        $timetable = new TimeTable();
        $timetable->initialize();

//        echo "<h3>Halls</h3>";
//        echo "<pre>";
//        print_r(Generator::$HALL_LIST);
//        echo "</pre>";
//
//        echo "<h3>Labs</h3>";
//        echo "<pre>";
//        print_r(Generator::$LAB_LIST);
//        echo "</pre>";
//
//        echo "<h3>Subjects</h3>";
//        echo "<pre>";
//        print_r(Generator::$SUBJECT_LIST);
//        echo "</pre>";
//
//        echo "<h3>Batches</h3>";
//        echo "<pre>";
//        print_r(Generator::$BATCH_LIST);
//        echo "</pre>";

        $timetable->createTimeTable(Generator::$BATCH_LIST);

        echo "<h3>Batch Schedule List</h3>";
        echo "<pre>";
        print_r($timetable->getBATCHSCHEDULES());
        echo "</pre>";

        echo "<h3>Hall Schedule List</h3>";
        echo "<pre>";
        print_r($timetable->getHALLSCHEDULES());
        echo "</pre>";

        echo "<h3>Lab Schedule List</h3>";
        echo "<pre>";
        print_r($timetable->getLABSCHEDULES());
        echo "</pre>";
    }


}