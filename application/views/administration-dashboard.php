<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $_SESSION['current_view']; ?></title>
        <link rel="Shortcut Icon" href="http://www.cecs.csulb.edu/~dphu/cecs491/assets/images/favicon.ico" /> 
        <meta name="author" content="Tuan Bui, Eriton Sena Lima, Davison Voeur, Julian Pagtama, Daniel Chi Phu" />
        <meta name="keywords" content="later" />
        <meta name="description" content="later."/>
        <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" title="Main Layout" type="text/css" media="all" />
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.8.3.js" ></script>-->
    </head>

    <body>
        <h3>Hey, this is the admin area.  If you're not an admin, get your arse out of here!</h3>

        <div id="loginarea">
            <form id="logout-form" method="post" action="<?php echo base_url(); ?>main/adminLogout">
                <ul>
                    <li><input type="submit" name="submit" id="submit" value="Logout" /></li>
                </ul>
            </form>
        </div>
    </body>
</html>