$( document ).ready(function() {
	var close = false;
    $( ".twitch-close-botton" ).click(function() {
      
   	  if(!close)
   	  {  	  		
	  	$( ".twitch-container" ).animate({
		    right: "-856px"		    
		  }, 1500 );	  	  
		  close = true;	


   	  }
   	  else
   	  {
   	  	  $( ".twitch-container" ).animate({
		    right: "0"		    
		  }, 1500 );
		  close = false;
   	  }
      	  
	});   	
});