<?php

use Illuminate\Database\Seeder;

/**
 * User: Buwaneka Boralessa
 *
 * Class TimeTableSeeder
 */
class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createHalls();
        $this->createLabs();
        $this->createSubjects();

    }


    /**
     * Generate Halls list
     */
    private function createHalls()
    {
        for ($i = 1; $i <= \App\Algorithm\Constants::$HALL_COUNT; $i++) {
            DB::table('rooms')->insert([
                'room_no' => "#RES_H_#_0" . $i,
                'room_type' => \App\Algorithm\Constants::$HALL_TYPE,
                'student_count' => rand(50, 150),
                'location' => \App\Algorithm\Constants::$IT_FACULTY,
                'active' => true
            ]);
        }
    }

    /**
     * Generate Labs list
     */
    private function createLabs()
    {
        for ($i = 1; $i <= \App\Algorithm\Constants::$LAB_COUNT; $i++) {
            DB::table('rooms')->insert([
                'room_no' => "#RES_L_#_0" . $i,
                'room_type' => \App\Algorithm\Constants::$LAB_TYPE,
                'student_count' => rand(70, 100),
                'location' => \App\Algorithm\Constants::$IT_FACULTY,
                'active' => true
            ]);
        }
    }


    /**
     * Gennerate Subjects list
     */
    private function createSubjects()
    {
//        for ($i = 1; $i <= Constants::$TOTAL_SUBJECT_COUNT; $i++) {
//            $subject = new Subject();
//            $subject->setSubjectID("@rid_#S0" . $i);
//            $subject->setSubjectCode("#IT0" . $i);
//            $subject->setSubjectName("SEP-II");
//            $subject->setNoOfLectures(Constants::$NO_OF_LEC_HOURS);
//            $subject->setNoOfLabs(Constants::$NO_OF_LAB_HOURS);
//            $subject->setNoOfTutorials(Constants::$NO_OF_TUTORIAL_HOURS);
//
//            $halls = array();
//            $labs = array();
//            // add special halls and labs
//            if ($i <= Constants::$SPECIAL_COUNT) {
//                // add halls
//                for ($hl = 1; $hl <= rand(0, Constants::$SPECIAL_COUNT); $hl++) {
//                    array_push($halls, self::$HALL_LIST["#RES_H_#_0" . rand(1, Constants::$HALL_COUNT)]);
//                }
//                // add labs
//                for ($lb = 1; $lb <= rand(0, Constants::$SPECIAL_COUNT); $lb++) {
//                    array_push($labs, self::$LAB_LIST["#RES_L_#_0" . rand(1, Constants::$LAB_COUNT)]);
//                }
//            }
//            $subject->setSpecial(array(
//                "halls" => $halls,
//                "labs" => $labs
//            ));
//
//            self::$SUBJECT_LIST["#IT0" . $i] = $subject;
//        }
    }
}
