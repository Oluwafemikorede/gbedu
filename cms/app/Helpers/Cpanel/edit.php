<?php
session_start();

access_level($_SESSION['access_level']);
//echo $access_level.' <br> '. $_SESSION['access_level'];
if($access_level > $_SESSION['access_level'])
	echo 'You dont have access to this page';
else {	

if(isset($_POST['Upload'])){
$newtitle = "";
$ud_lname = $_REQUEST["ud_lname"];
$ud_fname = $_REQUEST["ud_fname"];
$ud_id = $_REQUEST["ud_id"];
$ud_email = $_REQUEST["ud_email"];
$ud_username = $_REQUEST["ud_username"];
$ud_access_level = $_REQUEST["ud_access_level"];

//$localPath = '/folktales/users/';
$localPath = '/users/';
$serverPath = $_SERVER['DOCUMENT_ROOT'];
$location = $serverPath.''.$localPath;

$fullname = $_REQUEST["ud_fname"].' '.$_REQUEST["ud_lname"];
$ud_user_alias = makeStringUrlFriendly($fullname);
$time = time();
		      $imagename = $_FILES['new_image']['name'];
              $source = $_FILES['new_image']['tmp_name'];
              $target = $location."".$imagename;
//$video_result = add_video($name, $description, '3');

	db_connect();
	$res = mysql_query("SELECT * FROM users 
							WHERE (email = '$ud_email' AND id != '$ud_id') 
							OR (uname = '$ud_username' AND id != '$ud_id')");
		if (mysql_num_rows($res) > 0)
			do_form_message("User already exists", $error);
		else{
		
			if (is_uploaded_file ($_FILES['new_image']['tmp_name'])){
					uploadPicture($source, $imagename, $newtitle, $location, $time);			
	
					db_connect();
					$updateRes = mysql_query("UPDATE users SET lname = '$ud_lname', fname = '$ud_fname', email = '$ud_email', uname = '$ud_username',
												access_level = '$ud_access_level', user_alias = '$ud_user_alias'
												WHERE id = '$ud_id'");
															
					if ($updateRes){
						$ext = getExtension($imagename);
						$saveImageAs = $localPath.''.$time.'.'.$ext;
	
						db_connect();
						$updateRes = mysql_query("UPDATE users SET profile_pic = '$saveImageAs' WHERE id = '$ud_id'");
						do_form_message("Photo Saved", "success");
						}
					else
						do_form_message("Unable to save item at this time. Please try later", "error");
				} // end if upload picture check
			else{
					db_connect();
					$updateRes = mysql_query("UPDATE users SET lname = '$ud_lname', fname = '$ud_fname', email = '$ud_email', uname = '$ud_username',
												access_level = '$ud_access_level', user_alias = '$ud_user_alias'
												WHERE id = '$ud_id'");
												
					
					if ($updateRes == 'ok')
						do_form_message("User Saved", "success");
					else
						do_form_message("Unable to save user at this time. Please try later", "error");
			}
		}
}
				if ($_GET['message'])
					echo $_GET['message']; 
db_connect();
$res = mysql_query("SELECT * FROM users WHERE id = '$_GET[id]'");
$row = mysql_fetch_array($res);
					?>

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="?w=plugins/users/index">Manage Users</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="?w=plugins/users/edit">Edit User</a>
					</li>
				</ul>
			</div>
                <div style="float: right;"><?php include "plugins/users/users_menu.php"; ?></div>
                
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Edit User</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
          <form action="<?php echo $_server['php-self'];  ?>" method="post" enctype="multipart/form-data" name="newmessage" id="newmessage">
          <input type='hidden' name='ud_id' value='<?= $row['id']; ?>' />
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
      <tbody>
      	<tr>
	        <td>Last name: *</td>
	        <td><input id="lname2" class="lname" name="ud_lname" type="text" value="<?= $row['lname']; ?>" /></td>
      </tr>
      	<tr>
	        <td>First name: *</td>
	        <td><input id="fname2" class="fname" name="ud_fname" type="text" value="<?= $row['fname']; ?>" /></td>
      </tr>
      	<tr>
	        <td>Email: *</td>
	        <td><input id="email2" class="email" name="ud_email" required type="text" value="<?= $row['email']; ?>" /></td>
      </tr>
      	<tr>
          <td>Username: *</td>
      	  <td><input id="username2" class="username" required name="ud_username" type="text" value="<?= $row['uname']; ?>" /></td>
   	  </tr>
      	<tr>
          <td>Alias: *</td>
      	  <td><input id="user_alias" class="ud_user_alias" required name="ud_user_alias" type="text" value="<?= $row['user_alias']; ?>" /></td>
   	  </tr>
        <tr>
          <td>Profile Photo:</td>
          <td class="space"><input name="new_image" id="new_image" size="30" type="file" class="fileUpload" /> <img src="<?= $row['profile_pic']; ?>" height="40px" /></td>
        </tr>
      	<tr>
          <td>Access Level: *</td>
      	  <td>
		<?php get_value("access_levels", array("access_id"), array($row['access_level'])); ?>
          <select name="ud_access_level" id="access_level2" required>
              <option value="<?php echo $row['access_level']; ?>"><?php echo $value_row['access_level']; ?> </option>
              <option value="">-----</option>
                <? $module = "access_levels";
				$order = "ORDER BY access_level ASC";
				$option1 = "access_level";
				$value = "access_id";
				list_menu($module, $order, $option1, "", $value, "*"); ?>         
                </select></td>
   	  </tr>
	      <tr>
	        <td>&nbsp;</td>
	        <td> <button name="Upload" type="submit" class="btn btn-primary">Save Changes</button></td>
	      </tr>
    </tbody>
  </table>
</form>
  </div>
  </div>
  </div>
<? }?>