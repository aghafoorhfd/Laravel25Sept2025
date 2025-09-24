<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <style>
        html,body{
            height: 100%;
        }
    </style>
</head>
<body>

<iframe id="lessonScormPlayer" src="{{asset('uploads/'.$scorm->index_path)}}" width="100%" height="100%" frameborder="0">Browser not compatible.</iframe>

<script src="{{asset('module/course/api/init.js')}}" type="text/javascript"></script>
<script src="{{asset('module/course/api/constants.js')}}" type="text/javascript"></script>
<script src="{{asset('module/course/api/jsonFormatter.js')}}" type="text/javascript"></script>
<script src="{{asset('module/course/api/baseAPI.js')}}" type="text/javascript"></script>

<?php if($scorm->version === "1.2"):?>
<script src="{{asset('module/course/api/lesson_scorm_api_1.2.js')}}" type="text/javascript"></script>
<?php else:?>
<script src="{{asset('module/course/api/lesson_scorm_api_2004.js')}}" type="text/javascript"></script>
<?php endif;?>
</body>
</html>
