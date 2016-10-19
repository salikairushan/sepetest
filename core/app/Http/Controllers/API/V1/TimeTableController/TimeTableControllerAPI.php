<?php

namespace App\Http\Controllers\API\V1\TimeTableController;

use App\Algorithm\Generator;
use App\Algorithm\TimeTable;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * User: Buwaneka Boralessa
 *
 * Class TimeTableControllerAPI
 * @package App\Http\Controllers\API\V1\TimeTableController
 */
class TimeTableControllerAPI extends Controller
{
    private static $timetable = "";

    function __construct()
    {
        /**
         * For Testing Phase
         */
        self::$timetable = new TimeTable();
        self::$timetable->initialize();
        self::$timetable->createTimeTable(Generator::$BATCH_LIST);
    }

    // -----------------------------------------------------------------------------------------------------------------
    //                                              TimeTable API Methods
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Get Batch Time table for requested batch ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getBatchTimeTable(Request $request)
    {
        // get batch ID from request
        $batchID = $request->batchID;

        $res['data'] = self::$timetable->getBATCHSCHEDULES()["#" . $batchID];

        return response(json_encode($res));
    }

    /**
     * Get Hall Time table for requested Hall ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getHallTimeTable(Request $request)
    {
        // get hall ID from request
        $hallID = $request->hallID;

        $res['data'] = self::$timetable->getHALLSCHEDULES()["#" . $hallID];

        return response(json_encode($res));
    }

    /**
     * Get Lab Time table for requested Lab ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getLabTimeTable(Request $request)
    {
        // get hall ID from request
        $labID = $request->labID;

        $res['data'] = self::$timetable->getLABSCHEDULES()["#" . $labID];

        return response(json_encode($res));
    }
}
