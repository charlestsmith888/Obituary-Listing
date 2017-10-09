
        
        jQuery("#custom_fields_address").geocomplete()
          .bind("geocode:result", function(event, result){
              
            console.log(result.formatted_address);
              jQuery('#logger').html('LOG : '+result.formatted_address);

            // jQuery.log("Result: " + result.formatted_address);
            


          })
          .bind("geocode:error", function(event, status){
            // jQuery.log("ERROR: " + status);
          })
          .bind("geocode:multiple", function(event, results){
            // jQuery.log("Multiple: " + results.length + " results found");
          });
        
        jQuery("#find").click(function(){
          jQuery("#custom_fields_address").trigger("geocode");
        });
        
    
 