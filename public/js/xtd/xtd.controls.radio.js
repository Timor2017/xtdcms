try {
	XTD.factories = XTD.factories || {};
	XTD.factories.RadioFactory = XTD.factories.RadioFactory || (function () {
		return {
			name: 'radio', 
			display: '单选按钮',
			icon: 'fa-edit',
			create: function (definition) {
				return new XTD.controls.Radio(definition);
			},
			createEditable: function (definition) {
				return new XTD.controls.EditableRadio(definition);
			}
		}
	})();
	
	XTD.controls = XTD.controls || {};
	XTD.controls.Radio = function(definition) {
		this.__proto__ = new XTD.definitions.Item(definition.name, (definition.properties.common)?definition.properties.common.display:'');
		this.definition = definition;
		this.definition.properties.common.display = this.definition.properties.common.display || new XTD.properties.DefaultPropertyDefinition('common', 'display', 'display', 'TextBox');
		this.definition.properties.common.default_value = this.definition.properties.common.default_value || new XTD.properties.DefaultPropertyDefinition('common', 'default_value', 'default_value', 'TextBox');
		this.definition.properties.common.placeholder = this.definition.properties.common.placeholder || new XTD.properties.DefaultPropertyDefinition('common', 'placeholder', 'placeholder', 'TextBox');
		this.definition.properties.common.tooltips = this.definition.properties.common.tooltips || new XTD.properties.DefaultPropertyDefinition('common', 'tooltips', 'tooltips', 'TextBox');
		this.definition.properties.common.is_searchable = this.definition.properties.common.is_searchable || new XTD.properties.DefaultPropertyDefinition('common', 'is_searchable', 'is_searchable', 'CheckBox');
		this.definition.properties.common.is_show_in_list = this.definition.properties.common.is_show_in_list || new XTD.properties.DefaultPropertyDefinition('common', 'is_show_in_list', 'is_show_in_list', 'CheckBox');
		this.definition.properties.common.is_show_in_mobile_list = this.definition.properties.common.is_show_in_mobile_list || new XTD.properties.DefaultPropertyDefinition('common', 'is_show_in_mobile_list', 'is_show_in_mobile_list', 'CheckBox');
		this.definition.properties.common.sort_sequence = this.definition.properties.common.sort_sequence || new XTD.properties.DefaultPropertyDefinition('common', 'sort_sequence', 'sort_sequence', 'TextBox');
		//this.definition.properties.layout.width = this.definition.properties.layout.width || new XTD.properties.DefaultPropertyDefinition('layout', 'width', 'width', 'TextBox');
		//this.definition.properties.layout.height = this.definition.properties.layout.height || new XTD.properties.DefaultPropertyDefinition('layout', 'height', 'height', 'TextBox');
		this.definition.properties.layout.horizontalAlignment = this.definition.properties.layout.horizontalAlignment || new XTD.properties.DefaultPropertyDefinition('layout', 'horizontalAlignment', 'horizontalAlignment', 'TextBox');
		this.definition.properties.layout.verticalAlignment = this.definition.properties.layout.verticalAlignment || new XTD.properties.DefaultPropertyDefinition('layout', 'verticalAlignment', 'verticalAlignment', 'TextBox');
		this.definition.properties.layout.marginTop = this.definition.properties.layout.marginTop || new XTD.properties.DefaultPropertyDefinition('layout', 'marginTop', 'marginTop', 'TextBox');
		this.definition.properties.layout.marginRight = this.definition.properties.layout.marginRight || new XTD.properties.DefaultPropertyDefinition('layout', 'marginRight', 'marginRight', 'TextBox');
		this.definition.properties.layout.marginBottom = this.definition.properties.layout.marginBottom || new XTD.properties.DefaultPropertyDefinition('layout', 'marginBottom', 'marginBottom', 'TextBox');
		this.definition.properties.layout.marginLeft = this.definition.properties.layout.marginLeft || new XTD.properties.DefaultPropertyDefinition('layout', 'marginLeft', 'marginLeft', 'TextBox');
		this.definition.properties.brush.backgroundColor = this.definition.properties.brush.backgroundColor || new XTD.properties.DefaultPropertyDefinition('brush', 'backgroundColor', 'backgroundColor', 'TextBox');
		this.definition.properties.brush.backgroundImage = this.definition.properties.brush.backgroundImage || new XTD.properties.DefaultPropertyDefinition('brush', 'backgroundImage', 'backgroundImage', 'TextBox');
		this.definition.properties.brush.foregroundColor = this.definition.properties.brush.foregroundColor || new XTD.properties.DefaultPropertyDefinition('brush', 'foregroundColor', 'foregroundColor', 'TextBox');
		this.definition.properties.text.size = this.definition.properties.text.size || new XTD.properties.DefaultPropertyDefinition('text', 'size', 'size', 'TextBox');
		this.definition.properties.text.weight = this.definition.properties.text.weight || new XTD.properties.DefaultPropertyDefinition('text', 'weight', 'weight', 'TextBox');
		this.definition.properties.text.textDecoration = this.definition.properties.text.textDecoration || new XTD.properties.DefaultPropertyDefinition('text', 'textDecoration', 'textDecoration', 'TextBox');
		this.definition.properties.text.style = this.definition.properties.text.style || new XTD.properties.DefaultPropertyDefinition('text', 'style', 'style', 'TextBox');

		if (this.definition.id) {
			this.__id = this.definition.id;
		}
		var $this = this;
		this.initialize = function () {
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.display).setParent(this).subscribe(function (value) {
				$('#lbl_'+$(this).attr('data-parent-id')).html(value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.default_value).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).val(value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.placeholder).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).attr('placeholder', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.tooltips).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).attr('title', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.is_searchable).setParent(this));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.is_show_in_list).setParent(this));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.is_show_in_mobile_list).setParent(this));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.sort_sequence).setParent(this));
			
			//this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.width).setParent(this).subscribe(function (value) {
			//	$('#'+$(this).attr('data-parent-id')).css('width', value);
			//}));
			//this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.height).setParent(this).subscribe(function (value) {
			//	$('#'+$(this).attr('data-parent-id')).css('height', value);
			//}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.horizontalAlignment).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('text-aign', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.verticalAlignment).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('vertical-align', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginTop).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('margin-top', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginRight).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('margin-right', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginBottom).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('margin-bottom', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginLeft).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('margin-left', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.backgroundColor).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('background-color', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.backgroundImage).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('background-image', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.foregroundColor).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('color', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.size).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('font-size', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.weight).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('font-weight', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.textDecoration).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('text-decoration', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.style).setParent(this).subscribe(function (value) {
				$('#'+$(this).attr('data-parent-id')).css('font-style', value);
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
									$('<input />').attr('type','radio').attr('name', this.__id).attr('id', ''+this.__id)//.addClass('form-control')
										.val(this.properties.get('common.default_value').getValue())
										.attr('placeholder', this.properties.get('common.placeholder').getValue())
										.attr('title', this.properties.get('common.tooltips').getValue())
										//.css('width', this.properties.get('layout.width').getValue())
										//.css('height', this.properties.get('layout.height').getValue())
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
	XTD.controls.EditableRadio = function(definition) {
		this.__proto__ = new XTD.definitions.EditableItem(definition.name, definition.properties.common.display);
		this.control = new XTD.controls.Radio(definition).setParent(this);
		this.render = function () {
			var output = this.control.render();
			output.find('#lbl_'+this.control.__id).append($("<div />").addClass("pull-right box-tools").append('<button type="button" class="btn btn-info btn-xs" data-id="'+this.control.definition.name+'" title="Remove" onclick="remove(this)"><i class="fa fa-remove"></i></button>'));
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

