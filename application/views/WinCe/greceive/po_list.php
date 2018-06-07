<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<a href="<?php echo site_url('greceive_controller/po_post_grn')?>" class="btn_default"><small>POST by GR ID</small></a>
<br><br>
<p><a href="<?php echo site_url('greceive_controller/scan_po'); ?>" class="btn_primary">+ ADD PO</a></p>
<h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
<table width="200" class="cTable">
<thead>  
  <tr>
    <td class="cTD">PO No</td>
    <td class="cTD">Supplier Name</td>
    <td class="cTD">Created By</td>
  </tr>
</thead>
    <?php
        foreach ($po_list->result() as $row)
          {  
    ?>

  <tr>
    <td class="cTD"><?php echo $row->po_no; ?><br><br>
    <a href="<?php echo site_url('greceive_controller/po_edit')?>?po_no=<?php echo $row->po_no;?>&sname=<?php echo $row->s_name;?>&grn_guid=<?php echo $row->grn_guid?>" class="btn_info">EDIT</a></td>
    <td class="cTD">
    <a href="<?php echo site_url('greceive_controller/po_batch')?>?grn_guid=<?php echo $row->grn_guid?>&po_no=<?php echo $row->po_no?>&sname=<?php echo $row->s_name;?>"><?php echo $row->s_name; ?></a>
    </td>
    <td class="cTD"><?php echo $row->created_by; ?><br><?php echo $row->created_at?></td>
  </tr>

    <?php
        }
    ?>
</table>
<p>&nbsp;</p>
</div>
</body>
</html>

