<html>
<body>
<div class="container">
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/sendprint'); ?>">
  <?php
    foreach ($item->result() as $row)
    {
  ?>
    <input style="display:none;" type="hidden" name="guid" value="<?php echo $row->Trans_ID?>">
    <input type="hidden" name="Itemcode[]" value="<?php echo $row->Itemcode?>">
  <?php
    }
  ?>
   <table width="200" border="0">
    <tr>
        <td width="120"><h5><b>STOCK REQUEST</b><br>
        </h5></td>
        <td width="5"><input type="image" src="<?php echo base_url('assets/icons/print.jpg');?>" alt="Submit" /></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a id="dontprint" href="<?php echo site_url('pandarequest_controller/scan_binID_view')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a id="dontprint" href="<?php echo site_url('pandarequest_controller/backhome')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
    </tr>
   </table>
   <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
</form>      
  
  <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/scanbarcode'); ?>">
    <label>Item Barcode</label><br>
    <input type="text" placeholder="Item Barcode" class="form-control input-md" name="barcode" style="background-color:#E6fff2" required />
                            
  </form>
    <?php
      $bin_ID = $this->session->userdata('bin_ID');
    ?>
    <p><b>Bin_ID :</b><?php echo $bin_ID?></p>
   
     <table width="200" class="cTable">
      <thead>
          <tr>
              <td class="cTD"><b>Item Code</b></td>
              <td class="cTD"><b>Item Link</b></td>
              <td class="cTD"><b>Description</b></td>                                    
              <td class="cTD" style="text-align:center;"><b>Qty On<br> Hand</b></td>
              <td class="cTD" style="text-align:center;"><b>Qty<br> Request</b></td>
              <td class="cTD" style="text-align:center;"><b>Carton<br> Qty</b></td>
              <td class="cTD" style="text-align:center;"><b>Qty<br> Balance</b></td>
          </tr>
      </thead>
      <?php
      if($item->num_rows() != 0)
      {
          foreach ($item->result() as $row)
          {
      ?>   
  <tbody>
      <tr>
        <td class="cTD"><?php echo $row->Itemcode; ?></td>
        <td class="cTD"><?php echo $row->Itemlink; ?></td>
        <td class="cTD"><?php echo $row->Description; ?></td>
        <td class="cTD" style="text-align:center;"><?php echo $row->Qoh; ?></td>
        <td class="cTD" style="text-align:center;"><?php echo $row->qty_request; ?></td>
        <td class="cTD" style="text-align:center;">
        <?php echo round($row->qty_request / $row->BulkQty, 2) ?> ctn @ 
        <?php echo round($row->qty_request / $row->BulkQty, 0) ?> ctn
        <?php echo round(fmod($row->qty_request, $row->BulkQty), 0) ?> unit</td>
        <?php
        if($row->qty_balance == '0')
        {
          ?>
          <td class="cTD" style="text-align:center;">NO QTY</br> BALANCE</td>
          <?php
        }
        else
        {
          ?>
          <td class="cTD" style="text-align:center;"><?php echo $row->qty_balance; ?></td>
              </tr>
            </tbody>
            <?php
            }
          }
      }
      else
           {
              ?>
              <tbody>
                  <tr>
                  <td class="cTD" colspan="7" style="text-align:center;">No Item Scaned</td>
                  </tr>
              </tbody>
              <?php       
              }
      ?>
      </table>
                              </div>
                              </body>
                              </html>