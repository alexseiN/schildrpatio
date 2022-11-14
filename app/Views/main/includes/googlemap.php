  <?php
  
  $lat=$_POST['lat'];
		  $long=$_POST['lon'];
		
		 $branches = Array(
    		0 => Array(
    			'id' => 15,
    	        'name' => 'NEW JERSEY OFFICE',
    	        'gps' => '41.0233904, -74.16409',
    		),
    		1 => Array(
    			'id' => 14,
    	        'name' => 'NEW YORK OFFICE',
    	        'gps' => '40.7038704, -74.0138541',
    		),
    		2 => Array(
    			'id' => 23,
    			'name' => 'CALIFORNIA OFFICE',
    			'gps' => '35.71506343775428, -119.9013308375'
    		),
    		3 => Array(
    			'id' => 16,
    			'name' => 'SCHILDR MASSACHUSETTS',
    			'gps' => '42.4072107, -71.3824374'
    		),
    		4 => Array(
    			'id' => 17,
    			'name' => 'TEXAS OFFICE',
    			'gps' => '31.9685988, -99.9018131'
    		),
    		5 => Array(
    			'id' => 13,
    			'name' => 'SCHILDR YAPI L力M力TED',
    			'gps' => '41.0082376, 28.9783589'
    		),
    		6 => Array(
    			'id' => 18,
    			'name' => 'UK OFFICE',
    			'gps' => '51.4944043, -0.1140718'
    		),
    		7 => Array(
    			'id' => 19,
    			'name' => 'RUSSIA OFFICE',
    			'gps' => '55.743459567680645, 37.589834079687485'
    		),
    		8 => Array(
    			'id' => 21,
    			'name' => 'Glass Construction',
    			'gps' => '40.40926169999999, 49.8670924'
    		),
    		9 => Array(
    			'id' => 22,
    			'name' => 'CANADA OFFICE',
    			'gps' => '43.6627132, -79.5929742'
    		),
    		10 => Array(
    			'id' => 24,
    			'name' => 'NORHT CAROLINA OFFICE',
    			'gps' => '35.0868297, -80.67281'
    		),
    		11 => Array(
    			'id' => 25,
    			'name' => 'MASSACHUSETTS OFFICE',
    			'gps' => '41.6409895, -70.9272335'
    		),
    	);
		
		foreach ($branches as $key => $branch)
    	{
    		$branch_location = explode(",", $branch['gps']);
    		$a = $lat - $branch_location[0];
    		$b = $long - $branch_location[1];
    		$distance = sqrt(($a**2) + ($b**2));
    		$distances[$key] = $distance;
    	}
    	# Get The Closest Branch
    	asort($distances);
    	$key = key($distances);
    	$closest = $branches[key($distances)];
		echo	$closest['name'];
		
		
		?>