<?php include '../includes/define.php'; ?>
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
                        <a href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a>		                </li>
                    <li class="active"><a title="">Organization List</a></li>
                </ul>
            </div>
          
                    <div class="content_middle mt15">    
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Phone No</th>
                                    <th>Email</th>
                                    <th>Address</th>
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
            $('#example thead th:nth-child(3)').each(function () {
                var title = $('#example thead th:nth-child(2)').eq($(this).index()).text();
                $(this).html('<input type="text" placeholder="Mobile" style="width:80px;" />');
            });
            $('#example thead th:nth-child(4)').each(function () {
                var title = $('#example thead th:nth-child(3)').eq($(this).index()).text();
                $(this).html('<input type="text"  placeholder="Email" />');
            });
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "organization_data.php",
            });
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