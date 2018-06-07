<html>
<head>
</head>

<body>
<div style="background-color: #ffffff;color: white" >
    <div class="container">

<table width="200" border="0">
  <tr align="right">
    <th width="120" scope="col">&nbsp;</th>
    <!-- <th width="20" scope="col"><a href="<?php echo site_url('logout_c/clearSession')?>"><img src="<?php echo base_url('assets/icons/refresh.jpg');?>"></a></th> -->
    <th width="20" scope="col">
    <a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a>
  </tr>
</table>
<br>
<table width="200" border="0">
  <tr>
    <td rowspan="2" align="center"><img src="<?php echo base_url('assets/img/panda.jpg');?>" class="img-rounded" width="65" height="75" /></td>
    
  </tr>
  <tr>
    <td><strong>Loc: </strong><?php echo $_SESSION["location"] ?>
      <br><strong>Login as: </strong><?php echo $_SESSION["username"] ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><h5 align="center"><strong>PANDA RETAIL SYSTEM </strong></h5></td>

  </tr>
</table>

      
    </div>        

</div>
<br>
<?php
                        $parent_name = $this->db->query("SELECT parent_name FROM backend_warehouse.`module_menu` where hide_menu = '0' GROUP BY parent_name ORDER BY parent_sequence ASC;");
                        
                        foreach($parent_name->result() as $row)
                        {
                            ?>
                        
                        <li class="menu">
                            <a href="#" style="color:black"><i class="fa fa-dot-circle-o" style="color:#00b359"></i>&nbsp;<b><?php echo $row->parent_name?></b></a>
                            <ul class="nav nav-second-level">
                            <?php
                            $i = 0;
                                $module_name = $this->db->query("SELECT a.module_name, a.module_link 
                                FROM backend_warehouse.`module_menu` AS a
                                INNER JOIN backend_warehouse.set_user_group_webmodule AS b 
                                ON a.`module_name`=b.module_name 
                                INNER JOIN backend_warehouse.set_user_group AS c 
                                ON b.user_group_guid=c.user_group_guid 
                                INNER JOIN backend_warehouse.set_user AS d 
                                ON d.user_group_guid=c.user_group_guid  
                                WHERE parent_name = '".$row->parent_name."' 
                                AND user_name='".$_SESSION['username']."'
                                AND hide_menu <> 1 ORDER BY sequence ASC   ");
                                foreach($module_name->result() as $row2)
                                {
                            ?>
                                <li>
                                    <a href="<?php echo site_url($row2->module_link)?>" style="color:black"><?php echo ++$i ?>.&nbsp;<?php echo $row2->module_name?></a>
                                </li>

                            <?php
                                }
                            ?>
                            </ul>
                        </li>
                    
                            <?php
                        }
                    ?>

</body>
</html>

<!-- <div>
                    <?php
                        foreach($menu->result() as $row)
                        {
                        ?>
                        <li><a href="<?php echo site_url($row->module_link)?>" style="color:black"><i class="fa fa-dot-circle-o" style="color:#00b359"></i>
                        <b><?php echo $row->module_name; ?></b></a></li>
                        <?php
                        }
                        ?>
</div>
 -->
