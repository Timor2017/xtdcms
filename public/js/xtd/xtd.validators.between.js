try {
	window.XTD.validators = window.XTD.validators || {};
	window.XTD.validators.Between = window.XTD.validators.Between || function (o) {
		var min = Number.MIN_VALUE;;
		var max = Number.MAX_VALUE;
		if (o) {
			min = o.min;
			max = o.max;
		}
		return {
			validate: function (value) {
				return (value == null || value == '' || (value >= min && value <= max));
			}
		}
	};
}  catch (e) {
	console.log(e);
}