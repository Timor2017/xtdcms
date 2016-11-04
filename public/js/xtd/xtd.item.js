try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.Item = function (name, display) {
		this.__proto__ = new XTD.definitions.BaseItem(name, display);
		this._value = '';
		
		this.setValue = function (value) {
			this._value = value;
			return this;
		};
		this.getValue = function () {
			return this._value;
		};
		this.serialize = function () {
			return {'name': name, 'value' : _value };
		};
		return this;
	}
} catch (e) {
    console.log(e);
}

