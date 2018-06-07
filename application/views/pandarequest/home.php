<style>
.logout-header{
    float:right;
}
</style>
<body>
    <div id="wrapper">
        
        <!-- /. NAV TOP  -->
        
        <!-- /. NAV SIDE  -->
        <!--<div id="page-wrapper">-->
            <div id="page-inner">                

                <!-- ROW  -->
                <!--<div class="row">-->

                    <!--REVIEWS &  SLIDESHOW  -->
                <ul class="nav" id="main-menu">
                    <li>
                        <div class="user-img-div">

                            <img src="<?php echo base_url('assets/img/panda.png')?>" class="img-rounded" />
                            
                            <div class="logout-header">
                            <a href="<?php echo site_url('logout_c/logout')?>"  title="Logout" >
                            <span class="glyphicon glyphicon-log-out" style="color:black;font-size:20px">
                            </span></a>
                            </div>
                            
                            <div class="inner-text">
                                <strong>Login as: </strong><?php echo $_SESSION["username"] ?>
                                <br />
                                
                                <small><span id="date_time"></span>
                                <script type="text/javascript">window.onload = date_time('date_time');</script>
                                </small>
                            </div>
                            
                        </div>
                    </li>

                    <li>
                        <!--<a href="<?php echo site_url('pandarequest_controller/viewdata')?>"><i class="fa fa-home"></i>Home</a>-->
                    </li>

                    <li class="menu">
                        <?php
                        foreach($menu->result() as $row)
                        {

                        ?>

                        <li><a href="<?php echo site_url($row->module_linkCI)?>" style="color:black"><i class="fa fa-dot-circle-o" style="color:#00b359"></i>
                        <b><?php echo $row->module_name; ?></b></a></li>
                        
                        <?php
                        }

                        ?>
                    </li>

                    <li>
                        <!--<a href="<?php echo site_url('logout_c/logout')?>"><i class="fa fa-sign-out "></i>Logout</a>-->    
                    </li>
                </ul>
                    <!-- /.REVIEWS &  SLIDESHOW  -->
                    
                    <!--4-->
                    
                <!--</div>-->
                <!-- /. ROW  -->

                <!--5-->
                
                <!--5-->

                <!--/.Row-->
                <hr />
            </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

    <!--<div id="footer-sec">
        &copy; Panda Software House Sdn. Bhd.
    </div>-->
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->