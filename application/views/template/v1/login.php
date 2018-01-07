<!DOCTYPE html>
<html lang="en" style="background-color:#516673">
<?php $includes = getcwd().'/public_assets/includes/';?>
<title>
    Login   
</title>
<head>
        <?php include($includes.'header.php'); ?>
        <?php echo(isset($loadCSS) ? $loadCSS : "");?>
</head>
<body>
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <div style="padding-top:80px"></div>
        <div class="container">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-success panel-sm">
                    <div class="panel-body">
                            <div class="text-center">
                            <img src="<?php echo site_url('assets/plugins/images/logo.png')?>" width="300px" alt="" class="logo">
                            </div>
                            <form action="<?php echo site_url('auth')?>" method="post">
                                <div class="form-group text-center">
                                        <?php $textMsg = $this->session->flashdata('alert_msg');?>
                                        <?php if (!empty($textMsg)) :?>
                                        <div class="notif">
                                        <?php echo $textMsg;?>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php endif;?>
                                </div>
                                <div class="form-group">
                                    <strong>Email or Username</strong>
                                    <input type="text" name="email" class="form-control form-control-line" placeholder="Username atau email" required>
                                </div>
                                <div class="form-group">
                                    <strong>Password</strong>
                                    <input type="password" name="password" class="form-control form-control-line" placeholder="Password" required>
                                </div>
                                <br>
                                <div align="center">
                                    <input type="submit" value="LOGIN" class="btn btn-success btn-block">
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php echo !empty($loadJS) ? $loadJS : '';?>
<?php include($includes.'js-general.php');?>

</html>
