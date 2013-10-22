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

        <div id="loginarea">
            <form id="login-form" method="post" action="<?php echo base_url(); ?>main/admin-login-validation">
                <ul>
                    <li><input type="text" name="admin-name" id="admin-name" placeholder="Admin Name" required="required" /></li>
                    <li><input type="password" name="admin-password" id="admin-password" placeholder="Password" required="required" /></li>
                    <li><input type="submit" name="submit" id="submit" value="Login" /></li>
                </ul>
            </form>
        </div>
    </body>
</html>