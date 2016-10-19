<?php

namespace App\Http\Controllers\TimeTableController;

use App\Algorithm\Generator;
use App\Algorithm\TimeTable;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * User: Buwaneka Boralessa
 *
 * Class TimeTableController
 * @package App\Http\Controllers\TimeTableController
 */
class TimeTableController extends Controller
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


    /**
     * View Time Table
     *
     * @param Request $request
     * @return mixed
     */
    public function viewBatchTimeTable(Request $request)
    {
        $res['category'] = "BATCH";

        return View::make('time_table.batch', $res);
    }

    /**
     * View Time Table
     *
     * @param Request $request
     * @return mixed
     */
    public function viewHallTimeTable(Request $request)
    {
        $res['category'] = "HALL";

        return View::make('time_table.hall', $res);
    }

    /**
     * View Time Table
     *
     * @param Request $request
     * @return mixed
     */
    public function viewLabTimeTable(Request $request)
    {
        $res['category'] = "LAB";

        return View::make('time_table.lab', $res);
    }

    /**
     * View Time Table Configurations
     *
     * @param Request $request
     */
    public function viewTimeTableConfig(Request $request){
        $res['category'] = "CONFIGURE";

        return View::make('time_table.config', $res);
    }


    // -----------------------------------------------------------------------------------------------------------------
    //                                          Ajax Page Loaders / Layouts
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Create Time Table view for given Batch ID
     * return Json with rendered HTML view supports for Ajax requests
     *
     * @param Request $request
     * @return mixed
     */
    public function getTimeTableLayout(Request $request)
    {
        if($request->type == "BATCH") {
            // get batch ID from request
            $batchID = $request->batchID;

            $data['data'] = self::$timetable->getBATCHSCHEDULES()["#" . $batchID];
            $data['type'] = $batchID;
        } else if($request->type == "HALL"){
            // get hall ID from request
            $hallID = $request->hallID;

            $data['data'] = self::$timetable->getHALLSCHEDULES()["#" . $hallID];
            $data['type'] = $hallID;
        } else if($request->type == "LAB"){
            // get hall ID from request
            $labID = $request->labID;

            $data['data'] = self::$timetable->getLABSCHEDULES()["#" . $labID];
            $data['type'] = $labID;
        }

        // get rendered Html view
        $HTMLView = (String) view('time_table.time_table_layout')->with($data);

        $res['page'] = $HTMLView;
        $res['data'] = $data;

        // return response as Json
        return response()->json($res);
    }
}
