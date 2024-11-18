<?php
	include("include.php");

    if(isset($_REQUEST['get_city']))
	{
		$district = $_REQUEST['get_district'];

		if(!empty($district))
		{
			$district = $obj->encode_decode("encrypt",$district);
		}

		$city = ""; $list = array();

		$list = $obj->getOtherCityList($district);

		foreach($list as $data) {
			if(!empty($data['city'])) {
				$data['city'] = $obj->encode_decode("decrypt",$data['city']);
				if(!empty($city)) {
					$city = $city.",".trim($data['city']);
				}
				else {
					$city = $data['city'];
				}
			}
			
		}
		if(!empty($city)) {
			echo trim($city);
		}
		exit;
	}
	
	if(isset($_REQUEST['others_city']))
	{
		$other_city = $_REQUEST['others_city'];
		$selected_district_index = $_REQUEST['selected_district'];
		$form_name = $_REQUEST['form_name'];

		if($other_city == '1')
		{ 
			?>
			<div class="form-group">
				<div class="form-label-group in-border">
					<input type="text" id="others_city" name="others_city" class="form-control shadow-none" value="" onkeydown="Javascript:KeyboardControls(this,'text',30,1);">
					<label>Others city <span class="text-danger">*</span></label>
				</div>
				<div class="new_smallfnt">Text Only.</div>
			</div>
			<?php 
		}
	}

?>