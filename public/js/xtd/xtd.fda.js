if (XTD) {
	$.when(
		$.cachedScript(BASE_URL + '/min/g/formjs')
		//$.cachedScript(BASE_URL + '/min/f/'
		//	+'/js/xtd/xtd.sequencegenerator.js'
		//	+',/js/xtd/xtd.collection.js'
		//	+',/js/xtd/xtd.baseitem.js'
		//	+',/js/xtd/xtd.item.js'
		//	+',/js/xtd/xtd.editableitem.js'
		//	+',/js/xtd/xtd.property.js'
		//	+',/js/xtd/xtd.form.js'
		//	+',/js/xtd/xtd.properties.textbox.js'
		//	+',/js/xtd/xtd.properties.checkbox.js'
		//	+',/js/xtd/xtd.controls.singleline.js'
		//	+',/js/xtd/xtd.controls.textarea.js'
		//	+',/js/xtd/xtd.controls.checkbox.js'
		//	+',/js/xtd/xtd.controls.radio.js'
		//	+',/js/xtd/xtd.controls.select.js'
		//	+',/js/xtd/xtd.controls.datetime.js'
		//	+',/js/xtd/xtd.controls.daterangepicker.js'
		//	+',/js/xtd/xtd.controls.date.js'
		//	+',/js/xtd/xtd.controls.time.js'
		//	+',/js/xtd/xtd.controls.fileupload.js'
		//	+',/js/xtd/xtd.validators.mandatory.js'
		//)
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.sequencegenerator.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.collection.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.baseitem.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.item.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.editableitem.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.property.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.form.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.properties.textbox.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.properties.checkbox.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.singleline.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.textarea.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.properties.textarea.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.checkbox.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.radio.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.select.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.datetime.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.daterangepicker.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.date.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.time.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.controls.fileupload.js'),
		//$.cachedScript(BASE_URL + '/js/xtd/xtd.validators.mandatory.js')
	).done(function () {
		XTD.FDA = XTD.FDA || function (definition, editable) {
			this.__itemContainerId = '';
			this.__propertyContainerId = '';
			this.__controlContainerId = '';
			
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
			this.setControlContainerId = function (id) {
				this.__controlContainerId = id;
			
				var controlContainer = $("#"+this.__controlContainerId);
				for (var name in XTD.factories) {
					if (XTD.factories[name].name) {
						$("<div />").addClass("control-item").addClass("fa fa-edit").attr('data-factory', name).html(XTD.factories[name].display).appendTo(controlContainer);
					}
				}

				$(".control-item").click(function () {
					var item = $(this);
					fda.addItem(new XTD.properties.DefaultDefinition(XTD.SequenceGenerator.getNextCounter() , item.html(), item.attr('data-factory').toString().replace('Factory','')));
					fda.renderAll();
				});
				
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
						$('#' + $this.__propertyContainerId).append($('<h3 />').html(XTD.__(group)).addClass('control-sidebar-heading'));
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
	});
}