"use strict";
var ScormRTE = function() {
    var scormElm = null;
    var options = {
        studentId : null,
        studentName : null,
        scormIdActive : null,
        scormVersion : null,
        lessonScormIsFlash : null,
        courseModuleId : null,
        courseId : null,
        suspend : null
    };



    return {
        scormElm: scormElm,
        options : options,
        init : function(scormElm, options) {
            var me = this;
            me.scormElm = scormElm;
            me.options = options;

            me.addScormLib();
            //App.showMessageWarningForScorm("<i class='fa fa-warning'></i> Cảnh báo","<div style='color: #12842c; font-size: 15px'>1. Khi gặp thông báo \"Bạn có muốn tiếp tục bài học lần trước đã học không?\". Nếu bạn chọn là KHÔNG (hoặc NO) thì tiến trình học sẽ bị cập nhật về 0%.</div><br><div style='color: #12842c; font-size: 15px'>2. Trước khi bạn muốn rời khỏi học liệu. Vui lòng tải lại trang hiện tại để hệ thống cập nhật danh sách các slide bạn đã học.</div>", "Đồng ý", function () {});
            me.initRte();
            me.initScormIframe(function(){
                me.resizeWindow();
            });
        },

        addScormLib : function() {
            if(this.options.scormVersion === '1.2'){
                if($('#scormLib12')){
                    $(document).find('body script#scormLib2004').remove();
                    $(document).find('body').append('<script id="scormLib12" src="/assets/module/lms/lesson_scorm/lesson_scorm_api_1.2.js" type="text/javascript"></script>')
                }
            } else{
                if($('#scormLib2004')){
                    $(document).find('body script#scormLib12').remove();
                    $(document).find('body').append('<script id="scormLib2004" src="/assets/module/lms/lesson_scorm/lesson_scorm_api_2004.js" type="text/javascript"></script>')
                }
            }
        },

        resizeWindow: function(){
            $('#lessonScormPlayer').attr('height', $(window).height() - 30);
            $("#lessonScormPlayer").contents().find("body").css('overflow', 'hidden');
        },
        initScormIframe: function(func){
            var scormIframeSrc = '/module/lms/lessonScormPlayer/load?id=' + this.options.scormIdActive;
            this.scormElm.html('<iframe id="lessonScormPlayer" src="' + scormIframeSrc + '" width="100%" height="100%" allow="autoplay" frameborder="0">Browser not compatible.</iframe>\n');
            var scormIframe = document.getElementById('lessonScormPlayer');
            scormIframe.addEventListener("load", function() {
                func();
            });
        },
        initRte: function(){
            var me = this;
            var scormIdActive = me.options.scormIdActive;
            var courseId = me.options.courseId;
            var courseModuleId = me.options.courseModuleId;
            var scormVersion = me.options.scormVersion;
            var lessonScormIsFlash = me.options.lessonScormIsFlash;
            var studentId = me.options.studentId;
            var studentName = me.options.studentName;
            var suspend = me.options.suspend;

            /* @todo set dữ liệu suspend data cho scorm */
            localStorage.setItem("scorm_" + scormIdActive, suspend);

            /* @todo lấy dữ liệu suspend data cho sco */
            var scormData = localStorage.getItem("scorm_" + scormIdActive);
            var dataUersInterActive = {
                'lesson_scorm_id' : scormIdActive,
                'lesson_status' : '',
                'course_id' : courseId,
                'course_module_id' : courseModuleId,
                'version' : scormVersion,
                'credit' : '',
                'entry' : '',
                'exit' : '',
                'lesson_location' : '',
                'lesson_mode' : '',
                'session_time' : '',
                'suspend_data' : '',
                'total_time' : '',
                'score_max' : '',
                'score_min' : '',
                'score_raw' : '',
                'pattern' : '',
                'slide_id' : '',
                'objectives_id' : '',
                'result' : '',
                'student_response' : '',
                'latency' : '',
                'time' : '',
                'type' : '',
                'weighting' : '',
                'slide_states' : ''
            };

            if(scormVersion === "1.2"){
                if(scormData){
                    var json = JSON.parse(scormData);
                    window.API.loadFromJSON(json);
                }
                window.API.cmi.core.student_id = studentId;
                window.API.cmi.core.student_name = studentName;
                if(lessonScormIsFlash == 1) {
                    /* @todo Nếu không phải trình duyệt coccoc thì thông báo cho người dùng */
                    var isBrowserCoccoc = /coc_coc_browser/.test(navigator.userAgent.toLowerCase());
                    if(!isBrowserCoccoc) {
                        App.notification('Khuyến cáo', 'Bài giảng là Flash vui lòng chọn trình duyệt coccoc để học!');
                    }

                    /* @todo Lấy tổng thời gian học của học liệu */
                    $.post('/module/lms/service/lessonScorm/getById', {lesson_scorm_id : scormIdActive}, function(req) {
                        if(req.data.result) {
                            var total_time = 60;
                            if(req.data.result.total_time != 0 && req.data.result.total_time != '') {
                                total_time = req.data.result.total_time;
                            }
                            setInterval(function(){
                                var section_time = window.API.cmi.core._session_time;
                                if(!section_time || section_time == 'undefined'){
                                    section_time = 60;
                                }else {
                                    section_time = parseInt(section_time) + 60;
                                }
                                if(section_time > (total_time*60)) {
                                    dataUersInterActive.score_raw = 100;
                                }else {
                                    dataUersInterActive.score_raw = (section_time / parseInt(total_time * 60)) * 100;
                                }

                                /* @todo Lưu tiến trình lms_lesson_scorm_user_interactive */
                                $.post("/module/lms/service/lessonScormInteractive/saveUserInteractive", {data : dataUersInterActive}, function(req) {
                                    if(req.success && typeof(req.data.progress) != "undefined") {
                                        window.parent.Course.lessonChangeProgress(Math.round(req.data.progress));
                                        if(req.data.completion_state) {
                                            window.parent.Course.enableLesson({'completion_state' : req.data.completion_state});
                                        }
                                    }else {
                                        /* @todo Nếu user đã logout thì thông báo và redirect */
                                        if(req.type == "require_login") {
                                            App.showMessageWarning(req.message, "Đồng ý", function () {
                                                var url = window.location.href;
                                                window.location.href = url + '/#dang-nhap';
                                            })
                                        }else {
                                            /* @todo Nếu lưu tiến trình học thất bại thì thông báo và yêu cầu học viên reload lại trang */
                                            App.showMessageWarning('Có lỗi trong quá trình lưu tiến trình học. Vui lòng tải lại trang', 'Đồng ý', function () {
                                                window.location.reload(true);
                                            });
                                        }
                                    }
                                }).fail(function() {
                                    App.showMessageWarning('Lỗi kết nối đến máy chủ. Vui lòng kiểm tra kết nối', 'Đồng ý', function () {
                                        window.location.reload(true);
                                    });
                                });
                            }, 60000);
                        }
                    });
                }else {
                    window.API.on("LMSSetValue", function(varname, varvalue) {
                        switch (varname) {
                            case "cmi.core.exit" : {
                                dataUersInterActive.exit = varvalue;
                                break;
                            }
                            case "cmi.core.lesson_status" : {
                                dataUersInterActive.lesson_status = varvalue;
                                break;
                            }
                            case "cmi.core.score.max" : {
                                dataUersInterActive.score_max = varvalue;
                                break;
                            }
                            case "cmi.core.score.min" : {
                                dataUersInterActive.score_min = varvalue;
                                break;
                            }
                            case "cmi.core.score.raw" : {
                                dataUersInterActive.score_raw = varvalue;
                                break;
                            }
                            case "cmi.core.session_time" : {
                                dataUersInterActive.session_time = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.correct_responses.0.pattern" : {
                                dataUersInterActive.pattern = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.correct_responses.0.pattern" : {
                                dataUersInterActive.pattern = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.id" : {
                                dataUersInterActive.slide_id = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.id" : {
                                dataUersInterActive.slide_id = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.objectives.0.id" : {
                                dataUersInterActive.objectives_id = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.objectives.0.id" : {
                                dataUersInterActive.objectives_id = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.result" : {
                                dataUersInterActive.result = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.result" : {
                                dataUersInterActive.result = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.student_response" : {
                                dataUersInterActive.student_response = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.student_response" : {
                                dataUersInterActive.student_response = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.time" : {
                                dataUersInterActive.time = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.time" : {
                                dataUersInterActive.time = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.type" : {
                                dataUersInterActive.type = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.type" : {
                                dataUersInterActive.type = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.weighting" : {
                                dataUersInterActive.weighting = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.weighting" : {
                                dataUersInterActive.weighting = varvalue;
                                break;
                            }
                            case "cmi.interactions.true.latency" : {
                                dataUersInterActive.latency = varvalue;
                                break;
                            }
                            case "cmi.interactions.NaN.latency" : {
                                dataUersInterActive.latency = varvalue;
                                break;
                            }
                            case "cmi.suspend_data" : {
                                dataUersInterActive.suspend_data = varvalue;
                                break;
                            }
                            case "cmi.core.lesson_location" : {
                                dataUersInterActive.lesson_location = varvalue;
                                break;
                            }
                            case "cmi.total_time" : {
                                dataUersInterActive.total_time = varvalue;
                                break;
                            }
                        }
                    });

                    /* @todo khi học viên next slide */
                    window.API.on("LMSCommit", function() {
                        localStorage.setItem("scorm_" + scormIdActive, JSON.stringify(window.API.cmi));

                        /* @todo thực hiện lấy và lưu ispring key của học scorm */
                        var regex = new RegExp("ispring::{([A-Za-z0-9-]*)}");
                        var arrIspring = {};
                        for (var i = 0; i < localStorage.length; i++) {
                            var res = regex.test(localStorage.key(i));
                            if(res === true) {
                                arrIspring[localStorage.key(i)] = localStorage.getItem(localStorage.key(i));
                            }
                        }
                        dataUersInterActive.slide_states = JSON.parse(JSON.stringify(arrIspring));
                        /* @todo Lưu tiến trình học của học viên  */
                        $.post("/module/lms/service/lessonScormInteractive/saveUserInteractive", {data : dataUersInterActive}, function(req) {
                            if(req.success && typeof(req.data.progress) != "undefined") {
                                if(req.data.warning == true) {
                                    if (!$(".notification-warning-progress-scorm").length ) {
                                        //* @todo Thông báo cho người dùng biết đang học với tiến trình thấp hơn hiện tại */
                                        var eventClick = "Course.studyLesson('" + scormIdActive + "','5', $(event.target), true)";
                                        $("#course_lesson_content").append('<div style="margin: 0px 12px" class="alert alert-warning notification-warning-progress-scorm"><b><i class="fa fa-warning"> </i> Cảnh báo: </b>Bạn đang học với tiến trình thấp hơn tiến trình cao nhất bạn đạt được. Chọn reset để quay về trạng thái cao nhất. <a href="javascript:void(0)" data-course-moudule-id="' + courseModuleId + '" data-module-id="5" id="' + scormIdActive + '" onclick="' + eventClick + '" title="Quay về tiến trình học cao nhất" class="btn btn-primary btn-sm">Reset</a></div>')
                                    }
                                    $('#lessonScormPlayer').attr('height', $(window).height() - $('.notification-warning-progress-scorm').height() - 30 - 42);
                                }else {
                                    $( ".notification-warning-progress-scorm" ).remove();
                                    $('#lessonScormPlayer').attr('height', $(window).height() - 30);
                                }
                                window.parent.Course.lessonChangeProgress(Math.round(req.data.progress));
                                if(req.data.completion_state) {
                                    window.parent.Course.enableLesson({'completion_state' : req.data.completion_state});
                                }
                            }else {
                                /* @todo Nếu user đã logout thì thông báo và redirect */
                                if(req.type == "require_login") {
                                    App.showMessageWarning(req.message, "Đồng ý", function () {
                                        var url = window.location.href;
                                        window.location.href = url + '/#dang-nhap';
                                    })
                                }else {
                                    /* @todo Nếu lưu tiến trình học thất bại thì thông báo và yêu cầu học viên reload lại trang */
                                    App.showMessageWarning('Có lỗi trong quá trình lưu tiến trình học. Vui lòng tải lại trang', 'Đồng ý', function () {
                                        window.location.reload(true);
                                    });
                                }
                            }
                        }).fail(function() {
                            App.showMessageWarning('Lỗi kết nối đến máy chủ. Vui lòng kiểm tra kết nối', 'Đồng ý', function () {
                                window.location.reload(true);
                            });
                        });
                    });
                }
            } else{
                if(scormData){
                    var json = JSON.parse(scormData);
                    window.API_1484_11.loadFromJSON(json);
                }
                window.API_1484_11.cmi.learner_id = studentId;
                window.API_1484_11.cmi.learner_name = studentName;
                if(lessonScormIsFlash == 1) {
                    /* @todo Nếu học liệu là flash thì lấy tổng thời gian học liệu */
                    $.post('/module/lms/service/lessonScorm/getById', {lesson_scorm_id : scormIdActive}, function(req) {
                        if(req.data.result) {
                            var total_time = 60;
                            if(req.data.result.total_time != 0 && req.data.result.total_time != '') {
                                total_time = req.data.result.total_time;
                            }
                            setInterval(function(){
                                var arrSectionTime = window.API_1484_11.cmi._session_time.split(":");
                                dataUersInterActive.lesson_status  = window.API_1484_11.cmi.completion_status;
                                dataUersInterActive.session_time = window.API_1484_11.cmi._session_time;
                                dataUersInterActive.score_min = 0;
                                var secondsTime = parseInt(arrSectionTime[0]*3600) + parseInt(arrSectionTime[1]*60) + parseInt(arrSectionTime[2]);
                                if(secondsTime > total_time*60) {
                                    dataUersInterActive.score_raw = 100;
                                }else {
                                    dataUersInterActive.score_raw = (secondsTime / parseInt(total_time * 60)) * 100;
                                }

                                /* @todo Lưu tiến trình lms_lesson_scorm_user_interactive */
                                $.post("/module/lms/service/lessonScormInteractive/saveUserInteractive", {data : dataUersInterActive}, function(req) {
                                    if(req.success && typeof(req.data.progress) != "undefined") {
                                        window.parent.Course.lessonChangeProgress(Math.round(req.data.progress));
                                        if(req.data.completion_state) {
                                            window.parent.Course.enableLesson({'completion_state' : req.data.completion_state});
                                        }
                                    }else {
                                        /* @todo Nếu user đã logout thì thông báo và redirect */
                                        if(req.type == "require_login") {
                                            App.showMessageWarning(req.message, "Đồng ý", function () {
                                                var url = window.location.href;
                                                window.location.href = url + '/#dang-nhap';
                                            })
                                        }else {
                                            /* @todo Nếu lưu tiến trình học thất bại thì thông báo và yêu cầu học viên reload lại trang */
                                            App.showMessageWarning('Có lỗi trong quá trình lưu tiến trình học. Vui lòng tải lại trang', 'Đồng ý', function () {
                                                window.location.reload(true);
                                            });
                                        }
                                    }
                                }).fail(function() {
                                    App.showMessageWarning('Lỗi kết nối đến máy chủ. Vui lòng kiểm tra kết nối', 'Đồng ý', function () {
                                        window.location.reload(true);
                                    });
                                });
                            }, 60000);
                        }
                    });
                }else {
                    window.API_1484_11.on("SetValue", function(varname, varvalue){
                        switch (varname) {
                            case "cmi.completion_status" :
                            {
                                dataUersInterActive.lesson_status = varvalue;
                                break;
                            }
                            case "cmi.exit" :
                            {
                                dataUersInterActive.exit = varvalue;
                                break;
                            }
                            case "cmi.progress_measure" :
                            {
                                dataUersInterActive.progress_measure = varvalue;
                                break;
                            }
                            case "cmi.score.max" :
                            {
                                dataUersInterActive.score_max = varvalue;
                                break;
                            }
                            case "cmi.score.min" :
                            {
                                dataUersInterActive.score_min = varvalue;
                                break;
                            }
                            case "cmi.score.raw" :
                            {
                                dataUersInterActive.score_raw = varvalue;
                                break;
                            }
                            case "cmi.score.scaled" :
                            {
                                dataUersInterActive.scaled = varvalue;
                                break;
                            }
                            case "cmi.session_time" :
                            {
                                dataUersInterActive.pattern = varvalue;
                                break;
                            }
                            case "cmi.success_status" : {
                                dataUersInterActive.success_status = varvalue;
                                break;
                            }
                            case "cmi.suspend_data" :
                            {
                                dataUersInterActive.suspend_data = varvalue;
                                break;
                            }
                        }
                    });

                    window.API_1484_11.on("Commit", function() {
                        localStorage.setItem("scorm_" + scormIdActive, JSON.stringify(window.API_1484_11.cmi));

                        /* @todo thực hiện lấy và lưu ispring key của học scorm */
                        var regex = new RegExp("ispring::{([A-Za-z0-9-]*)}");
                        var arrIspring = {};
                        for (var i = 0; i < localStorage.length; i++) {
                            var res = regex.test(localStorage.key(i));
                            if(res === true) {
                                arrIspring[localStorage.key(i)] = localStorage.getItem(localStorage.key(i));
                            }
                        }
                        dataUersInterActive.slide_states = JSON.parse(JSON.stringify(arrIspring));

                        /* @todo Lưu tiến trình học của học viên  */
                        $.post("/module/lms/service/lessonScormInteractive/saveUserInteractive", {data : dataUersInterActive}, function(req) {
                            if(req.success && typeof(req.data.progress) != "undefined") {
                                if(req.data.warning == true) {
                                    if (!$(".notification-warning-progress-scorm").length ) {
                                        //* @todo Thông báo cho người dùng biết đang học với tiến trình thấp hơn hiện tại */
                                        var eventClick = "Course.studyLesson('" + scormIdActive + "','5', $(event.target), true)";
                                        $("#course_lesson_content").append('<div style="margin: 0px 12px" class="alert alert-warning notification-warning-progress-scorm"><b><i class="fa fa-warning"> </i> Cảnh báo: </b>Bạn đang học với tiến trình thấp hơn tiến trình cao nhất bạn đạt được. Chọn reset để quay về trạng thái cao nhất. <a href="javascript:void(0)" data-course-moudule-id="' + courseModuleId + '" data-module-id="5" id="' + scormIdActive + '" onclick="' + eventClick + '" title="Quay về tiến trình học cao nhất" class="btn btn-primary btn-sm">Reset</a></div>')
                                    }
                                    $('#lessonScormPlayer').attr('height', $(window).height() - $('.notification-warning-progress-scorm').height() - 30 - 42);
                                }else {
                                    $( ".notification-warning-progress-scorm" ).remove();
                                    $('#lessonScormPlayer').attr('height', $(window).height() - 30);
                                }
                                window.parent.Course.lessonChangeProgress(Math.round(req.data.progress));
                                if(req.data.completion_state) {
                                    window.parent.Course.enableLesson({'completion_state' : req.data.completion_state});
                                }
                            }else {
                                /* @todo Nếu user đã logout thì thông báo và redirect */
                                if(req.type == "require_login") {
                                    App.showMessageWarning(req.message, "Đồng ý", function () {
                                        var url = window.location.href;
                                        window.location.href = url + '/#dang-nhap';
                                    })
                                }else {
                                    /* @todo Nếu lưu tiến trình học thất bại thì thông báo và yêu cầu học viên reload lại trang */
                                    App.showMessageWarning('Có lỗi trong quá trình lưu tiến trình học. Vui lòng tải lại trang', 'Đồng ý', function () {
                                        window.location.reload(true);
                                    });
                                }
                            }
                        }).fail(function() {
                            App.showMessageWarning('Lỗi kết nối đến máy chủ. Vui lòng kiểm tra kết nối', 'Đồng ý', function () {
                                window.location.reload(true);
                            });
                        });
                    });
                }
            }
        }
    }
}();
