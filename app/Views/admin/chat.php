<?php
	$thisEmployee = get_langer('employees',false,$adminDetails->employee_id);
	$thisbranch = get_langer('branches',$admin_lang,$thisEmployee->branch_id);
	$sentInvoices = print_count('setproject',array('parent_id'=>0,'sendtime<>'=>0));
	$quotes = print_count('quotes',array());
	$employeescount = print_count('employees',array());
	$employees = get_table_where('employees',false);
	$adminrole = $adminDetails->role;

	$f_visitor_array = array();
	$f_idss_array = array();

	$visitor_array = array();
	$idss_array = array();
	
	$is_show = false;
	if($adminrole == "Global Admin") {
		$is_show = true;
		$get_visitors = get_support_visitors_by_chat();
	}
	else {
		$get_visitors = get_support_visitors_by_chat($thisEmployee->branch_id);
	}

	$idarray = array();$timearray = array();
	if(count($get_visitors)>0) {
		foreach($get_visitors as $get_visitor) {
			//pp($get_visitor,false);
			$id = $get_visitor->sender_id;
			if($get_visitor->sender_id == '0'){
				$id = $get_visitor->receiver_id;
			}
			if(!in_array($id,$idarray)){
				$last_time = date("d M, H:iA",strtotime($get_visitor->created_at));
				array_push($idarray,$id);
				array_push($timearray,$last_time);
			}
		}
	}
	//pp($idarray,false);
	//pp($timearray,false);
	//pp($get_visitors);
	$user_name = '';	
	$latestchatemp = get_emp_by_chat($adminDetails->employee_id);
	$chatids = $latestchatemp['ids'];
	$chattimes = $latestchatemp['time'];
?>
<div class="content d-flex flex-column flex-column-fluid mb-15" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
			<div class="d-flex flex-column flex-lg-row">
				<div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-350px mb-10 mb-lg-0">
					<!--begin::Contacts-->
					<div class="card card-flush">
						
						<!--begin::Card header-->
						<div class="card-header pt-7 pb-0" id="kt_chat_contacts_header" style="padding: 1rem;">
							<div class="w-100 position-relative caption mb-5">
								<!--<span class="caption-subject caption-subject fs-4 fw-bolder text-gray-900 text-hover-primary mb-2">Users</span>-->
								<ul class="w-100 nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2 text-center">
									<li class="nav-item w-50">
										<a class="nav-link text-active-primary pb-4" data-id="front" data-bs-toggle="tab" href="#portlet_comments_1">Front chat <span class="badge badge-sm badge-danger total_front" style="float: right;"></span></a>
									</li>
									<li class="nav-item w-50">
										<a class="nav-link text-active-primary pb-4 active" data-id="admin" data-bs-toggle="tab" href="#portlet_comments_2">Local chat <span class="badge badge-sm badge-danger  total_back" style="float: right;"></span></a>
									</li>
								</ul>
								<div class="separator separator-dashed mt-2"></div>				
							</div>
									
							<div class="w-100 position-relative mb-5" autocomplete="off">
								<input type="text" class="form-control form-control-solid pe-15 input-circle-users" name="search" value="" placeholder="Search users" id="searchusers">
								<span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 me-5 translate-middle-y" style="right:0;cursor:pointer;">
									<i class="fa fa-search submitsearchusers"></i>
								</span>
							</div>							
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="tab-content">
						<div class="tab-pane fade pt-0" id="portlet_comments_1" role="tab-panel" style="padding: 1rem;">
							<!--begin::List-->
							<div class="scroll-y me-n5 pe-5 h-650px h-lg-auto mt-comments frontcomments" style="max-height: 650px;">
								
								<?php if(count($idarray)>0) { foreach($idarray as $keyid=>$vid) { $visitorresult = get_support_visitor_by_id($vid); $svisitor = $visitorresult[0]; //pp($svisitor);
									$f_visitor_array[] = strtoupper($svisitor->c_name);
									$f_idss_array[] = $svisitor->id;
								?>
								<!--begin::User-->
								<div class="d-flex flex-stack py-4 cursor-pointer bg-hover-light-primary px-1 mt-comment showchatwindow" id="frontuserli_<?php echo $svisitor->id;?>" data-id="<?php echo $svisitor->id;?>" data-type="visitor" data-name="<b><?php echo $svisitor->c_name;?> ( <?=$svisitor->b_name?> )</b>">
									<!--begin::Details-->
									<div class="d-flex align-items-center">
										<!--begin::Avatar-->
										<div class="symbol symbol-45px symbol-circle">
											<span class="symbol-label bg-light-warning text-warning fs-6 fw-bolder">
												<?=$svisitor->c_name[0]?>
											</span>
											<div class="symbol-badge bg-danger start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2 loginlable" id="userfrontonline_<?php echo $svisitor->id;?>"></div>
										</div>
										<!--end::Avatar-->
										<!--begin::Details-->
										<div class="ms-5">
											<span class="fs-6 fw-bolder text-gray-900 text-hover-primary mt-comment-author">
												<?=$svisitor->c_name;?>												
											</span>
											<div class="fw-bold text-muted fs-7">												
												<b>( <?=$svisitor->b_name?> )</b>
												<br>
												<b>P: </b> +<?php echo $svisitor->c_phone;?> <br> <b>IP:</b> <?php echo $svisitor->ipaddress;?> <!--/ <b>Online</b>-->
											</div>
										</div>
										<!--end::Details-->
									</div>
									<!--end::Details-->
									<!--begin::Lat seen-->
									<div class="d-flex flex-column align-items-end ms-2">
										<span class="text-muted fs-8 mb-1 mt-comment-date" id="updatetimeforfrontuser_<?=$svisitor->id?>">
											<?=$timearray[$keyid]?>
										</span>
										<span class="badge badge-sm badge-danger" id="frontuserlabel_<?php echo $svisitor->id;?>"></span>
									</div>
									<!--end::Lat seen-->
								</div>
								<!--end::User-->
								<?php } } ?>								
							</div>
							<!--end::List-->
						</div>
						<!--end::Card body-->

						<!--begin::Card body-->
						<div class="tab-pane fade  pt-0 active show" id="portlet_comments_2" role="tab-panel" style="padding: 1rem;">
							<!--begin::List-->
							<div class="scroll-y me-n5 pe-5 h-650px h-lg-auto mt-comments admincomments" style="max-height: 650px;">
								<div class="d-flex flex-stack py-4 cursor-pointer bg-light-primary bg-hover-light-primary px-1 showchatwindow" id="groupchatli" data-id="Groupchat" data-type="adminlocal" data-name="Group chat <b>( All )</b>">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-45px symbol-circle">
											<img src="/assets/uploads/sites/favicon.webp"> 
										</div>
										<div class="ms-5">
											<span class="fs-6 fw-bolder text-gray-900 text-hover-primary">
												Group Chat (All)
											</span>
										</div>
									</div>
									<div class="d-flex flex-column align-items-end ms-2">
										<span class="text-muted fs-8 mb-1"><?=$lasttime?></span>
										<span class="badge badge-sm badge-light-danger" id="groupchatlabel" style="display:none;"></span>
									</div>
								</div>
								<?php								
									foreach($chatids as $empid) {
										$employeer = get_table_where('employees',["id"=>$empid]);
										$employee = $employeer[0];
										if($employee->id != $adminDetails->employee_id){
											if($employee->id==$empid) {												
												$empkey = array_search($employee->id, $chatids);
												$username = $employee->first_name.' '.$employee->last_name;
												$visitor_array[] = strtoupper($username);
												$idss_array[] = $employee->id;
												if($employee->image != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/employees/small/'.$employee->image)) {
													$setimage = site_url('/').'assets/uploads/employees/small/'.$employee->image;
													$img_html = '<img src="'.$setimage.'" alt="'.$username.'">';
												}
												else {
													$img_html = '<span class="symbol-label bg-light-warning text-warning fs-6 fw-bolder">'.$username[0].'</span>';
												}
											
								?>
									<div class="d-flex flex-stack py-4 cursor-pointer bg-hover-light-primary px-1 mt-comment showchatwindow" id="userli_<?php echo $employee->id;?>" data-id="<?=$employee->id;?>" data-type="adminlocal" data-name="<?=$username?>">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-45px symbol-circle">
												<?=$img_html?>
												<div class="symbol-badge bg-danger start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2 loginlable" id="useronline_<?php echo $employee->id;?>" ></div>
											</div>
											<div class="ms-5">
												<span class="fs-6 fw-bolder text-gray-900 text-hover-primary">
													<?=$username?>
												</span>
											</div>
										</div>
										<div class="d-flex flex-column align-items-end ms-2">
											<span class="text-muted fs-8 mb-1" id="updatetimeforuser_<?=$employee->id?>"><?=$lasttime?></span>
											<span class="badge badge-sm badge-danger" id="userlabel_<?php echo $employee->id;?>"></span>
										</div>
									</div>
								<?php  } } }  ?>
								<?php
									foreach($employees as $employee) {
										if($employee->id != $adminDetails->employee_id){
											if(!in_array($employee->id,$chatids)) {
												$setimage = site_url('/').'assets/avatar.png';
												$username = $employee->first_name.' '.$employee->last_name;
												$visitor_array[] = strtoupper($username);
												$idss_array[] = $employee->id;
												
												if($employee->image != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/employees/small/'.$employee->image)) {
													$setimage = site_url('/').'assets/uploads/employees/small/'.$employee->image;
													$img_html = '<img src="'.$setimage.'" alt="'.$username.'">';
												}
												else {
													$img_html = '<span class="symbol-label bg-light-warning text-warning fs-6 fw-bolder">'.$username[0].'</span>';
												}
												
												
								?>
									<div class="d-flex flex-stack py-4 cursor-pointer bg-hover-light-primary px-1 mt-comment showchatwindow" id="userli_<?php echo $employee->id;?>" data-id="<?=$employee->id;?>" data-type="adminlocal" data-name="<?=$username?>">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-45px symbol-circle">
												<?=$img_html?> 
												<div class="symbol-badge bg-danger start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2 loginlable" id="useronline_<?php echo $employee->id;?>"></div>
											</div>
											<div class="ms-5">
												<span class="fs-6 fw-bolder text-gray-900 text-hover-primary">
													<?=$username?>
												</span>
											</div>
										</div>
										<div class="d-flex flex-column align-items-end ms-2">
											<span class="text-muted fs-8 mb-1" id="updatetimeforuser_<?=$employee->id?>"><?=$lasttime?></span>
											<span class="badge badge-sm badge-danger" id="userlabel_<?php echo $employee->id;?>"></span>
										</div>
									</div>
								<?php  } } }  ?>
							</div>
							<!--end::List-->
						</div>
						<!--end::Card body-->
						</div>
					</div>
					<!--end::Contacts-->
				</div>
				<?=view('admin/includes/common/chatbody',$all_data)?>
			</div>
		</div>
    </div>
</div>
<input type="hidden" id="activetab" value="admin"/>
<?php
	$f_namesarray = "'".implode("','",$f_visitor_array)."'"; $f_idssarray = "'".implode("','",$f_idss_array)."'";
	$namesarray = "'".implode("','",$visitor_array)."'"; $idssarray = "'".implode("','",$idss_array)."'";

	$admin_link_chat = $admin_link;
?>
<!--
<style>
	.showchatwindow{    border-top-style: dashed!important;
    border-color: #e4e6ef;
    border-top-width: 1px;}
</style>-->
<script>
	function loadLog(lastid = '1') {
		
		var checkinputsearch = $("#searchwindow").val().trim();
		if(checkinputsearch != '') {return false;}
		var myDiv = document.getElementById("chatbox");
		
		var oldscrollHeight = myDiv.scrollHeight;
		var senderlastid = $("div#chatbox div.chatsline").last().attr('data-id');
		var showloader = false;
		var lastidsent = lastid;
		
		if(lastidsent == '0'){
			lastidsent = 'new';
		}
		else {
			
			if($.isNumeric(senderlastid)){
				lastidsent = senderlastid;
			}
			else {
				lastidsent = '';
			}		
		}	
		//console.log(lastidsent);console.log(senderlastid);
		$.ajax({
			url: '<?=$admin_link_chat."/chat"?>/loadlocalchat/20',
			type:'POST',
			data: {'lastid':lastidsent},
			cache:false,
			global: showloader,
			success: function (response) {
				const res = JSON.parse(response);			
				if(res.html != ''){
					
					if(lastid == 'new'){
						//console.log(lastid);
						$("#chatbox").html('');
						$("#chatbox").append(res.html);
					}
					else {
						$("#chatbox").append(res.html);
					}
					$("#updatetimeforGroupchat").html(res.lasttime);
					var newscrollHeight = myDiv.scrollHeight;
					if(newscrollHeight > oldscrollHeight){
						myDiv.scrollTop = myDiv.scrollHeight;
					} 
				}				  
			}
		});
	}

	var myDiv = document.getElementById("chatbox");
    myDiv.scrollTop = myDiv.scrollHeight;
	
	
	var e_branch_id = '<?=$thisEmployee->branch_id?>';
	var e_emp_id = '<?=$adminDetails->employee_id?>';



	var lastKeyUp=0;
	setInterval(function(){
		lastKeyUp = ++lastKeyUp % 360 + 1;
		//if(lastKeyUp>5 && $("#contentmsg").val()!=""){
			//startstopwriting("stoppedTyping");
		//}
		//else {
			startstopwriting("stoppedTyping");
		//}
	},2500);


	$("#contentmsg").keyup(function(){
		lastKeyUp=0;
		startstopwriting("startedTyping");	  
	});
	function startstopwriting(type){
		/*$.post("<?php echo site_url("manage/chat");?>/typeStatus", {action:type,"e_emp_id":e_emp_id,
			"e_branch_id":e_branch_id,"loadedchat":$("#loadedchat").val(),"loadedchattype":$("#loadedchattype").val()}, function(){
				lastKeyUp=0;
			}
		);*/

		$.ajax({
			url: "<?=$admin_link_chat.'/chat'?>/typeStatus",
			type:'POST',
			data: {action:type,"e_emp_id":e_emp_id,
			"e_branch_id":e_branch_id,"loadedchat":$("#loadedchat").val(),"loadedchattype":$("#loadedchattype").val()},
			cache:false,
			global: false,
			success: function (response) {
				lastKeyUp=0;
			}
		});
		
	}

	
	
	$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("data-id") // activated tab
		$("#activetab").val(target);
	});
	
	var timer = 0;
	var intervaltime = 2500;
	function setgroupchatInterval(bool){  
	  if(bool){
			timer = setInterval(loadLog,intervaltime);
	  }else{
			clearInterval(timer); 
	  }
	}
	setgroupchatInterval(true);

	
	var timer_2 = 0;
	function setonetooneInterval(bool){  
	  if(bool){
			timer_2 = setInterval(loadonetooneLog,intervaltime);
	  }else{
			clearInterval(timer_2); 
	  }
	}
	setonetooneInterval(false);


	var timer_3 = 0;
	function checkunreadmessages(bool){  
	  if(bool){
			timer_3 = setInterval(checkunreadmessage,2500);
	  }else{
			clearInterval(timer_3); 
	  }
	}
	checkunreadmessage();
	checkunreadmessages(true);

	var timer_4 = 0;
	function checkonlineinterval(bool){  
	  if(bool){
			timer_4 = setInterval(checkonline,intervaltime);
	  }else{
			clearInterval(timer_4); 
	  }
	}
	checkonline();
	checkonlineinterval(true);


	var timer_5 = 0;

	function setchecktypestatus(bool){  
	  if(bool){		  
			timer_5 = setInterval(checktypestatus,1500);
	  }else{
			clearInterval(timer_5); 
	  }
	}
	setchecktypestatus(true);



	var i = 0;
	var txt = 'typing...';
	var speed = 100;

	function typeWriter() {		
		if (i < txt.length) {
			document.getElementById("typingshow").innerHTML += txt.charAt(i);
			i++;
			setTimeout(typeWriter, speed);
		}
	}

	

	function checktypestatus(){
		var chatid = $("#loadedchat").val();
		var chattype = $("#loadedchattype").val();
		var totalfront = $(".total_front");
		var totalback = $(".total_back");
		if(chatid != 'Groupchat') {
			var urltogo = '<?=$admin_link_chat."/chat"?>/checktypestatus';
			$.ajax({
				url: urltogo,
				type:'POST',
				data: {'chatid':chatid,'chattype':chattype,'e_branch_id':e_branch_id,'e_emp_id':e_emp_id},
				cache:false,
				global: false,
				success: function (response) {				
				
					const res = JSON.parse(response);
					var tstatus = res.tstatus;
					$("#typingshow").html('');
					if(tstatus == 'Startedtyping' && chatid != 'Groupchat') {
						i = 0;
						var checkname = $("#chatbody .caption-subject").html();
						$("#typingshow").html("<b>"+checkname+"</b> typing...");
						//typeWriter();
					}
					else {
						i = 0;
						$("#typingshow").html('');			
					}				
				}
			});
		}
	}

	var onlinearray = [];
	function checkonline(){
		var chatid = $("#loadedchat").val();
		var chattype = $("#loadedchattype").val();
		var urltogo = '<?=$admin_link_chat."/chat"?>/checkonline';		
		$.ajax({
			url: urltogo,
			type:'POST',
			data: {'chatid':chatid,'chattype':chattype,'e_branch_id':e_branch_id,'e_emp_id':e_emp_id},
			cache:false,
			global: false,
			success: function (response) {				
				
				const res = JSON.parse(response);
				$(".loginlable").addClass("bg-danger");
				$(".loginlable").removeClass("bg-success");
				if(res.total_online > 0){
					var onlineobject = res.all_users;
					var onlinefrom = res.from_array;
								
					Object.entries(onlineobject).forEach(([key, value]) => {
						var checkonlinearray = onlinefrom[key];
						if(checkonlinearray == '0'){
							$("#useronline_"+value).addClass("bg-success");
							$("#useronline_"+value).removeClass("bg-danger");
						}
						else if(checkonlinearray == '1'){
							$("#userfrontonline_"+value).addClass("bg-success");
							$("#userfrontonline_"+value).removeClass("bg-danger");
						}
					});					
				}				
				//$(".loginlable:not(.active)").addClass('activenathi');		
			}
		});
	}
	
	var myArray = [];
	
	function checkunreadmessage(){
		var chatid = $("#loadedchat").val();
		var chattype = $("#loadedchattype").val();
		var totalfront = $(".total_front");
		var totalback = $(".total_back");		
		var urltogo = '<?=$admin_link_chat."/chat"?>/checkunreadmessage';
		$.ajax({
			url: urltogo,
			type:'POST',
			data: {'chatid':chatid,'chattype':chattype,'e_branch_id':e_branch_id,'e_emp_id':e_emp_id},
			cache:false,
			global: false,
			success: function (response) {
				
			
				const res = JSON.parse(response);
				
				if(res.total_back > '0'){
					totalback.html(res.total_back);
				}
				else {
					totalback.html("");
				}
				if(res.total_front > '0'){
					totalfront.html(res.total_front);
				}
				else {
					totalfront.html("");
				}

				if(res.totalgroup > '0'){
					$("#updatetimeforGroupchat").html(res.grouptimelatest);
				}
				
				var $groupchatli = $("#groupchatli");
				if(res.total_back > '0'){				
			
					var myObject = res.total_back_array;
					Object.entries(myObject).forEach(([key, value]) => {
						var timearrayset = res.total_back_time;
						var timetoupdate = timearrayset[key];
						$("#userlabel_"+key).html(value);
						$("#updatetimeforuser_"+key).html(timetoupdate);		
								
					});
					
					var prepandarrayset = res.total_back_array_flip;					
					Object.entries(prepandarrayset).forEach(([keyf, value]) => {
						var timearraysetflip = res.total_back_array_flip_time;
						var timetoupdateflip = timearraysetflip[keyf];


						var timearrayset = res.total_back_array_flip_time_new;
						var timetoupdate = timearrayset[keyf];
						
						var usernameset = res.username;
						var namearray = usernameset[keyf];
						var name = namearray.UserName;
						
						var $selfstart = $("#"+keyf);
						
						var checkattrvalue = $selfstart.attr('data-last-time');
						if(checkattrvalue != timetoupdateflip){
							$selfstart.attr('data-last-time',timetoupdateflip);
							$selfstart.parent().prepend($groupchatli,[$selfstart]);
						}
						$checkuser = $selfstart;
						if($checkuser.length <= '0'){
							
							buildnewli(namearray.UserName,namearray.employee_id,'adminlocal',timetoupdate,timetoupdateflip,value)
						}
					});
					
				}
  



				if(res.total_front > '0'){				
			
					var myObjectnew = res.total_front_array;
					Object.entries(myObjectnew).forEach(([keyc, value]) => {
						var timearrayset = res.total_front_time;
						var timetoupdate = timearrayset[keyc];
						$("#frontuserlabel_"+keyc).html(value);
						$("#updatetimeforfrontuser_"+keyc).html(timetoupdate);		
								
					});
					
					var prepandarraysetnew = res.total_front_array_flip;					
					Object.entries(prepandarraysetnew).forEach(([keytf, value]) => {
						var timearraysetflip = res.total_front_array_flip_time;
						var timetoupdateflip = timearraysetflip[keytf];

						//console.log("front - "+keytf);
						
						var timearrayset = res.total_front_array_flip_time_new;
						var timetoupdate = timearrayset[keytf];
						
						var usernameset = res.username_front;
						var namearray = usernameset[keytf];

						
						var $selfstart = $("#"+keytf);
						var checkattrvalue = $selfstart.attr('data-last-time');
						if(checkattrvalue != timetoupdateflip){
							$selfstart.attr('data-last-time',timetoupdateflip);
							$selfstart.parent().prepend($selfstart);
						}
						$checkuser = $selfstart;
						if($checkuser.length <= '0'){
							frontuserbuild(namearray.c_name,namearray.id,'visitor',timetoupdate,timetoupdateflip,value,namearray.c_phone,namearray.ipaddress,namearray.b_name)
						}
					});
					
				}
				

				
					
			}
		});
	}



	$("#submitmsg").on('click',function () {
		submitchat();
	});
	$(".showchatwindow").on('click',function (e) {
		var dataid = $(this).attr('data-id');
		var datname = $(this).attr('data-name');
		var dattype = $(this).attr('data-type');
		var $self = $(this);
		$('.showchatwindow').removeClass('bg-light-primary');	
		
		$self.addClass('bg-light-primary');
		searchuserchat(dataid,datname,dattype,$self);
	});

	function callfunction(selfvar){
		var dataid = $(selfvar).attr('data-id');
		var datname = $(selfvar).attr('data-name');
		var dattype = $(selfvar).attr('data-type');
		var $self = $(selfvar);
		$('.showchatwindow').removeClass('bg-light-primary');	
		
		$self.addClass('bg-light-primary');
		searchuserchat(dataid,datname,dattype,$self);
	}
	function buildnewli(name,id,datatype,time,timetostr,unreadvalue){
		var imageset = "<?=site_url('/').'assets/avatar.png';?>";
		var header = name;
		var setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'+header.charAt(0)+'</span>';
		var htmltoshow = '<div class="d-flex flex-stack py-4 cursor-pointer bg-hover-light-primary px-1 mt-comment showchatwindow" onclick="return callfunction(this)" id="userli_'+id+'" data-last-time="'+timetostr+'" data-id="'+id+'" data-type="'+datatype+'" data-name="'+name+'" ><div class="d-flex align-items-center"><div class="symbol symbol-45px symbol-circle">'+setimage+'<div class="symbol-badge bg-danger start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2 loginlable" id="useronline_'+id+'"></div></div><div class="ms-5"><span class="fs-6 fw-bolder text-gray-900 text-hover-primary">'+name+'</span></div></div><div class="d-flex flex-column align-items-end ms-2"><span class="text-muted fs-8 mb-1" id="updatetimeforuser_'+id+'">'+time+'</span><span class="badge badge-sm badge-light-danger" id="userlabel_'+id+'">'+unreadvalue+'</span></div></div>';
									
		$(".admincomments div.showchatwindow:first-child").after(htmltoshow);
		
	}

	function frontuserbuild(name,id,datatype,time,timetostr,unreadvalue,phone,ip,b_name){
		var header = name;
		var setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'+header.charAt(0)+'</span>';
		
		var htmltoshow = '<div class="d-flex flex-stack py-4 cursor-pointer bg-hover-light-primary px-1 mt-comment showchatwindow" onclick="return callfunction(this)" id="frontuserli_'+id+'" data-last-time="'+timetostr+'" id="frontuserli_'+id+'" data-id="'+id+'" data-type="visitor" data-name="<b>'+name+' ( '+b_name+' )</b>" ><div class="d-flex align-items-center"><div class="symbol symbol-45px symbol-circle">'+setimage+'<div class="symbol-badge bg-danger start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2 loginlable" id="userfrontonline_'+id+'"></div></div><div class="ms-5"><span class="fs-6 fw-bolder text-gray-900 text-hover-primary mt-comment-author">'+name+'</span><div class="fw-bold text-muted fs-7"><b>( '+b_name+' )</b><br><b>P: </b> +'+phone+' <br> <b>IP:</b> '+ip+'</div></div></div><div class="d-flex flex-column align-items-end ms-2"><span class="text-muted fs-8 mb-1 mt-comment-date" id="updatetimeforfrontuser_'+id+'">'+time+'</span><span class="badge badge-sm badge-danger" id="frontuserlabel_'+id+'">'+unreadvalue+'</span></div></div>';

		$(".frontcomments").prepend(htmltoshow);
	}

	

	function searchuserchat($id,$name,$type,$self) {
		showloader=true;
		setgroupchatInterval(false);
		setonetooneInterval(false);

		$("#loadedchat").val($id);
		$("#loadedchattype").val($type);
		if($id == 'Groupchat') {
			setonetooneInterval(false);
			$("#searchwindow").val('');	
			$("#chatbody .caption-subject").html($name);
			loadLog("0");
			setgroupchatInterval(true);
			//setTimeout(setgroupchatInterval(true),500);
			return false;
		}
		else {
			setgroupchatInterval(false);
			$("#chatbody .caption-subject").html($name);
			if($type == 'visitor') {
				
				var urltogo = '<?=$admin_link_chat.'/chat'?>/loadsvisitorchat/200';
			}
			else {
				var urltogo = '<?=$admin_link_chat.'/chat'?>/loadlocalonetoone/20';
			}
		}		
		var myDiv = document.getElementById("chatbox");
		var oldscrollHeight = myDiv.scrollHeight;
		var lastid = 0;		
		$.ajax({
			url: urltogo,
			type:'POST',
			data: {'lastid':lastid,'receiver_id':$id,'loadedchattype':$type},
			cache:false,
			success: function (response) {
				
				
				if($type == 'visitor') {
					$('#frontuserlabel_'+$id).html('');
				}
				else {
					$('#userlabel_'+$id).html('');
				}
				
				
				const res = JSON.parse(response);			
				$("#chatbox").html(res.html);
				var newscrollHeight = myDiv.scrollHeight;
				if(newscrollHeight > oldscrollHeight){
					myDiv.scrollTop = myDiv.scrollHeight;
				}
				$("#searchwindow").val('');
				setonetooneInterval(true);			  
			}
		});
	}

	function loadonetooneLog() {
		var checkinputsearch = $("#searchwindow").val().trim();
		if(checkinputsearch != '') {return false;}
		var myDiv = document.getElementById("chatbox");
		var oldscrollHeight = myDiv.scrollHeight;
		var $id = $("#loadedchat").val();
		var $type = $("#loadedchattype").val();
		var lastid = $("div.chatsline").last().attr('data-id');
		var urltogo = '<?=$admin_link_chat.'/chat'?>/loadlocalonetoone/20';
		var $self = $("#userli_"+$id);
		var $updatetime = $("#updatetimeforuser_"+$id);
		if($type == "visitor"){
			$self = $("#frontuserli_"+$id);
			$updatetime = $("#updatetimeforfrontuser_"+$id);
			urltogo = '<?=$admin_link_chat.'/chat'?>/loadsvisitorchat/200';
		}
		$.ajax({
			url: urltogo,
			type:'POST',
			data: {'lastid':lastid,'receiver_id':$id,'loadedchattype':$type},
			cache:false,
			global: false,
			success: function (response) {
				const res = JSON.parse(response);			
				if(res.html != ''){
					
					var $groupchatli = $("#groupchatli");
					$("#chatbox").append(res.html);
					$updatetime.html(res.lasttime);
					if($type == "visitor"){
						$self.parent().prepend($self);
					}
					else {
						$self.parent().prepend($groupchatli,[$self ]);
					}					
					var newscrollHeight = myDiv.scrollHeight;
					if(newscrollHeight > oldscrollHeight){
						myDiv.scrollTop = myDiv.scrollHeight;
					} 
				}				  
			}
		});
	}

	$('#contentmsg').on('keypress',function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			submitchat();
		}
	});
	function submitchat(){
		var clientmsg = $("#contentmsg").val();
		var loadedchat = $("#loadedchat").val();
		var loadedchattype = $("#loadedchattype").val();
		var urltogo = '<?=$admin_link_chat.'/chat'?>/localchatpost';
		if(loadedchattype == 'visitor') {urltogo = '<?=$admin_link_chat.'/chat'?>/visitorchatpost';}

		$.ajax({
			url: urltogo,
			type:'POST',
			data: { 'text':clientmsg,'loadedchat':loadedchat,'loadedchattype':loadedchattype},
			cache:false,
			global: false,
			success: function (response) {
								  
			}
		});
		
		//$.post(urltogo, { 'text':clientmsg,'loadedchat':loadedchat,'loadedchattype':loadedchattype});
		$("#contentmsg").val("");
		return false;
	}

	$(".submitsearch").on('click',function () {
		searchchat();
	});

	$('.input-circle').on('keypress',function(event){		
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			
			searchchat();
		}
	});


	$('.input-circle-users').on('keypress',function(event){		
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			
			searchuserschat();
		}
	});

	$(".submitsearchusers").on('click',function () {
		searchuserschat();
	});

	function searchuserschat(){
		$("#loader").show();
		var checktabs = $("#activetab").val();
		
		var testname = $("#searchusers").val().trim();
		var searchname = testname.toUpperCase();

		if($(".submitsearchusers").hasClass('removesearchusers')){
			$(".submitsearchusers").toggleClass("fa-search fa-times removesearchusers");
			searchname = '';
			$("#searchusers").val('');		
		}
		else {
			$(".submitsearchusers").toggleClass("fa-times removesearchusers fa-search");			
		}
		$("#searchusers").toggleClass("removesearchinout");
		
		if(checktabs == "admin") {
			var namesarray = [<?php echo $namesarray;?>];
			var idssarray = [<?php echo $idssarray;?>];			
			var arr = [];
			var arr2 = [];
			let filtered = namesarray.filter(namesarray => namesarray.includes(searchname));
			$(".admincomments div.showchatwindow").attr('style', 'display: none !important;');
			if(searchname == ''){
				$(".admincomments div.showchatwindow").removeAttr('style');
			}
			arr2 = jQuery.map( filtered, function( n, i ) {
				var checkidsindex = namesarray.indexOf(n.toUpperCase());
				var idtoshow = "#userli_"+idssarray[checkidsindex];
				$(idtoshow).removeAttr('style');
			});
		}
		else {
			var namesarray = [<?php echo $f_namesarray;?>];
			var idssarray = [<?php echo $f_idssarray;?>];
			var arr = [];
			var arr2 = [];
			let filtered = namesarray.filter(namesarray => namesarray.includes(searchname));
			$(".frontcomments div.showchatwindow").attr('style', 'display: none !important;');
			if(searchname == ''){
				$(".frontcomments div.showchatwindow").removeAttr('style');
			}
			arr2 = jQuery.map( filtered, function( n, i ) {
				var checkidsindex = namesarray.indexOf(n.toUpperCase());
				var idtoshow = "#frontuserli_"+idssarray[checkidsindex];
				$(idtoshow).removeAttr('style');
			});
			
		}

		setTimeout($("#loader").hide(),500);
		
	}

	

	function removechat() {

		$(".iconsubmit").toggleClass("fa fa-search submitsearch fa fa-times removesearch");
		$(".iconsubmittext").toggleClass("input-circle removesearchinout");
		var myDiv = document.getElementById("chatbox");
		var oldscrollHeight = myDiv.scrollHeight;
		var lastid = '0';
		var loadedchat = $("#loadedchat").val();
		var loadedchattype = $("#loadedchattype").val();
		var urltogo = '<?=$admin_link_chat.'/chat'?>/loadlocalonetoone/20';
		if(loadedchattype == 'visitor'){
			urltogo = '<?=$admin_link_chat.'/chat'?>/loadsvisitorchat/200';
		}
		
		var senddata = {"lastid":lastid,"receiver_id":loadedchat,"loadedchattype":loadedchattype};
		if(loadedchat == 'Groupchat') {
			urltogo = '<?=$admin_link_chat.'/chat'?>/loadlocalchat/20';
			senddata = {"lastid":'+lastid+'};
		}		
		$.ajax({
			url: urltogo,
			type:'POST',
			data: senddata,
			cache:false,
			success: function (response) {
				const res = JSON.parse(response);			
				if(res.html != ''){
					$("#chatbox").html(res.html);
					var newscrollHeight = myDiv.scrollHeight;
					if(newscrollHeight > oldscrollHeight){
						myDiv.scrollTop = myDiv.scrollHeight;
					}
					$("#searchwindow").val('');
				}				  
			}
		});
	}

	function searchchat(){

		if($(".iconsubmit").hasClass('removesearch')){removechat();return false;}
		var checkinputsearch = $("#searchwindow").val().trim();
		$(".iconsubmit").toggleClass("fa fa-times removesearch fa fa-search submitsearch");
		$(".iconsubmittext").toggleClass("removesearchinout input-circle");
		var myDiv = document.getElementById("chatbox");
		var oldscrollHeight = myDiv.scrollHeight;

		var loadedchat = $("#loadedchat").val();
		var loadedchattype = $("#loadedchattype").val();
		var urltogo = '<?=$admin_link_chat.'/chat'?>/searchcontent';
		if(loadedchattype == 'visitor'){
			urltogo = '<?=$admin_link_chat.'/chat'?>/searchcontentvisitor';
		}
		$.ajax({
			url: urltogo,
			type:'POST',
			data: {'checkinputsearch':checkinputsearch,'loadedchat':loadedchat,'loadedchattype':loadedchattype},
			cache:false,
			success: function (response) {
				const res = JSON.parse(response);
				$("#chatbox").html(res.html);
				var newscrollHeight = myDiv.scrollHeight;
				if(newscrollHeight > oldscrollHeight){
					myDiv.scrollTop = myDiv.scrollHeight;
				} 				  
			}
		});
	}
	


</script>
