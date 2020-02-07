<?php require_once('/config/constants.php');?>


<!DOCTYPE HTML>
<html>
	<head>
	<title>CLOCK-IT TIME TRACKER</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        
        <script type="text/javascript" src="<?php echo '/'.APP_ROOT.'/'; ?>public/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="<?php echo '/'.APP_ROOT.'/'; ?>public/js/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="<?php echo '/'.APP_ROOT.'/'; ?>public/js/kendo/kendo.all.min.js"></script>
        
	<link href="<?php echo '/'.APP_ROOT.'/'; ?>public/themes/uncomplicated/site.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo '/'.APP_ROOT.'/'; ?>public/themes/uncomplicated/layout.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo '/'.APP_ROOT.'/'; ?>public/themes/kendo/kendo.common.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo '/'.APP_ROOT.'/'; ?>public/themes/kendo/kendo.kendo.min.css" rel="stylesheet" type="text/css" />
        
        <script language="javascript" type="text/javascript">
		tinyMCE.init({
			mode : "textareas",
			theme : "advanced",
			plugins : "media",
			content_css : "<?php echo '/'.APP_ROOT.'/'; ?>public/stylesheets/application.css",
			theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,image,media",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
		});
        </script>
</head>
<body>
    <!-- start header -->
    <div id="header">
        <div class="row">
            <div id="logo" class="column grid_12">
                    <h1><a href="#">CLOCK-IT TIME TRACKER</a></h1>
                    <p><a href="#">By Rajesh Pillai</a></p>
            </div>
        </div>
    </div>
    <div id="menu">

        <div class="row">
            <ul class="column grid_12">
           

            </ul>
            
        </div>
    </div>
    <hr />
    <!-- end header -->
    <!-- start page -->
    <div id="wrapper" class="row">
            <div id="page" class="column grid_12">
                    <!-- start content -->
                    <div id="content">
                        <?php include(VIEW_PATH.$this->route['controller'].DS.$this->route['action'].'.php'); ?>
                    </div>
                    <!-- end content -->
                    <!-- start sidebar -->
                    <div id="sidebar">
                           
                    </div>
                    <!-- end sidebar -->
                    <br style="clear: both;" />
            </div>
    </div>
    <!-- end page -->
    <!-- start footer -->
    <div id="footer">
        <div  class="row">
            <p class="column grid_12">
            &copy;2011 Rajesh Pillai . All Rights Reserved.
            </p>
        </div>
    <!-- end footer -->
    </div>

    <?php if (DEBUG_ROUTE) {?>
    <div id="debug">
        <?php print_r($this->route)?>
    </div>
    <?php }?>
</body>

</html>
