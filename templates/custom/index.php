<?php

defined('_JEXEC') or die;
define('YOURBASEPATH', dirname(__FILE__));
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>"
      lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta name="application-name" content="OpenItStudio"/>
    <meta name="msapplication-TileColor" content="#01B8E4"/>
    <meta name="msapplication-square70x70logo" content="tiny.png"/>
    <meta name="msapplication-square150x150logo" content="square.png"/>
    <meta name="msapplication-wide310x150logo" content="wide.png"/>
    <meta name="msapplication-square310x310logo" content="large.png"/>
    <?php $this->_generator = 'OpenITStudio'; ?>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/normalize.css"
          type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/main.css"
          type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/user.css"
          type="text/css" media="screen"/>
    <link rel="stylesheet"
          href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/media-queries.css"
          type="text/css" media="screen"/>
    <link rel="stylesheet"
          href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/style.less.css"
          type="text/css"/>

    <?php //rmm section ?>
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/rmm.css"
          type="text/css"/>
    <script type="text/javascript"
            src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/javascript/rmm.js"/></script>
    <?php //end rmm ?>


    <script src = "<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/javascript/html5shiv.js"
    type = "text/javascript" ></script>
    <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/javascript/respond.min.js"
            type="text/javascript"></script>
    <![endif]-->

    <!--[if IE]>
    <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie.css" rel="stylesheet"
          type="text/css"/>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE9.js"></script>
    <![endif]-->
    <!--[if lt IE 8]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
    <![endif]-->
    <!--[if lt IE 7]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
    <![endif]-->

    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/javascript/jquery-1.8.3.min.js"/></script>
    <script type = "text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/javascript/core.js" / ></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script src="assets/bxslider/jquery.bxslider.min.js"></script>
    <!-- bxSlider CSS file -->
    <link href="assets/bxslider/jquery.bxslider.css" rel="stylesheet"/>

    <link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/custom.css" rel="stylesheet">

    <jdoc:include type="head"/>
</head>

<body>

<?php
$app = JFactory::getApplication();
$menu = $app->getMenu();
$isMain = $menu->getActive() == $menu->getDefault();
?>

<?php if ($isMain) : ?>
    <style>
        #header {
            background-color: rgba(255, 255, 255, 0.4);
            position: absolute;
        }
    </style>
<?php endif ?>
<body>

<script>
    $(document).ready(function () {
        $('.bxslider').bxSlider({
                mode: 'fade',
                auto: true
            }
        );
    });
</script>

<div id="header">
    <div class="container">
        <div class="col-lg-4 col-xs-12 col-sm-4">
            <img class="margin-top-5" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/logo.png">
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <jdoc:include type="modules" name="top-menu"/>
        </div>
        <div class="hidden-xs col-lg-2 col-sm-2 padding-0 margin-top-15">
            <div class="text-right col-sm-12 padding-0">
                <span class="fsize-11">тел.:</span>
                <span class="fcolor-red fsize-15">(495)</span>
                <span class="fcolor-blue fsize-24">955-01-91</span>
            </div>
            <div class="text-right col-sm-12 padding-0">
                <span class="fsize-11">email:</span>
                <span class="fcolor-blue fsize-9">veramir10@gmail.com</span>
            </div>
        </div>
    </div>
</div>

<jdoc:include type="modules" name="message"/>
<jdoc:include type="message"/>
<jdoc:include type="component"/>


<jdoc:include type="modules" name="debug"/>
</body>
</html>
