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
		
		return this;
	}
} catch (e) {
    console.log(e);
}

