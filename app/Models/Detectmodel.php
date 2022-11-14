<?php

namespace App\Models; 

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class Detectmodel extends Model {
	

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    } 

function get_ip() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}

   
function nearmebranch($lat,$long){ 
    
    
    $gcompound = $this->get_compound($lat,$long);
    
    $curloc = trim($gcompound[1]);
    $curloc2 = trim($gcompound[2]);
    $curloc3 = trim($gcompound[3]);
    
    if($curloc3 == 'USA') {
        $curloc = $curloc2;
        $curloc2 = $curloc3;
    }
    
    if ($curloc2 == 'Canada' OR $curloc2 == 'Russia' OR $curloc2 == 'Germany') {
        $curloc = $curloc2;    
    }
   

    
    $db      = \Config\Database::connect();
    $builder = $db->table('branches');
    $query = $builder->get();
    $result = $query->getResult();
    
    $branches =json_decode(json_encode($result),true);
    
    $new_branches =array();
    foreach ($branches as $key=>$branch)
    	{
    		$branch_location = explode(",", $branch['gps']);
    		
    		
    		
    		$compound1 = $branch['city'];
    		$compound2 = $branch['reg'];
    		
    	
    	
    		
    		if ($compound2 == 'Canada' OR $compound2 == 'Russia' OR $compound2 == 'Germany') {
    		    
    		    $branch['compound']=$compound2;
    		    
    		} else {
    		    $branch['compound']=$compound1;
    		}
    		
    		
    	
    		
    	
    		
    		if($curloc == $branch['compound']) {
        		array_push($new_branches,$branch);
    		}
    	}

    
    
    if ($new_branches) {} else {
        
        
        foreach ($branches as $key=>$branch)
    	{
    		$branch_location = explode(",", $branch['gps']);
 
    		
    		$branch['compound']=$branch['city'];
    		
    	
    		if ($curloc2 == 'USA') {
    		
    		    if($branch['rm'] == 1 AND $branch['region_id'] == 14) {
        		    array_push($new_branches,$branch);
        		}
    		    
    		    
    		} else {
    		
    		if($branch['rm'] == 1 AND $branch['region_id'] <> 14) {
    		array_push($new_branches,$branch);
    		}}
    	}
        
        
        
        
        
        
    }
    
    

    
if ($new_branches) {        
  foreach ($new_branches as $key=>$branch)
    	{
    	    
    		$branch_location = explode(",", $branch['gps']);
    		$a = $lat - $branch_location[0];
    		$b = $long - $branch_location[1];
    		$distance = sqrt(($a**2) + ($b**2));
    		$distances[$key] = $distance;
    	    
    	}
    	# Get The Closest Branch
    	asort($distances);

    	$closest = $new_branches[key($distances)]; 
		
		 }
		

	    $datam['compound'] = $gcompound;
	    $datam['closest'] = $closest;
		
	   return $datam; 
            
    
    
}



function get_compound($lat,$long) {
    
            
       
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($long).'&sensor=false&key=AIzaSyAaKj99IELHH4tjVKjo05MJ6FjcF43-9u8');
            $output = json_decode($geocodeFromLatLong);
            $compound = explode(',',$output->plus_code->compound_code);

            return $compound;
            
}


function get_compound_by_zip($zip) {
    
    
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $zip . '&sensor=true&key=AIzaSyAaKj99IELHH4tjVKjo05MJ6FjcF43-9u8');
            $output = json_decode($geocodeFromLatLong);
            

    return $output;
}


function ziptobranch($zip) { 
    
    $db = \Config\Database::connect();
    $builder = $db->table('branches');
    
    $query  = $builder->get();
	$output = $query->getResult();
	
	foreach ($output as $item) {
	    
	    if ($item->zipranges) {
	        
	        $exs = explode(',',$item->zipranges);
	        
	        foreach ($exs as $key=>$ex) {
	            
	            if (strpos($ex, '-')) {
	                
	                
	                $exs[$key] = range(explode('-',$ex)[0],explode('-',$ex)[1]); 
	                
	                
	            }
	            
	            if ($ex == $zip) { return $item; } else 
	            if (is_array($exs[$key]) == 1 AND in_array($zip, $exs[$key])) { return $item; } 
  
	            
	        }

	        
	    }
	    
	    
	}
	
	
	

    
    }

		
function counter () {
    
    $db = \Config\Database::connect();
        $builder = $db->table('visitors');
        $builder->where('id', 1);
        $item = $builder->get()->getRow()->count+1;
	    $builder->set('count',$item);
	    $builder->update();
    
    
}


function allvisitors ($ip,$lat,$long,$nearmebranch) {
    
    $latlong=$lat.','.$long;
    $branch = $nearmebranch['closest']['name'];
    
    
   // echo '<pre>';print_r($nearmebranch);
    
    $db = \Config\Database::connect();
    $builder = $db->table('allvisitors');
    
    $builder->set('ip', $ip);
    $builder->set('latlong', $latlong);
    $builder->set('time', time());
    $builder->set('branch', $branch);
    $builder->set('status', 0);
    $builder->set('compound', implode(" | ",$nearmebranch['compound']));
    
    $builder->insert();   
    
    
}



		
					
}



/* End of file super_admin_model.php */
/* Location: ./system/application/models/super_admin_model.php */
?>
