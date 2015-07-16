<?php include '../includes/define.php'; 
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
                        <a href="<?php echo BASE_URL; ?>" title="Dash Boad">Home</a>		                </li>
                    
                    <li class="active"><a title="">Driver List</a></li>
                </ul>
            </div>
           
               
                    <div class="content_middle mt20">    
                        <div class="pageHeader">
                             <span id="succMsg"></span>
                            <div class="style_1">Driver List  <div class="floatR"><a href="driver.php" class="edit_btn ">Add New</a></div></div>
                           
                        </div>
                        <table id="example" class="display table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>mobile</th>
                                    <th>City</th>
                                    <th>address</th>

                                    <th>Licence No</th>

                                    <th> liecence validity</th>

                                    <th>Emergency Contact</th>
                                    <th>addedon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                        </table>
                   
                    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                </div>
           
       
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
            $('#example thead th:nth-child(2)').each(function () {
                var title = $('#example thead th:nth-child(2)').eq($(this).index()).text();
                $(this).html('<input type="text" style="width:80px;" placeholder="Mobile" />');
            });
          
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "driver_data.php",         
                "fnDrawCallback":function (){
                    ready();
                }
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