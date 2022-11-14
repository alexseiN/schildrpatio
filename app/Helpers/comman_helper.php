<?php
use App\Models\CommanModel;


function create_PDF($html){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/thirdparty/tcpdf_min/tcpdf.php';
    $obj_pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    //$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $obj_pdf->SetFooterMargin(1);    
    $obj_pdf->SetPrintHeader(false);
    $obj_pdf->SetPrintFooter(false);
    //$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $obj_pdf->SetMargins(5 ,7, 5);
    $obj_pdf->SetAutoPageBreak(TRUE, 7);
    $obj_pdf->SetFont('helvetica', '', 10);
    $obj_pdf->setFontSubsetting(false);
    $obj_pdf->AddPage('L', 'LETTER');
    ob_start();
    $content = $html;  
    ob_end_clean();
    $obj_pdf->writeHTML($content, true, false, true, false, '');
    $filepath = $_SERVER['DOCUMENT_ROOT'].'/assets/invoicePDF/Invoice.pdf';
    $fileatt = $obj_pdf->Output($filepath, 'F');
    return $fileatt;
}


function usw($size,$unit) {
    if($unit == 'inch') {$size = $size/25.4;}
    
    return $size;
} 

function create_PDF_demo($html){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/thirdparty/tcpdf_min/tcpdf.php';
    
    $obj_pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    //$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $obj_pdf->SetFooterMargin(1);    
    $obj_pdf->SetPrintHeader(false);
    $obj_pdf->SetPrintFooter(false);
    //$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $obj_pdf->SetMargins(5 ,7, 5);
    $obj_pdf->SetAutoPageBreak(TRUE, 7);
    $obj_pdf->SetFont('helvetica', '', 10);
    $obj_pdf->setFontSubsetting(false);
    $obj_pdf->AddPage('L', 'LETTER');
    ob_start();
    $content = $html;  
    ob_end_clean();
    $obj_pdf->writeHTML($content, true, false, true, false, '');
    $filepath = $_SERVER['DOCUMENT_ROOT'].'/assets/invoicePDF/Invoice.pdf';
    $fileatt = $obj_pdf->Output($filepath, 'I');
    return $fileatt;
}


function print_count($table,$array=false){
    
    
    $db = \Config\Database::connect();
    $builder = $db->table($table);
       
    $getuserrole = getuserrole();  
    if($getuserrole == 'Region Admin' || $getuserrole == 'Region SubAdmin' || $getuserrole == 'Branch Group Admin'){
	$loadsession = loadsession();
	$totalbranches = $loadsession['totalbranches_region'];
	$totalemployees = $loadsession['totalemployees_region'];
	if($table == 'quotes'){
	    $name = 'branch_id';
	    $adddata = $totalbranches;
	    $builder->whereIn($name,$adddata);
	}
	else if($table == 'setproject'){
	    $name = 'employee';
	    $adddata = $totalemployees;
	    $builder->whereIn($name,$adddata);
	}
	else if($table == 'employees'){
	    $name = 'id';
	    $adddata = $totalemployees;
	    $builder->whereIn($name,$adddata);
	}
	
    }
    else if($getuserrole == 'Branch Group Admin'){
	$loadsession = loadsession();
	$totalbranches = $loadsession['totalbranches_region'];
	$totalemployees = $loadsession['totalemployees_region'];
	if($table == 'quotes'){
	    $name = 'branch_id';
	    $adddata = $totalbranches;
	    $builder->whereIn($name,$adddata);
	}
	else if($table == 'setproject'){
	    $name = 'employee';
	    $adddata = $totalemployees;
	    $builder->whereIn($name,$adddata);
	}
	else if($table == 'employees'){
	    $name = 'id';
	    $adddata = $totalemployees;
	    $builder->whereIn($name,$adddata);
	}
    }
    
    
    
    if($array) {
	$builder->where($array);
    }
    return $builder->countAllResults();
}

function makeUrltoLink($text) {
    $text = strip_tags($text);
    $reg_pattern = "/(((http|https|ftp|ftps)\:\/\/)|(www\.))[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/i";
    return preg_replace($reg_pattern, '<a href="$0" target="_blank" rel="noopener noreferrer">$0</a>', $text);
}

function yoxla($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function branchtime ($time, $diff, $format ) {
        $sec = 0;
        if($diff) {$sec=$diff*3600;}
        
        if ($time) {
        $res = date($format,$time+$sec); } else {$res='';}
        return $res;
    }

function randomstring($limit){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $limit; $i++) {
	    $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



function chtbotautoresponse($languageid = ''){
    $comman_model = new CommanModel();
    if($languageid == 'en') {
	$array = array(
	    "hi"=>"Hello, How may i help you?",
	    "testbot"=>"Testing bot working",
	);
    }
    else if($languageid == 'de') {
	$array = array(
	    "hixxx"=>"Hallo, wie kann ich Ihnen helfen?",
	    "testbot"=>"Testen des Bots",
	);
    }
    else if($languageid == 'tr') {
	$array = array(
	    "selam"=>"Merhaba, Size nasıl yardımcı olabilirim?",
	    "testbot"=>"Test botu çalışıyor",
	);
    }
    else if($languageid == 'gb') {
	$array = array(
	    "hixxx"=>"Hello, How may i help you?",
	    "testbot"=>"Testing bot working",
	);
    }    
    return $array;
}

function timenowzone() {
    helper('date');
    $datetocheck = date("Y-m-d H:i:s",now('Asia/Baku'));
    return $datetocheck;
}
function datetoday() {
    helper('date');
    $datetocheck = date("Y-m-d",now('Asia/Baku'));
    return $datetocheck;
}

function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while( $current <= $last ) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }

    return $dates;
}

function create_select($name,$event,$optiondata,$condition,$selectelementid = ''){
    $html = '<select class="form-control" name="'.$name.'" onchange="'.$event.'">';
    $html .= '<option value="">Select</option>';
    foreach($optiondata as $key=>$option){
	$selected = '';
	if($selectelementid == $key){
	    $selected = 'selected';
	}
	if(count($condition)>0){
	    if(in_array($key,$condition)){
		$html .= '<option value="'.$key.'" '.$selected.'>'.$option.'</option>';
	    }
	}
	else {
	    $html .= '<option value="'.$key.'" '.$selected.'>'.$option.'</option>';
	}	
    }
    $html .= '</select>';
    return $html;
}

function create_select_options($optiondata){
    $html = '<option value="">Please select</option>';
    foreach($optiondata as $key=>$option){
	$html .= '<option value="'.$key.'">'.$option.'</option>';	
    }
    $html .= '</select>';
    return $html;
}

function getarray($type){
    if($type == "type") {
	$array = array("task"=>"Task","techsupport"=>"Technical support","newidea"=>"New idea","roadmap"=>"Roadmap");
    }
    if($type == "status") {
	$array = array("waiting"=>"Waiting","started"=>"In progress","problem"=>"Problem","discussion"=>"Discussion","urgent"=>"Urgent","completed"=>"Completed");
    }
    return $array;
}

    

    
function updateloginstatus($from,$id) {
    $comman_model = new CommanModel();
    $comman_model->updateloginsts($from,$id);
}


function pp($myArray = array(), $terminate = true) {
    echo '<pre>';
    print_r($myArray);
    echo '</pre>';
    if($terminate) {
	die;
    }
}

function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            //return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
	    return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}


function numberFormat($number){
	return number_format((float)$number, 2, '.', '');
}


function yesno($item) {
    
    if($item == 1) {$result='yes';}
    if($item == 0) {$result='no';}
    
    return $result;
    
}





function sendmail($id,$to,$fields,$return='sales@schildr.com') {
    
			    $comman_model = new CommanModel();
				$email_data = $comman_model->get_by('email',array('id'=>$id),false,false,true);
				
				if ($fields) {
				    foreach ($fields as $key=>$field) {
				
				      $email_data->subject = str_replace('{'.$key.'}', $field, $email_data->subject);
				      $email_data->message = str_replace('{'.$key.'}', $field, $email_data->message);
				    }
				
				}

				$email = \Config\Services::email();
				
        
                $email->setFrom($return, 'Schildr Information Center',$return);
                $email->setTo($to); 
                
               
                
                $email->setSubject($email_data->subject);
                $email->setMessage($email_data->message);
                
                
                		
				 if ($email->send()) 
		{
            return true;
        } 
		else 
		{
           return false;
        }

}

function sendmail2($id,$to,$fields,$return,$is_attach=false,$attachdata = '') {    
    $comman_model = new CommanModel();
    $email_data = $comman_model->get_by('email',array('id'=>$id),false,false,true);
    if ($fields) {
	foreach ($fields as $key=>$field) {
	    $email_data->subject = str_replace('{'.$key.'}', $field, $email_data->subject);
	    $email_data->message = str_replace('{'.$key.'}', $field, $email_data->message);
	}
    }

    $senddata = $email_data->message;
    //$senddata .= $attachdata;
    
    $email = \Config\Services::email();
    $email->setFrom($return, 'Schildr Information Center',$return);
    $email->setTo($to); 
    $email->setSubject($email_data->subject);
    $email->setMessage($senddata);

    if($is_attach){
	$email->attach($attachdata);
    }

    if ($email->send()){
	return true;
    } 
    else {
	return false;
    }
}

function get_langer($table,$lang,$id){
        $db = \Config\Database::connect(); 
    
		$builder = $db->table($table);
		
		if ($lang) {
		$builder->join($table.'_lang', $table.'.id = '.$table.'_lang.connlang_id');
		$builder->where('language_id', $lang);
		
		}
		
		$builder->where($table.'.id', $id);
		$builder->orderBy('order', 'ASC');
		
		$query  = $builder->get();
	
		$check = $query->getRow();
	
		return $check; 
}


function orinpro($selprods) {
    
    $db = \Config\Database::connect(); 
    
	$builder = $db->table('product');
	$builder->orderBy('order', 'asc');
	$query  = $builder->get();
	$allprods = $query->getResult();
	
	
	$ordering = array();	
    
    foreach($allprods as $prods) {
    foreach($selprods as $key=>$spro) {
        
            
            if ($prods->id == $spro->sproduct) {
                
                $spro->order = $prods->order; 
                
                array_push($ordering,$spro);
                
            }
            
        }
    
        
    }
    
    
    return $ordering;
    
}


function get_table_where($table,$where){ 
        $db = \Config\Database::connect();
    
		$builder = $db->table($table);
		
		$getuserrole = getuserrole();  
    if($getuserrole == 'Region Admin' || $getuserrole == 'Region SubAdmin' || $getuserrole == 'Branch Group Admin'){
	$loadsession = loadsession();
	$totalbranches = $loadsession['totalbranches_region'];
	$totalemployees = $loadsession['totalemployees_region'];
	if($table == 'quotes'){
	    $name = 'branch_id';
	    $adddata = $totalbranches;
	    $builder->whereIn($name,$adddata);
	}
	else if($table == 'setproject'){
	    $name = 'employee';
	    $adddata = $totalemployees;
	    $builder->whereIn($name,$adddata);
	}
	else if($table == 'employees'){
	    $name = 'id';
	    $adddata = $totalemployees;
	    $builder->whereIn($name,$adddata);
	}
	
    }
		
		if ($where) {
		    
		$builder->where($where);
		    
		}
		
		

		
		$query  = $builder->get();
	
		$check = $query->getResult();
	
		return $check; 
}

function get_table_front($table,$where){ 
        $db = \Config\Database::connect();
    
		$builder = $db->table($table);
		
	
		
		if ($where) {
		    
		$builder->where($where);
		    
		}
		
		

		
		$query  = $builder->get();
	
		$check = $query->getResult();
	
		return $check; 
}

function get_emp_by_chat($currentuser){
    $currentsession = \Config\Services::session();
    //pp($currentuser);
    $db = \Config\Database::connect();    
    $buildquery = "select `sender_id`,`receiver_id`,`created_at` from `localontoonechat` where `sender_id` = '".$currentuser."' || `receiver_id` = '".$currentuser."' order by `created_at` DESC";
    $query = $db->query($buildquery);
    $rows_counter = $query->getNumRows();
    $output = array();
    $idsarray = array();
    $timearray = array();
    if($rows_counter>0){
	$resultarray = $query->getResult();	
	foreach($resultarray as $result){
	    $idtocheck = $result->sender_id;
	    if($result->sender_id == $currentuser){
		$idtocheck = $result->receiver_id;
	    }
	    if(!in_array($idtocheck,$idsarray)){
		array_push($idsarray,$idtocheck);
		array_push($timearray,date("d M, H:iA",strtotime($result->created_at)));
	    }
	}
    }
    $output = array("ids"=>$idsarray,"time"=>$timearray);
    
    return $output;
}
    


function sub_langers($table,$lang,$pid){
        $db = \Config\Database::connect();
    
		$builder = $db->table($table);
		$builder->join($table.'_lang', $table.'.id = '.$table.'_lang.connlang_id');
		$builder->where('language_id', $lang);
		$builder->where('parent_id', $pid);
		$builder->where('enabled', 1);
		$builder->orderBy('order', 'ASC');
		
		$query  = $builder->get();
	
		$check = $query->getResult();
	
		return $check; 
}


function langidtocode ($id) {
    $db = \Config\Database::connect();
    $builder = $db->table('language');
    $builder->where('id', $id);
    
    $query  = $builder->get();
    
    return $query->getRow()->code; 
    
}    


function langcodetoid($code) { 
    $db = \Config\Database::connect();
    $builder = $db->table('language');
    $builder->where('code', $code);
    
    $query  = $builder->get();
    
    return $query->getRow()->id; 
    
}  


function morefiles($table,$id) {
    
    $comman = new CommanModel();
	$check = $comman->get_by('files',array('section'=>$table,'connfile_id'=>$id),false,array('order'=>'asc'),false);
	
	return $check;
    
}


function langidtoimg ($id) {
    $db = \Config\Database::connect();
    $builder = $db->table('language');
    $builder->where('id', $id);
    
    $query  = $builder->get();
    
    return $query->getRow()->image; 
    
}







function show_lang_detail($table,$field_val,$id,$lang_id=1,$show=false){
    $string= '';
    $CommanModel = new CommanModel();
    $checkLangCourse = $CommanModel->get_by($table,array($field_val=>$id,'language_id'=>$lang_id),false,false,true);
    if($checkLangCourse){
        if($show){
            $string = $checkLangCourse->$show;
        }
        else{
            $string = $checkLangCourse->title;
        }
    }
    else{
        $checkLangCourse = $CommanModel->get_by($table,array($field_val=>$id),false,false,true);
        if($checkLangCourse){
            if($show){
                $string = $checkLangCourse->$show;
            }
            else{
                $string = $checkLangCourse->title;
            }
        }
    }
    return $string;
}


function show_field_value($lang,$array){
	$CI =& get_instance();
	$comman = new CommanModel();
	$check = $comman->get_lang('field_values',$lang,NULL,$array,'field_value_id',true);
	if($check){
		return $check->title;
	}
	else{
		return '-';
	}
}

function print_lang_value($table,$lang,$array,$field_id,$show){
	$comman = new CommanModel();
	$check = $comman->get_lang($table,$lang,NULL,$array,$field_id,true);
	if($check){
		return $check->$show;
	}
	else{
		return '-';
	}
}


function print_value($table,$array,$show,$default=false,$empty=false){
	$comman = new CommanModel();
	$check = $comman->get_by($table,$array,false,false,true);
	if($check){
		return $check->$show;
	}
	else{
		if($empty){
			return '';
		}
		else if($default)
			return $default;
		else
			return '-';
	}
}



function h_orderNumber2($id,$orderName,$digit){
    $order_number =	$orderName.str_pad($id, $digit, '0', STR_PAD_LEFT);
    return $order_number;
}


function print_count_query($string){
    $db = \Config\Database::connect();
	$result = $db->query($string);
	return $result->getNumRows();
}

