<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>SI MOBILE PICK</b></h5>
        <small><b><?php echo $si_refno?></b></small></font> 
    </td>
    <td width="20"><a href="<?php echo site_url('sipick_controller/scan_item_error')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

 <form role="form" method="POST" id="myForm" action="<?php echo site_url('sipick_controller/item_entry_add')?>">

	<p><h5><b><?php echo $si_description?></b></h5>
    </p>
    <p><h5><b><?php echo $iteminfo?></b></h5></p>
    <table width="200">
            <tr>
                <td>Req Qty</td>
                <td>Actual Qty</td>
            </tr>
            <tr>
              <td><input disabled type="number" value="<?php echo $si_qty?>" style="background-color: #e6fff2" class="form-control input-sm"></td>
              <td><input  type="number" value="<?php echo $si_qty_mobile ?>"
              style="text-align:center;width:80px;background-color:#ffff99" name="qty_mobile" class="form-control input-sm"></td>
            </tr>
    </table>
      <br>
       <input type="submit" name="submit" class="btn_success" value="SAVE">
       
 </form>
	</div>
  <p>&nbsp;</p>
</body>
</html>
