<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panda Retail System</title>
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/panda.png');?>" >	
    <script type="text/javascript" src="<?php echo base_url('date_time.js');?>"></script>
    <link href="<?php echo base_url('http://fonts.googleapis.com/css?family=Open+Sans');?>" rel='stylesheet' type='text/css' />
    <link href="<?php echo base_url('assets/css/bootstrap.css');?>" rel="stylesheet" />

<script type="text/javascript">
function check()
{
    var answer=confirm("Are You Sure Want To Delete?");
    return answer;
}
window.onload=function(){
        document.getElementById('autofocus').focus();
    }

$(document).ready( function() {
  $('#id').click( function( event_details ) {
    $(this).select();
  });
});
/*var _debug = false;
var _placeholderSupport = function() {
    var t = document.createElement("input");
    t.type = "text";
    return (typeof t.placeholder !== "undefined");
}();

window.onload = function() {
    var arrInputs = document.getElementsByTagName("input");
    var arrTextareas = document.getElementsByTagName("textarea");
    var combinedArray = [];
    for (var i = 0; i < arrInputs.length; i++)
        combinedArray.push(arrInputs[i]);
    for (var i = 0; i < arrTextareas.length; i++)
        combinedArray.push(arrTextareas[i]);
    for (var i = 0; i < combinedArray.length; i++) {
        var curInput = combinedArray[i];
        if (!curInput.type || curInput.type == "" || curInput.type == "text" || curInput.type == "textarea")
            HandlePlaceholder(curInput);
        else if (curInput.type == "password")
            ReplaceWithText(curInput);
    }

    if (!_placeholderSupport) {
        for (var i = 0; i < document.forms.length; i++) {
            var oForm = document.forms[i];
            if (oForm.attachEvent) {
                oForm.attachEvent("onsubmit", function() {
                    PlaceholderFormSubmit(oForm);
                });
            }
            else if (oForm.addEventListener)
                oForm.addEventListener("submit", function() {
                    PlaceholderFormSubmit(oForm);
                }, false);
        }
    }
};

function PlaceholderFormSubmit(oForm) {    
    for (var i = 0; i < oForm.elements.length; i++) {
        var curElement = oForm.elements[i];
        HandlePlaceholderItemSubmit(curElement);
    }
}

function HandlePlaceholderItemSubmit(element) {
    if (element.name) {
        var curPlaceholder = element.getAttribute("placeholder");
        if (curPlaceholder && curPlaceholder.length > 0 && element.value === curPlaceholder) {
            element.value = "";
            window.setTimeout(function() {
                element.value = curPlaceholder;
            }, 100);
        }
    }
}

function ReplaceWithText(oPasswordTextbox) {
    if (_placeholderSupport)
        return;
    var oTextbox = document.createElement("input");
    oTextbox.type = "text";
    oTextbox.id = oPasswordTextbox.id;
    oTextbox.name = oPasswordTextbox.name;
    //oTextbox.style = oPasswordTextbox.style;
    oTextbox.className = oPasswordTextbox.className;
    for (var i = 0; i < oPasswordTextbox.attributes.length; i++) {
        var curName = oPasswordTextbox.attributes.item(i).nodeName;
        var curValue = oPasswordTextbox.attributes.item(i).nodeValue;
        if (curName !== "type" && curName !== "name") {
            oTextbox.setAttribute(curName, curValue);
        }
    }
    oTextbox.originalTextbox = oPasswordTextbox;
    oPasswordTextbox.parentNode.replaceChild(oTextbox, oPasswordTextbox);
    HandlePlaceholder(oTextbox);
    if (!_placeholderSupport) {
        oPasswordTextbox.onblur = function() {
            if (this.dummyTextbox && this.value.length === 0) {
                this.parentNode.replaceChild(this.dummyTextbox, this);
            }
        };
    }
}

function HandlePlaceholder(oTextbox) {
    if (!_placeholderSupport) {
        //alert(oTextbox.tagName);
        var curPlaceholder = oTextbox.getAttribute("placeholder");
        if (curPlaceholder && curPlaceholder.length > 0) {
            Debug("Placeholder found for input box '" + oTextbox.name + "': " + curPlaceholder);
            oTextbox.value = curPlaceholder;
            oTextbox.setAttribute("old_color", oTextbox.style.color);
            oTextbox.style.color = "#c0c0c0";
            oTextbox.onfocus = function() {
                var _this = this;
                if (this.originalTextbox) {
                    _this = this.originalTextbox;
                    _this.dummyTextbox = this;
                    this.parentNode.replaceChild(this.originalTextbox, this);
                    _this.focus();
                }
                Debug("input box '" + _this.name + "' focus");
                _this.style.color = _this.getAttribute("old_color");
                if (_this.value === curPlaceholder)
                    _this.value = "";
            };
            oTextbox.onblur = function() {
                var _this = this;
                Debug("input box '" + _this.name + "' blur");
                if (_this.value === "") {
                    _this.style.color = "#c0c0c0";
                    _this.value = curPlaceholder;
                }
            };
        }
        else {
            Debug("input box '" + oTextbox.name + "' does not have placeholder attribute");
        }
    }
    else {
        Debug("browser has native support for placeholder");
    }
}

function Debug(msg) {
    if (typeof _debug !== "undefined" && _debug) {
        var oConsole = document.getElementById("Console");
        if (!oConsole) {
            oConsole = document.createElement("div");
            oConsole.id = "Console";
            document.body.appendChild(oConsole);
        }
        oConsole.innerHTML += msg + "<br />";
    }
}*/

</script>
<style type="text/css">
th,td,h6 {
    font-size: 12px;
  }
thead {
  font-weight: bold;
}
.btn {
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0px;
  font-family: Arial;
  color: #000000;
  font-size: 12px;
  background: #4DFFA6;
  padding: 0px 3px 3px 3px;
  border: solid #4DFFA6 2px;
  text-decoration: none;
}

.btn_login {
  font-family: Georgia;
  color: #ffffff;
  font-size: 12px;
  font-weight: bold;
  background: #4380B8;
  border: solid #4380B8 1px;
  padding: 3px 5px 3px 5px;
  text-decoration: none;
}

.btn_primary {
  font-family: Georgia;
  color: #ffffff;
  font-size: 12px;
  font-weight: bold;
  background: #4380B8;
  border: solid #4380B8 1px;
  padding: 3px 5px 3px 5px;
  text-decoration: none;
}
.btn_info {
  font-family: Georgia;
  color: #ffffff;
  font-size: 12px;
  font-weight: bold;
  background: #31B0D5 ;
  border: solid #31B0D5  1px;
  padding: 3px 3px 3px 3px;
  text-decoration: none;
}
.btn_default {
  font-family: Arial;
  color: #000000;
  font-size: 8px
  font-weight: bold;;
  padding: 2px 4px 2px 4px;
  border: solid #cccccc 2px;
  text-decoration: none;
}

.btn_success {
  font-family: Georgia;
  color: #ffffff;
  font-size: 12px;
  font-weight: bold;
  background: #00B359 ;
  border: solid #00B359  1px;
  padding: 3px 3px 3px 3px;
  text-decoration: none;
}

.btn_delete {
  font-family: Georgia;
  color: #ffffff;
  font-size: 14px;
  font-weight: bold;
  background: #FF0000;
  border: solid #FF0000 1px;
  padding: 3px 5px 3px 5px;
  text-decoration: none;
}

 table{
   border-collapse: collapse;
 } 
.cTable
{ 
     font-size: 10px;
}
.cTD
{ 
    border: 1px solid black;
    padding: 3px;
}

td.big {    font-size: 18px;
}
b,p{
  font-size: 10px;
}
</style>
<?php
    function convert_to_chinese($description) {

        if($_SESSION['chinese_char'] == '1')
        {
            echo mb_convert_encoding($description, "UTF-8", "GB-18030");
        }
        else
        {
            echo $description;
        }
    }
?>
</head>