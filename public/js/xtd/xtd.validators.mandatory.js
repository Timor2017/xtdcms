try {
	XTD.factories = XTD.factories || {};
	XTD.factories.MandatoryFactory = XTD.factories.MandatoryFactory || (function () {
		return {
			name: 'mandatory', 
			display: '必須填項',
			icon: 'fa-edit',
			create: function (definition) {
				return new XTD.validators.Mandatory(definition);
			}
		}
	})();

	window.XTD.validators = window.XTD.validators || {};
	window.XTD.validators.Mandatory = window.XTD.validators.Mandatory || function (o) {
		var initializeValue = '';
		var message = XTD.__('cannot be empty');
		if (o) {
			if (o !== null && typeof o === 'object') {
				initializeValue = o.rule;
				message = XTD.__(o.message);
			}
			else{
				initializeValue = o;
			}
		}
		return {
			name: "Mandatory",
			validate: function (value) {
				var result = { valid: true, message: '' };
					if (!(value != null && value != initializeValue)) {
						result.valid = false;
						result.message = message;
					}
				return result;
			}
		}
	};
}  catch (e) {
	console.log(e);
}