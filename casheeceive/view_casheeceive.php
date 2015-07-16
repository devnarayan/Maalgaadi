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
                <li class="active"><a title="">Cash Receive List</a></li>
            </ul>
        </div>

        <div class="content_middle mt15">    
            <table id="example" class="display" cellspacing="0" width="100%">

                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Cash Receive Date </th>
                        <th>Cash Receive Amount  </th>
                        <th>Narration </th>
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
                "ajax": "casheeceive_data.php"
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