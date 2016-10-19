<!DOCTYPE html>
<html>
<head>
    <title>user management cron</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/custom/js/time_table.js') }}"></script>

</head>
<body>
<div style="font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue';margin:auto">

    <div style="align:center;background-color:#f0f0f0;padding-top:5px;padding-bottom:5px"><span style="color: #17469a;font-size: 28px;margin-left:35%">Time Table- 2016</span></div>

    <div><span>{{ $first_name }}&nbsp;{{ $last_name }} </span></div>
    <br/>

    <div style="margin-top: 10px" >This is your time Table for 2016 2nd semester x </div>


    <br/>
    <div><span style="font-weight: 500">Time table</span></div>
    <br/>
    <input type="button" class="btn btn-info dropdown-toggle" value="Change Request" />

</div>


</body>
</html>