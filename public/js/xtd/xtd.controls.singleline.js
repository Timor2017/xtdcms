try {
	XTD.factories = XTD.factories || {};
	XTD.factories.SinglelineFactory = XTD.factories.SinglelineFactory || (function () {
		return {
			name: 'singleline', 
			display: '單行文字',
			create: function (definition) {
				return new XTD.controls.Singleline(definition);
			},
			createEditable: function (definition) {
				return new XTD.controls.EditableSingleline(definition);
			}
		}
	})();
	
	XTD.controls = XTD.controls || {};
	XTD.controls.Singleline = function(definition) {
		this.__proto__ = new XTD.definitions.Item(definition.properties.name, definition.properties.common.display);
		this.definition = definition;
		this.__id = definition.id;
		this.initialize = function () {
			this.properties.add(new XTD.definitions.properties.TextBox('display', 'display').setParent(this).setValue(definition.properties.common.display).subscribe(function (value) {
				$('#lbl_'+$(this).attr('data-parent-id')).html(value);
			}));
			//this.properties.add(new XTD.definitions.properties.TextBox('common.description', 'description').setParent(this).setValue(definition.properties.common.description).subscribe(function (value) {
			//	$('#txt_'+$(this).attr('data-parent-id')).html(value);
			//}));
			this.properties.add(new XTD.definitions.properties.TextBox('common.default_value', 'default_value').setParent(this).setValue(definition.properties.common.default_value).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).val(value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('common.placeholder', 'placeholder').setParent(this).setValue(definition.properties.common.placeholder).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).attr('placeholder', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('common.tooltips', 'tooltips').setParent(this).setValue(definition.properties.common.tooltips).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).attr('title', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.width', 'width').setParent(this).setValue(definition.properties.layout.width).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('width', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.height', 'height').setParent(this).setValue(definition.properties.layout.height).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('height', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.horizontalAlignment', 'horizontalAlignment').setParent(this).setValue(definition.properties.layout.horizontalAlignment).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('text-aign', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.verticalAlignment', 'verticalAlignment').setParent(this).setValue(definition.properties.layout.verticalAlignment).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('vertical-align', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.marginTop', 'marginTop').setParent(this).setValue(definition.properties.layout.marginTop).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('margin-top', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.marginRight', 'marginRight').setParent(this).setValue(definition.properties.layout.marginRight).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('margin-right', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.marginBottom', 'marginBottom').setParent(this).setValue(definition.properties.layout.marginBottom).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('margin-bottom', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.marginLeft', 'marginLeft').setParent(this).setValue(definition.properties.layout.marginLeft).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('margin-left', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('brush.backgroundColor', 'backgroundColor').setParent(this).setValue(definition.properties.brush.backgroundColor).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('background-color', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('brush.backgroundImage', 'backgroundImage').setParent(this).setValue(definition.properties.brush.backgroundImage).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('background-image', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('brush.foregroundColor', 'foregroundColor').setParent(this).setValue(definition.properties.brush.foregroundColor).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('color', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('text.size', 'size').setParent(this).setValue(definition.properties.text.size).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('font-size', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('text.weight', 'weight').setParent(this).setValue(definition.properties.text.weight).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('font-weight', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('text.textDecoration', 'textDecoration').setParent(this).setValue(definition.properties.text.textDecoration).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('text-decoration', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('text.style', 'style').setParent(this).setValue(definition.properties.text.style).subscribe(function (value) {
				$('#txt_'+$(this).attr('data-parent-id')).css('font-style', value);
			}));
			
		};
		this.render = function () {
			return $('<div />').attr('id', 'container_'+this.__id)
							.append(
								$('<label />').attr('id', 'lbl_'+this.__id).html(this.properties.get('display').getValue()) 
							)
							.append(
								$('<div />').addClass('item-control')
								.append(
									$('<input />').attr('type','text').attr('name', this.__id).attr('id', 'txt_'+this.__id)
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

		this.initialize();
		
		return this;
	};
	XTD.controls.EditableSingleline = function(definition) {
		this.__proto__ = new XTD.definitions.EditableItem(definition.properties.name, definition.properties.common.display);
		this.control = new XTD.controls.Singleline(definition).setParent(this);
		this.render = function () {
			var output = this.control.render();
			var properties = this.control.properties;
			var $this = this;
			output.bind('click', function () {
				$this.fire(properties);
			});
			
			return output;
		};

		return this;
	};

} catch (e) {
    console.log(e);
}

