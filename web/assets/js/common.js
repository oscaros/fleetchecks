/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteVehicle", function(){
		var vehicleId = $(this).data("vehicleid"),
			hitURL = baseURL + "deleteVehicle",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this vehicle ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { vehicleId : vehicleId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Vehicle successfully deleted"); }
				else if(data.status = false) { alert("Vehicle deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	jQuery(document).on("click", ".deleteAnswer", function(){
		var answerId = $(this).data("answerid"),
			hitURL = baseURL + "deleteAnswer",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this inspection entry ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { answerId : answerId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("inspection entry successfully deleted"); }
				else if(data.status = false) { alert("inspection entry deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
