<html>
<body>
<div class="container">
    <table width="200" border="0">
      <tr>
        <td width="120"><h4><b>Attendance</b></h4></td>
        <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
    <form method="post" action="<?php echo site_url('Sub_attendance_controller/display_date')?>" > <!-- add -->
        <input type="submit" value='Search' class='btn btn-xs btn-primary' style="float:right;font-size: 12px;background-color:#4380B8;color:white">
        <span class="glyphicon glyphicon-plus-sign" style="color:white"></span></button>
        <input type='text' name='date' style="float:right;border-radius: 8px" required/><span class="help-block"><?php echo form_error('date'); ?></span>
    </form>
    <br>
    <a href="<?php echo site_url('sub_attendance_controller/add_record');?>" class="btn_primary">+ ADD RECORD</a><br><br><h4 style = "color:black"><?php echo $this->session->flashdata('message')?></h4><b>Total Records:</b><?php echo $supp_array->num_rows();?>
 <table width="220" class="cTable">
        <thead>
            <tr align="center">
                <th class="cTD"><p>Created Date</p></th>
                <th class="cTD"><p>Created Time</p></th>
                <th class="cTD"><p>Suppliers</p></th>
                <th class="cTD"><p>Reference No.</p></th>
                <!-- <th class="cTD"><p>Amount</p></th> -->
                <th class="cTD"><p>Total Incl GST (RM)</p></th>
                <th class="cTD"><p>GST (RM)</p></th>
                <th class="cTD"><p>Remark</p></th>
                <th class="cTD"><p>Updated Date</p></th>
            </tr>
        </thead>
        <tbody>
          <?php
                 foreach ($supp_array->result() as $row)
                    {
          ?>
                    <tr align="center" class="border">
                        <td class="cTD" style="text-align:center;"><?php echo $row->date; ?></td>
                        <td class="cTD" style="text-align:center;"><?php echo $row->time; ?></td>
                        <td><a href = "<?php echo site_url('sub_attendance_controller/update'); ?>?trans=<?php echo $row->web_guid?>"><?php echo $row->Suppliers; ?></a></td>
                        <td class="cTD" style="text-align:center;"><?php echo $row->RefNo; ?></td>
                        <!-- <td class="cTD" style="text-align:center;"><?php echo $row->Amount; ?></td> -->
                        <td class="cTD" style="text-align: right"><?php echo number_format($row->Amount,2); ?></td>
                        <td class="cTD" style="text-align: right"><?php echo number_format($row->GST,2)?></td>
                        <td class="cTD" style="text-align:center;"><?php echo $row->Remark; ?></td>
                        <td class="cTD" style="text-align:center;"><?php echo $row->Updated_at; ?></td>
                        <!-- <td><a href = '<?php echo site_url('sub_attendance_controller/update'); ?>?trans=<?php echo $row->web_guid?>' class = "btn btn-warning" >Update</a></td> -->
                    </tr>
          <?php
                    }
          ?> 

        </tbody>
    </table>
    
</div>
</body>
</html>