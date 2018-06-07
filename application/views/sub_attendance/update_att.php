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
  h6,td.big {
    font-size: 10px;
  }
  td.big {
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

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

function check()
{
    var answer=confirm("Confirm want to delete item ?");
    return answer;
}

</script>
<!--onload Init-->
<body>
    <div id="wrapper">
        
        <div id="page-inner">
        <div class="fixed">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('sub_attendance_controller/main')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <font>Update Attendance
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>
        </div>

                <!-- ROW  -->
            <div class="row" >
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            
                        <?php foreach ($refno->result() as $row) { ?> 

                        <form method="POST" action="<?php echo site_url('sub_attendance_controller/update_into')?>?trans=<?php echo $row->web_guid; ?>">

                          <?php if ($row->Code == 'Others') 
                          { ?>
                              <h4>Supplier:<br></h4>
                              <input type="text" class="form-control" name="supplier" value="<?php echo $row->Suppliers?>" required/>
                          <?php }
                          else
                          { ?>
                              <h4>Supplier:<br></h4>
                              <input type="text" class="form-control" name="supplier" value="<?php echo $row->Suppliers?>"  readonly/>
                          <?php } ?>
                        </div>
                        <div class="col-md-6">
                          <h4>Reference No.:<br></h4>
                          <input type="text" class="form-control" name="refno" value="<?php echo $row->RefNo?>" placeholder="Ref No.">
                          <span class="help-block"><?php echo form_error('refno'); ?>
                          </span>
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-md-6">
                          <br>
                          <h4>Total Amount Include GST:<br></h4>
                          <input type="number" class="form-control" name="Amount" value="<?php echo $row->Amount?>" placeholder="Amount(RM)" min="0" step="0.01">
                          <span class="help-block"><?php echo form_error('Amount'); ?>
                          </span>
                        </div>
                        <div class="col-md-6">
                          <br>
                          <h4>Total GST:<br></h4>
                          <input type="number" class="form-control" name="gst" value="<?php echo $row->GST?>" placeholder="GST(RM)" min="0" step="0.01">
                          <span class="help-block"><?php echo form_error('gst'); ?>
                          </span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <br>
                          <h4>Remark:<br></h4>
                          <textarea name="remark" class="form-control" rows="4" cols="50" placeholder="Add remark" pattern="any"><?php echo $row->Remark?></textarea>
                          <input type="hidden" name="date" value="<?php echo $row->date?>" /> <!-- add -->
                        </div>
                      </div>
                          <br><br>
                          <input type="submit" value="Submit" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                        </form> 
                        <?php } ?>
   
        </div>
    </div>
   </div>
</body>