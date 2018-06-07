<html>
<body>
<div class="container">   
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>STOCK REQUEST</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('pandarequest_controller/view_transaction')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('pandarequest_controller/backhome')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>  
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>    
    <table width="200" class="cTable">
      <thead>
        <tr>
          <td class="cTD">Bin_ID</td>
          <td class="cTD">Doc Date</td>
          <td class="cTD" style="text-align:center;"><b>View</b></td>
        </tr>
      </thead>
        <?php
        if($view->num_rows() != 0)
        {
            foreach ($view->result() as $row)
            {
        ?>   
        <tbody>
              <tr>
                <td class="cTD"><?php echo $row->Bin_ID; ?></td>
                <td class="cTD"><?php echo $row->DocDate; ?></td>
                <td class="cTD">                 
                 <a href="<?php echo site_url('pandarequest_controller/view_item')?>?Bin_ID=<?php echo $row->Bin_ID?>&guidpost=<?php echo $row->Trans_ID; ?>" class="btn_info">VIEW</a>
                </td>
              </tr>
          </tbody>
          <?php
              }
          }
          else
              {
                  ?>
                  <tbody>
                      <tr>
                      <td colspan="3" style="text-align:center;">No Item Found</td>
                      </tr>
                  </tbody>
                  <?php       
                  }
          ?>
</table>
</div>
<p>&nbsp;</p>
</body>
</html>          