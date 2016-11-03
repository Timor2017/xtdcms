try {
	window.XTD.validators = window.XTD.validators || {};
	window.XTD.validators.GreaterThan = window.XTD.validators.GreaterThan || function (o) {
		var compare = Number.MIN_VALUE;;
		if (o) {
			compare = o;
		}
		return {
			validate: function (value) {
				return (value == null || value == '' || value > compare);
			}
		}
	};
}  catch (e) {
	console.log(e);
}