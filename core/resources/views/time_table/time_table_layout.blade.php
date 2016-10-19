<style>
    .table-bordered tbody tr td {
        border: 1px solid #4b4b4b;
        text-align: center;
        height: 40px !important;
        vertical-align: middle !important;
    }

    .table-bordered tbody tr td:hover {
        cursor: pointer;
        background: rgba(192, 50, 0, 0.6);
        color: #FFF;
    }

    .table-bordered thead tr th {
        border-top: 1px solid #4b4b4b !important;
        border: 1px solid #4b4b4b;
        background: rgba(217, 189, 0, 0.47);
        text-align: center;
    }

    .table-bordered tbody tr th {
        border: 1px solid #4b4b4b;
        background: #e7e7e7;
        text-align: center;
        vertical-align: middle;
    }

    .interval-td {
        color: #000 !important;
        background: rgba(221, 146, 1, 0.46) !important;
    }
</style>

<div class="header" style="padding: 5px 18px; border-bottom: 0px;">
    <h2>
        #&nbsp;{{ ucfirst(strtolower($type)) }}
    </h2>
</div>
<div class="body table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="20%">Time</th>
            @foreach($data as $key => $value)
                <th width="16%">{{ $key }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <?php
            foreach($data as $key => $value) {
                for ($x=0;$x<sizeof($data[$key]);$x++) {
                    $checkTutorial = \App\Algorithm\TimeTable::checkTutorial($data,$x);
                    if($x == \App\Algorithm\Constants::$INTERVAL_TIME_SLOT){
        ?>
        <tr>
            <th>
                {{ \App\Algorithm\TimeTable::getStartTime($x) }} - {{  \App\Algorithm\TimeTable::getEndTime($x) }}
            </th>
            <td  colspan="{{ sizeof($data) }}" class="interval-td">
                INTERVAL
            </td>
        </tr>
        <?php
                    continue;
                    } else {
        ?>
        <tr>
        <?php
                        if(($x < \App\Algorithm\Constants::$INTERVAL_TIME_SLOT && $x%2 == 0) || ($x > \App\Algorithm\Constants::$INTERVAL_TIME_SLOT && $x%2 != 0)){
        ?>
        <th rowspan="2">
            {{ \App\Algorithm\TimeTable::getStartTime($x) }} - {{ \App\Algorithm\TimeTable::getEndTime($x) }}
        </th>
        <?php
                        }
                    }

                    foreach($data as $key_2 => $value_2) {

                        if (isset($data[$key_2][$x]) && $data[$key_2][$x] != "") {
                            if ($data[$key_2][$x]['type'] == \App\Algorithm\Constants::$TYPE_LECTURE || $data[$key_2][$x]['type'] == \App\Algorithm\Constants::$TYPE_LAB) {
                                if(isset($data[$key_2][$x+1]) && $data[$key_2][$x+1] != "" && ($data[$key_2][$x+1]['type'] == \App\Algorithm\Constants::$TYPE_LECTURE || $data[$key_2][$x+1]['type'] == \App\Algorithm\Constants::$TYPE_LAB) && $data[$key_2][$x]['subjectCode'] == $data[$key_2][$x+1]['subjectCode']) {
        ?>
        <td rowspan="2" data-toggle="modal" data-target="#defaultModal">
            {{ $data[$key_2][$x]['subjectCode'] }}
            <br>
            {{ $data[$key_2][$x]['resource'] }}
            <br>
            {{ $data[$key_2][$x]['type'] }}
        </td>
        <?php
                                }
                            } else if ($data[$key_2][$x]['type'] == \App\Algorithm\Constants::$TYPE_TUTORIAL) {
        ?>
        <td data-toggle="modal" data-target="#defaultModal">
            {{ $data[$key_2][$x]['subjectCode'] }}
            <br>
            {{ $data[$key_2][$x]['resource'] }}
            <br>
            {{ $data[$key_2][$x]['type'] }}
        </td>
        <?php
                            }
                        } else {
        ?>
        <td></td>
        <?php
                        }
                    }
        ?>
        </tr>
        <?php
                }
                break;
            }

        ?>

        </tbody>
    </table>
</div>
