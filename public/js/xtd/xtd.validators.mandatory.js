try {
	window.XTD.validators = window.XTD.validators || {};
	window.XTD.validators.Mandatory = window.XTD.validators.Mandatory || function (o) {
		var initializeValue = '';
		if (o) {
			initializeValue = o;
		}
		return {
			validate: function (value) {
				return (value != null && value != initializeValue);
			}
		}
	};
}  catch (e) {
	console.log(e);
}