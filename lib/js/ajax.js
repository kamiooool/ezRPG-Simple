$(document).ready(function() {

	// Pretty bars
	$selector = '.bar_wrap';
	$($selector).each(function(e) {

		var current = $(this).children("div").attr("id");
		if (current) {

			$c_val = $("#" + current).data('current');
			$c_val = parseInt($c_val);
			if (isNaN($c_val)) $c_val = 0;
			
			$m_val = $("#" + current).data('max');
			$m_val = parseInt($m_val);
			if (isNaN($m_val)) $m_val = 0;

			$('#' + current).append('<div><span class="current">' + $c_val + '</span> / <span class="max">' + $m_val + '</span></div>');
			
			$width_percentage = ((($m_val-$c_val)/$m_val)*100);
			$total_width = 100-$width_percentage;
			
			$('#'+current).css({
				width: $total_width+'%'
			})
		}
	});

	// Storing set data module for comparing
	var module_id = $('form').data('module');
	
	// Here we are preventing default actions for form submition and doing AJAX request instead, depending on data-* parameter
	$('form').submit(function(event) {
		event.preventDefault();
		
		// Also we are requesting form's id (if there is one) - for empty forms submissions (where no data is stored inside, and only submit button exists)
		var form_id = $(this).attr('id');
		var data = $('form').serialize();
		
		$.ajax({
		  type: 'POST',
		  data: data+'&form_id='+form_id,
		  url: 'index.php?mod=' + module_id,
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