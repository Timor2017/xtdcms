try {
	XTD.factories = XTD.factories || {};
	XTD.factories.CheckboxFactory = XTD.factories.CheckboxFactory || (function () {
		return {
			name: 'checkbox', 
			display: '复选框',
			icon: 'fa-edit',
			create: function (definition) {
				return new XTD.controls.Checkbox(definition);
			},
			createEditable: function (definition) {
				return new XTD.controls.EditableCheckbox(definition);
			}
		}
	})();
	
	XTD.controls = XTD.controls || {};
	XTD.controls.Checkbox = function(definition) {
		this.__proto__ = new XTD.definitions.Item(definition.name, definition.properties.common.display);
		this.definition = definition;
		if (this.definition.id) {
			this.__id = this.definition.id;
		}
		var $this = this;
		this.initialize = function () {
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.display).setParent(this).subscribe(function (value) {
				$('#lbl_'+$(this).attr('data-parent-id')).html(value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.default_value).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).val(value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.placeholder).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).attr('placeholder', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.tooltips).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).attr('title', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.width).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('width', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.height).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('height', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.horizontalAlignment).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('text-aign', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.verticalAlignment).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('vertical-align', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginTop).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('margin-top', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginRight).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('margin-right', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginBottom).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('margin-bottom', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginLeft).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('margin-left', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.backgroundColor).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('background-color', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.backgroundImage).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('background-image', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.foregroundColor).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('color', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.size).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('font-size', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.weight).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('font-weight', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.textDecoration).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('text-decoration', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.style).setParent(this).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('font-style', value);
			}));
			
		};
		this.render = function () {
			return $('<div />').attr('id', 'container_'+this.__id).addClass("item-container")
							.append(
								$('<label />').attr('id', 'lbl_'+this.__id).html(this.properties.get('common.display').getValue()) 
							)
							.append(
								$('<div />').addClass('item-control')
								.append(
									$('<input />').attr('type','checkbox').attr('name', 'form[fields]').attr('id', 'txt_'+this.__id)
										.val(this.properties.get('common.default_value').getValue())
										.attr('placeholder', this.properties.get('common.placeholder').getValue())
										.attr('title', this.properties.get('common.tooltips').getValue())
										.css('width', this.properties.get('layout.width').getValue())
										.css('height', this.properties.get('layout.height').getValue())
										.css('text-aign', this.properties.get('layout.horizontalAlignment').getValue())
										.css('vertical-align', this.properties.get('layout.verticalAlignment').getValue())
										.css('margin-top', this.properties.get('layout.marginTop').getValue())
										.css('margin-right', this.properties.get('layout.marginRight').getValue())
										.css('margin-bottom', this.properties.get('layout.marginBottom').getValue())
										.css('margin-left', this.properties.get('layout.marginLeft').getValue())
										.css('background-color', this.properties.get('brush.backgroundColor').getValue())
										.css('background-image', this.properties.get('brush.backgroundImage').getValue())
										.css('color', this.properties.get('brush.foregroundColor').getValue())
										.css('font-size', this.properties.get('text.size').getValue())
										.css('font-weight', this.properties.get('text.weight').getValue())
										.css('text-decoration', this.properties.get('text.textDecoration').getValue())
										.css('font-style', this.properties.get('text.style').getValue())
								)
							);
		};
		
		//this.serialize = function () {
		//};

		this.initialize();
		
		return this;
	};
	XTD.controls.EditableCheckbox = function(definition) {
		this.__proto__ = new XTD.definitions.EditableItem(definition.name, (definition.properties.common)?definition.properties.common.display:'');
		this.control = new XTD.controls.Checkbox(definition).setParent(this);
		this.render = function () {
			var output = this.control.render();
			var properties = this.control.properties;
			var $this = this;
			output.bind('click', function () {
				$this.fire(properties, this);
			});
			
			return output;
		};

		return this;
	};

} catch (e) {
    console.log(e);
}

