$(document).ready(function() {
	$('form').submit(function(event) {
		var json;
		event.preventDefault();
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(result) {
				json = jQuery.parseJSON(result);
				if (json.url) {
					window.location.href = '/' + json.url;
				} else {
					if (json.status != 'Error') {
                        swal({
                            title: json.status,
                            text: json.message,
                            icon: "success",
                            button: "OK",
                        });
					} else {
                        swal({
                            title: json.status,
                            text: json.message,
                            icon: "error",
                            button: "OK",
                        });
                    }
				}
			},
		});
	});
});