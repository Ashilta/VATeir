<?php
$pagetitle = "Add a breakdown option";
require_once("../includes/header.php");
if(!$user->hasPermission('tdstaff')) {
	Session::flash('error', 'Invalid permissions');
	Redirect::to(BASE_URL . 'training');
}
$r = new Reports;

if(Input::exists()) { //if form submitted!
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'textarea' => array(
			'field_name' => 'Text',
			'required' => true
		),
		'program' => array(
			'field_name' => 'Program Name',
			'required' => false
		),
		'check' => array(
			'field_name' => 'Slider/Boolean',
			'required' => false
		)
	));

	if($validation->passed()) {

		try {
			$check = (Input::get('check')) ? 1 : 0;
			$r->updateS(array(
				'type'				=> $check,
				'program_id'		=> Input::get('program'),
				'text'				=> Input::get('textarea')
			), [['id', '=', Input::get('id')]]);

			Session::flash('success', 'Option added');
			Redirect::to('./sliders.php');

				
		} catch (Exception $e) {
			die($e->getMessage());
		}
	} else {
		echo '<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-danger">
			  <div class="panel-heading">
			    <h3 class="panel-title">The following errors occured:</h3>
			  </div>
			  <div class="panel-body">';
			    foreach($validation->errors() as $error) {
					echo $error.'<br>';
				}
			  echo '</div>
			</div>
		</div></div>
		';
			
	}
}

$option = $r->getSlider(Input::get('id'));
//print_r($option);

$t = new Training;
$programs = $t->getPrograms();
?>
<h3 class="text-center">Add a breakdown option</h3><br>
<div class="row">
	<div class="col-md-12">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Add</h3>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" action="" method="post">
								<div class="form-group">
									<label for="textarea" class="col-lg-2 control-label">Option text</label>
									<div class="col-lg-8">
										<input id="textarea" name="textarea" type="input" value="<?php echo (isset($_GET['text'])) ? $_GET['text'] : $option->text;?>" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="program" class="col-lg-2 control-label">Programme</label>
									<div class="col-lg-8">
										<select class="form-control" id="program" name="program">
								          <?php foreach($programs as $program): ?>
								          	<option value="<?php echo $program->id; ?>"
								          	<?php if(isset($_GET['program']) && ($_GET['program'] == $option->program_id)) { 
								          				echo 'selected';
								          			} elseif($option->program_id == $program->id) {
								          				echo 'selected';
								          			} ?> >
								          				
								          	<?php echo $program->name; ?></option>
								          <?php endforeach; ?>
								        </select>
									</div>
								</div>
								<div class="form-group">
									<label for="check" class="col-lg-2 control-label">Is Boolean</label>
									<div class="col-lg-10">
										<div class="checkbox">
											<label>
												<input name="check" style="margin-left:5px;" value="1" type="checkbox"
													<?php if($option->type == 1) {
														echo 'checked ';
													} ?>
												 class="checkbox check" id="check">
											</label>
										</div>
										<span class="help-block">Check for boolean. Leave unchekced for slider.</span>
									</div>
								</div>
								<div class="form-group text-center">
									<input type="hidden" name="id" value="<?php echo Input::get('id'); ?>">
									<input type="submit" name="submit" value="Submit" class="btn btn-primary">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
<?php
require_once("../../includes/footer.php");
