<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
<link rel="stylesheet" href="/assets/main/chat.css?<?=time()?>" />
<div id="chat-circle" class=" btn-raised">
	<i class="fas fa-comment icon-speech"></i>
</div>
<div class="chatbot chatbot--closed ">
	<div class="chatbot__header">
		<p><strong>Got a question?</strong> <span>Ask Us</span></p>
		<i class="fas fa-comment chatbot__close-button icon-speech"></i>
		<i class="fas fa-times chatbot__close-button icon-close"></i>
	</div>
	<div class="chatbot__message-window" id="chatbox">
        <div class="dot"></div>
        <div class="welcomemessage" style="display:none;"><p><strong class='intro'>Hello, Congratulations you can start chat with out support.</strong></p></div>
        <div class="autoask" style="display:none;"><p><strong class='intro'>Hello, Do you need any help?</strong></p></div>
		<ul class="chatbot__messages" >
            <li class="hideli" style="margin-bottom:0px;">
				<p><strong class='intro'>Please enter your details to continue chat with our support.</strong></p>
			</li>
            <li class="hideli" id="formli">
                <div>
                    <form id="contactsupport" name="contactsupport">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your name..">
                        <label for="emailaddress">Email address</label>
                        <input type="email" id="emailaddress" name="emailaddress" placeholder="Your email..">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" placeholder="Your phone..">
                        <button type="button" id="start_chat" class="btn btn-outline-secondary">Start Chat</button>
                    </form>
                </div>
            </li>			
		</ul>
	</div>
	<div class="chatbot__entry chatbot--closed hidechat">
		<input type="text" class="chatbot__input" id="chatbot__input" placeholder="Write a message..." />
		<i class="fas fa-paper-plane chatbot__submit"></i>
	</div>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.1/js.cookie.min.js" integrity="sha512-Meww2sXqNHxI1+5Dyh/9KAtvI9RZSA4c1K2k5iL02oiPO/RH3Q30L3M1albtqMg50u4gRTYdV4EXOQqXEI336A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<audio id="myAudio">
  <source src="/assets/play.wav" type="audio/wav">
  Your browser does not support the audio element.
</audio>
<input type="hidden" id="lastsent"/>
<script type="text/javascript">


var audiocreate = document.getElementById("myAudio"); ;

var heightOutput = '';
var widthOutput = '';
var timer = 0;
var intervaltime = 700;
var loadingdelay = 700;
const baseUrl = "<?=site_url();?>";
const loader = "<span class='loader'><span class='loader__dot'></span><span class='loader__dot'></span><span class='loader__dot'></span></span>";
const $document = document;
const $chatbot = $document.querySelector(".chatbot");
const $chatbotMessageWindow = $document.querySelector(".chatbot__message-window");
const $chatbotHeader = $document.querySelector(".chatbot__header");
const $chatbotMessages = $document.querySelector(".chatbot__messages");
const $chatbotInput = $document.querySelector(".chatbot__input");
const $chatbotSubmit = $document.querySelector(".chatbot__submit");
const $startChat = $document.querySelector("#start_chat");
function reportWindowSize() {
    $(".chatbot").removeClass("heightclass");
    heightOutput = window.innerHeight;
    widthOutput = window.innerWidth;
    var showheight = parseInt(heightOutput)-parseInt(54);
    if(heightOutput<400) {
        
        $(".chatbot").addClass("heightclass");
        
    }
    $('.chatbot__message-window').css('max-height',showheight)
}
window.onresize = reportWindowSize;
reportWindowSize();
function setchatInterval(bool){  
  if(bool){
     timer = setInterval(sendmessage,intervaltime);
  }else{
     clearInterval(timer); 
  }
}
$chatbotHeader.addEventListener("click",() => {
  var element = document.getElementsByClassName("chatbot");
  element[0].style.display = "none";
  document.getElementById("chat-circle").style.display = "block";
  setchatInterval(false);
},false);
document.getElementById("chat-circle").addEventListener("click",() => {
  $(".dot").show();
  var element = document.getElementsByClassName("chatbot");
  element[0].classList.remove("chatbot--closed");
  element[0].style.display = "block";
  $chatbotInput.focus();
  document.getElementById("chat-circle").style.display = "none";
  $(".chatbot__messages").hide();
  $(".welcomemessage").hide();
    <?php if(count($current_visitor)>0) { ?>
        $(".welcomemessage").show();
        $(".hideli").remove();
        $(".chatbot--closed").removeClass('hidechat');
        $("#chatbox ul.chatbot__messages").html('');
        sendmessage();
        setTimeout(function(){ setchatInterval(true);}, intervaltime);     
    <?php } else { ?>
        setTimeout(function(){ $(".dot").hide(); $(".chatbot__messages").show();}, loadingdelay);     
    <?php } ?>
});
$startChat.addEventListener("click",() => {
    $("#contactsupport input").css('border-color','inherit');
    var selectform = $("#contactsupport")
    var name = $("#contactsupport #name").val().trim();
    var emailaddress = $("#contactsupport #emailaddress").val().trim();
    var phone = $("#contactsupport #phone").val().trim();
    var showerror = false;
    if(name == "" && emailaddress == "" && phone == "") {
        $("#contactsupport input").css('border-color','red');
        showerror = true;
    }
    if(name == "") {
        $("#contactsupport #name").css('border-color','red');
        showerror = true;
    }
    if(emailaddress == "") {
        $("#contactsupport #emailaddress").css('border-color','red');
        showerror = true;
    }
    if(phone == "") {
        $("#contactsupport #phone").css('border-color','red');
        showerror = true;
    }

    if(IsEmail(emailaddress)==false){
        $("#contactsupport #emailaddress").css('border-color','red');
        showerror = true;
    }
    
    if(showerror){
        return false;
    }
    // 
    startchat(name,emailaddress,phone);
});
const aiMessage = (content, isLoading, delay = 0) => {
  setTimeout(() => {
    removeLoader();
    $chatbotMessages.innerHTML += "<li class='is-ai animation' id='"+isLoading+"'><div class='is-ai__profile-picture'>          <i class='fas fa-user-tie icon-avatar'></i>        </div>        <span class='chatbot__arrow chatbot__arrow--left'></span>        <div class='chatbot__message'>          "+content+"       </div>      </li>";
    scrollDown();
  }, delay);
};
const removeLoader = () => {
  let loadingElem = document.getElementById("is-loading");
  if (loadingElem) {
    $chatbotMessages.removeChild(loadingElem);
  }
};
const resetInputField = () => {
  $chatbotInput.value = "";
};
const scrollDown = () => {
  const distanceToScroll =
  $chatbotMessageWindow.scrollHeight - (
  $chatbotMessages.lastChild.offsetHeight);
  $chatbotMessageWindow.scrollTop = distanceToScroll;
  return false;
};

$chatbotSubmit.addEventListener("click",event => {
  validateMessage();
},false);

$chatbotInput.addEventListener("keypress",event => {
  if (event.which == 13) {
    validateMessage();
  }
},false);

const validateMessage = () => {
  const text = $chatbotInput.value;
  const safeText = text ? escapeScript(text) : "";
  if (safeText.length && safeText !== " ") {
    sendmessagefront(safeText);
    resetInputField();
  }
  scrollDown();
  return;
};
const escapeScript = unsafe => {
  const safeString = unsafe.
  replace(/</g, " ").
  replace(/>/g, " ").
  replace(/&/g, " ").
  replace(/"/g, " ").
  replace(/\\/, " ").
  replace(/\s+/g, " ");
  return safeString.trim();
};
function sendmessagefront(safeText){
    //setchatInterval(false);
    var AJAXURL = baseUrl+'/home/send_front_chat_insert';
    $.ajax({
        url:AJAXURL,
        method:'POST',
        data:{'text':safeText},
        success:function(res){
            //setchatInterval(true);
            $("#lastsent").val(safeText);
            const responseset = JSON.parse(res);			
            if(responseset.status == 'Success'){
                console.log("sent");
            }
            else {
                alert("Something not right.");
            }
        },
        error:function(xhr, status, error){
            alert("Something not right.");
        }
    });
}

function checkbot(){
    var lastrow = $("#chatbox ul.chatbot__messages li").last();
    var sendercheck = lastrow.attr('data-sender-from');
    if(sendercheck == 'front') {
        //console.log(sendercheck);
    }
    else {
        return false;
    }
    var lastrowtext = lastrow.find('p.chatbot__message').text();
    var AJAXURL = baseUrl+'/home/checkbot';  
    $.ajax({
        url:AJAXURL,
        method:'POST',
        data:{'lastrowtext':lastrowtext},
        success:function(res){
            const resnew = JSON.parse(res);
            var status = resnew.status;
            if(status == 'Success'){
                //console.log("added"); 
            }
            checkforfrontmessage();
            setchatInterval(true);         
        },
        error:function(xhr, status, error){
            console.log("Error");
        }
    });
}

function sendmessage(){
    var lastrow = $("#chatbox ul.chatbot__messages li").last();
    var sendercheck = lastrow.attr('data-sender-from');
    if(sendercheck == 'front') {
        setchatInterval(false);
        checkbot();
    }
    else {
        checkforfrontmessage();
    }
}
function checkforfrontmessage(){
    var AJAXURL = baseUrl+'/home/send_front_chat/200';    
    var myDiv = document.getElementById("chatbox");
    var oldscrollHeight = myDiv.scrollHeight;
    var lastid = $("#chatbox ul.chatbot__messages li").last().attr('data-id');   
    
    $.ajax({
        url:AJAXURL,
        method:'POST',
        data:{'lastid':lastid},
        success:function(res){
            $(".dot").hide();
            $(".chatbot__messages").show();
            const resnew = JSON.parse(res);
            var ids = resnew.data.rows;
            //var lengthget = $("#chatbox ul.chatbot__messages").find('[data-id="755"]').length;
            //if(resnew.data.html != '' && lengthget <= '0'){
            if(resnew.data.html != ''){
                $(".welcomemessage").hide();
                if(ids.length > '0'){
                    for (let i = 0; i < ids.length; i++) {
                        var checkli = $('#front_chat_'+ids[i]).length;
                        //console.log("li = "+ checkli);
                        var lastmessagecome = $("#lastsent").val();
                        if(checkli <= '0') {
                            $("#chatbox ul.chatbot__messages").append(resnew.data.html);

                            var lastlatest = $("#chatbox ul.chatbot__messages li").last().attr('data-sender-from'); 
                            //var checkinnermessage = lastlatest.children('p.chatbot__message').text().trim();
                            //console.log(checkinnermessage);
                            if(lastlatest != 'front' && lastmessagecome != ''){
                                audiocreate.play();
                                setTimeout(function(){ audiocreate.pause();}, 3000);    
                            }
                            
                        }
                    }
                }
                var newscrollHeight = myDiv.scrollHeight;
                if(newscrollHeight > oldscrollHeight){
                    myDiv.scrollTop = myDiv.scrollHeight;
                } 
            }
            
        },
        error:function(xhr, status, error){
            //alert("Something not right.");
        }
    });
}
function startchat(name,emailaddress,phone){
    var AJAXURL = baseUrl+'/home/startchat';	
    $.ajax({
        url:AJAXURL,
        method:'POST',
        data:{'name':name,'emailaddress':emailaddress,'phone':phone},
        success:function(res){
            const response = JSON.parse(res);
            $(".hideli").remove();
            $(".welcomemessage").show();
            $(".chatbot--closed").removeClass('hidechat');
            setchatInterval(true);
        },
        error:function(xhr, status, error){
            alert("Something not right.");
        }
    });
}
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}


$(window).load(function(){
    checkCookie();
});



function setCookie(cname, cvalue, exdays) {
    Cookies.set(cname, cvalue, { expires: exdays });
}
function getCookie(cname) {
    return Cookies.get(cname);
}
function checkCookie() {
    var checkpopup = getCookie('chatpopup');
    console.log(checkpopup);
    if( typeof checkpopup === 'undefined' || checkpopup === null ){
        var checksupportform = $("#contactsupport").length;
        console.log(checksupportform);
        if(checksupportform <= '0'){
            setTimeout(runautoask, 120000);
        }
        else {
            
            setTimeout(function(){

                $(".dot").show();
                var element = document.getElementsByClassName("chatbot");
                element[0].classList.remove("chatbot--closed");
                element[0].style.display = "block";
                $chatbotInput.focus();
                document.getElementById("chat-circle").style.display = "none";
                $(".chatbot__messages").hide();
                $(".welcomemessage").hide();
                $(".autoask").hide();

            
                $(".dot").hide();
                $(".autoask").show();
                setCookie("chatpopup", "yes", 1);
                $(".chatbot__messages").show();
            }, 10000);
        }
    }    
}
function runautoask(){
    $(".dot").show();
    var element = document.getElementsByClassName("chatbot");
    element[0].classList.remove("chatbot--closed");
    element[0].style.display = "block";
    $chatbotInput.focus();
    document.getElementById("chat-circle").style.display = "none";
    $(".chatbot__messages").hide();
    $(".welcomemessage").hide();
    $(".autoask").hide();
    <?php if(count($current_visitor)>0) { ?>
        $(".welcomemessage").show();
        $(".hideli").remove();
        $(".chatbot--closed").removeClass('hidechat');
        $("#chatbox ul.chatbot__messages").html('');
        sendmessage();
        setTimeout(function(){ setchatInterval(true);}, intervaltime);     
    <?php } else { ?>
        $(".dot").hide();
        $(".autoask").show();
        setCookie("chatpopup", "yes", 1);
        $(".chatbot__messages").show();
    <?php } ?>    
}
</script>

<style>
.dot {
    display:none;
  margin:20px auto;
  color:#6d7278;
  width:95px;
  height:40px;
  --d:radial-gradient(farthest-side,currentColor 90%,#0000);
  background:var(--d),var(--d),var(--d),var(--d);
  background-size:20px 20px;
  background-repeat:no-repeat;
  animation: m 1s infinite;
  position:absolute;top:40%;left:34%;
}

@keyframes m {
  0%   {background-position:calc(0*100%/3) 100%, calc(1*100%/3) 100%, calc(2*100%/3) 100%, calc(3*100%/3) 100%}
  12.5%{background-position:calc(0*100%/3) 0   , calc(1*100%/3) 100%, calc(2*100%/3) 100%, calc(3*100%/3) 100%}
  25%  {background-position:calc(0*100%/3) 0   , calc(1*100%/3) 0   , calc(2*100%/3) 100%, calc(3*100%/3) 100%}
  37.5%{background-position:calc(0*100%/3) 0   , calc(1*100%/3) 0   , calc(2*100%/3) 0   , calc(3*100%/3) 100%}
  50%  {background-position:calc(0*100%/3) 0   , calc(1*100%/3) 0   , calc(2*100%/3) 0   , calc(3*100%/3) 0   }
  62.5%{background-position:calc(0*100%/3) 100%, calc(1*100%/3) 0   , calc(2*100%/3) 0   , calc(3*100%/3) 0   }
  75%  {background-position:calc(0*100%/3) 100%, calc(1*100%/3) 100%, calc(2*100%/3) 0   , calc(3*100%/3) 0   }
  87.5%{background-position:calc(0*100%/3) 100%, calc(1*100%/3) 100%, calc(2*100%/3) 100%, calc(3*100%/3) 0   }
  100% {background-position:calc(0*100%/3) 100%, calc(1*100%/3) 100%, calc(2*100%/3) 100%, calc(3*100%/3) 100%}
}
</style>

