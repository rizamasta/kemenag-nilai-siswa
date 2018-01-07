<!DOCTYPE html>
<html lang="en">
<?php $includes = getcwd().'/public_assets/includes/';?>
<head>
        <title>
            <?php echo $title;?>
        </title>
        <?php include($includes.'header.php'); ?>
        <?php echo(isset($loadCSS) ? $loadCSS : "");?>
        <?php include($includes.'js-general.php');?>
        <?php echo !empty($loadJS) ? $loadJS : '';?>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>404</h1>
                <h3 class="text-uppercase">Page Not Found !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                <a href="<?php echo site_url()?>" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
            <footer class="footer text-center">2017 © <?php echo $this->config->item('appName')?></footer>
        </div>
    </section>
    <script>
    $(function() {
        $(".preloader").fadeOut();
    });
    </script>
</body>

</html>
