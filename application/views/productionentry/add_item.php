<script src="<?php echo base_url('js/jquery.min.js');?>"></script>

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

label {
  font-size:13px;
}

td {
  font-size:12px;
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
                        
                        <a href="<?php echo site_url('Productionentry_controller/item')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <font>Add Item
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>
        </div>

          <?php
          if($this->session->userdata('message'))
          {
             echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
          }
          ?>
    
          <?php if(isset($value) && $production_batch_c->num_rows() > 0 && $production_batch->num_rows() == '0')
          { ?>

            <!-- <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('Productionentry_controller/post_item'); ?>"> -->
            <!-- <div style="float:right;">
              <a href="<?php echo site_url('Productionentry_controller/post_item'); ?>?guid=<?php echo $guid; ?>&refno=<?php echo $ReferenceNo; ?>"> <button type="button" title="Post" id="post" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white;" onclick="return confirm('Are you sure want to post this item?')" onSubmit="window.location.reload()"><span style="color:white;"></span><b> Post</b></button></a> -->
              <!-- <button title="Post" id="post" type="button" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white" data-toggle="modal" data-name="" data-oriname="" ><span style="color:white"></span><b> Post</b></button> -->
            <!-- </div> -->
            <!-- </form> -->

          <?php }; ?>
        <!-- </div> -->
        <form method="post" action="<?php echo site_url('Productionentry_controller/add_item'); ?>?guid=<?php echo $guid; ?>&refno=<?php echo $ReferenceNo; ?>">
        <div class="box-body">
          <div class="row">
            <!-- /.col -->
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:12px;">Reference No.</label>
                <input type="text" id="ReferenceNo" name="ReferenceNo" value="<?php echo $ReferenceNo; ?>" class="form-control" placeholder="Reference No" readonly>
              </div>
              <div class="form-group">
                <label style="font-size:12px;">Location</label>
                <select id="location" name="location" class="form-control" required>
                  <option value=""></option>
                  <?php foreach($location->result() as $row) 
                      { 
                  ?>
                      <option value="<?php echo $row->code ?>" 
                          <?php if($main->row('location') ==  $row->code) 
                              { 
                                echo "selected"; 
                              }
                              else { 
                                echo '' ;
                              }; 
                          ?>  
                        ><?php echo $row->code; echo " - "; echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?>
                          
                      </option>

                 <?php 

                      } 

                  ?>
                </select>

               
              </div>
              <div class="form-group">
                <label>Barcode <a style="color:red;">*</a></label>
                <input type="text" id="Barcode" name="Barcode" value="<?php echo $Barcode; ?>" class="form-control" placeholder="Insert Barcode" <?php echo $autofocusBarcode?> required

                <?php if($Barcode != '' || $production_batch->num_rows() > 0)
                {
                  
                  echo "readonly";

                }; ?> />
              </div>

              <?php if($Barcode != '')
              { ?>

                <div class="form-group">
                  <label>Preset Quantity <a style="color:red;">*</a></label>
                  <input type="number" min="0" step="0.01" class="form-control" id="Quantity" value="<?php echo $Quantity; ?>" name="Quantity" placeholder="Quantity" required <?php echo $autofocusPresetqty?>/>
                </div>
            <!-- /.col -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Item Code</label>
                  <input type="text" id="ItemCode" name="ItemCode" value="<?php echo $ItemCode; ?>" class="form-control" placeholder="Item Code" readonly>
                </div>
                <div class="form-group">
                  <label>Unit Measurement</label>
                  <input type="text" class="form-control" id="UnitMeasurement" value="<?php echo $UnitMeasurement; ?>" name="UnitMeasurement" placeholder="Unit Measurement" readonly/>
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <input type="text" class="form-control" id="Description" value="<?php echo htmlentities(convert_to_chinese($Description, "UTF-8", "GB-18030")); ?>" name="Description" placeholder="Description" readonly/>
                </div>
                  <!-- /.form-group --> 

              <?php }; ?>

            </div>
            <!-- /.col -->
          </div>
        <!-- /.box-body -->
        <div class="row">
          <div class="col-md-12">
          <br>

            <?php if(isset($value))
            { ?>

              <input type="submit" value="Submit_code" name="submit" class="btn btn-success pull-left" style="display:none" />

            <?php }
            else
            { 
              if($add == '1')
              { ?>

                <input type="submit" value="Add" name="submit" class="btn btn-success pull-left" />

              <?php }
              elseif($add == '0')
              { ?>

                <input type="submit" value="Save" name="submit" class="btn btn-success pull-left" />

              <?php } ?> 
            <?php } ?>

          </div>
        </div>
      <!-- </div> -->
      </form>
      <br>
      <br>
          
          <div class="box-body">
          <div style="overflow-x:auto;">
          <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
            <thead style="cursor:s-resize">
            <tr>
              <?php if($production_batch->num_rows() == '0')
              { ?>

                <th>Actions</th>
                
              <?php }; ?>

              <th>Item Code</th>
              <th>Description</th>
              <!-- <th>Unit Measurement</th> -->
              <th>Batch</th>
              <th>Quantity</th>
              <th>Created at</th>
              <th>Created by</th>
              <th>Updated at</th>
              <th>Updated by</th>
            </tr>
            </thead>
            <tbody>

              <?php foreach($production_batch_c->result() as $row)
              { ?>

              <tr>

                <?php if($production_batch->num_rows() == '0')
                { ?>

                  <td>
                    <center><a href="<?php echo site_url('Productionentry_controller/edit_item'); ?>?main_guid=<?php echo $row->trans_guid_c; ?>&guid=<?php echo $guid; ?>&refno=<?php echo $ReferenceNo; ?>" title="Edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a> 
                    <a href="<?php echo site_url('Productionentry_controller/delete_item'); ?>?main_guid=<?php echo $row->trans_guid_c; ?>&guid=<?php echo $guid; ?>&refno=<?php echo $ReferenceNo; ?>" > <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a><center>
                  </td>

                <?php }; ?>

                <td><?php echo $row->itemcode; ?></td>
                <td><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></td>
                <!-- <td><?php echo $row->um; ?></td> -->
                <td><?php echo $row->batch; ?></td>
                <td><?php echo $row->preset_qty; ?></td>
                <td><?php echo $row->created_at; ?></td>
                <td><?php echo $row->created_by; ?></td>
                <td><?php echo $row->updated_at; ?></td>
                <td><?php echo $row->updated_by; ?></td>
              </tr>
              
              <?php } ?>
             
            </tbody>
              
          </table>
          </div>
          </div>
        



