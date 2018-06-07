<?php
$browser_id = $_SERVER["HTTP_USER_AGENT"];
?>
<body style="background-color: #E2E2E2;">
    <div class="container">
        <div class="row text-center " style="padding-top:100px;">
            <div class="col-md-12">
                <!--<img src="assets/img/panda.png" class="img-thumbnail" alt="Cinque Terre" width="184" height="100" />-->
                <?php
                if(strpos($browser_id,"Windows CE"))
                {
                    echo "";
                }
                else
                {
                ?>
                    <img src="<?php echo base_url('assets/img/panda.png');?>" class="img-thumbnail" alt="Cinque Terre" width="100" height="60" />
                    <br />
                    <h4>PANDA WEB REQUEST</h4>
                <?php
                }
                ?>
                
            </div>
        </div>
        <div class="row ">
               
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                           
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo site_url('main_controller/login_form'); ?>">
                        <hr style="background-color:#00b359"/>            
                        <!--<br />-->
            
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input name="username" type="text" class="form-control" placeholder="Login ID"
                            style="background-color:#e6fff2" autofocus/>     
                        </div>
                        <span class="help-block"<?php echo form_error('username') ?></span>

                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                            <input name="userpass" type="password" class="form-control"  placeholder="Password" 
                            style="background-color:#e6fff2" />
                        </div>
                        <span class="help-block"<?php echo form_error('userpass') ?></span>
                        <div class="form-group">
                                            
                            <!--<span class="pull-right">
                            <a href="" >Forget password ? </a> 
                            </span>-->
                            <span class="pull-right">
                            <h6><small>&copy; Panda Software House Sdn. Bhd.</small></h6>
                            </span>
                        </div>
                                     
                        <button class="btn btn-primary" type="submit" name="login" value="Login" >Login</button>
                        <hr />
                        <!--<h5><small>&copy; Panda Software House Sdn. Bhd.</small></h5>-->
                    </form>       
                </div>
                           
            </div>
                
        </div>
    </div>


