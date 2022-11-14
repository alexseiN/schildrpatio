<script>

// check for Geolocation support
if (navigator.geolocation) {
  console.log('Geolocation is supported2!');
}
else {
  console.log('Geolocation is not supported for this Browser/OS.');
}


window.onload = function() {
  var startPos;
  var items = [];
  var geoSuccess = function(position) {
    startPos = position;

    lat = startPos.coords.latitude;
    lon = startPos.coords.longitude;
    
    items.push(lat,lon);
    
    var ur = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lon+"&key=AIzaSyBsz0EDlBgVm2_sR8C2EAOc15dCnZMDp7A";
			$.getJSON(ur, function(data) {
			    
			    
			  
				
				var resultArray=data.results[0].address_components;
				  for (var i = 0; i < resultArray.length; i++) {
                    if ( resultArray[ i ].types[0] && 'locality' === resultArray[ i ].types[0] ) {
                    var citi = resultArray[ i ].long_name;
               
				items.push(citi);
				items.push(data.results[0].formatted_address);
				
				
              }
			   if ( resultArray[ i ].types[0] && 'country' === resultArray[ i ].types[0] ) {
				    var country = resultArray[ i ].long_name;
				    items.push(country);
			   }
			   
			   if ( resultArray[ i ].types[0] && 'postal_code' === resultArray[ i ].types[0] ) {
				   zipcode = resultArray[ i ].long_name;
				   
				   items.push(zipcode);
               
				
			   }
			   
			   
			 
			   
		
			}
			
});
    
    

    
    $.ajax({
                type: "POST",
                url: "/thisbranch/detectbranch",
                
                
				data:{lat:lat,lon:lon},
				success: function(data) {
					console.log(data);
						}
				});	
    
    
  };
  navigator.geolocation.getCurrentPosition(geoSuccess);
};




</script>