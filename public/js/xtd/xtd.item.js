try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.Item = function (name, display) {
		this.__proto__ = new XTD.definitions.BaseItem(name, display);
		//this.name = name;
		//this.display = display;
		this._value = '';
		
		this.setValue = function (value) {
			this._value = value;
		};
		this.getValue = function () {
			return this._value;
		};
		this.serialize = function () {
			return {'name': name, 'value' : _value };
		};
		return this;
	}
	//XTD.definitions.Item.prototype = new XTD.definitions.BaseItem();
} catch (e) {
    console.log(e);
}

