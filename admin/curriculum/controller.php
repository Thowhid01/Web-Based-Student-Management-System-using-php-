<?php
require_once ("../../include/initialize.php");
	 if (!isset($_SESSION['ACCOUNT_ID'])){
      redirect(web_root."admin/index.php");
     }

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;
	
	case 'delete' :
	doDelete();
	break;

	case 'photos' :
	doupdateimage();
	break;

	case 'curriculum' :
	doChangeStatUS();
	break;

 
	}
   
	function doInsert(){
		global $mydb;
		if(isset($_POST['save'])){


		if ($_POST['SUBJ_CODE'] == "" OR $_POST['SUBJ_DESCRIPTION'] == "" OR $_POST['UNIT'] == ""
			OR $_POST['PRE_REQUISITE'] == "" OR $_POST['COURSE_ID'] == "none"  OR $_POST['SEMESTER'] == "" ) {
			$messageStats = false;
			message("All field is required!","error");
			redirect('index.php?view=add');
		}else{	

			$sql = "SELECT * FROM `subject` WHERE `SUBJ_CODE`='".$_POST['SUBJ_CODE']."' AND COURSE_ID='".$_POST['COURSE_ID']."'";
			$mydb->setQuery($sql);
			$res = $mydb->executeQuery();
			$maxrow = $mydb->num_rows($res);

			if($maxrow>0){
				message("[". $_POST['SUBJ_CODE'] ."] cannot be save. Subject is already added.", "error");
				redirect("index.php?view=add");

			}else{
				$subj = New Subject();
			
				$subj->SUBJ_CODE 		= $_POST['SUBJ_CODE'];
				$subj->SUBJ_DESCRIPTION	= $_POST['SUBJ_DESCRIPTION']; 
				$subj->UNIT				= $_POST['UNIT'];
				$subj->PRE_REQUISITE 	= $_POST['PRE_REQUISITE'];
				$subj->COURSE_ID		= $_POST['COURSE_ID']; 
				$subj->YEARLEVEL		= $_POST['YEARLEVEL']; 
				$subj->AY				= $_POST['AY']; 
				$subj->SEMESTER			= $_POST['SEMESTER'];
				$subj->create();

							

				message("New [". $_POST['SUBJ_CODE'] ."] created successfully!", "success");
				redirect("index.php");

			}
 
			
		}
		}

	}

	function doEdit(){
	if(isset($_POST['save'])){

			$subj = New Subject(); 
			$subj->SUBJ_CODE 		= $_POST['SUBJ_CODE'];
			$subj->SUBJ_DESCRIPTION	= $_POST['SUBJ_DESCRIPTION']; 
			$subj->UNIT				= $_POST['UNIT'];
			$subj->PRE_REQUISITE 	= $_POST['PRE_REQUISITE'];
			$subj->COURSE_ID		= $_POST['COURSE_ID']; 
			$subj->YEARLEVEL		= $_POST['YEARLEVEL']; 
		    $subj->AY				= $_POST['AY']; 
			$subj->SEMESTER			= $_POST['SEMESTER'];
			$subj->update($_POST['SUBJ_ID']);

			  message("[". $_POST['SUBJ_CODE'] ."] has been updated!", "success");
			redirect("index.php");
		}
	}


	function doDelete(){
		
	

		
				$id = 	$_GET['id'];

				$subj = New Subject();
	 		 	$subj->delete($id);
			 
			message("Subject already Deleted!","info");
			redirect('index.php');
	

		
	}
	function doChangeStatUS(){

		global $mydb;
		$code =$_GET['id'];
		if ($_GET['status']=='New') {
		
			$status = 'New Curriculum';
		}else{
			$status = 'Old Curriculum';
		}

		$sql = "UPDATE `subject` SET `CURRICULUM`='{$status}' WHERE `SUBJ_CODE`='{$code}'";
		$mydb->setQuery($sql);
		$mydb->executeQuery();
		
		message("Status has been changed.", "success");
		redirect("index.php");
	}
 
 
?>