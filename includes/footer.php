<link rel="stylesheet" href="<?php echo BASE_PATH; ?>css/jquery.dataTables.css">
<script src="<?php echo BASE_PATH; ?>js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.easytabs.min.js"></script> 
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.collapsible.min.js"></script>
<!--<script src="<?php echo BASE_URL; ?>js/noty.js"></script>-->
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/jquery-ui.css">
<!--<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/datetimepicker.css">-->
<script type="text/javascript" src="<?php echo BASE_URL; ?>includes/readyFunction.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>includes/common_js_functions.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.age.js"></script>
<script src="<?php echo BASE_URL; ?>js/jquery-ui.js"></script>
<script src="<?php echo BASE_URL; ?>js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.validate.js"></script>
<?php
if ((isset($_SESSION['executive_position'])) && ($_SESSION['executive_position'] == "admin")) {
    
}
?>

</div>
<!-- /content -->
</div>
<?php
if ((isset($_SESSION['executive_id']))) {
    ?>
    <div id="jsrp_related">
        <a href="javascript:void()" id="jsrp_related-close" onclick="toggle()"><img id="close_btn" src="<?php echo BASE_PATH ?>images/minusnew.png" alt="Close"></a>
        <h3>Booking Alert</h3>
        <ul id="log_content"></ul>
    </div>
    <div id="jsrp_related1">
        <a href="javascript:void()" id="jsrp_related-close1" onclick="toggle1()"><img id="close_btn1" src="<?php echo BASE_PATH ?>images/minusnew.png" alt="Close"></a>
        <h3>Idle Vehicle</h3>
        <ul id="vehicle_idle"></ul>
    </div>
    <!-- /content container -->
    <!-- Footer -->
    <script type="text/javascript">
        var SrcPath = $("body").data('base');
        function toggle() {
            var imgSrc = $("#close_btn").attr("src");
            var findimg = imgSrc.split('/').pop();
            //For Replacing the Menu Images
            //==============================
            //alert(findimg);
            var toggle_image = SrcPath + "images/minusnew.png";
            if (findimg == "minusnew.png") {
                var toggle_image = SrcPath + "images/maximize.png";
                $("#jsrp_related").animate({height: "40px"}, {queue: false, duration: 500});
            }
            else {
                $("#close_btn").attr({src: toggle_image});
                $("#jsrp_related").animate({height: "500px"}, {queue: false, duration: 500});
            }
            $("#close_btn").attr({src: toggle_image});
        }
        function toggle1() {
            var imgSrc = $("#close_btn1").attr("src");
            var findimg = imgSrc.split('/').pop();
            //For Replacing the Menu Images
            //==============================
            var toggle_image = SrcPath + "images/minusnew.png";
            if (findimg == "minusnew.png") {
                var toggle_image = SrcPath + "images/maximize.png";
                $("#jsrp_related1").animate({height: "40px"}, {queue: false, duration: 500});
            }
            else {
                $("#close_btn1").attr({src: toggle_image});
                $("#jsrp_related1").animate({height: "500px"}, {queue: false, duration: 500});
            }
            $("#close_btn1").attr({src: toggle_image});
        }
        function load_logcontent()
        {
            var dataS = '';
            var SrcPath = $('#baseurl').val();
            var response;
            $.ajax
                    ({
                        type: "POST",
                        url: SrcPath + "logs/get_log_content1.php",
                        data: dataS,
                        cache: false,
                        dataType: 'html',
                        success: function (response)
                        {
                            response = response.trim();
                            if (response != "") {
                                var imgSrc = $("#close_btn").attr("src");
                                var findimg = imgSrc.split('/').pop();
                                if (findimg == "maximize.png") {
                                    toggle();
                                }
                            }
                            else {
                                var imgSrc = $("#close_btn").attr("src");
                                var findimg = imgSrc.split('/').pop();
                                if (findimg == "minimize.png") {
                                    toggle();
                                }
                            }
                            $('#log_content').html(response);
                            $('.age').age();
                        }
                    });
        }
        function load_unnoticeddriver()
        {
            var dataS = '';
            var SrcPath = $('#baseurl').val();
            var response;
            $.ajax
                    ({
                        type: "POST",
                        url: SrcPath + "location/notsendinglocation.php",
                        data: dataS,
                        cache: false,
                        dataType: 'html',
                        success: function (response)
                        {
                            response = response.trim();
                            if (response != "") {
                                var imgSrc = $("#close_btn1").attr("src");
                                var findimg = imgSrc.split('/').pop();
                                if (findimg == "maximize.png") {
                                    toggle1();
                                }
                            }
                            else {
                                var imgSrc = $("#close_btn1").attr("src");
                                var findimg = imgSrc.split('/').pop();
                                if (findimg == "minimize.png") {
                                    toggle1();
                                }
                            }
                            $('#vehicle_idle').html(response);
    //                            $('.age').age();
                        }
                    });
        }
        toggle();
        toggle1();
        setInterval("load_unnoticeddriver()", 200000);
        setInterval("load_logcontent()", 130000);
        setTimeout("firsttime()",3000);// firsttime();
        
        function notifydriver(driverid) {
            $.post(SrcPath + "logs/notify.php", {id: driverid}, function (success) {
                alert(success);
            });
        }
        function  firsttime() {
            var dataS = '';
            var SrcPath = $('#baseurl').val();
            var response;
            $.ajax
                    ({
                        type: "POST",
                        url: SrcPath + "location/notsendinglocation.php",
                        data: dataS,
                        cache: false,
                        dataType: 'html',
                        success: function (response)
                        {
                            response = response.trim();
                            $('#vehicle_idle').html(response);

                        }
                    });

            
            $.ajax
                    ({
                        type: "POST",
                        url: SrcPath + "logs/get_log_content1.php",
                        data: dataS,
                        cache: false,
                        dataType: 'html',
                        success: function (response)
                        {
                            $('#log_content').html(response);
                            $('.age').age();
                        }
                    });
        }
        function accept_booking(bookingid) {
            $.post(SrcPath + "assign/assign_update.php", {booking_id: bookingid, mode: "acceptbooking"}, function (success) {
                alert(success);
                load_logcontent();
            });
        }
    </script>
<?php }
?>

<div id="footer">
    <div class="copyrights">©2014 Maalgaadi. All rights reserved.</div>
</div>
