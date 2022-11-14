<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
	    <?=$chathtml?>
	</div>
    </div>
</div>
<script>
<?php if($is_view) { ?>
    var myDiv = document.getElementById("chatbox");
    var oldscrollHeight = myDiv.scrollHeight;
    myDiv.scrollTop = myDiv.scrollHeight;
<?php } ?>
$(".submitsearch").on('click',function () {
	searchchat();
});

$('.input-circle').on('keypress',function(event){		
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		
		searchchat();
	}
});

function searchchat(){

    if($(".iconsubmit").hasClass('removesearch')){removechat();return false;}
    var checkinputsearch = $("#searchwindow").val().trim();
    $(".iconsubmit").toggleClass("fa fa-times removesearch fa fa-search submitsearch");
    $(".iconsubmittext").toggleClass("removesearchinout input-circle");
    
    var myDiv = document.getElementById("chatbox");
    var oldscrollHeight = myDiv.scrollHeight;
    var loadedchat = $("#loadedchat").val();
    var loadedchattype = $("#loadedchattype").val();
    var urltogo = '<?=$admin_link."/chat";?>/searchcontentvisitor';
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

function removechat() {
    
    $(".iconsubmit").toggleClass("fa fa-search submitsearch fa fa-times removesearch");
    $(".iconsubmittext").toggleClass("input-circle removesearchinout");
    var myDiv = document.getElementById("chatbox");
    var oldscrollHeight = myDiv.scrollHeight;
    var lastid = '0';
    var loadedchat = $("#loadedchat").val();
    var loadedchattype = $("#loadedchattype").val();
    var urltogo = '<?= $_cancel;?>/messages/'+loadedchat;    
    var senddata = {"lastid":lastid,"receiver_id":loadedchat,"loadedchattype":loadedchattype,"is_ajax":"yes"};
	
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


</script>
