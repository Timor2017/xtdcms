try {
	window.XTD.validators = window.XTD.validators || {};
	window.XTD.validators.LessThan = window.XTD.validators.LessThan || function (o) {
		var compare = Number.MAX_VALUE;;
		if (o) {
			compare = o;
		}
		return {
			validate: function (value) {
				return (value == null || value == '' || value < compare);
			}
		}
	};
}  catch (e) {
	console.log(e);
}