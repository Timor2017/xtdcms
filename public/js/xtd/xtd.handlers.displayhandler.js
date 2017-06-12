try {
	XTD.handlers = XTD.handlers || {};
	XTD.handlers.DisplayHandler = XTD.handlers.DisplayHandler || (function () {
		return {
			name: 'Display Handler', 
			//display: 'Display',
			display: '显示',
			//icon: 'fa-edit',
			fire: function (id, parameters) {
				$("#container_"+id).slideDown("slow");
			},
			revise: function (id, parameters) {
				$("#container_"+id).slideUp();
			}
		}
	})();
}  catch (e) {
	console.log(e);
}