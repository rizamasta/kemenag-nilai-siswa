<!DOCTYPE html>
<html lang="en">
<?php $includes = getcwd().'/public_assets/includes/';?>
<head>
        <title>
            <?php echo !empty($title)?$title.' - '.$this->config->item('appName'):$this->config->item('appName');?>   
        </title>
        <?php include($includes.'header.php'); ?>
        <?php echo(isset($loadCSS) ? $loadCSS : "");?>
        <?php include($includes.'js-general.php');?>
</head>

<body>
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                <div class="top-left-part"><a class="logo" href="index.html"><b><img src="<?php echo site_url('assets/plugins/images/logo-kemenag.png')?>" alt="home" width="50px" /></b><span class="hidden-xs"><img src="<?php echo site_url('assets/plugins/images/pixeladmin-text.png')?>" alt="home" style="width: 150px"/></span></a></div>
                <ul class="nav navbar-top-links navbar-left m-l-20 hidden-xs">
                    <li>
                    <a class="profile-pic" href="jvascript:void(0)"><b class="hidden-xs"><?php echo $this->config->item('appName');?></b> </a>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic" href="#"><b class="hidden-xs"><?php echo !empty($full_name)?$full_name:''?></b> </a>
                    </li>
                </ul>
            </div>
        </nav>
        <?php include($includes.'menu.php');?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"></h4> 
                    </div>
                </div>
                <div class="row">
                    <?php   if (isset($body)) :?>
                    <?php   $moduleName = $this->router->fetch_module(); ?>
                    <?php   $controllerName = strtolower($this->router->fetch_class());?>
                    <?php   $view = $moduleName.'/'.$this->config->item('tbody').$controllerName.'/'.$body;?>
                    <?php   echo $this->load->view($view); ?>
                    <?php endif;?>
                </div>
            </div>
            <footer class="footer text-center"> 2017 &copy; <?php echo $this->config->item('appName');?> </footer>
        </div>
    </div>
    <?php echo !empty($loadJS) ? $loadJS : '';?>
    <script>
    </script>
</body>

</html>
