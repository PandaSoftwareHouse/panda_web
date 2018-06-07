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
                        
                        <a href="<?php echo site_url('Productionentry_controller')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <font><?php echo $title; ?>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                        </font>
                    
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
          
        <div class="row">
          <div class="col-md-12">
            <div class="box-header">
              <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo $direction; ?>" >
              <div style="overflow-x:auto;">
                <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                <span style="color:white"></span><b>ADD</b></button>
              </div>
              </form>  
            </div>
            <br>
            <!-- /.box-header -->
            <div class="row">
            <div class="col-md-6">
            <div class="box-body">
              <div style="overflow-x:auto;">
              <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                <thead style="cursor:s-resize">
                <tr>
                  <th>Reference No.</th>
                  <th style="width:100px">Actions</th>
                </tr>
                </thead>
                <tbody>
                  
                  <?php foreach($production_batch->result() as $row)
                  { ?>

                  <tr>
                    <!-- <td><?php echo $row->POSTED; ?></td> -->
                    <td><?php echo $row->refno; ?></td>
                    <td>
                      <a href="<?php echo $edit_direction; ?>?guid=<?php echo $row->trans_guid; ?>&refno=<?php echo $row->refno; ?>&cross_refno=<?php echo $row->cross_refno; ?>" title="Edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                      
                        <?php if($title == 'ITEM')
                        { ?>

                          <a href="<?php echo site_url('Productionentry_controller/post_item'); ?>?guid=<?php echo $row->trans_guid; ?>">

                        <?php }
                        else
                        { ?>

                          <a href="<?php echo site_url('Productionentry_controller/post_template'); ?>?guid=<?php echo $row->trans_guid; ?>">

                        <?php } ?>
                         
                         <button type="button" title="Post" id="post" class="btn btn-xs btn-success" onclick="return confirm('Are you sure want to post this item?')" onSubmit="window.location.reload()"><span style="color:white;"></span>Post</button></a>

                          <!-- <?php if($title == 'ITEM')
                          {
                            echo '<i class="glyphicon glyphicon-pencil"></i></a>';
                          }
                          else
                          {
                            echo 'View <i class="fa fa-eye"></i></a>'; ?>
                            <a href="<?php echo site_url('Productionentry_controller/post_template'); ?>?guid=<?php echo $row->trans_guid; ?>"> <button type="button" title="Post" id="post" class="btn btn-xs btn-success" onclick="return confirm('Are you sure want to post this item?')" onSubmit="window.location.reload()"><span style="color:white;"></span>Post</button></a>

                          <?php } ?> -->
                      <!-- <button title="Delete" onclick="confirm_modal('<?php echo site_url('Point_c/delete'); ?>?guid=<?php echo $row->TRANS_GUID; ?>&condition=<?php echo $column; ?>&table=trans_main&column=TRANS_GUID')" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-name="<?php echo $row->REF_NO?>"><i class="glyphicon glyphicon-trash"></i></button><center> -->
                    </td>
                  </tr>
                  
                  <?php } ?>
                 
                </tbody>
                  
              </table>
              </div>
            </div>
            </div>
            </div>
          <!-- /.box -->