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
  font-size: 13px;
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
                        
                        <a href="<?php echo site_url('Productionentry_controller/setup')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <font>Create Template
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

      <div class="box box-default">
        <div class="box-header">
        <!-- <div class="box-header"> -->
        <!-- <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('Item_c/post'); ?>">
        <div style="float:right;">
          <button title="Post" id="post" type="button" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white" data-toggle="modal" data-name="" data-oriname="" ><span style="color:white"></span><b> Post</b></button>
        </div>
        </form> -->
        <!-- </div> -->
        <form method="post" action="<?php echo $direction; ?>">
        <div class="box-body">
          <div class="row">
            <!-- /.col -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Code <a style="color:red;">*</a></label>
                <input type="text" id="Code" name="Code" value="<?php echo $Code; ?>" class="form-control" placeholder="Code" 

                <?php if($Code != '')
                { 
                  echo "readonly";
                } ?> required <?php echo $autofocusCode; ?> />
              </div>
              <div class="form-group">
                <label>Name <a style="color:red;">*</a></label>
                <input type="text" id="Name" name="Name" value="<?php echo $Name; ?>" class="form-control" placeholder="Name" 

                <?php if($Code != '')
                { 
                  echo "readonly";
                } ?> required />
              </div>

              <?php if($Code != '')
              { ?>

                <div class="form-group">
                  <label>Barcode <a style="color:red;">*</a></label>
                  <input type="text" id="Barcode" name="Barcode" value="<?php echo $Barcode; ?>" class="form-control" placeholder="Insert Barcode" <?php echo $autofocusBarcode?> required 

                  <?php if($Barcode != '')
                  {
                      echo "readonly";
                  }; ?> />
                </div>
              <!-- /.col -->

              <?php };
              if($Barcode != '')
              { ?>

                <div class="form-group">
                  <label>Preset Quantity</label>
                  <input type="number" min="0" step="0.01" id="Quantity" name="Quantity" value="<?php echo $Quantity; ?>" class="form-control" placeholder="Quantity" required <?php echo $autofocusPresetqty?> />
                </div>
                </div>
                <!-- <br><br> -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Item Code</label>
                    <input type="text" id="ItemCode" name="ItemCode" value="<?php echo $ItemCode; ?>" class="form-control" placeholder="Item Code" readonly>
                  </div>
                  <!-- <div class="form-group">
                    <label>Unit Measurement</label> -->
                    <input type="hidden" class="form-control" id="UnitMeasurement" value="<?php echo $UnitMeasurement; ?>" name="UnitMeasurement" placeholder="Unit Measurement" readonly/>
                  <!-- </div> -->
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

            <?php if($create == '0')
            { ?>

              <input type="submit" value="Scan_barcode" name="submit" class="btn btn-success pull-left" style="display:none"/>

            <?php }
            elseif($create == '1')
            { ?>

              <input type="submit" value="Create" name="submit" class="btn btn-success pull-left" />

            <?php }
            elseif($create == '2')
            { ?>
              
              <input type="submit" value="Add" name="submit" class="btn btn-success pull-left" />

            <?php }
            elseif($create == '3')
            { ?>
              
              <input type="submit" value="Update" name="submit" class="btn btn-success pull-left" />

            <?php } ?>

          </div>
        </div>
      <!-- </div> -->
      </form>
      </div>
    </div>
    <br>


  <div class="box box-default">   
    <div class="box-body">
      <div style="overflow-x:auto;">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Actions</th>
          <th>Item Code</th>
          <th>Article No.</th>
          <th>Description</th>
          <!-- <th>Unit Measurement</th> -->
          <th>Quantity</th>
          <th>Created at</th>
          <th>Created by</th>
          <th>Updated at</th>
          <th>Updated by</th>
        </tr>
        </thead>
        <tbody>

          <?php foreach($set_template_c->result() as $row)
          { ?>

            <tr>
              <td>
                <center><a href="<?php echo site_url('Productionentry_controller/setup_edit_child'); ?>?guid=<?php echo $guid; ?>&main_guid=<?php echo $row->trans_guid_c; ?>" title="Edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="<?php echo site_url('Productionentry_controller/delete_setup'); ?>?guid=<?php echo $guid; ?>&main_guid=<?php echo $row->trans_guid_c; ?>" > <button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a><center>
              </td>

              <td><?php echo $row->itemcode; ?></td>
              <td><?php echo $row->Articleno; ?></td>
              <td><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></td>
              <!-- <td><?php echo $row->um; ?></td> -->
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
    <!-- /.box-body -->
  </div>
<!-- /.box -->
  

