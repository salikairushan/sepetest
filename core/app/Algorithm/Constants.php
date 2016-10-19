<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 9/1/2016
 * Time: 9:29 PM
 */

namespace App\Algorithm;


class Constants
{
    // For TESTING
    // Request count
    public static $REQUEST_COUNT = 50;

    public static $TOTAL_SUBJECT_COUNT = 20; // total subjects per semester for all years
    public static $SUBJECT_COUNT = 5; // for one Semester
    public static $HALL_COUNT = 7; // number of halls
    public static $LAB_COUNT = 7; // number of labs

    public static $YEAR_COUNT = 4;
    public static $BATCH_COUNT = 2; // per Year


    public static $LECTURE_START = 830; // 08:30 AM
    public static $LECTURE_END = 1730; // 07:30 PM
    public static $INTERVAL_START = 1230; // 12:30 PM
    public static $INTERVAL_TIME_SLOT = 1; // interval time slot of a day
    public static $TIME_SLOT_VALUE = 100; // 1 hour
    public static $TIME_UNITS_PER_DAY = 0; // working time slots

    public static $NO_OF_LEC_HOURS = 2;
    public static $NO_OF_LAB_HOURS = 2;
    public static $NO_OF_TUTORIAL_HOURS = 1;

    public static $DAYS = ["Monday", "Tuseday", "Wednesday", "Thursday", "Friday"];

    // Resource Types
    public static $HALL = "HALL";
    public static $LAB = "LAB";

    public static $HALL_TYPE = 1; // hall
    public static $LAB_TYPE = 2; // lab


    // Week type
    public static $WEEK_TYPE = ["Weekend", "Weekday"];
    public static $WEEKEND = "Weekend";
    public static $WEEKDAY = "Weekday";

    // streams
    public static $STREAM_IT = "IT";
    public static $STREAM_SE = "SE";
    public static $STREAM_ENG = "ENG";

    // types of slots
    public static $TYPE_LECTURE = "Lecture";
    public static $TYPE_TUTORIAL = "Tutorial";
    public static $TYPE_LAB = "Lab";

    // time-slot request type
    public static $REQ_TYPE = "SRequest";
    public static $NORMAL_TYPE = "NRequest";

    // special labs and halls for subjects
    public static $SPECIAL_COUNT = 5;

    // resources locations
    public static $IT_FACULTY = "IT-FACULTY";
}