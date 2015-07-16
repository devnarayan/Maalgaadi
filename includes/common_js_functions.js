$(document).ready(function () {
     $('.fullview1').click(function () {
        var hasclass=$("body").hasClass("clean");
       
        if(hasclass){
            
            $("body").removeClass("clean");
        $('#sidebar').removeClass("hide-sidebar mobile-sidebar");
        $('#content').removeClass("full-content");
        }
        else{
             $("body").addClass("clean");
        $('#sidebar').addClass("hide-sidebar mobile-sidebar");
        $('#content').addClass("full-content");
        }
        
    });
    ready();
    setNavigation();
    setDateRange();
});
function setNavigation() {
    var path = window.location.href;
    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path);

    $("#sidebar a").each(function () {

        var href = $(this).attr('href');

        if (path == href) {

            $(this).addClass('active');
$(this).closest('ul').parent("li").children('a').addClass('subOpened');
$(this).closest('ul').show();
$(this).closest('ul').children('a').removeClass('subClosed');
$(this).closest('li').addClass('active');
$(this).attr('id','current');
$(this).closest('li').children('a').attr('id','current');
$(this).closest('li').children('a').attr('id','current');
$(this).closest('li').children('a').addClass('subOpened');
            $(this).closest('li').children('a').addClass('active')
            return;
        }
    });
}
function login(formid) {
    alert('hiii');
    var usrename = $("#" + formid + " #email").val();
    var password = $("#" + formid + " #password").val();
    if (usrename == "") {

    }
    $.post("defaultTask.php?function=login", {email: usrename, password: password})
            .done(function (data) {
                var result = data.trim();
                var arid = result.split('-');
                alert(arid[1]);
                console.log(arid);
                if (result == "success") {
                    $("#result").addClass("alert");
                    $("#result").removeClass("alert-danger");
                    $("#result").addClass("alert-success");
                    $("#result").html('<button class="close" data-dismiss="alert" type="button">x</button>');
                    $("#result").append("Congrats! You Are Success Fully Logged in");
                    window.location.href = "index.php";
                    //window.location.reload();
                }
                else {
                    $("#result").addClass("alert");
                    $("#result").removeClass("alert-success");
                    $("#result").addClass("alert-danger");
                    $("#result").html('<button class="close" data-dismiss="alert" type="button">x</button>');
                    $("#result").append("Oops! " + result);
                }
            });
}
function formSubmit(formid, rid, target) {
    $(".overflow").show();
    $("#" + formid).validate();
    if ($("#" + formid).valid()) {
        var oOutput = document.getElementById(rid);
        oData = new FormData(document.forms.namedItem(formid));
        var resultid = rid;
        var oReq = new XMLHttpRequest();
        oReq.open("POST", target, true);
        oReq.onload = function (oEvent) {
            if (oReq.status == 200) {
                var result = oReq.responseText;
                if (target == "forget_password1.php") {
                    if (result.indexOf("Success") > 0) {
                        setTimeout('window.location.reload()', 1000);
                        if (result.indexOf("Success") > 0) {
                            oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                            var customer_id=$("#customer_id").val();
                                    fetchpickupDrop(customer_id);
                                    setTimeout("$('#exampleModal').modal('close')");
                        }
                        return;
                    }
                }
                if(rid=="edit_fav_location_result"){
                    if (result.indexOf("Success") > 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                else {
                    oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                    $(".overflow").hide();
                   
                    return;
                }
                if(target=="booking_search.php"){
                    oOutput.innerHTML = result ;
                    $(".overflow").hide();
                  
                    return;
                }
                if (result.indexOf("Success") > 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                    if (result.indexOf("update") < 0) {
                        $("#" + formid + " input[type=text]").val("");
                        $("#" + formid + " textarea").val("");
                        $("#" + formid + " input[type=email]").val("");
                        $("#" + formid + " input[type=password]").val("");
                        $('#' + formid).each(function () {
                            this.reset();
                              $('#booking_button').show();
                        });
                    }
                    setTimeout("$('#" + rid + "')html('')", 3000);
                }
                else if (result.indexOf("reload") >= 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result.replace('reload', '') + '</div>';
                    setTimeout('window.location.reload()', 2000);
                }
                else if (result.indexOf("redirect") >= 0) {
                    var rs = result.replace('redirect', '');
                    var res = rs.split('URL')
                    var url = res[1];
                    //alert (url);
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + res[0] + '</div>';
                   window.location.href = url;
                }
                else if (result.indexOf("Print") >= 0) {
                    var rs = result.replace('Print', '');
                    var res = rs.split('URL')
                    var url = res[1];

                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + res[0] + '</div>';
                    window.open(url);
                    window.location.reload();
                }

                else {
                    oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                 $(".overflow").hide();
                   $('#booking_button').show();
            }
            else {
                oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>Error ' + oReq.status + ' occurred uploading your file.</div>';
                 $(".overflow").hide();
                   $('#booking_button').show();
            }
        };
        oReq.send(oData);
       
    }
    else{
         $(".overflow").hide();
           $('#booking_button').show();
    }
    
}




function formSubmitt(formid, rid, target) {
    $(".overflow").show();
    $("#" + formid).validate();
    if ($("#" + formid).valid()) {
        var oOutput = document.getElementById(rid);
        oData = new FormData(document.forms.namedItem(formid));
        var resultid = rid;
        var oReq = new XMLHttpRequest();
        oReq.open("POST", target, true);
        oReq.onload = function (oEvent) {
            if (oReq.status == 200) {
                var result = oReq.responseText;
                if (target == "forget_password1.php") {
                    if (result.indexOf("Success") > 0) {
                        setTimeout('window.location.reload()', 1000);
                        if (result.indexOf("Success") > 0) {
                            oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                            var customer_id=$("#customer_id").val();
                                    fetchpickupDrop(customer_id);
                                    setTimeout("$('#exampleModal').modal('close')");
                        }
                        return;
                    }
                }
                if(rid=="edit_fav_location_result"){
                    if (result.indexOf("Success") > 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                else {
                    oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                    $(".overflow").hide();
                   
                    return;
                }
                if(target=="booking_search_daily.php"){
                    oOutput.innerHTML = result ;
                    $(".overflow").hide();
                  
                    return;
                }
                if (result.indexOf("Success") > 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                    if (result.indexOf("update") < 0) {
                        $("#" + formid + " input[type=text]").val("");
                        $("#" + formid + " textarea").val("");
                        $("#" + formid + " input[type=email]").val("");
                        $("#" + formid + " input[type=password]").val("");
                        $('#' + formid).each(function () {
                            this.reset();
                              $('#booking_button').show();
                        });
                    }
                    setTimeout("$('#" + rid + "')html('')", 3000);
                }
                else if (result.indexOf("reload") >= 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result.replace('reload', '') + '</div>';
                    setTimeout('window.location.reload()', 2000);
                }
                else if (result.indexOf("redirect") >= 0) {
                    var rs = result.replace('redirect', '');
                    var res = rs.split('URL')
                    var url = res[1];
                    //alert (url);
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + res[0] + '</div>';
                   window.location.href = url;
                }
                else if (result.indexOf("Print") >= 0) {
                    var rs = result.replace('Print', '');
                    var res = rs.split('URL')
                    var url = res[1];

                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + res[0] + '</div>';
                    window.open(url);
                    window.location.reload();
                }

                else {
                    oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                 $(".overflow").hide();
                   $('#booking_button').show();
            }
            else {
                oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>Error ' + oReq.status + ' occurred uploading your file.</div>';
                 $(".overflow").hide();
                   $('#booking_button').show();
            }
        };
        oReq.send(oData);
       
    }
    else{
         $(".overflow").hide();
           $('#booking_button').show();
    }
    
}




function formSubmitCus(formid, rid, target) {
    $(".overflow").show();
    $("#" + formid).validate();
    if ($("#" + formid).valid()) {
        var oOutput = document.getElementById(rid);
        oData = new FormData(document.forms.namedItem(formid));
        var resultid = rid;
        var oReq = new XMLHttpRequest();
        oReq.open("POST", target, true);
        oReq.onload = function (oEvent) {
            if (oReq.status == 200) {
                var result = oReq.responseText;
                if (target == "forget_password1.php") {
                    if (result.indexOf("Success") > 0) {
                        setTimeout('window.location.reload()', 1000);
                        if (result.indexOf("Success") > 0) {
                            oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                            var customer_id=$("#customer_id").val();
                                    fetchpickupDrop(customer_id);
                                    setTimeout("$('#exampleModal').modal('close')");
                        }
                        return;
                    }
                }
                if(rid=="edit_fav_location_result"){
                    if (result.indexOf("Success") > 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                else {
                    oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                    $(".overflow").hide();
                   
                    return;
                }
                if(target=="customer_discount_report_data.php"){
                    oOutput.innerHTML = result ;
                    $(".overflow").hide();
                  
                    return;
                }
                if (result.indexOf("Success") > 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                    if (result.indexOf("update") < 0) {
                        $("#" + formid + " input[type=text]").val("");
                        $("#" + formid + " textarea").val("");
                        $("#" + formid + " input[type=email]").val("");
                        $("#" + formid + " input[type=password]").val("");
                        $('#' + formid).each(function () {
                            this.reset();
                              $('#booking_button').show();
                        });
                    }
                    setTimeout("$('#" + rid + "')html('')", 3000);
                }
                else if (result.indexOf("reload") >= 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result.replace('reload', '') + '</div>';
                    setTimeout('window.location.reload()', 2000);
                }
                else if (result.indexOf("redirect") >= 0) {
                    var rs = result.replace('redirect', '');
                    var res = rs.split('URL')
                    var url = res[1];
                    //alert (url);
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + res[0] + '</div>';
                   window.location.href = url;
                }
                else if (result.indexOf("Print") >= 0) {
                    var rs = result.replace('Print', '');
                    var res = rs.split('URL')
                    var url = res[1];

                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + res[0] + '</div>';
                    window.open(url);
                    window.location.reload();
                }

                else {
                    oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                 $(".overflow").hide();
                   $('#booking_button').show();
            }
            else {
                oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>Error ' + oReq.status + ' occurred uploading your file.</div>';
                 $(".overflow").hide();
                   $('#booking_button').show();
            }
        };
        oReq.send(oData);
       
    }
    else{
         $(".overflow").hide();
           $('#booking_button').show();
    }
    
}

function formSubmitCusBal(formid, rid, target) {
    $(".overflow").show();
    $("#" + formid).validate();
    if ($("#" + formid).valid()) {
        var oOutput = document.getElementById(rid);
        oData = new FormData(document.forms.namedItem(formid));
        var resultid = rid;
        var oReq = new XMLHttpRequest();
        oReq.open("POST", target, true);
        oReq.onload = function (oEvent) {
            if (oReq.status == 200) {
                var result = oReq.responseText;
                if (target == "forget_password1.php") {
                    if (result.indexOf("Success") > 0) {
                        setTimeout('window.location.reload()', 1000);
                        if (result.indexOf("Success") > 0) {
                            oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                            var customer_id=$("#customer_id").val();
                                    fetchpickupDrop(customer_id);
                                    setTimeout("$('#exampleModal').modal('close')");
                        }
                        return;
                    }
                }
                if(rid=="edit_fav_location_result"){
                    if (result.indexOf("Success") > 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                else {
                    oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                    $(".overflow").hide();
                   
                    return;
                }
                if(target=="customer_balance_report_data.php"){
                    oOutput.innerHTML = result ;
                    $(".overflow").hide();
                  
                    return;
                }
                if (result.indexOf("Success") > 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                    if (result.indexOf("update") < 0) {
                        $("#" + formid + " input[type=text]").val("");
                        $("#" + formid + " textarea").val("");
                        $("#" + formid + " input[type=email]").val("");
                        $("#" + formid + " input[type=password]").val("");
                        $('#' + formid).each(function () {
                            this.reset();
                              $('#booking_button').show();
                        });
                    }
                    setTimeout("$('#" + rid + "')html('')", 3000);
                }
                else if (result.indexOf("reload") >= 0) {
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + result.replace('reload', '') + '</div>';
                    setTimeout('window.location.reload()', 2000);
                }
                else if (result.indexOf("redirect") >= 0) {
                    var rs = result.replace('redirect', '');
                    var res = rs.split('URL')
                    var url = res[1];
                    //alert (url);
                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + res[0] + '</div>';
                   window.location.href = url;
                }
                else if (result.indexOf("Print") >= 0) {
                    var rs = result.replace('Print', '');
                    var res = rs.split('URL')
                    var url = res[1];

                    oOutput.innerHTML = '<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">x</button>' + res[0] + '</div>';
                    window.open(url);
                    window.location.reload();
                }

                else {
                    oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>' + result + '</div>';
                }
                 $(".overflow").hide();
                   $('#booking_button').show();
            }
            else {
                oOutput.innerHTML = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">x</button>Error ' + oReq.status + ' occurred uploading your file.</div>';
                 $(".overflow").hide();
                   $('#booking_button').show();
            }
        };
        oReq.send(oData);
       
    }
    else{
         $(".overflow").hide();
           $('#booking_button').show();
    }
    
}



function deleteRow1(ths) {
     $(".overflow").show();
    $(ths).closest("tr").remove();
     $(".overflow").hide();
}

function setDateRange() {
    if ($("#two-inputs3").length > 0) {
        var p = $("#two-inputs3");
        var x = p.offset();
        $("#two-inputs3").dateRangePicker({
            format: "DD/MM/YYYY",
            separator: " to ",
            showShortcuts: false,
            autoClose: true,
            getValue: function ()
            {
                if ($('#cit1').val() && $('#cot1').val())
                    return $('#cit1').val() + ' to ' + $('#cot1').val();
                else
                    return '';
            },
            setValue: function (s, s1, s2)
            {
                $('#cit1').val(s1);
                $('#cot1').val(s2);

            }

        });
    }
    if ($("#two-inputs").length > 0) {
        var p = $("#two-inputs");
        var x = p.offset();
        $("#two-inputs").dateRangePicker({
            format: "DD/MM/YYYY HH:mm:ss",
            separator: " to ",
            time: true,
            startDate: Date.today(),
            showShortcuts: false,
            autoClose: true,
            time:{
                enabled: true
            },
            getValue: function ()
            {
                if ($('#cit').val() && $('#cot').val())
                    return $('#cit').val() + ' to ' + $('#cot').val();
                else
                    return '';
            },
            setValue: function (s, s1, s2)
            {
                $('#cit').val(s1);
                $('#cot').val(s2);
                $('#cit').change();
            }

        });
    }
    if ($("#shortcheckoutdate").length > 0) {

        $("#shortcheckoutdate").dateRangePicker({
            format: "DD/MM/YYYY HH:mm:ss",
            time: true,
            startDate: Date.today(),
            autoClose: true,
            time:{
                enabled: true
            },
            singleDate: true,
            showShortcuts: false,
            setValue: function (s1)
            {
                $('#shortcheckoutdate').val(s1);
                $('#shortcheckoutdate').change();
            }
        });
    }
    if ($("#shortcheckoutdate1").length > 0) {

        $("#shortcheckoutdate1").dateRangePicker({
            format: "DD/MM/YYYY HH:mm:ss",
            time: true,
            startDate: Date.today(),
            autoClose: true,
            time:{
                enabled: true
            },
            singleDate: true,
            showShortcuts: false,
            setValue: function (s1)
            {
                $('#shortcheckoutdate1').val(s1);
                $('#shortcheckoutdate1').change();
            }
        });
    }
    if ($("#two-inputs1").length > 0) {
        var p = $("#two-inputs1");
        var x = p.offset();
        $("#two-inputs1").dateRangePicker({
            format: "DD/MM/YYYY HH:mm:ss",
            separator: " to ",
            time: true,
            startDate: Date.today(),
            showShortcuts: false,
            autoClose: true,
            time:{
                enabled: true
            },
            getValue: function ()
            {
                if ($('#sea11').val() && $('#sea21').val())
                    return $('#sea11').val() + ' to ' + $('#sea21').val();
                else
                    return '';
            },
            setValue: function (s, s1, s2)
            {
                $('#sea11').val(s1);
                $('#sea21').val(s2);

            }

        });
    }

}
function searchCustomer() {
     $(".overflow").show();
    $("#searchBynumber").validate();
    if ($("#searchBynumber").valid()) {
        var num = $("#searchnumber").val();
        if (num != "") {

            $.post('register_update.php', {mode: "searchCustomer", number: num}).done(function (data) {
                var form = document.forms['registerForm'];
                // create the text variables

                if (data != 'false') {
                    var text = data
                    text = text.replace(/(^\s+|\s+$)/, '');
                    text = "(" + text + ");";
                    // attempt to create valid JSON
                    try
                    {
                        var json = eval(text)
                    }
                    catch (err)
                    {
                        alert('That appears to be invalid JSON!')
                        return false;
                    }
                    $(form).populate(json, {resetForm: false, debug: 1});
                     $(".overflow").hide();
                }
                else {
                     $(".overflow").hide();
                    alert("No customer by this number");
                }
                
            });
        }
    }
    else{
         $(".overflow").hide();
    }
}
function fillvehicledetail(value) {
    if (value != "") {
        $.post("vehicle_update.php", {mode: "fetchCategory", name: value}, function (data) {
            var item = jQuery.parseJSON(data);
            $("#name").val(item.name);
            $("#capacity").val(item.capacity);
            $("#fare").val(item.fare);
        });
    }
}
function driver2Fetch(value, selecter,vehicle) {
    if (value != "") {
        $.post("vehicle_update.php", {mode: "fetchDriver2", id: value,vehicle:vehicle}, function (data) {
            $("#" + selecter).html(data);
        });
    }
}
function get_liveuser()
{
    var dataS = "1=1";
    var SrcPath = "<?php echo BASE_URL; ?>";
    var response;
    $.ajax
            ({
                type: "POST",
                url: SrcPath + "admin/activeusers_list.php",
                data: dataS,
                success: function (response)
                {
                    $('#liveuser').html();
                    $('#liveuser').html(response);
                }
            });
}
 function getAddress(address){
     var result;
     
     $.get("https://maps.googleapis.com/maps/api/geocode/json?address="+address,function(data){
          
                                               result = data.results[0].geometry.location.lat+"|"+data.results[0].geometry.location.lng; 
                                              alert(result);  
                                              return result; 
                                  });
    
      
     
     }