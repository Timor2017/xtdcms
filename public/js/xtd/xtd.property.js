try {
	XTD.factories = XTD.factories || {};
	XTD.factories.PropertyFactory = XTD.factories.PropertyFactory || (function () {
		return {
			generate: function (definition) {
				return new XTD.definitions.properties[definition.type](definition);
			}
		}
	})();
	
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.Property = function (property) {
		this.property = property;
		this.__proto__ = new XTD.definitions.EditableItem(this.property.group + "." + this.property.name, this.property.display);
		this.setValue(this.property.value);
		
		return this;
	}
} catch (e) {
    console.log(e);
}

