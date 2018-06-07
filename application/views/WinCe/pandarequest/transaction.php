<html>
<body>
<div class="container">
        
<table width="200" border="0">
    <tr>
        <td width="120"><h5><b>STOCK REQUEST</b><br>
        </h5></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('main_controller/homemenu')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
    </tr>
</table>  
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>       
    <p><a href="<?php echo site_url('pandarequest_controller/add_transID'); ?>" class="btn_primary">+ ADD TRANS</a></p>
    <input type="hidden" name="username" value="<?php echo $_SESSION['username']?>" style="text-align:center;" max="100000"/>            
               
    <table width="200" class="cTable">
        <thead>
            <tr>      
                <td class="cTD">Trans Date</td>
                <td class="cTD">Created By</td>
                <td class="cTD">DocDate</td>
                <td class="cTD" style="text-align:center;"><b>Print</b></td>
            </tr>
        </thead>
    <?php
                                    
        if($transactions->num_rows() != 0)
        {
            foreach ($transactions->result() as $row)
            {  
    ?>        
    <tbody>
        <tr>
            <td class="cTD"><?php echo $row->Trans_Date; ?></td>
            <td class="cTD"><?php echo $row->Created_By; ?></td>
            <td class="cTD"><?php echo $row->DocDate; ?></td>
            <td class="cTD" style="text-align:center;">
            <a href="<?php echo site_url('pandarequest_controller/view_bin')?>?guidpost=<?php echo $row->Trans_ID?>" class="btn_info">VIEW</a>
            </td>            
            <input type="hidden" name="guidpost" value="<?php echo $row->Trans_ID; ?>"/>
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
                    <td class="cTD" colspan="4" style="text-align:center;">No Pending Transaction</td>
                    </tr>
                </tbody>
        <?php
            }
        ?>
    </table>
</div>
</body>
</html>