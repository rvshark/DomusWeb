<?php // $Id: insert_image.php,v 1.9.8.2 2009/06/09 04:58:39 jonathanharker Exp $

require("../config.php");

//$id = optional_param('id', SITEID, PARAM_INT);
$id = required_param('id', PARAM_INT);
$choose = optional_param('choose',PARAM_FILE);
require_login($id);
require_capability('moodle/course:managefiles', get_context_instance(CONTEXT_COURSE, $id));

@header('Content-Type: text/html; charset=utf-8');

$upload_max_filesize = get_max_upload_file_size($CFG->maxbytes);

if ($httpsrequired or (!empty($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off')) {
	$url = preg_replace('|https?://[^/]+|', '', $CFG->wwwroot).'/files/';
} else {
	$url = $CFG->wwwroot.'/files/';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php print_string("managerfiles","editor");?></title>
<script type="text/javascript">
//<![CDATA[
var preview_window = null;

//Fun��o para inserir o arquivo selecionado
function set_value() {
	txt = document.getElementById('f_url').value;
	opener.document.getElementById('id_reference_value').value = txt;
    window.close();
}

function Init() {
  //__dlg_init();
  var param = window.dialogArguments;
  if (param) {
      var alt = param["f_url"].substring(param["f_url"].lastIndexOf('/') + 1);
      document.getElementById("f_url").value = param["f_url"];
      document.getElementById("f_alt").value = param["f_alt"] ? param["f_alt"] : alt;
      document.getElementById("f_border").value = parseInt(param["f_border"] || 0);
      document.getElementById("f_align").value = param["f_align"];
      document.getElementById("f_vert").value = param["f_vert"] != -1 ? param["f_vert"] : 0;
      document.getElementById("f_horiz").value = param["f_horiz"] != -1 ? param["f_horiz"] : 0;
      document.getElementById("f_width").value = param["f_width"];
      document.getElementById("f_height").value = param["f_height"];
      window.ipreview.location.replace('preview.php?id='+ <?php print($id);?> +'&imageurl='+ param.f_url);
  }
  document.getElementById("f_url").focus();
};

function onOK() {
  var required = {
    "f_url": "<?php print_string("mustenterurl", "editor");?>",
    "f_alt": "<?php print_string("pleaseenteralt", "editor");?>"
  };
  for (var i in required) {
    var el = document.getElementById(i);
    if (!el.value) {
      alert(required[i]);
      el.focus();
      return false;
    }
  }
  // pass data back to the calling window
  var fields = ["f_url", "f_alt", "f_align", "f_border",
                "f_horiz", "f_vert","f_width","f_height"];
  var param = new Object();
  for (var i in fields) {
    var id = fields[i];
    var el = document.getElementById(id);
    param[id] = el.value;
  }
  if (preview_window) {
    preview_window.close();
  }
  __dlg_close(param);
  return false;
};

function onCancel() {
  if (preview_window) {
    preview_window.close();
  }
  __dlg_close(null);
  return false;
};

function onPreview() {
  var f_url = document.getElementById("f_url");
  var url = f_url.value;
  if (!url) {
    alert("<?php print_string("enterurlfirst","editor");?>");
    f_url.focus();
    return false;
  }
  var img = new Image();
  img.src = url;
  var win = null;
  if (!document.all) {
    win = window.open("<?php echo $url ?>blank.html", "ha_imgpreview", "toolbar=no,menubar=no,personalbar=no,innerWidth=100,innerHeight=100,scrollbars=no,resizable=yes");
  } else {
    win = window.open("<?php echo $url ?>blank.html", "ha_imgpreview", "channelmode=no,directories=no,height=100,width=100,location=no,menubar=no,resizable=yes,scrollbars=no,toolbar=no");
  }
  preview_window = win;
  var doc = win.document;
  var body = doc.body;
  if (body) {
    body.innerHTML = "";
    body.style.padding = "0px";
    body.style.margin = "0px";
    var el = doc.createElement("img");
    el.src = url;

    var table = doc.createElement("table");
    body.appendChild(table);
    table.style.width = "100%";
    table.style.height = "100%";
    var tbody = doc.createElement("tbody");
    table.appendChild(tbody);
    var tr = doc.createElement("tr");
    tbody.appendChild(tr);
    var td = doc.createElement("td");
    tr.appendChild(td);
    td.style.textAlign = "center";

    td.appendChild(el);
    win.resizeTo(el.offsetWidth + 30, el.offsetHeight + 30);
  }
  win.focus();
  return false;
};

function checkvalue(elm,formname) {
    var el = document.getElementById(elm);
    if(!el.value) {
        alert("Campo em branco!");
        el.focus();
        return false;
    }
}

function submit_form(dothis) {
    if(dothis == "delete") {
        window.ibrowser.document.dirform.action.value = "delete";
    }
    else if(dothis == "move") {
        window.ibrowser.document.dirform.action.value = "move";
    }
    else if(dothis == "zip") {
        window.ibrowser.document.dirform.action.value = "zip";
    }
    else if(dothis == "checkall") {
        window.ibrowser.document.dirform.action.value = "checkall";
    }
    else if(dothis == "uncheckall") {
        window.ibrowser.document.dirform.action.value = "uncheckall";
    }
    else if(dothis == "mkdir"){
    	window.ibrowser.document.dirform.action.value = "mkdir";
    }
    else if(dothis == "upload"){
    	window.ibrowser.document.dirform.action.value = "upload";
    }
    window.ibrowser.document.dirform.submit();
    return false;
}

//]]>
</script>
<style type="text/css">
html,body {
	margin: 2px;
	background-color: #dededc;
	font-family: Tahoma, Verdana, sans-serif;
	font-size: 11px;
}

.title {
	background-color: #ddddff;
	padding: 5px;
	border-bottom: 1px solid black;
	font-family: Tahoma, sans-serif;
	font-weight: bold;
	font-size: 14px;
	color: black;
}

td,input,select,button {
	font-family: Tahoma, Verdana, sans-serif;
	font-size: 11px;
}

button {
	width: 70px;
}

.space {
	padding: 2px;
}

form {
	margin-bottom: 0px;
	margin-top: 0px;
}
</style>
</head>
<body onload="Init()">
<div class="title"><?php print_string("managerfiles","editor");?></div>
<div class="space"></div>
<div class="space"></div>
<div class="space"></div>
<form action="" method="get" id="first">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<?php if($choose != "" ){?>
		<td nowrap="nowrap"><?php print_string("fileurl","editor");?>:<input name="f_url" type="text" id="f_url" readonly="readonly"
			style="width: 75%;" /><input type="button" value="Selecionar" onclick="return set_value()"/></td>
	<?php }else{?>
		<td nowrap="nowrap"><?php print_string("fileurl","editor");?>:<input name="f_url" type="text" id="f_url" readonly="readonly"
			style="width: 87%;" /></td>
	<?php }?>
	</tr>
</table>
</form>
<br/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="55%" valign="top" colspan="2"><?php
		//print_string("filebrowser","editor");
		//echo "<br />";
		echo "<iframe id=\"ibrowser\" name=\"ibrowser\" src=\"{$CFG->wwwroot}/files/coursefiles.php?usecheckboxes=1&id=$id\" style=\"width: 99%; height: 200px;\"></iframe>";
		?></td>
	</tr>
</table>
<br/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="55%" valign="top" colspan="2">
		<?php if(has_capability('moodle/course:managefiles', get_context_instance(CONTEXT_COURSE, $id))) { ?>
		<table border="0" cellpadding="2" cellspacing="0">
			<tr>
				<td><?php print_string("selection","editor");?>:</td>
				<td>
				<form id="idelete"><input name="btnDelete" type="submit"
					id="btnDelete" value="<?php print_string("delete","editor");?>"
					onclick="return submit_form('delete');" /></form>
				</td>
				<td>
				<form id="imove"><input name="btnMove" type="submit" id="btnMove"
					value="<?php print_string("move","editor");?>"
					onclick="return submit_form('move');" />
				</form>
				</td>
				<td>
					<form id="izip">
						<input name="btnZip" type="submit" id="btnZip" value="<?php print_string("zip","editor");?>"
						onclick="return submit_form('zip');" />
					</form>
				</td>
				<td>
					<form id="icheckall">	
						<input name="btnCheckall" type="submit" id="btnCheckall" value="<?php echo get_string("selectall");?>" 
						 onclick="return submit_form('checkall');"  />						
					</form>
				</td>
				<td>
					<form id="iuncheckall">
						<input name="btnUncheckall" type="submit" id="btnUncheckall" value="<?php echo get_string("deselectall");?>" 
						onclick="return submit_form('uncheckall');"  />
					</form>
				</td>
			</tr>		
		</table>
		<?php
		} else {
			print "";
		} ?></td>
	</tr>
	<tr><td><br/></td></tr>
	<tr>
		<td valign="top" width="50%">
			<fieldset style="height: 100px">
				<legend><?php print_string("search","editor") ?></legend>
				
				<form id="cfolder" action="../files/coursefiles.php" method="post" target="ibrowser">
				<table style="width: 100%">
					<tr>
						<td width="10%" style="text-align: right">
							<label for="id">Cursos:</label>
						</td>
						<td width="40%">
							<select name="idSearch" id="idSearch" style="width:90%" >
							<option value="0" >Todos </option>
							<?php 
							$SQL="SELECT DISTINCT c.fullname, c.id FROM {$CFG->prefix}course c 
								  WHERE category > 0 and visible = 1 ORDER BY c.id";
							$menumembers = get_recordset_sql($SQL);
							while ($rs = rs_fetch_next_record($menumembers)) {
								echo "<option value='$rs->id' ". ($id == $rs->id ? "selected='selected'" : "" ) ." >$rs->fullname</option>";
							 } ?>
							</select>
							<input type="hidden" id="id" name="id" value="<?php echo $id ?>" />
						</td>
						<td width="10%" style="text-align: right">
							<label for="id">Tipo:</label>
						</td>
						<td width="40%">
							<select name="typeFile" id="typeFile" style="width:100%" >
								<option value="all">Todos</option>
								<option value="img">Imagens</option>
								<option value="docs">Docs</option>
								<option value="pdf">Pdf</option>						
							</select>		
						</td>
					</tr>
					<tr>
						<td style="text-align: right">
							<label for="id">Palavra:</label>
						</td>
						<td colspan="3">
							<input style="width:99%" type="text" name="keywords" id="keywords" value="" />
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right">
							<input name="name" type="submit" id="foldername" value="Buscar"/>
						</td>
					</tr>
				</table>
				</form>
			</fieldset>
		</td>
		<td width="50%">
			<fieldset style="height: 100px">
				<legend><?php print_string("options","editor"); ?></legend>
				<form id="cfolder" action="../files/coursefiles.php" method="post" target="ibrowser">
						<input type="hidden" name="id" value="<?php print($id);?>" /> 
						<input type="hidden" name="wdir" value="" /> 
						<input type="hidden" name="action" value="mkdir" /> 
						<input type="hidden" name="sesskey" value="<?php p($USER->sesskey) ?>" /> 
						<input name="name" type="text" id="foldername" size="35" /> 
						<input name="btnCfolder" type="submit" id="btnCfolder" value="<?php print_string("createfolder","editor");?>" onclick="return checkvalue('foldername','cfolder');" />
				</form>
				<div class="space"></div>
				<form action="../files/coursefiles.php?id=<?php print($id);?>" method="post" enctype="multipart/form-data" target="ibrowser" id="uploader">
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php print($upload_max_filesize);?>" /> 
					<input type="hidden" name="id" value="<?php print($id);?>" /> 
					<input type="hidden" name="wdir" value="" /> <input type="hidden" name="action" value="upload" /> 
					<input type="hidden" name="sesskey" value="<?php p($USER->sesskey) ?>" /> 
					<input type="file" name="userfile" id="userfile" size="35" /> 
					<input name="save" type="submit" id="save" onclick="return checkvalue('userfile','uploader');" value="<?php print_string("upload","editor");?>" />
				</form>
			</fieldset>
		<div class="space"><br/></div>
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top">
			<fieldset style="height: 200px"><legend>
			<?php print_string("properties","editor");?></legend>
			<div class="space"></div>
			<div class="space"></div>
			<?php print_string("size","editor");?>: 
			<input type="text" id="isize" name="isize" size="50" style="background: transparent; border: none;" /> 
			<div class="space"></div>
			<div class="space"></div>
			<?php print_string("type","editor");?>:
			<input type="text" id="itype" name="itype" size="50" style="background: transparent; border: none;" />
			<div class="space"></div>
			<div class="space"></div>
			<?php print_string("height","editor");?>:
			<input type="text" id="f_height" name="f_height" size="50" style="background: transparent; border: none;" />
			<div class="space"></div>
			<div class="space"></div>
			<?php print_string("width","editor");?>:
			<input type="text" id="f_width" name="f_width" size="50" style="background: transparent; border: none;" />
			<div class="space"></div>
			<div class="space"></div>
			</fieldset>
		</td>
		<td width="50%" valign="top">
			<fieldset style="height: 200px"><legend><?php print_string("preview","editor");?></legend>
				<iframe id="ipreview" name="ipreview" src="<?php echo $url ?>blank.html" style="width: 99%; height: 90%;"></iframe>
			</fieldset>
		</td>
	</tr>
	</table>
<p>&nbsp;</p>
</body>
</html>
