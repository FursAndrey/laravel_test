$(document).ready(function() {
	if($("button").is("#add_next_eo")) {
		$("#add_next_eo").click(function() {
			var elem = $(".for-copy:last").clone();

			//получить новый номер для ID
			var new_id_elem = $(".for-copy").length;

			//увеличить на 1 значения аттрибутов для корректной работы
			incrementAttrVal(elem, 'label', 'for', new_id_elem);
			incrementAttrVal(elem, '.change-id', 'id', new_id_elem);

			elem.insertAfter(".for-copy:last");
		});
	}

	function incrementAttrVal(elem, selector, nameAttr, new_id_elem) {
		var labels = elem.find(selector);
		for (var i = 0; i < labels.length; i++) {
			//получить значение аттрибута
			var forAttr = $(labels[i]).attr(nameAttr);

			//замена индекса
			var forAttrInArr = forAttr.split('_');
			forAttrInArr[1] = new_id_elem;
			forAttr = forAttrInArr.join('_');

			//заменить значение аттрибута
			$(labels[i]).attr(nameAttr, forAttr);
		}		
	}
});
