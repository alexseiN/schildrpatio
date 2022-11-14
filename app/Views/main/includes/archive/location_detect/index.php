<!doctype html>
<html class="no-js" lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            
    </head>
    <body onload="abc();">
			<label><b>Latitude:</b> 		<span id="Latitude"></span></label><br/>
			<label><b>Longitude:</b> 		<span id="Longitude"></span></label><br/>
			<label><b>Country:</b> 			<span id="Country"></span></label><br/>
			<label><b>City:</b> 			<span id="City"></span></label><br/>
			<label><b>Address:</b> 			<span id="Address"></span></label><br/>
			<label><b>Zipcode:</b> 			<span id="Zipcode"></span></label><br/>
			<label><b>Nearest Branch Database:</b> 			<span id="nearbranch"></span></label><br/>
   </body>

<script type="text/javascript">

    var getIPAddress = function() {
     
    // document.getElementById("demo4").innerHTML = data.geoplugin_request;
		$.getJSON('https://ipapi.co/json/', function(data) {
  console.log(JSON.stringify(data, null, 2));
 



});
};


    var getIPAddress1 = function() {
     
    // document.getElementById("demo4").innerHTML = data.geoplugin_request;
		$.getJSON('https://ipapi.co/json/', function(data) {
  console.log(JSON.stringify(data, null, 2));
		 var lat = data.latitude;
		var lon = data.longitude;	
		showPositionip(lat,lon);

});
};
function getLocation() {
	
	navigator.geolocation.getCurrentPosition(function(position) {
    navigator.geolocation.getCurrentPosition(showPosition);
}, function() {
    getIPAddress1();
});
	
    if (navigator.geolocation) {
        
    } else {
		
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}


function showPosition(position)
{
	 var lat = position.coords.latitude;
		var lon = position.coords.longitude;
		
		 var ur = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lon+"&key=AIzaSyBsz0EDlBgVm2_sR8C2EAOc15dCnZMDp7A";
			$.getJSON(ur, function(data) {
				var formatted_addressformatted_addressformatted_addressformatted_addressformatted_address=data.results[0].formatted_address;
				var resultArray=data.results[0].address_components;
				  for (var i = 0; i < resultArray.length; i++) {
              if ( resultArray[ i ].types[0] && 'locality' === resultArray[ i ].types[0] ) {
                var citi = resultArray[ i ].long_name;
               
				$("#City").html(citi);
				$("#Address").html(data.results[0].formatted_address);
				$('#Latitude').html(position.coords.latitude);
				$('#Longitude').html(position.coords.longitude);
				
              }
			   if ( resultArray[ i ].types[0] && 'country' === resultArray[ i ].types[0] ) {
				    var country = resultArray[ i ].long_name;
				   $('#Country').html(country);
			   }
			   
			   if ( resultArray[ i ].types[0] && 'postal_code' === resultArray[ i ].types[0] ) {
				   zipcode = resultArray[ i ].long_name;
               // zipcodefinal.value = zipcode;
				$("#Zipcode").html(zipcode);
			   }
			   
			   
			 
			   
		
			}
			
});

checknearestbranch(lat,lon);		   		

}






function showPositionip(lat,lon)
{
	 var lat = lat;
		var lon = lon;
		
		 var ur = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lon+"&key=AIzaSyBsz0EDlBgVm2_sR8C2EAOc15dCnZMDp7A";
			$.getJSON(ur, function(data) {
				var formatted_addressformatted_addressformatted_addressformatted_addressformatted_address=data.results[0].formatted_address;
				var resultArray=data.results[0].address_components;
				  for (var i = 0; i < resultArray.length; i++) {
              if ( resultArray[ i ].types[0] && 'locality' === resultArray[ i ].types[0] ) {
                var citi = resultArray[ i ].long_name;
               
				$("#City").html(citi);
				$("#Address").html(data.results[0].formatted_address);
				$('#Latitude').html(lat);
				$('#Longitude').html(lon);
				
              }
			   if ( resultArray[ i ].types[0] && 'country' === resultArray[ i ].types[0] ) {
				    var country = resultArray[ i ].long_name;
				   $('#Country').html(country);
			   }
			   
			   if ( resultArray[ i ].types[0] && 'postal_code' === resultArray[ i ].types[0] ) {
				   zipcode = resultArray[ i ].long_name;
               // zipcodefinal.value = zipcode;
				$("#Zipcode").html(zipcode);
			   }
			   
			   
			 
			   
		
			}
			
});

checknearestbranch(lat,lon);		   		

}

	function abc()
	{
		
		getIPAddress();
    getLocation();

	}
	
	function checknearestbranch(lat,lon)
	{
		
				$.ajax({
                type: "POST",
                url: "googlemap.php",
				data:{'lat':lat,'lon':lon},
				success: function(response) {
					$("#nearbranch").html(response);
						}
				});	
	
	}
	

  </script>
</html>
