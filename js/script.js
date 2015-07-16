// JavaScript Document
/** Home Page Popup and Calculation Script **/
$(document).ready(function () {

    $(".cc").keyup(function () {
        if ($(this).val().length == $(this).attr("maxlength")) {
            //debugger;
            alert($(this).next().next().attr("id"));
            $(this).next().focus();
        }
    });

    $('.cal_input_box').focusin(function () {
        $('input').attr('placeholder', '');
    });
});


var scripts = document.getElementsByTagName("script");
var thisScript = scripts[scripts.length - 1];
var thisScriptsSrc = thisScript.src;

function trim(s) {
    return s.replace(/^\s+|\s+$/, '');
}

var responseVal;
var xmlhttp


function hide_req() {
    $('.popup_block').hide();
    //location.reload()

}
$(document).keyup(function (e) {
    if (e.keyCode == 27) {
        $('.popup_block').hide();
        //location.reload()
    }
});

/** Home Page Popup and Calculation Script End **/

function validates() {
    var cname = document.home_contact.name.value;
    var email = document.home_contact.email.value;
    var a = b = 0;
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    var iChars = "!#$%^&*()+=[]\\\';,/{}|\":<>?";

    for (var i = 0; i < document.home_contact.email.value.length; i++) {
        if (iChars.indexOf(document.home_contact.email.value.charAt(i)) != -1) {
            $('#email_error').html('Please Remove Special Characters');
            return false;
        }
    }
    if (cname == '') {
        $("#name_error").html("Please enter: Name");
    } else {
        $("#name_error").html("");
        b = 2;
    }

    if (email == '') {
        $("#email_error").html("Please enter: Email Id");
    } else if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
        $('#email_error').html('Invalid Email');
    } else {
        $("#email_error").html("");
        a = 6;
    }

    if (a == 6 && b == 2) {
        document.home_contact.submit();
        return true;
    } else {
        return false;
    }
}

/** Feature page script **/

function show_driver() {
    $('#dri').show();
    $('#pass').hide();
    $('#adm').hide();
    $('#efea').hide();
    $('#dis-patcher').hide();
    $('#driver').addClass('active');
    $('#passenger').removeClass('active');
    $('#admin').removeClass('active');
    $('#efeature').removeClass('active');
    $('#dispatcher').removeClass('active');
}

function show_dispatcher() {
    $('#dri').hide();
    $('#pass').hide();
    $('#adm').hide();
    $('#efea').hide();
    $('#dis-patcher').show();
    $('#driver').removeClass('active');
    $('#passenger').removeClass('active');
    $('#admin').removeClass('active');
    $('#efeature').removeClass('active');
    $('#dispatcher').addClass('active');
}

function show_passenger() {

    $('#dri').hide();
    $('#pass').show();
    $('#adm').hide();
    $('#efea').hide();
    $('#dis-patcher').hide();
    $('#driver').removeClass('active');
    $('#passenger').addClass('active');
    $('#admin').removeClass('active');
    $('#efeature').removeClass('active');
    $('#dispatcher').removeClass('active');
}

function show_admin() {
    $('#dri').hide();
    $('#pass').hide();
    $('#adm').show();
    $('#efea').hide();
    $('#dis-patcher').hide();
    $('#driver').removeClass('active');
    $('#passenger').removeClass('active');
    $('#admin').addClass('active');
    $('#efeature').removeClass('active');
    $('#dispatcher').removeClass('active');
}

function show_feature() {
    $('#dri').hide();
    $('#pass').hide();
    $('#adm').hide();
    $('#efea').show();
    $('#dis-patcher').hide();
    $('#driver').removeClass('active');
    $('#passenger').removeClass('active');
    $('#admin').removeClass('active');
    $('#efeature').addClass('active');
    $('#dispatcher').removeClass('active');
}
$(document).ready(function () {
    $('#efea').show();
    $('#dri').hide();
    $('#pass').hide();
    $('#adm').hide();
    $('#efeature').addClass('active');
    $('#dis-patcher').hide();
});

function resp_scr(val) {
    if (val == "efeature") {
        show_feature();
    } else if (val == "passenger") {
        show_passenger();
    } else if (val == "driver") {
        show_driver();
    } else if (val == "admin") {
        show_admin();
    } else if (val == "dispatcher") {
        show_dispatcher();
    } else if (val == "faq") {
        window.location.href = "/faq.html";
    }
}

/** Feature page script End */


var TINY = {};

function T$(i) {
    return document.getElementById(i)
}

function T$$(e, p) {
    return p.getElementsByTagName(e)
}

TINY.slider = function () {
    function slide(n, p) {
        this.n = n;
        this.init(p)
    }
    slide.prototype.init = function (p) {
        var s = this.x = T$(p.id),
                u = this.u = T$$('ul', s)[0],
                c = this.m = T$$('li', u),
                l = c.length,
                i = this.l = this.c = 0;
        this.b = 1;
        if (p.navid && p.activeclass) {
            this.g = T$$('li', T$(p.navid));
            this.s = p.activeclass
        }
        this.a = p.auto || 0;
        this.p = p.resume || 0;
        this.r = p.rewind || 0;
        this.e = p.elastic || false;
        this.v = p.vertical || 0;
        s.style.overflow = 'hidden';
        for (i; i < l; i++) {
            if (c[i].parentNode == u) {
                this.l++
            }
        }
        if (this.v) {
            ;
            u.style.top = 0;
            this.h = p.height || c[0].offsetHeight;
            u.style.height = (this.l * this.h) + 'px'
        } else {
            u.style.left = 0;
            this.w = p.width || c[0].offsetWidth;
            u.style.width = (this.l * this.w) + 'px'
        }
        this.nav(p.position || 0);
        if (p.position) {
            this.pos(p.position || 0, this.a ? 1 : 0, 1)
        } else if (this.a) {
            this.auto()
        }
        if (p.left) {
            this.sel(p.left)
        }
        if (p.right) {
            this.sel(p.right)
        }
    },
            slide.prototype.auto = function () {
                this.x.ai = setInterval(new Function(this.n + '.move(1,1,1)'), this.a * 4000)
            },
            slide.prototype.move = function (d, a) {
                var n = this.c + d;
                if (this.r) {
                    n = d == 1 ? n == this.l ? 0 : n : n < 0 ? this.l - 1 : n
                }
                this.pos(n, a, 1)
            },
            slide.prototype.pos = function (p, a, m) {
                var v = p;
                clearInterval(this.x.ai);
                clearInterval(this.x.si);
                if (!this.r) {
                    if (m) {
                        if (p == -1 || (p != 0 && Math.abs(p) % this.l == 0)) {
                            this.b++;
                            for (var i = 0; i < this.l; i++) {
                                this.u.appendChild(this.m[i].cloneNode(1))
                            }
                            this.v ? this.u.style.height = (this.l * this.h * this.b) + 'px' : this.u.style.width = (this.l * this.w * this.b) + 'px';
                        }
                        if (p == -1 || (p < 0 && Math.abs(p) % this.l == 0)) {
                            this.v ? this.u.style.top = (this.l * this.h * -1) + 'px' : this.u.style.left = (this.l * this.w * -1) + 'px';
                            v = this.l - 1
                        }
                    } else if (this.c > this.l && this.b > 1) {
                        v = (this.l * (this.b - 1)) + p;
                        p = v
                    }
                }
                var t = this.v ? v * this.h * -1 : v * this.w * -1,
                        d = p < this.c ? -1 : 1;
                this.c = v;
                var n = this.c % this.l;
                this.nav(n);
                if (this.e) {
                    t = t - (8 * d)
                }
                this.x.si = setInterval(new Function(this.n + '.slide(' + t + ',' + d + ',1,' + a + ')'), 50)
            },
            slide.prototype.nav = function (n) {
                if (this.g) {
                    for (var i = 0; i < this.l; i++) {
                        this.g[i].className = i == n ? this.s : ''
                    }
                }
            },
            slide.prototype.slide = function (t, d, i, a) {
                var o = this.v ? parseInt(this.u.style.top) : parseInt(this.u.style.left);
                if (o == t) {
                    clearInterval(this.x.si);
                    if (this.e && i < 3) {
                        this.x.si = setInterval(new Function(this.n + '.slide(' + (i == 1 ? t + (12 * d) : t + (4 * d)) + ',' + (i == 1 ? (-1 * d) : (-1 * d)) + ',' + (i == 1 ? 2 : 3) + ',' + a + ')'), 50)
                    } else {
                        if (a || (this.a && this.p)) {
                            this.auto()
                        }
                        if (this.b > 1 && this.c % this.l == 0) {
                            this.clear()
                        }
                    }
                } else {
                    var v = o - Math.ceil(Math.abs(t - o) * .1) * d + 'px';
                    this.v ? this.u.style.top = v : this.u.style.left = v
                }
            },
            slide.prototype.clear = function () {
                var c = T$$('li', this.u),
                        t = i = c.length;
                this.v ? this.u.style.top = 0 : this.u.style.left = 0;
                this.b = 1;
                this.c = 0;
                for (i; i > 0; i--) {
                    var e = c[i - 1];
                    if (t > this.l && e.parentNode == this.u) {
                        this.u.removeChild(e);
                        t--
                    }
                }
            },
            slide.prototype.sel = function (i) {
                var e = T$(i);
                e.onselectstart = e.onmousedown = function () {
                    return false
                }
            }
    return {
        slide: slide
    }
}();

/** Message Display **/
$(document).ready(function () {
    if ($('#messagedisplay')) {
        $('#messagedisplay').animate({
            opacity: 1.0
        }, 5000)
        $('#messagedisplay').fadeOut('slow');
    }

    if ($('#error_messagedisplay')) {
        $('#error_messagedisplay').animate({
            opacity: 1.0
        }, 5000);
        $('#error_messagedisplay').fadeOut('slow');
    }

});
/*************************/
/** Login & Registration *******/

var SrcPath = $("body").data('base');


function show_id(id) {
    $('#' + id).show("fast");
}

function hide_id(id) {
    $('#' + id).hide("fast");
}


function journey_completed() {
    var id = $('#passlog_id').val();
    var from = $('#fromText1').val();
    var to = $('#toText1').val();

    var Timeobject = new Date()
    var hours = Timeobject.getHours()
    var minutes = Timeobject.getMinutes()
    var seconds = Timeobject.getSeconds()
    var currentTime = hours + ':' + minutes + ':' + seconds;
    //alert(id);	

    var waiting_time = $('#stopwatch').html();

    var dataS = "pass_logid=" + id + "&from=" + from + "&to=" + to + "&waiting_time=" + waiting_time;
    var response;
    $.ajax({
        type: "POST",
        url: SrcPath + "driver/journey_completed",
        data: dataS,
        cache: false,
        dataType: 'html',
        success: function (response) {
            $('#travel_completed').show();
            $('#result_status_div').html(response);
            $('#ongoing_journey').hide();


            //location.reload();
        }

    });

}

function markfavourite(log_id, mark_status) {

    var url = SrcPath + 'passengers/markfavourite/?log_id=' + log_id + '&mark_status=' + mark_status;
    $.post(url, {}, function (response) {
        location.reload();
    });

}



ajax_call_notify(0);


function ajax_call_notify(flag) {

    if ($('#notify_alert').length > 0) {
        var value = $('#driver_logs').val();
        var dataS = "value=" + value + "&flag=" + flag;

        var response;
        $.ajax({
            type: "POST",
            url: SrcPath + "driver/get_driver_notifications",
            data: dataS,
            cache: false,
            dataType: 'html',
            success: function (response) {
                //alert(response);		
                if (flag == 0) {
                    //alert(response);
                    //$('#notify_alert').html(response);	
                    var ars = ["Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola"];
                    //$.each(ars, function(i, val) {
                    //alert(val)
                    var n = noty({
                        text: response, //'<strong>Hi!</strong> <br /> You have new booking request!',
                        type: 'confirm',
                        layout: 'bottomRight',
                        closeWith: ['click'],
                    });
                    //});
                } else {
                    //$('#notify_alert').html(response);	
                }
            }

        });
    } else
        return false;

}




function validate_span(id, pass_logid, status, flag) {
    //alert(id);alert(pass_logid);alert(status);alert(flag);
    var value;
    value = $('#' + id).val();

    if (value == '') {
        //$('#span_'+id).text('Enter the Value');
        $('#' + id).addClass('invalid');
        $('#' + id).focus();
        return false;
    } else {
        // flag for driver cancel the trip when pick up passenger
        var dataS = "pass_logid=" + pass_logid + "&status=" + status + "&field=" + value + "&flag=" + flag;
        $('#notify_alert').html('<img src="' + SrcPath + 'images/ajax-loaders/ajax-loader-4.gif" />' + 'Your request is being processed...');
        $.ajax({
            type: "GET",
            url: SrcPath + "driver/set_driver_status",
            data: dataS,
            cache: false,
            dataType: 'html',
            success: function (response) {
                $('#notify_alert').html(response);
            }

        });
    }
}


var myFuncCalls = 0;
$(window).scroll(function (event) {

    var current_count = $('#current_count').val();
    var count = $('#comment_count').val();

    event.preventDefault();
    if ($("#comments_ratings").length > 0) {
        var top = $(window).scrollTop();
        if (top >= ($(document).height() - $(window).height())) {
            event.preventDefault();
            myFuncCalls = myFuncCalls + parseInt(current_count);
            load_modules(myFuncCalls, count);
        }
    }
});

function load_modules(myFuncCalls, count, rec_per_page) {

    var dataS = "limit=" + myFuncCalls + "&count=" + count;

    if (myFuncCalls < count) {
        console.log(myFuncCalls);
        //$('#comment_ratings_ajax').append('<div class="media-body"><h4 style="text-align:center" class="media-heading">Loading ......... </h4></div>');
        var response;
        $.ajax({
            type: "POST",
            url: SrcPath + "driver/dashboard_ajax",
            data: dataS,
            cache: false,
            dataType: 'html',
            success: function (response) {
                $('#comment_ratings_ajax').append(response);

            }

        });
    }
}


//FUnction Used to SHow the Map
//FUnction Used to SHow the Map
function show_map(start, end, driverid, drivername, picklat, picklon, droplat, droplon) {
    $('#map-container').show();
    $('#map-canvas').show();
    document.getElementById('map-container').scrollIntoView();
    $('#driverid').val(driverid);
    $('#drivername').val(drivername);
    $('#location1').val(start);
    $('#location2').val(end);
    $('#picklat').val(picklat);
    $('#picklon').val(picklon);
    $('#droplat').val(droplat);
    $('#droplon').val(droplon);
    initialize(start);
    if (end != "") {
        calcRoute(start, end);
    }
    setInterval(FetchData, 2000);
}


function push_notification(driver_id) {

    var dataS = "driver_id=" + driver_id;

    var response;
    $.ajax({
        type: "POST",
        url: SrcPath + "driver/push_notification",
        data: dataS,
        cache: false,
        dataType: 'html',
        success: function (response) {
            var test_str = response;
            var start_pos = test_str.indexOf('|') + 1;
            var end_pos = test_str.indexOf('|', start_pos);
            var text_to_get = test_str.substring(start_pos, end_pos)

            if (text_to_get.length > 1) {
                $('#ongoing_journey').show();
                $('#current_place').hide();
                $('#driver_logs_upcoming').hide();
                response = response.substr(text_to_get.length + 4);
                $('#on_going_trip_btn').html(text_to_get);
                loadPage();
                //console.log(text_to_get);
            }

            $('#on_going_trip').html(response);
            var lat = $('#latitude').val();
            var lng = $('#longitude').val();

            showPosition(lat, lng);
        }

    });
}


//Cancel the Trip 
function cancelTrip() {
    var passlog_id = $('#passlog_id').val();
    var status = 'C';
    var flag = 1;
    var dataS = "pass_logid=" + passlog_id + "&status=" + status + "&flag=" + flag;

    var response;
    $.ajax({
        type: "POST",
        url: SrcPath + "driver/update_driver_status",
        data: dataS,
        cache: false,
        dataType: 'html',
        success: function (response) {
            $('#notify_alert').html(response);
        }

    });

}

function show_progress_driver(driver_id) {
    var dataS = "driver_id=" + driver_id;

    var response;
    $.ajax({
        type: "POST",
        url: SrcPath + "driver/show_progress_driver",
        data: dataS,
        cache: false,
        dataType: 'html',
        success: function (response) {
            var test_str = response;
            var start_pos = test_str.indexOf('|') + 1;
            var end_pos = test_str.indexOf('|', start_pos);
            var text_to_get = test_str.substring(start_pos, end_pos)

            $('#ongoing_journey').show();
            $('#current_place').hide();
            $('#driver_logs_upcoming').hide();
            response = response.substr(text_to_get.length + 4);
            $('#on_going_trip_btn').html(text_to_get);
            loadPage();
            console.log(text_to_get);

            scrollIntoView('ongoing_journey')


        }

    });
}




// Common functions
function pad(number, length) {
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;
}

function formatTime(time) {

    var min = parseInt(time / 6000),
            sec = parseInt(time / 100) - (min * 60),
            hundredths = pad(time - (sec * 100) - (min * 6000), 2);
    return (min > 0 ? pad(min, 2) : "00") + ":" + pad(sec, 2) + ":" + hundredths;
}

function scrollIntoView(id) {
    document.getElementById(id).scrollIntoView();
}

/*Selecting the Motor Model from Motor Type */
$('#taxi_type').change(function () {

    if (this.value != null) {
        var datas = "motor_type=" + this.value;
        $.ajax({
            type: "POST",
            url: SrcPath + "find/get_motor_model",
            data: datas,
            cache: false,
            dataType: 'html',
            success: function (response) {
                $('#taxi_model').html(response);
            }

        });
    }
});

//Driver Break 
function driverbreak(breakstatus, driver_break_insert_id) {

    var dataS = "breakstatus=" + breakstatus + "&driver_break_insert_id=" + driver_break_insert_id;

    //If Break In ., Get the Reason for the Break
    if (breakstatus == 1) {
        $('#on_going_trip').html('');
        $('#on_going_trip').html('<div id="breakstatus"><select id="interval_type"><option value="S">Taxi Service</option><option value="B">Break</option></select><textarea id="reason"></textarea><br><span class="btn btn-mini btn-warning" onclick=javascript:valdate_text("reason",' + breakstatus + ');>Submit</span></div>');

    } else {
        var response;
        $.ajax({
            type: "POST",
            url: SrcPath + "driver/update_break_status",
            data: dataS,
            cache: false,
            dataType: 'html',
            success: function (response) {
                $('#breakstatus').html(response);
            }

        });
    }
}




function valdate_text(id, breakstatus) {
    var value;
    value = $('#' + id).val();

    if (value == '') {
        //$('#span_'+id).text('Enter the Value');
        $('#' + id).addClass('invalid');
        $('#' + id).focus();
        return false;
    } else {
        $('#' + id).removeClass('invalid');
        var reason = $('#reason').val();
        var interval_type = $('#interval_type').val();

        var dataS = "breakstatus=" + breakstatus + "&reason=" + reason + "&interval_type=" + interval_type;

        $.ajax({
            type: "POST",
            url: SrcPath + "driver/update_break_status",
            data: dataS,
            cache: false,
            dataType: 'html',
            success: function (response) {
                $('#breakstatus').html(response);
            }

        });



    }

}

var slideshow = new TINY.slider.slide('slideshow', {
    id: 'slider',
    auto: true,
    resume: false,
    vertical: false,
    navid: 'pagination',
    activeclass: 'current',
    position: 0,
    rewind: false,
    elastic: false,
    left: 'slideleft',
    right: 'slideright'
});


var win2;

function facebookconnect() {
    var url = location.href;
    win2 = window.open(SrcPath + 'passengers/fconnect/', null, 'width=750,location=0,status=0,height=500');
    checkChild();
}


function change_userdetails(name, field_name) {

    var url = SrcPath + "tdispatch/get_passengerDetails/?field_value=" + name + "&field_name=" + field_name;
    $.post(url, {}, function (response) {
        var myArray = response.split(',');
        $('#passenger_id').val(myArray[0]);

        if (field_name == 'firstname') {
            $('#firstname').removeAttr('readonly');
            $('#email').val(myArray[2]);
            $('#email').attr('readonly', 'readonly');
            $('#phone').val(myArray[3]);
            $('#phone').attr('readonly', 'readonly');
        } else if (field_name == 'email') {
            $('#email').removeAttr('readonly');
            $('#firstname').val(myArray[1]);
            $('#firstname').attr('readonly', 'readonly');
            $('#phone').val(myArray[3]);
            $('#phone').attr('readonly', 'readonly');
        } else if (field_name == 'phone') {
            $('#phone').removeAttr('readonly');
            $('#firstname').val(myArray[1]);
            $('#firstname').attr('readonly', 'readonly');
            $('#email').val(myArray[2]);
            $('#email').attr('readonly', 'readonly');

        }

        get_groupdetails(myArray[0]);

    });

}


function change_accountuserdetails(name, field_name) {

    var url = SrcPath + "tdispatch/get_passengerDetails/?field_value=" + name + "&field_name=" + field_name;
    $.post(url, {}, function (response) {
        var myArray = response.split(',');
        $('#passenger_id').val(myArray[0]);

        if (field_name == 'firstname') {
            $('#account_firstname').removeAttr('readonly');
            $('#account_email').val(myArray[2]);
            $('#account_email').attr('readonly', 'readonly');
            $('#account_phone').val(myArray[3]);
            $('#account_phone').attr('readonly', 'readonly');
        } else if (field_name == 'email') {
            $('#account_email').removeAttr('readonly');
            $('#account_firstname').val(myArray[1]);
            $('#account_firstname').attr('readonly', 'readonly');
            $('#account_phone').val(myArray[3]);
            $('#account_phone').attr('readonly', 'readonly');
        } else if (field_name == 'phone') {
            $('#account_phone').removeAttr('readonly');
            $('#account_firstname').val(myArray[1]);
            $('#account_firstname').attr('readonly', 'readonly');
            $('#account_email').val(myArray[2]);
            $('#account_email').attr('readonly', 'readonly');

        }



    });

}


function change_suggestedlocation() {

    var url = SrcPath + "tdispatch/get_suggestedlocation/";
    $.post(url, {}, function (response) {
        $('#load_location').html('');
        $('#load_location').html(response);
    });

}


function change_suggestedjourney() {

    var url = SrcPath + "tdispatch/get_suggestedjourney/";
    $.post(url, {}, function (response) {
        $('#load_journey').html('');
        $('#load_journey').html(response);
    });

}

function get_groupdetails(userid) {

    var url = SrcPath + "tdispatch/getgrouplist/?userid=" + userid;

    $.post(url, {}, function (response) {
        if (trim(response) != '') {
            $('#show_group').show();
            $('#usergroup_list').html('');
            $('#usergroup_list').html(response);
        }
    });

}

function change_minfare(model_id) {
    if (model_id != '') {

        var find_km = $('#distance_km').val();
        if (isNaN(find_km) || find_km == '') {
            find_km = 0;
        }
        //alert(find_km);
        calculate_totalfare(find_km, model_id,"","");

        /*var url= SrcPath+"tdispatch/get_modelminfare/?model_id="+model_id;
         
         $.post(url, {
         }, function(response){
         
         var find_km = $('#distance_km').val();
         if(isNaN(find_km) || find_km =='')
         {
         find_km = 0;
         }
         
         //var model_minfare = $('#model_minfare').val();
         $('#min_value').html(model_minfare);
         var total_fare = Math.round(parseFloat(km)*parseFloat(model_minfare));
         //
         
         
         
         });
         */
    }
}


function checkuseremail(email, passenger_id) {

    var url = SrcPath + "tdispatch/checkemailuserdetails/?email=" + email + "&passenger_id=" + passenger_id;

    $.post(url, {}, function (response) {
        if (trim(response) != 'N') {
            $('#uemailavilable').html('');
            $('#uemailavilable').html(response);
        } else {
            $('#uemailavilable').html('');
        }
    });

}

function checkuserphone(phone, passenger_id) {

    var url = SrcPath + "tdispatch/checkphoneuserdetails/?phone=" + phone + "&passenger_id=" + passenger_id;

    $.post(url, {}, function (response) {
        if (trim(response) != 'N') {
            $('#uphoneavilable').html('');
            $('#uphoneavilable').html(response);
        } else {
            $('#uphoneavilable').html('');
        }
    });

}

function checkdomainname(domainname) {
    if (trim(domainname).length != 0)
        loadurl(SrcPath + "/add/checkdomain?type=" + domainname, "unameavilable");
}

function calculate_totalfare(km, model_id,city,city_id) {

    if (trim(model_id) != '') {
        var url = SrcPath + "booking/booking_update.php";
        var dataS = "mode=calculateTotalFare&distance_km=" + km + "&model_id=" + model_id;

        $.ajax({
            type: "POST",
            url: url,
            data: dataS,
            cache: false,
            async: true,
            dataType: 'html',
            success: function (response) {
                /*var model_minfare = $('#model_minfare').val();
                 $('#min_value').html(model_minfare);
                 var total_fare = Math.round(parseFloat(km)*parseFloat(model_minfare));
                 */
                var rrr = response.split(",");
                var total_fare = rrr[0];
                var min_fare = rrr[2];
                var rate = rrr[1];
                var vat_tax = $('#vat_tax').html();
                var tot_tax = (total_fare * vat_tax / 100).toFixed(2);
                var tot_amt = parseFloat(total_fare) + parseFloat(tot_tax);
                tot_amt = (tot_amt).toFixed(2);
               $('#min_value').html(min_fare);
                $("#min_fare").html(min_fare);
                $('#sub_total').html(tot_amt);
                $('#total_price').html(tot_amt);
                $('#total_fare').val(tot_amt);
                $('#min_fare').removeClass('strike');
                $('#rate').val(rate);
                $('#model_minfare').val(min_fare);
                //alert(tot_amt +">"+ min_fare);
                if (parseFloat(tot_amt) > parseFloat(min_fare)) {
                    $('#min_fare').addClass('strike');
                   
                }
                else{
                     $('#total_fare').val(min_fare);
                    $('#total_price').html(min_fare);
                }
            }

        });
    }

}

function checkpotp() {
    var potp = $('#potp').val();
    var email = $('#customer_pemail').val();
    var key = $('#key').val();
    var dataS = "potp=" + potp + "&email=" + email + "&key=" + key;
    //alert(potp);
    if (potp != "") {
        $('#submit_otp').hide();
        $('#resend_otp').hide();
        $('#otp_btn').html('<img src="' + SrcPath + 'images/ajax-loaders/ajax-loader-1.gif" />');
        $.ajax({
            type: "POST",
            url: SrcPath + "passengers/otpvalidation", data: dataS,
            cache: false,
            dataType: 'html',
            success: function (response) {
                var resdata = JSON.parse(response);
                if (resdata.status == 3) {
                    $('#errors').html(resdata.message);
                    $('#otp_btn').hide();
                    $('#submit_otp').show();
                    $('#resend_otp').show();
                    return false;
                } else if (resdata.status == 2) {
                    $('#errors').html(resdata.message);
                    $('#otp_btn').hide();
                    $('#submit_otp').show();
                    $('#resend_otp').show();
                    return false;
                } else if (resdata.status == 4) {
                    window.location = SrcPath;
                } else if (resdata.status == 1) {
                    window.location = SrcPath;
                }
            }

        });
    } else {
        $('.errors').html('Please enter the OTP');
        return false;
    }
}


function resendpotp() {
    var email = $('#customer_pemail').val();
    var key = $('#key').val();
    //var dataS = "email="+email+"&key="+key+"&phone="+phone;
    var dataS = "email=" + email;
    //alert(potp);
    $('#resend_otp').hide();
    $('#submit_otp').hide();
    $('#errors').hide();
    $('#otp_btn').html('<img src="' + SrcPath + 'images/ajax-loaders/ajax-loader-1.gif" />');
    $.ajax({
        type: "POST",
        url: SrcPath + "passengers/resendotp",
        data: dataS,
        cache: false,
        dataType: 'html',
        success: function (response) {
            var resdata = JSON.parse(response);
            //alert(resdata);
            if (resdata.status == 2) {
                window.location = SrcPath;
            } else if (resdata.status == 3) {
                $('#errors').html(resdata.message);
                $('#resend_otp').show();
                $('#submit_otp').show();
                return false;
            } else if (resdata.status == 1) {
                window.location = SrcPath;
            }
        }

    });
}


function loginresendpotp() {
    var email = $('#customer_pemail').val();
    var key = $('#key').val();
    //var dataS = "email="+email+"&key="+key+"&phone="+phone;
    var dataS = "email=" + email;
    //alert(potp);
    $('#resend_otp').hide();
    $('#btn_login').hide();
    $('#otp_btn').html('<img src="' + SrcPath + 'images/ajax-loaders/ajax-loader-1.gif" />');
    $.ajax({
        type: "POST",
        url: SrcPath + "passengers/resendotp",
        data: dataS,
        cache: false,
        dataType: 'html',
        success: function (response) {
            var resdata = JSON.parse(response);
            //alert(resdata);
            if (resdata.status == 2) {
                window.location = SrcPath;
            } else if (resdata.status == 3) {
                $('#otp_btn').hide();
                $('#customer_p_error').html(resdata.message);
                $('#resend_otp').css('display', 'inline');
                return false;
            } else if (resdata.status == 1) {
                window.location = SrcPath;
            }
        }

    });
}


function checkdotp() {
    var dotp = $('#dotp').val();
    var demail = $('#demail').val();
    var key = $('#key').val();
    var dataS = "dotp=" + dotp + "&email=" + demail + "&key=" + key;
    //alert(dataS);
    if (dotp != "") {
        $('#submit_otp').hide();
        $('#resend_otp').hide();
        $('#otp_btn').html('<img src="' + SrcPath + 'images/ajax-loaders/ajax-loader-1.gif" />');
        $.ajax({
            type: "POST",
            url: SrcPath + "driver/otpvalidation",
            data: dataS,
            cache: false,
            dataType: 'html',
            success: function (response) {
                var resdata = JSON.parse(response);
                if (resdata.status == 3) {
                    $('#errors').html(resdata.message);
                    $('#otp_btn').hide();
                    $('#submit_otp').show();
                    $('#resend_otp').show();
                    return false;
                } else if (resdata.status == 2) {
                    $('#errors').html(resdata.message);
                    $('#otp_btn').hide();
                    $('#submit_otp').show();
                    $('#resend_otp').show();
                    return false;
                } else if (resdata.status == 4) {
                    window.location = SrcPath;
                } else if (resdata.status == 1) {
                    window.location = SrcPath;
                }
            }

        });
    } else {
        $('.errors').html('Please enter the OTP');
        return false;
    }
}


function resenddotp() {
    var email = $('#demail').val();
    var key = $('#key').val();
    //var dataS = "email="+email+"&key="+key+"&phone="+phone;
    var dataS = "email=" + email;
    //alert(potp);
    $('#resend_otp').hide();
    $('#submit_otp').hide();
    $('#otp_btn').html('<img src="' + SrcPath + 'images/ajax-loaders/ajax-loader-1.gif" />');
    $.ajax({
        type: "POST",
        url: SrcPath + "driver/resendotp", data: dataS,
        cache: false,
        dataType: 'html',
        success: function (response) {
            var resdata = JSON.parse(response);
            //alert(resdata);
            if (resdata.status == 2) {
                window.location = SrcPath;
            } else if (resdata.status == 3) {
                $('#errors').html(resdata.message);
                $('#resend_otp').show();
                $('#submit_otp').show();
                return false;
            } else if (resdata.status == 1) {
                window.location = SrcPath;
            }
        }

    });
}


function loginresenddotp() {
    var email = $('#demail').val();
    var key = $('#key').val();
    //var dataS = "email="+email+"&key="+key+"&phone="+phone;
    var dataS = "email=" + email;
    //alert(potp);
    $('#resend_dotp').hide();
    $('#btn_dlogin').hide();
    $('#otp_dbtn').html('<img src="' + SrcPath + 'images/ajax-loaders/ajax-loader-1.gif" />');
    $.ajax({
        type: "POST",
        url: SrcPath + "driver/resendotp", data: dataS,
        cache: false,
        dataType: 'html',
        success: function (response) {
            var resdata = JSON.parse(response);
            //alert(resdata);
            if (resdata.status == 2) {
                window.location = SrcPath;
            } else if (resdata.status == 3) {
                $('#otp_btn').hide();
                $('#d_error').html(resdata.message);
                $('#resend_otp').css('display', 'inline');
                return false;
            } else if (resdata.status == 1) {
                window.location = SrcPath;
            }
        }

    });
}

/*
 function checkuseremail(email,passenger_id)
 {  
 if(trim(email).length>0)
 {	
 loadurl(SrcPath+"tdispatch/checkemailuserdetails/?email="+email+"&passenger_id="+passenger_id,"uemailavilable");
 }	
 
 }
 
 function checkuserphone(phone,passenger_id)
 {  
 if(trim(phone).length>0)
 { 	
 loadurl(SrcPath+"tdispatch/checkphoneuserdetails/?phone="+phone+"&passenger_id="+passenger_id,"uphoneavilable");
 }
 
 }
 */


/*Phone Number validation */
/*function phone_validatelogin()
 {
 //valid = true;
 var mobReg1 = /^[1-9]{1}[0-9]{9}$/;
 var phone = document.phone_no.lphone.value;  
 var phone_length = document.phone_no.lphone.value.length; 
 var creditcard_no = $('#creditcard_no').val();
 var creditcard_cvv = $('#creditcard_cvv').val();
 
 if(phone=="")
 {
 $('#popup_lphone_error').html("Please enter the Phone");
 document.phone_no.lphone.focus();
 return false;        
 }	
 
 else if(phone_length<10)
 {
 
 $('#popup_lphone_error').html("Invalid Phone No");
 document.phone_no.lphone.focus();
 return false;
 }
 
 else if(!mobReg1.test(phone))
 {			
 $('#popup_lphone_error').html("Please enter number only");
 document.phone_no.lphone.focus();
 return false;
 }
 
 else if(creditcard_no == '')
 {
 $('#email_error').html('');
 $('#phone_error').html('');
 $('#address_error').html('');
 $('#creditcard_no_error').html('Please enter the Credit Card Number');	
 document.signup.creditcard_no.focus();
 return false;
 }
 else if(!numbers.test(creditcard_no))
 {
 $('#email_error').html('');
 $('#phone_error').html('');
 $('#address_error').html('');
 $('#creditcard_no_error').html('Please enter the Number only');	
 document.signup.creditcard_no.focus();
 return false;
 }
 else if(!all_cardtype.test(creditcard_no) )
 {
 $('#email_error').html('');
 $('#phone_error').html('');
 $('#address_error').html('');
 $('#creditcard_no_error').html('Please enter the Valid Credit Card Number');	
 document.signup.creditcard_no.focus();
 return false;
 }
 
 else{
 
 var url= SrcPath+'passengers/check_phone_exist/?phone='+phone;
 $.post(url,function(check){
 if(check == 1){
 $('#popup_lphone_error').html("Phone Number Already Exist");
 return false;
 }
 else
 {
 
 $('#popup_lphone_error').html('');
 
 var phone = $('#popup_lphone').val(); 			  
 var dataS = "phone="+phone;
 var response;
 $.ajax
 ({ 			
 type: "POST",
 url: SrcPath+"passengers/phonenumber", 
 data: dataS, 
 cache: false, 
 dataType: 'html',
 success: function(response) 
 { 	//alert(response);exit;
 $(document).ready(function() {
 window.location=SrcPath+"passengers/dashboard";
 $('#phone_number').trigger('close');			 				
 event.preventDefault();	
 });		
 
 } 
 
 });
 
 }
 
 });
 
 }
 }*/



/*** Phone phone popup form ***/
/*$('#phone_no').keyup(function(e) {
 if(e.which == 13) 
 {
 phone_validatelogin();
 }
 });
 */

/***  EOF phone popup form ***/