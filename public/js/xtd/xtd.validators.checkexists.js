try {
	XTD.factories = XTD.factories || {};
	XTD.factories.CheckExistsFactory = XTD.factories.CheckExistsFactory || (function () {
		return {
			name: 'checkexists', 
			display: '查詢重複',
			icon: 'fa-edit',
			create: function (definition) {
				return new XTD.validators.CheckExists(definition);
			}
		}
	})();

	window.XTD.validators = window.XTD.validators || {};
	window.XTD.validators.CheckExists = window.XTD.validators.CheckExists || function (f,c) {
		var form = '';
		var column = '';
		var message = XTD.__('record does not exists');
		if (f !== null && typeof f === 'object') {
			var r = f.rule.split(',');
			form = r[0];
			column = r[1];
			message = XTD.__(f.message);
		}
		else if (f && c){
			form = f;
			column = c;
		}
		
		
		return {
			name : "Check Exists",
			validate: function (value) {
				var result = { valid: true, message: '' };
				if (value != '') {
					XTD.syncApi('/validate/exists', XTD.method.POST, { fid: form, cid: column, value: value }, function (data) {
						if (!data.result) {
							result.valid = false;
							result.message = message;
						}
					});
				}
				return result;
			}
		}
	};
}  catch (e) {
	console.log(e);
}