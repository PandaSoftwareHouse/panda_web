<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5><small><b><?php echo $method?></b></small></td>
    <td width="20"><a href="<?php echo $back ?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo $form_action ?>">

<h5><b>PO No: </b><?php echo $po_no?></h5>
<h5><b>Supplier Name: </b><?php echo $sname?></h5>
<h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
<label><b>D/O No :</b></label><br>
<input autofocus onfocus="this.select()" onkeyup="autopopulate()" type="text" name="do_no" style="background-color:#ffff99" maxlength="20" class="form-control"
  
  value="<?php echo $do_no  ?>"
          />
 <br>                                                   
<label><b>Invoice No: (= D/O No. if Blank)</b></label><br>
<input type="text" onfocus="this.select()" name="inv_no" style="background-color:#80ff80" maxlength="20" class="form-control"
  
  value="<?php echo $inv_no  ?>"
  />
  <br>
 <?php if($grn_by_weight_hide_inv_detail == '0') { ?>
<label>Invoice Date: </label>
  <input type="date" name="inv_date" style="width:170px;background-color:#80ff80" class="form-control" required
  <?php
    if($po_details->num_rows() > 0)
    {
      foreach($po_details->result() as $row)
      {
          ?>
          <?php  if($row->inv_date == '') { ?>
           value="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>"
           <?php } else { ?>
           value="<?php echo $row->inv_date?>"
           <?php } ?>
        <?php
      }
    }
    else
    {
    ?>
      value="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>"
    <?php 
    } 
  ?>
  max="<?php echo $max_invoice_date; ?>"/>
<br>

<label>Receiving Date: </label>
  <input type="date" name="received_date" style="width:170px; background-color:#C0C0C0" class="form-control"
    <?php
    if($po_details->num_rows() > 0)
    {
      foreach($po_details->result() as $row)
      {
          ?>
          <?php  if($row->received_date == '') { ?>
           value="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>"
           <?php } else { ?>
           value="<?php echo $row->received_date; ?>"
           <?php } ?>
        <?php
      }
    }
    else
    {
    ?>
      value="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>"
    <?php 
    } 
  ?>
  min="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>" max="<?php echo $max_received_date ?>"/>
<br>

<label><b>Amount exc tax :</b></label><br>
<input autofocus onfocus="this.select()" type="number" step="any" name="amt_exc_tax" style="background-color:#ffff99" class="form-control"
  value="<?php echo $amt_exc_tax  ?>"
          />
 <br>
 <label><b>Gst amount :</b></label><br>
<input autofocus onfocus="this.select()" type="number" step="any" name="gst_tax" style="background-color:#ffff99" class="form-control"
  value="<?php echo $gst_tax  ?>"
          />
 <br>

  <br>
 <label><b>Rounding Adj Amount:</b></label><br>
<input autofocus onfocus="this.select()" type="number" step="any" name="rounding_adj" style="background-color:#ffff99" class="form-control"
  value="<?php echo $rounding_adj  ?>"
          />
 <br>

 <label><b>Amount inc tax :</b></label><br>
<input autofocus onfocus="this.select()" type="number" step="any" name="amt_inc_tax" style="background-color:#ffff99" class="form-control"
  value="<?php echo $amt_inc_tax  ?>"
          />
 <br>
<br><br>
<?php } ?>
<input type="submit" name="button" id="button" class="btn_success" value="SAVE" onclick="$('#myForm').submit()">
 
</form>
<p>&nbsp;</p>
</div>
</body>
</html>


<script>
function autopopulate() {
    var x = document.getElementById("do_no").value;
    document.getElementById("inv_no").value =  x;
}
</script>