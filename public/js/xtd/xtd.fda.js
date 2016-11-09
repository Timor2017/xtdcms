if (XTD) {
	XTD.FDA = XTD.FDA || function (definition, editable) {
		this.__itemContainerId = '';
		this.__propertyContainerId = '';
		
		this.definition = definition;
		this.form = {};
		if (editable) {
			this.form = new XTD.definitions.EditableForm(this.definition);
		} else {
			this.form = new XTD.definitions.Form(this.definition);
		}

		this.setItemContainerId = function (id) {
			this.__itemContainerId = id;
			
			return this;
		};
		this.setPropertyContainerId = function (id) {
			this.__propertyContainerId = id;
			
			return this;
		};
		
		this.changeControlHandler = function (item) {
			$('#' + $this.__propertyContainerId).empty();
			item.each(function (property) {
				$('#' + $this.__propertyContainerId).append($(property.render()));
			});
		};
		
		this.renderAll = function () {
			$('#' + $this.__itemContainerId).empty().append($($this.form.render()));
		};
		
		this.addItem = function (definition) {
			//console.log($this.form);
			$this.form.control.__addItem(definition);
		};
		
		this.serializeItem = function () {
			return this.form.definition;
		};
		
		this.serializeValue = function () {
			//return this.form.serialize();
		};

		if (editable) {
			this.form.setChangeControlHandler(this.changeControlHandler);
		}
		var $this = this;
	};
}