$(document).ready(function() {
	if($("button").is("#add_next_eo")) {
		$("#add_next_eo").click(function() {
			$(".for-copy:first").clone().insertAfter(".for-copy:last");
		});
	}
});
