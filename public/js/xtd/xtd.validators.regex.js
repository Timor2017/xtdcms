try {
	window.XTD.validators = window.XTD.validators || {};
	window.XTD.validators.Regex = window.XTD.validators.Regex || function (o) {
		var regex = /[*]/gi;
		if (o) {
			regex = o;
		}
		return {
			validate: function (value) {
				return (value == null || value == '' || value.search(regex) != -1);
			}
		}
	};
}  catch (e) {
	console.log(e);
}