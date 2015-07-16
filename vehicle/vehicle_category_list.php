<?php
include '../includes/define.php';
verifyLogin();
?>
<html>
    <head>
<?php include '../includes/head.php'; ?>
        <style>
            #footer{
                bottom:0 !important;  
            }
        </style>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
<?php include '../includes/header.php'; ?>

        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li>
                    <a href="<?php echo BASE_URL; ?>" title="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="active"><a title="">Vehicle Category List</a></li>
            </ul>
        </div>

        <div class="content_middle mt15">    
            <table id="example" class="display" cellspacing="0" width="100%">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>City </th>
                        <th>Capacity </th>

                        <th>Volume  </th>
                        <th>Image</th>
                        <th>Salary </th>
                        <th>Rate </th>

                        <th>Wait time</th>
                        <th>WTC</th>
                        <th>Contract Km</th>
                        <th>Contract Hour</th>
                        <th>extra km</th>
                        <th>extra Time</th>

                        <th>Action</th>
                    </tr>
                </thead>


            </table>

            <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        </div>
        <script src="<?php echo BASE_PATH; ?>js/jquery.dataTables.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>css/jquery.dataTables.css">
    <!--dtat tabl-->
    <style>
        tfoot {
            display: table-header-group;

        }
    </style>
    <script>

        $(document).ready(function () {
            $('#example thead th:first-child').each(function () {
                var title = $('#example thead th:first-child').eq($(this).index()).text();
                $(this).html('<input type="text" style="width:60px;" placeholder="Name" />');
            });
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "vehicle_category_data.php"
            });
            // Apply the search
            table.columns().eq(0).each(function (colIdx) {
                $('input', table.column(colIdx).header()).on('keyup change', function () {
                    table
                            .column(colIdx)
                            .search(this.value)
                            .draw();
                });
            });
        });


    </script>
<?php include '../includes/footer.php'; ?>


</body>
</html> 