<script type="text/javascript">
function autofocus() {
    var el = document.getElementById("autofocus");
    if (el === null) {
        return;
    } else if (el.tagName.toUpperCase() == "SELECT") {
        if (el.selectedIndex == -1) {
            el.options[0].selected = true;
        }
    }
    el.focus();
}

</script>
<body style="background-color: #E2E2E2;" onload="autofocus()">
    <div class="container">
        <div class="row ">
            
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo site_url('main_controller/login_form2'); ?>">
                        <h4>PANDA WEB REQUEST</h4>

                        
                        <div>
                            <label style="font-size:12px">Login ID:</label>
                            <input name="username" type="text" autofocus="autofocus" id="autofocus"/>     
                        </div>

                        <div>
                            <label style="font-size:12px">Password:</label>
                            <input name="userpass" type="password" />
                        </div>
                        </br>   
                        <button type="submit" name="login" value="Login" >Login</button>
                        
                        <!--<h5><small>&copy; Panda Software House Sdn. Bhd.</small></h5>-->
                    </form>       
                </div>
        </div>
    </div>


