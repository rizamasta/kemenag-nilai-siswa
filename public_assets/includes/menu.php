<?php
$ctrl =  $this->uri->segment(1);
$action = $this->uri->segment(2);
$params = $this->uri->segment(3);
$secondparams = $this->uri->segment(4);
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li style="padding: 10px 0 0;">
                <a href="<?php echo site_url()?>" class="waves-effect <?php echo empty($ctrl)?'active':''?>">
                    <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('data/siswa')?>" class="waves-effect <?php echo $ctrl=='siswa'?'active':''?>">
                    <i class="fa fa-users fa-fw" aria-hidden="true"></i>
                    <span class="hide-menu">Data Siswa</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('user')?>" class="waves-effect <?php echo $ctrl=='user'?'active':''?>">
                    <i class="fa fa-user fa-fw" aria-hidden="true"></i>
                    <span class="hide-menu">Data Pengguna</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('data/nilai')?>" class="waves-effect <?php echo $ctrl=='nilai'?'active':''?>">
                    <i class="fa fa-bar-chart-o fa-fw" aria-hidden="true"></i>
                    <span class="hide-menu">Data Nilai</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('data/jadwal')?>" class="waves-effect <?php echo $ctrl=='jadwal'?'active':''?>">
                    <i class="fa fa-table fa-fw" aria-hidden="true"></i>
                    <span class="hide-menu">Data Jadwal</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('logout')?>" class="waves-effect">
                    <i class="fa fa-lock fa-fw" aria-hidden="true"></i>
                    <span class="hide-menu">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>