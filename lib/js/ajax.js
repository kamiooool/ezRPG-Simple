$(document).ready(function() {

	// Here we are preventing default actions for form submition and doing AJAX request instead, depending on data-* parameter
	$('form').submit(function(event) {
		event.preventDefault();
		var data = $('form').serialize();
		
		$.ajax({
		  type: 'POST',
		  data: data,
		  url: 'index.php?mod=' + this.dataset.module,
		  beforeSend:function(){
			// this is where we append a loading image
			$('#messages').html('<div class="loading" id="loading">Loading...</div>');
		  },
		  success:function(data, status, xhr){
		  
			// Here we are cathing redirect instead of showing message. This lines depends on redirectTo func.
			var catchRedirect = data.indexOf("Location:");
			if (catchRedirect != -1) {
				var catchRedirect = data;
				var catchRedirect = catchRedirect.replace('Location:','');
				window.location = catchRedirect;
				return;
			}
			// successful request; do something with the data
			$('#messages').empty();
			  $('#messages').append(data);
		  }
		});
		
	});
	
})