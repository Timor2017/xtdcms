try {
	window.XTD.validators = window.XTD.validators || {};
	window.XTD.validators.AlwaysTrue = window.XTD.validators.AlwaysTrue || function (o) {
		return {
			validate: function (value) {
				return true;
			}
		}
	};
} catch (e) {
	console.log(e);
}