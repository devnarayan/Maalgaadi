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
                    <li class="active"><a title="">Vehicle Price Range List</a></li>
                </ul>
            </div>
          
                    <div class="content_middle mt15">    
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>City</th>
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
                $(this).html('<input type="text" style="width:100px;" placeholder="City" />');
            });
           
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "city_data.php",
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

        function delete_menu(value)
        {
            if(confirm('Are you sure you want to delete'))
            {
                  document.location.href = 'city_update.php?mode=delete_city&id='+value;  
            } 
        }

    </script>
    <?php include '../includes/footer.php'; ?>
</body>
</html> 