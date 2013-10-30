<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo empty($product['pagetitle']) ? ucwords(urldecode($_SESSION['current_view'])) : $product['pagetitle']; ?></title>
        <link rel="Shortcut Icon" href="http://www.cecs.csulb.edu/~dphu/cecs491/assets/images/favicon.ico" /> 
        <meta name="author" content="Tuan Bui, Eriton Sena Lima, Davison Voeur, Julian Pagtama, Daniel Chi Phu" />
        <meta name="keywords" content="<?php echo empty($product['metakeyword']) ? 'later' : $product['metakeyword']; ?>" />
        <meta name="description" content="<?php echo empty($product['metadescription']) ? 'later' : $product['metadescription']; ?>"/>
        <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" title="Main Layout" type="text/css" media="all" />
        <link href="<?php echo base_url(); ?>assets/css/flexslider.css" rel="stylesheet" title="Main Layout" type="text/css" media="all" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.flexslider.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.flexslider-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.zoom-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.zoom.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/google.js">
        </script>

    </head>

    <body>
        <div class="wrapper container">
            <header>    
                <div class="logo four columns">
                    <h1>
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/images/eworldbanner.jpg" alt="e-World Computers' Banner" title="Goto e-World Computers' Home Page" />
                        </a>
                    </h1>
                </div>