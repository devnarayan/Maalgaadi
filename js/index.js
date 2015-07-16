//$(document).ready(function () {

/*
    $("#transtartdate").datetimepicker({
        showTimepicker: true,
        showSecond: true,
        timeFormat: 'hh:mm:ss',
        dateFormat: 'yy-mm-dd',
        stepHour: 1,
        stepMinute: 1,
        maxDateTime: new Date(),
        stepSecond: 1
    });

    $("#tranenddate").datetimepicker({
        showTimepicker: true,
        showSecond: true,
        timeFormat: 'hh:mm:ss',
        dateFormat: 'yy-mm-dd',
        stepHour: 1,
        stepMinute: 1,
        maxDateTime: new Date(),
        stepSecond: 1
    });

    $("#userstartdate").datetimepicker({
        showTimepicker: true,
        showSecond: true,
        timeFormat: 'hh:mm:ss',
        dateFormat: 'yy-mm-dd',
        stepHour: 1,
        stepMinute: 1,
        maxDateTime: new Date(),
        stepSecond: 1
    });

    $("#userenddate").datetimepicker({
        showTimepicker: true,
        showSecond: true,
        timeFormat: 'hh:mm:ss',
        dateFormat: 'yy-mm-dd',
        stepHour: 1,
        stepMinute: 1,
        maxDateTime: new Date(),
        stepSecond: 1
    });


     var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'container_userchart',
            type: 'line',
            marginRight: 130,
            marginBottom: 25,
            events: {
                load: requestData()
            }
        },
        title: {
            text: "Users Registation per Month",
            x: -20 //center
        },
        subtitle: {
            text: "For  2015",
            x: -20
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: "Users Count"
            },
            plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -10,
            y: 100,
            borderWidth: 0
        },
        series: [{
                name: "Users Count",
                data: []
            }]
    });


    function requestData() {
        $.ajax({
            url: 'logs/getUsers.php',
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (json) {
                if (json['error']) {
                    alert(json['error']);
                }

                if (json['success']) {
                    var series = chart.series[0],
                            shift = series.data.length > 30; // shift if the series is longer than 300 (drop oldest point)
                    $.each(json['success']['users'], function (key, value) {
                        // add the point
                        chart.series[0].addPoint(eval(value['count']), true, shift);
                    });
                }
            }
        });
    }

});


$(function () {

    // Radialize the colors
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });

    // Build the chart
    $('#user_company').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Drivers by Company'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function () {
                        return '<b>' + this.point.name + '</b>: ' + this.y;
                    }
                }
            }
        },
        series: [{
                type: 'pie',
                name: 'Total Users',
                data: [
                    ['Company', 11], ['test', 5]]
            }]
    });
});


$(function () {

    // Radialize the colors


    // Build the chart
    $('#booking_chart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Booking by Company'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function () {
                        return '<b>' + this.point.name + '</b>: ' + this.y;
                    }
                }
            }
        },
        series: [{
                type: 'pie',
                name: 'Total Users',
                data: [
                    ['Company', 11], ['test', 5]]
            }]
    });
});
$(function () {

    // Build the chart
    $('#transaction_company').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Employees Chart'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            //pointFormat: '{series.name}: <b>{point.y}</b>'
            percentageDecimals: 1
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function () {
                        //$nightfare = ($night_fare/100)*$total_fare;//night_charge%100;
                        //var new_val = (Math.round(this.percentage*100)/100);
                        var new_val = (Math.round(this.percentage * 100));
                        return '<b>' + this.point.name + '</b>:' + new_val + ' %';
                        //return '<b>'+ this.point.name +'</b>: '+ this.y;
                    }
                }
            }
        },
        series: [{
                type: 'pie',
                name: 'Employees Chart',
                data: [
                    ['Company', 195711.64]]
            }]
    });
});


*/





//ajax_call_notify(0);
//Function used for the Push notifications
//setInterval(function ()
//{
//    if ($("#notify_alert").length > 0)
//    {
//      //  ajax_call_notify(1);
//    }
//
//   // get_liveuser();
//
//}, 500000);
/*
 function ajax_call_notify(flag)
 {
 
 if ($("#notify_alert"))
 {
 
 var value = $('#driver_logs').val();
 
 var dataS = "value="+value+"&flag="+flag;			
 var response;
 $.ajax
 ({ 			
 type: "POST",
 url: "<?php echo BASE_URL; ?>admin/get_admin_notifications", 
 data: dataS, 
 cache: false, 
 dataType: 'html',
 success: function(response) 
 { 		
 //alert(response);		
 if(flag==0){
 //alert(response);
 //$('#notify_alert').html(response);	
 var ars =  ["Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola"];
 //$.each(ars, function(i, val) {
 //alert(val)
 var n = noty({
 text: response,//'<strong>Hi!</strong>  You have new booking request!',
 type: 'confirm',
 layout: 'bottomRight',
 closeWith: ['click'],
 });
 //});
 }
 else{
 //$('#notify_alert').html(response);	
 }
 } 
 
 });	
 }
 else
 return false;
 }
 */

function get_liveuser()
{

    var dataS = "1=1";
   var SrcPath = $("body").data('base');
    var response;
    $.ajax
            ({
                type: "POST",
                url: SrcPath + "admin/activeusers_list",
                data: dataS,
                success: function (response)
                {
                    $('#liveuser').html();
                    $('#liveuser').html(response);
                }

            });
}

$("#change_usercompany").click(function () {

    var startdate = $("#userstartdate").val();
    var enddate = $("#userenddate").val();
    if (startdate == '')
    {
        $("#startdate_error").html("Select the Start date");
        $("#startdate_error").show();
    }
    else
    {
        $("#startdate_error").html("");
        $("#startdate_error").hide();
    }
    if (enddate == '')
    {
        $("#enddate_error").html("Select the End date");
        $("#enddate_error").show();
    }
    else
    {
        $("#enddate_error").hide("");
        $("#enddate_error").hide();
    }
    if (startdate != '' && enddate != '')
    {
        if (startdate > enddate)
        {
            $("#startdate_error").html("Start date should not be greater than End date !!");
            $("#startdate_error").show();
        }
        else
        {
            $("#startdate_error").html("");
            $("#startdate_error").hide();
            document.forms['dashboard'].submit();

        }
    }

});

$("#change_transcompany").click(function () {


    var startdate = $("#transtartdate").val();
    var enddate = $("#tranenddate").val();
    if (startdate == '')
    {
        $("#transtartdate_error").html("Select the Start date");
        $("#transtartdate_error").show();
    }
    else
    {
        $("#transtartdate_error").html("");
        $("#transtartdate_error").hide();
    }
    if (enddate == '')
    {
        $("#tranenddate_error").html("Select the End date");
        $("#tranenddate_error").show();
    }
    else
    {
        $("#tranenddate_error").hide("");
        $("#tranenddate_error").hide();
    }
    if (startdate != '' && enddate != '')
    {
        if (startdate > enddate)
        {
            $("#transtartdate_error").html("Start date should not be greater than End date !!");
            $("#transtartdate_error").show();
        }
        else
        {
            $("#transtartdate_error").html("");
            $("#transtartdate_error").hide();
            document.forms['dashboard'].submit();

        }
    }

});
//===== Hide/show action tabs =====//

$('.showmenu').click(function () {
    $('.actions-wrapper').slideToggle(100);
});

//===== Easy tabs =====//

$('.actions').easytabs({
    animationSpeed: 300,
    collapsible: false,
    tabActiveClass: "current"
});