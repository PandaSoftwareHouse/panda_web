<?php 
'session_start()' 
?>
<style>

#poDetails, #promoDetails {
  display: none;
}


b .font {
    font-size: 90px;
}

@media screen and (max-width: 768px) {
  
  p,input,div,span,h4 {
    font-size: 90%;
  }
  h1 {
    font-size: 20px;  
  }
  h4 {
    font-size: 18px;  
  }
  h3 {
    font-size: 20px;  
  }
  input {
    font-size: 16px;
  }
  p {
    font-size: 12px;
  }
  font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
}

</style>

<script type="text/javascript">


</script>
<!--onload Init-->
<body>
    <div id="wrapper">
        
        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>

                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url("Adjout_controller/main?type=".$_SESSION['aotype'])?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>adjust out <?php if($_SESSION['aotype'] == 'DP') { echo '- Disposal';}; if($_SESSION['aotype'] == 'OU') { echo '- Own Use';}; ?>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                        </font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('adjout_controller/add_process'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">

                            <h5><b>Reason</b></h5>
                                <select name="reason" class="form-control" required style="width: 220px;background-color:#ccf5ff"  >
                                <?php
                                foreach($reason->result() as $row)
                                {
                                    ?>
                                <option><?php echo $row->code_desc;?></option>
                                    <?php
                                }
                                ?>
                                
                                </select>
                                <br>
                                
                            <!-- <input type="textarea" class="form-control" placeholder="Remarks" name="remarks" id="textarea" required autofocus onblur="this.focus()"/> -->
                            </span>

                            <h5><b>Remarks</b></h5>
                                    <textarea rows="2" name="remarks" id="textarea" cols="24" ></textarea>
                                    <br>
                            <button value="save" name="save" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button>
                        </div>
                    </form><br>
                </div>
            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>