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

td {
  font-size:12px;
}

td.code {
  width: 200px;
}

input.input-sm.t_name {
  width: 240px;
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
  td.code {
    width: 100px;
  }
  input.input-sm.t_name {
  width: 120px;
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

function disable_readonly()
{
    $('input[type=text]').removeAttr('readonly');
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
                        
                        <a href="<?php echo site_url('Productionentry_controller')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <font>Template Setup
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
    
          <!-- <div class="box-header"> -->
            <form class="form-inline" role="form" method="POST" action="<?php echo site_url('Productionentry_controller/setup_create_template'); ?>">
            <!-- <div style="overflow-x:auto;"> -->
              <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
              <span style="color:white"></span><b>CREATE TEMPLATE</b></button>
            <!-- </div> -->
            <!-- <hr> -->
            </form>  
          <!-- </div> -->
          <!-- /.box-header -->
          <div class="row">
          <div class="col-md-6">
          <!-- <div class="box-body"> -->
            <div class="box-tools pull-right">
              <button class="btn btn-xs btn-success pull-right" onclick="$('#myForm').submit()"><i class="glyphicon glyphicon-floppy-saved"></i> Save</button>&nbsp;
            </div>
            <div class="box-tools pull-right">
              <button class="btn btn-xs btn-info pull-right" onclick="disable_readonly()"><i class="glyphicon glyphicon-pencil"></i> Edit Name</button>  
            </div>
            <br>
            <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('Productionentry_controller/setup_save'); ?>">
            <div style="overflow-x:auto;">
            <table id="" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Code</th>
                <th>Name</th>
                <th style="width:50px">Active</th>
                <th style="width:70px">Actions</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($set_template->result() as $row)
                { ?>

                  <tr>
                    <td class="code"><?php echo $row->code; ?></td>
                    <!-- <td><?php echo $row->name; ?></td> -->
                    <td>
                      <input type="text" name="template_name[]" id="template_name" class="form-control input-sm t_name" style="border-radius: 10px;" value="<?php echo $row->name; ?>" readonly />
                    </td>
                    <td>
                      <center>
                      <input type="hidden" name="isactive[]" 
                      <?php if($row->isactive == 0)
                      {
                      echo 'value="0"';
                      }
                      else
                      {
                        echo 'value="1"';
                      }
                      ?>
                      ><input type="checkbox"  

                      <?php if($row->isactive == '1')
                      {
                        echo "checked";
                      }
                      else
                      {
                        echo "";
                      } ?> onchange="this.previousSibling.value=1-this.previousSibling.value"/>
                      <input type="hidden" name="trans_guid[]" value="<?php echo $row->trans_guid; ?>" />
                      </center>
                    </td>
                    <td>
                      <center><a href="<?php echo site_url('Productionentry_controller/setup_back'); ?>?guid=<?php echo $row->trans_guid; ?>" title="Edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a> 
                      <!-- <a href="<?php echo site_url('Productionentry_controller/delete_item'); ?>?guid=<?php echo $row->trans_guid; ?>" > <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a> --><center>
                    </td>
                  </tr>

                <?php } ?>

              </tbody>
                
            </table>
            </div>
            </form>
        <!-- </div> -->
        </div>
        </div>
        <!-- /.box -->