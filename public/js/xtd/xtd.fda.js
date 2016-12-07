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
		
		this.changeControlHandler = function (item, scope) {
			$('#' + $this.__propertyContainerId).empty();
			$(".selected").removeClass("selected");
			$(scope).addClass("selected");
			var group = '';
			item.each(function (property) {
				if (group != property.property.group) {
					group = property.property.group;
					$('#' + $this.__propertyContainerId).append($('<h3 />').html(group).addClass('control-sidebar-heading'));
				}
				$('#' + $this.__propertyContainerId).append($(property.render()));
			});
			$(".nav-tabs a[href='#control-sidebar-properties-tab']").tab('show');
		};
		
		this.renderAll = function () {
			$('#' + $this.__itemContainerId).empty().append($($this.form.render()));
		};
		
		this.addItem = function (definition) {
			//console.log($this.form);
			$this.form.control.addItem(definition);
		};
		
		this.insertItem = function (index, definition) {
			//console.log($this.form);
			$this.form.control.insertItem(index, definition);
		};
		
		this.serializeItem = function () {
			return this.form.control.definition;
		};
		
		this.serializeValue = function () {
			console.log($this.form);
			var result = {};
			$this.form.items.each(function (property) {
				result[property.__id] = $("[name=" + property.__id + "]").val();
			});
			//return this.form.serialize();
			return result;
		};

		if (editable) {
			this.form.setChangeControlHandler(this.changeControlHandler);
		}
		var $this = this;
	};
}