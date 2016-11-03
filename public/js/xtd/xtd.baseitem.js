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
		
		return this;
	}
} catch (e) {
    console.log(e);
}

