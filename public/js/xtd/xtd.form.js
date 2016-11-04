try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.Form = function (definition) {
		this.__proto__ = new XTD.definitions.Item(definition.properties.name, definition.properties.common.display);
		this.definition = definition;
		this.__id = definition.id;
		this.initialize = function () {
			this.properties.add(new XTD.definitions.properties.TextBox('display', 'display').setParent(this).setValue(definition.properties.common.display).subscribe(function (value) {
				$('#form_title').html(value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('common.description', 'description').setParent(this).setValue(definition.properties.common.description).subscribe(function (value) {
				$('#form-items-container').html(value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('common.default_value', 'default_value').setParent(this).setValue(definition.properties.common.default_value).subscribe(function (value) {
				$('#form-items-container').val(value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('common.placeholder', 'placeholder').setParent(this).setValue(definition.properties.common.placeholder).subscribe(function (value) {
				$('#form-items-container').attr('placeholder', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('common.tooltips', 'tooltips').setParent(this).setValue(definition.properties.common.tooltips).subscribe(function (value) {
				$('#form-items-container').attr('title', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.width', 'width').setParent(this).setValue(definition.properties.layout.width).subscribe(function (value) {
				$('#form-items-container').css('width', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.height', 'height').setParent(this).setValue(definition.properties.layout.height).subscribe(function (value) {
				$('#form-items-container').css('height', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.horizontalAlignment', 'horizontalAlignment').setParent(this).setValue(definition.properties.layout.horizontalAlignment).subscribe(function (value) {
				$('#form-items-container').css('text-aign', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.verticalAlignment', 'verticalAlignment').setParent(this).setValue(definition.properties.layout.verticalAlignment).subscribe(function (value) {
				$('#form-items-container').css('vertical-align', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.marginTop', 'marginTop').setParent(this).setValue(definition.properties.layout.marginTop).subscribe(function (value) {
				$('#form-items-container').css('margin-top', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.marginRight', 'marginRight').setParent(this).setValue(definition.properties.layout.marginRight).subscribe(function (value) {
				$('#form-items-container').css('margin-right', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.marginBottom', 'marginBottom').setParent(this).setValue(definition.properties.layout.marginBottom).subscribe(function (value) {
				$('#form-items-container').css('margin-bottom', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('layout.marginLeft', 'marginLeft').setParent(this).setValue(definition.properties.layout.marginLeft).subscribe(function (value) {
				$('#form-items-container').css('margin-left', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('brush.backgroundColor', 'backgroundColor').setParent(this).setValue(definition.properties.brush.backgroundColor).subscribe(function (value) {
				$('#form-items-container').css('background-color', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('brush.backgroundImage', 'backgroundImage').setParent(this).setValue(definition.properties.brush.backgroundImage).subscribe(function (value) {
				$('#form-items-container').css('background-image', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('brush.foregroundColor', 'foregroundColor').setParent(this).setValue(definition.properties.brush.foregroundColor).subscribe(function (value) {
				$('#form-items-container').css('color', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('text.size', 'size').setParent(this).setValue(definition.properties.text.size).subscribe(function (value) {
				$('#form-items-container').css('font-size', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('text.weight', 'weight').setParent(this).setValue(definition.properties.text.weight).subscribe(function (value) {
				$('#form-items-container').css('font-weight', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('text.textDecoration', 'textDecoration').setParent(this).setValue(definition.properties.text.textDecoration).subscribe(function (value) {
				$('#form-items-container').css('text-decoration', value);
			}));
			this.properties.add(new XTD.definitions.properties.TextBox('text.style', 'style').setParent(this).setValue(definition.properties.text.style).subscribe(function (value) {
				$('#form-items-container').css('font-style', value);
			}));

			//for (var item in definition.items) {
			for (var i = 0; i < definition.items.length; i++) {
				var item = definition.items[i];
				this.items.add(XTD.factories[item.properties.type+"Factory"].createEditable(item).subscribe(this.changeControlHandler));
			}
			//this.properties.add(new XTD.definitions.properties.TextBox('display', 'display').setParent(this).subscribe(function (value) {
			//	$('#lbl_'+$(this).attr('data-parent-id')).html(value);
			//}));
		};
		this.render = function () {
			var style = '';
			var container = $('<div />').attr('id', 'container_'+this.__id);
			console.log(this);
				$('<h1 />').attr('id','form_title').html(this.display).appendTo(container);

			this.items.each(function (item) {
				$(item.render()).appendTo(container);
			});
			return container;
		};
	
		this.changeControlHandler = function (item) {
			$("#form-properties-container").empty();
				item.each(function (property) {
					$("#form-properties-container").append($(property.render()));
				});
		}

		this.initialize();
		
		return this;
	};
} catch (e) {
    console.log(e);
}

