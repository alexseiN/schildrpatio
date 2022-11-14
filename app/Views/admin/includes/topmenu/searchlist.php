<?php
	
	if($_thisData['adminDetails']->role == 'Branch Admin'){
		$thisEmployee = get_langer('employees',false,$_thisData['adminDetails']->employee_id);
		$thisbranch = get_langer('branches',$_thisData['admin_lang'],$thisEmployee->branch_id);
		$main_menu_array = branchmenu($thisbranch);
	}
	else {
		$main_menu_array = globalmenu();
	}
	$main_menu_array['dashboard'] = array("name"=>"dashboard","icon"=>"fa fa-th-large","menuitems"=>array("dashboard"=>"Dashboard"));
	$main_menu_array['chat'] = array("name"=>"chat","icon"=>"fas fa-comment-alt-lines","menuitems"=>array("chat"=>"Chat"));
		
	
	if($postdata['view'] == 'recentsearch' && count($topsearch)>0) {
		foreach($topsearch as $searchvalues){
			$resultsearch[] = strtolower($searchvalues->searchitem);
		}
		$array_values_search = array_values(array_unique($resultsearch));
		foreach($main_menu_array as $menulist) {
			$menuitems = $menulist['menuitems'];
			foreach($menuitems as $key=>$value){
				if(is_array($value)){$showvalue = $value['name'];} else { $showvalue = $value; }
				$checkmenuitems[$key] = $showvalue;
			}
		}
		foreach($array_values_search as $items) {		
?>
<div class="d-flex align-items-center mb-5">
	<div class="symbol symbol-40px me-4">
		<span class="symbol-label bg-light">
			<span class="svg-icon svg-icon-2 svg-icon-primary">
				<i class="fas fa-file"></i>
			</span>
		</span>
	</div>
	<div class="d-flex flex-column">
		<a href="<?='/'.$_thisData['admin_link'].'/account/referrecent?view='.$items?>" class="fs-6 text-gray-800 text-hover-primary fw-bold">
			<?=$checkmenuitems[$items]?>
		</a>
	</div>
</div>
<?php } }
	else if($postdata['view'] == 'searchresult') {
		$keyword = $postdata['keyword'];
		foreach($main_menu_array as $menulist) {
			$menuitems = $menulist['menuitems'];
			foreach($menuitems as $key=>$value){
				$checkvalue = $key;
				if(is_array($value)){$showvalue = $value['name'];} else { $showvalue = $value; }
				if (strpos(strtolower($showvalue), strtolower($keyword)) !== false) { 

?><div class="d-flex align-items-center mb-5"><div class="symbol symbol-40px me-4"><span class="symbol-label bg-light"><span class="svg-icon svg-icon-2 svg-icon-primary"><i class="fas fa-file"></i></span></span></div><div class="d-flex flex-column"><a href="<?='/'.$_thisData['admin_link'].'/account/referrecent?view='.$key?>" class="fs-6 text-gray-800 text-hover-primary fw-bold"><?=$showvalue?></a></div></div><?php } } } } ?>
					