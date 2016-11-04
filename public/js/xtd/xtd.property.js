try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.Property = function (name, display) {
		this.__proto__ = new XTD.definitions.EditableItem(name, display);
		
		return this;
	}
} catch (e) {
    console.log(e);
}

