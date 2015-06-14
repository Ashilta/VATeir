<?php
require_once("../includes/header.php");
if(isset($_POST["data"])) {
	$data = unserialize($_POST["data"]);
	if(isset($_POST["transfer"])) { //transfer request
		try{
			$try = $user->create([
				'id' 				=> $data->id,
				'first_name' 		=> $data->name_first,
				'last_name' 		=> $data->name_last,
				'email' 			=> $data->email,
				'rating' 			=> $data->rating->id,
				'pilot_rating' 		=> $data->pilot_rating->rating,
				'regdate_vatsim' 	=> date("Y-m-d H:i:s", strtotime($data->reg_date)),
				'regdate_vateir' 	=> date('Y-m-d H:i:s'),
				'vateir_status'		=> 4
			]);
			Session::flash("success", "Thank you for your transfer request. A member of staff will be in touch!");
			Redirect::to("../index.php");
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	} elseif(isset($_POST["visiting"])) { //visiting request
		try{
			$try = $user->create([
				'id' 				=> $data->id,
				'first_name' 		=> $data->name_first,
				'last_name' 		=> $data->name_last,
				'email' 			=> $data->email,
				'rating' 			=> $data->rating->id,
				'pilot_rating' 		=> $data->pilot_rating->rating,
				'regdate_vatsim' 	=> date("Y-m-d H:i:s", strtotime($data->reg_date)),
				'regdate_vateir' 	=> date('Y-m-d H:i:s'),
				'vateir_status'		=> 3
			]);
			Session::flash("success", "Thank you for your application. A member of staff will be in touch!");
			Redirect::to("../index.php");
		} catch(Exception $f) {
			echo $f->getMessage();
		}
	}	
} else {
	Session::flash("error", "Cannot access resource!");
	Redirect::to("../index.php");
}