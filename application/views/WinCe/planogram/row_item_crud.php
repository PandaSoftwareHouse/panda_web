<html>
<body>
<div class="container">
  <table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>PLANOGRAM</b></h5></td>
    <td width="20"><a href="<?php echo site_url('planogram_controller/row_item_scan')?>?row_guid=<?php echo $_SESSION['row_guid']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a>
    </td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
    <form role="form" method="POST" id="myForm" action="<?php echo site_url('planogram_controller/rack_row_item_crud_save'); ?>">
       
       <table width="200" border="0">
         <tr>
           <td><b>Bin ID:</b> <?php echo $_SESSION['bin_ID']?>&nbsp&nbsp<b><?php echo $_SESSION['row_no']?></b></td>
           <td><center>

             <?php
                if($deletebutton == '1')
                {
              ?>
                <a href="<?php echo site_url('planogram_controller/rack_row_item_delete')?>" onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a>  
              <?php
                }
               ?>
           </center></td>
         </tr>
       </table>

       <table width="200" border="0">
         <tr>
           <td><?php echo $itemcode?></td>
           <td><?php echo $barcode?></td>
         </tr>
         <tr>
           <td colspan="2"><h5><b><?php echo $description?></b></h5></td>
         </tr>
       </table>

         <table width="200" border="0">
           <tr>
             <td>Qty</td>
             <td>Max Stackable</td>
           </tr>
           <tr>
              <td>
               <input type="number" class="form-control" size="10" value="<?php echo $Qty ?>" style="text-align:center;width:80px;background-color:#66FFCC" name="Qty" />
              </td>
             
              <td>
               <input type="number" class="form-control" size="10" value="<?php echo $MaxStackable?>" style="text-align:center;width:80px;background-color:#66FFCC" name="MaxStackable" />
              </td>
           </tr>
           <tr>
             <td>Width</td>
             <td>Depth</td>
           </tr>
           <tr>
             <td>
               <input type="number" class="form-control" size="10" value="<?php echo $Width ?>" style="text-align:center;width:80px;background-color:#66FFCC" name="Width" />
             </td>
             <td>
                <input type="number"  class="form-control" size="10" value="<?php echo $Depth?>" style="text-align:center;width:80px;background-color:#66FFCC" name="Depth" />
             </td>
           </tr>
           <tr>
             <td>Height</td>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td>
             <input type="number" class="form-control" size="10" value="<?php echo $Height ?>" style="text-align:center;width:80px;background-color:#66FFCC" name="Height" siz />
             </td>
             <td>
             <input type="submit" name="submit" value="SAVE" class="btn_success">
             </td>
           </tr>
         </table>
         <input type="hidden" name="row_guid" value="<?php ?>">
  </form>
</div>
</body>
</html>