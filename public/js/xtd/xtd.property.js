try {
	XTD.factories = XTD.factories || {};
	XTD.factories.PropertyFactory = XTD.factories.PropertyFactory || (function () {
		return {
			generate: function (definition) {
				if (definition && definition.type) {
					return new XTD.definitions.properties[definition.type](definition);
				} else {
					return new XTD.definitions.properties.TextBox(definition);
				}
				return null;
			}
		}
	})();
	
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.Property = function (property) {
		this.property = property;
		var name = '';
		var display = '';
		if (this.property && this.property.group) {
			if (name != '') name += '.';
			name += this.property.group;
		}
		if (this.property && this.property.name) {
			if (name != '') name += '.';
			name += this.property.name;
		}
		if (this.property && this.property.display) {
			display = this.property.display;
		}
		this.__proto__ = new XTD.definitions.EditableItem(name, display);
		if (this.property && this.property.value) {
			this.setValue(this.property.value);
		}
		return this;
	}

	XTD.properties = XTD.properties || {};
	XTD.properties.DefaultDefinition = function (name, display, type) {
		return {
			"id": "",
			"name": name,
			"type": type,
			"value_type": "string",
			"properties": {
				"common" : {
					"display" : { "group": "common", "name": "display", "value": display, "type": "TextBox" },
					"description" : { "group": "common", "name": "description", "value": "", "type": "TextBox" },
					"default_value" : { "group": "common", "name": "default_value", "value": "", "type": "TextBox" },
					"is_searchable" : { "group": "common", "name": "is_searchable", "value": "", "type": "CheckBox" },
					"is_show_in_list" : { "group": "common", "name": "is_show_in_list", "value": "", "type": "CheckBox" },
					"is_show_in_mobile_list" : { "group": "common", "name": "is_show_in_mobile_list", "value": "", "type": "CheckBox" },
					"sort_sequence" : { "group": "common", "name": "sort_sequence", "value": "", "type": "TextBox" },
					"placeholder" : { "group": "common", "name": "placeholder", "value": "", "type": "TextBox" },
					"tooltips" : { "group": "common", "name": "tooltips", "value": "", "type": "TextBox" }
				},
				"layout": { 
					"width" : { "group": "layout", "name": "width", "value": "", "type": "TextBox" },
					"height" : { "group": "layout", "name": "height", "value": "", "type": "TextBox" },
					"horizontalAlignment" : { "group": "layout", "name": "horizontalAlignment", "value": "left", "type": "TextBox" },
					"verticalAlignment" : { "group": "layout", "name": "verticalAlignment", "value": "top", "type": "TextBox" },
					"marginTop" : { "group": "layout", "name": "marginTop", "value": "0px", "type": "TextBox" },
					"marginRight" : { "group": "layout", "name": "marginRight", "value": "0px", "type": "TextBox" },
					"marginBottom" : { "group": "layout", "name": "marginBottom", "value": "0px", "type": "TextBox" },
					"marginLeft" : { "group": "layout", "name": "marginLeft", "value": "0px", "type": "TextBox" }
				},
				"brush": {
					"backgroundColor" : { "group": "brush", "name": "backgroundColor", "value": "", "type": "TextBox" },
					"backgroundImage" : { "group": "brush", "name": "backgroundImage", "value": "", "type": "TextBox" },
					"foregroundColor" : { "group": "brush", "name": "foregroundColor", "value": "#000000", "type": "TextBox" }
				},
				"text": {
					"size" : { "group": "text", "name": "size", "value": "inherit", "type": "TextBox" },
					"weight" : { "group": "text", "name": "weight", "value": "inherit", "type": "TextBox" },
					"textDecoration" : { "group": "text", "name": "textDecoration", "value": "inherit", "type": "TextBox" },
					"style" : { "group": "text", "name": "style", "value": "inherit", "type": "TextBox" }
				}
			},
			"validations": []
		};
	};
	XTD.properties.DefaultPropertyDefinition = function (group, name, display, type) {
		return { "group": group, "name": name, "value": display, "type": type };
	};
	
} catch (e) {
    console.log(e);
}

