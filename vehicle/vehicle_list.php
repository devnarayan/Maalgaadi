<?php include '../includes/define.php'; 
verifyLogin();?>
<html>
        <head>
        <?php include '../includes/head.php'; ?>
        <style>
#footer {
	bottom:0 !important;
}
</style>
        </head>
        <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>
            <div class="crumbs">
              <ul id="breadcrumbs" class="breadcrumb">
                <li> <a href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a> </li>
                <li class="active"><a title="">Booking List</a></li>
              </ul>
            </div>
         
              <div class="content_middle mt15">
                <div class="pageHeader">
                  <div class="style_1">Vehicle List
                    <div class="floatR"><a href="vehicle.php" class="edit_btn ">Add New</a></div>
                  </div>
                </div>
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>name</th>
                      <th>category</th>
                      <th>city</th>
                      <th>registration_no</th>
                      <th>capacity</th>
                      <th>rate</th>
                      <th>email</th>
                      <th>mobile</th>
                      <th>addedon</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
             
              <div class="content_bottom">
                <div class="bot_left"></div>
                <div class="bot_center"></div>
                <div class="bot_rgt"></div>
              </div>
            </div>
            
            <!--dtat tabl-->
            <style>
            tfoot {
    display: table-header-group;
}
            </style>
            <script>
  $(document).ready(function () {
     $('#example').DataTable( {
         "serverSide": true,
         "ajax": "vehicle_data.php",
         "fnDrawCallback":function (){
                    ready();
    },
        initComplete: function () {
            var api = this.api();
 
            api.columns(1).indexes().flatten().each( function ( i ) {
                var column = api.column( i );
                 
                var select = $('<select style="width:100px;"><option value="">Category</option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? val : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
        </script>
            <?php include '../includes/footer.php'; ?>
</body>
</html>
