<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Update Attendance</b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table> 
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
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
                          <br>
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
<p>&nbsp;</p>
</body>
</html>