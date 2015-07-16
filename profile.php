<?php include 'includes/define.php'; ?>
<html>
    <head>
        <?php include 'includes/head.php'; ?>
        <style>
            #footer{
                bottom:0 !important;  
            }
        </style>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include 'includes/header.php'; ?>
        <div class="container_content">
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li>
                        <a href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a>		                </li>
                    <li class="active"><a title="">Booking List</a></li>
                </ul>
            </div>
            <div class="container_content fl clr">
                <div class="cont_container mt15 mt10">
                    <div class="content_middle">     
                        
                    </div>
                    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                </div>
            </div>
        </div>
        
        <?php include 'includes/footer.php'; ?>
    </body>
</html> 