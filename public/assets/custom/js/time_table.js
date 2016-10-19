/**
 * Created by HP-PC on 9/14/2016.
 */
// $('.selectpicker').selectpicker({
// });


// -------------------------------------------------  Constants --------------------------------------------------------

var FILTER_BATCH = "filter_batch";
var FILTER_HALL = "filter_hall";
var FILTER_LAB = "filter_lab";

var STATE_INTI = "inti";
var STATE_ON_PROGRESS = "on_progress";
var STATE_ON_LOAD = "on_load";

var TYPE_BATCH = "BATCH";
var TYPE_HALL = "HALL";
var TYPE_LAB = "LAB";

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Global Ajax Loader
 *
 * @param type
 * @param url
 * @param dataString
 */
function loadAjax(type, url, dataString) {
    // load Progress bar
    loadAjaxBlock(type, STATE_INTI, 0);

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: dataString,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        cache: false,
        xhr: function () {
            // get the native XmlHttpRequest object
            var xhr = $.ajaxSettings.xhr();
            // set the onprogress event handler
            xhr.upload.onprogress = function (evt) {
                ajaxXHR(type, STATE_ON_PROGRESS, (evt.loaded / evt.total * 100));
            };
            // set the onload event handler
            xhr.upload.onload = function () {
                ajaxXHR(type, STATE_ON_LOAD, 100);
            };
            // return the customized object
            return xhr;
        },
        success: function (data) {
            // console.log(data);
            loadAjaxResults(type, data);
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
};

/**
 * Handle Ajax XHR status
 *
 * @param type
 * @param state
 */
function ajaxXHR(type, state, tot) {
    switch (state) {
        case STATE_ON_PROGRESS:
            loadAjaxBlock(type, state, tot);
            break;
        case STATE_ON_LOAD:
            loadAjaxBlock(type, state, tot);
            break;
    }
}

/**
 * load Ajax ui-block
 *
 * @param type
 */
function loadAjaxBlock(type, state, tot) {
    switch (type) {
        case FILTER_BATCH:
            var progress = '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="' + tot + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + tot + '%;height: 15px !important;"><span class="sr-only">' + tot + '% Complete</span></div>';
            $("#batch_time_table_progress").html(progress);

            if (state == STATE_INTI)
                $("#batch_time_table_progress").fadeIn();
            else if (state == STATE_ON_LOAD)
                $("#batch_time_table_progress").hide(100);
            break;
        case FILTER_HALL:
            var progress = '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="' + tot + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + tot + '%;height: 15px !important;"><span class="sr-only">' + tot + '% Complete</span></div>';
            $("#hall_time_table_progress").html(progress);

            if (state == STATE_INTI)
                $("#hall_time_table_progress").fadeIn();
            else if (state == STATE_ON_LOAD)
                $("#hall_time_table_progress").hide(100);
            break;
        case FILTER_LAB:
            var progress = '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="' + tot + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + tot + '%;height: 15px !important;"><span class="sr-only">' + tot + '% Complete</span></div>';
            $("#lab_time_table_progress").html(progress);

            if (state == STATE_INTI)
                $("#lab_time_table_progress").fadeIn();
            else if (state == STATE_ON_LOAD)
                $("#lab_time_table_progress").hide(100);
            break;
    }
}

/**
 * load Ajax responses
 *
 * @param type
 * @param data
 */
function loadAjaxResults(type, data) {
    switch (type) {
        case FILTER_BATCH:
            console.log(data.data);
            $('#time_table_view').html(data.page);
            break;
        case FILTER_HALL:
            console.log(data.data);
            $('#time_table_view').html(data.page);
            break;
        case FILTER_LAB:
            console.log(data.data);
            $('#time_table_view').html(data.page);
            break;
    }
};

/**
 * Filter results with batch and year selections
 */
function filterBatch() {
    var year = $('#year').val();
    var batch = $('#batch').val();

    var dataString = "type="+TYPE_BATCH+"&batchID=BATCH_" + year + "_" + batch;
    var url = $('#base_URL').val() + "/timetable/getTimeTableLayout";

    loadAjax(FILTER_BATCH, url, dataString);
};


/**
 * Filter results with Hall
 */
function filterHall() {
    var hallID = $('#hall').val();

    var dataString = "type="+TYPE_HALL+"&hallID=RES_H_#_0" + hallID;
    var url = $('#base_URL').val() + "/timetable/getTimeTableLayout";

    loadAjax(FILTER_HALL, url, dataString);
};


/**
 * Filter results with Hall
 */
function filterLab() {
    var labID = $('#hall').val();

    var dataString = "type="+TYPE_LAB+"&labID=RES_L_#_0" + labID;
    var url = $('#base_URL').val() + "/timetable/getTimeTableLayout";

    loadAjax(FILTER_LAB, url, dataString);
};