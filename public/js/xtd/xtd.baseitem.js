try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.BaseItem = function (name, display) {
		this.__id = XTD.SequenceGenerator.getNextCounter() ;
		this.name = name;
		this.display = display;
		this.parent = {};
		this.items = new XTD.definitions.Collection();
		this.properties = new XTD.definitions.Collection();
		this.validators = new XTD.definitions.Collection();
		this.__basic_validators = new XTD.definitions.Collection();
		this.render = function () {};
		this.setName = function(name) {
			this.name = name;
			return this;
		};
		this.getName = function() {
			return this.name;
		};
		this.setDisplay = function(display) {
			this.display = display;
			return this;
		};
		this.getDisplay = function() {
			return this.display;
		};
		this.setParent = function (parent) {
			this.parent = parent;
			return this;
		};
		this.getParent = function () {
			return this.parent;
		};
		this._setId = function (id) {
			this.__id = id;
			return this;
		};
		this._getId = function () {
			return this.__id;
		};
		this.validate = function () {
			var result = { valid: true, message: '' };

			if ($("[name=" + this.__id + "]").size() > 0) {
				var value = $("[name=" + this.__id + "]").val();
				var length = 0;
				length = this.__basic_validators.getCount();
				$this = this;
				for (var i = 0; i < length; i++) {
					result = this.__basic_validators.at(i).validate(value);
					if (!result.valid) {
						return;
					}
				}

				if (result.valid) {
					length = this.validators.getCount();
					for (var i = 0; i < length; i++) {
						result = this.validators.at(i).validate(value);
						if (!result.valid) {
							break;
						}
					}
				}
			}

			return result;
		};
		
		this.handleProcess = function (definition, control, id) {
			if ( definition.processes && Object.keys(definition.processes).length > 0 ) {
				console.log(definition.processes);
				$.each ( definition.processes, function ( i, rule ) {
					$.each ( rule.triggers, function ( idx, trigger ) {
						control.find("#"+id).on( trigger.event, function () {
							var continueEvent = false;
							$.each ( trigger.logics, function ( index, logic ) {
								var source = 'value';
								if (logic.source != '') {
									source = logic.source;
								}
								var value = '';
								if ($( "#"+logic.id ).size() > 0) {
									if (source == 'value') {
										value = $( "#"+logic.id ).val();
									} else if (source == 'checked') {
										value = $( "#"+logic.id ).prop('checked').toString();
									}
								}
								if (logic.gate == "NE") {
									if (value != logic.value) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "EQ") {
									if (value == logic.value) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "LT") {
									if (value < logic.value) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "GT") {
									if (value > logic.value) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "LE") {
									if (value <= logic.value) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "GE") {
									if (value >= logic.value) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "NOT") {
									if (value != logic.value) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "BW") {
									var s = logic.value.split(',');
									if (s[0] <= value && value <= s[1]) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "NBW") {
									if (value <= s[0] || s[1] <= value) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "CT") {
									if (value.indexOf(logic.value) >= 0) {
										continueEvent |= true;
									}
								}
								if (logic.gate == "NCT") {
									if (value.indexOf(logic.value) < 0) {
										continueEvent |= true;
									}
								}

								if (!continueEvent) {
									return false;
								}
							});
							if (continueEvent) {
								$.each ( rule.results, function ( index, result ) {
									XTD.handlers[result.handler].fire(result.target, result.parameters);
								});
							} else {
								$.each ( rule.results, function ( index, result ) {
									XTD.handlers[result.handler].revise(result.target, result.parameters);
								});
							}
						});
						//control.find("#"+id).trigger( trigger.event );
					});
					
				});
			}
		}
		
		return this;
	}
} catch (e) {
    console.log(e);
}

