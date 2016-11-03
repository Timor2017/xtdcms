try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.BaseItem = function (name, display) {
		this.__id = XTD.SequenceGenerator.getNextCounter();
		this.name = name;
		this.display = display;
		this.items = new XTD.definitions.Collection();
		this.properties = new XTD.definitions.Collection();
		this.validators = new XTD.definitions.Collection();
		this.__basic_validators = new XTD.definitions.Collection();
		this.initialize = function () {};
		this.render = function () {};
		this.validate = function () {
			result = true;
			var length = this.__basic_validators.length;
			for (var i = 0; i < length; i++) {
				result = result && this.__basic_validators[i].validate(this.value);
				if (!result) break;
			}
			if (result) {
				var length = this.validators.length;
				for (var i = 0; i < length; i++) {
					result = result && this.validators[i].validate(this.value);
					if (!result) break;
				}
			}
			return result;
		};
		
		this.initialize();
		return this;
	}
} catch (e) {
    console.log(e);
}

