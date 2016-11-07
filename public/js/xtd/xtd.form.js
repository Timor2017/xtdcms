try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.Form = function (definition) {
		this.__proto__ = new XTD.definitions.Item(definition.properties.name, definition.properties.common.display);
		this.definition = definition;
		this.__id = this.definition.id;
		var $this = this;
		
		this.initialize = function () {
			this.properties.removeAll();
			this.items.removeAll();
			
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.display).setParent(this).subscribe(function (value) {
				$('#form_title').html(value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.description).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).html(value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.default_value).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).val(value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.placeholder).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).attr('placeholder', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.common.tooltips).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).attr('title', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.width).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('width', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.height).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('height', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.horizontalAlignment).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('text-aign', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.verticalAlignment).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('vertical-align', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginTop).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('margin-top', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginRight).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('margin-right', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginBottom).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('margin-bottom', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.layout.marginLeft).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('margin-left', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.backgroundColor).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('background-color', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.backgroundImage).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('background-image', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.brush.foregroundColor).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('color', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.size).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('font-size', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.weight).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('font-weight', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.textDecoration).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('text-decoration', value);
			}));
			this.properties.add(XTD.factories.PropertyFactory.generate(this.definition.properties.text.style).setParent(this).subscribe(function (value) {
				$('#container_'+$this.__id).css('font-style', value);
			}));

			for (var i = 0; i < this.definition.items.length; i++) {
				var item = this.definition.items[i];
				this.__addItem(item);
			}
		};
		
		this.__addItem = function (item) {
			//this.items.add(XTD.factories[item.properties.type+"Factory"].createEditable(item).subscribe(this.changeControlHandler));
			this.items.add(XTD.factories[item.properties.type+"Factory"].create(item));
		};
		
		this.render = function () {
			var style = '';
			var container = $('<div />').attr('id', 'container_'+this.__id);
			$('<h1 />').attr('id','form_title').html(this.definition.properties.common.display.value).appendTo(container);
			this.items.each(function (item) {
				$(item.render()).appendTo(container);
			});
			return container;
		};

		this.initialize();
		
		return this;
	};
	XTD.definitions.EditableForm = function(definition) {
		this.__proto__ = new XTD.definitions.EditableItem(definition.properties.name, definition.properties.common.display);
		var $this = this;
		this.definition = definition;
		this.control = new XTD.definitions.Form(this.definition).setParent(this);
		this.control.__addItem = function (item) {
			$this.control.items.add(XTD.factories[item.properties.type+"Factory"].createEditable(item).subscribe($this.changeControlHandler));
		};
		this.render = function () {
			var output = this.control.render();
			var properties = this.control.properties;
			var $this = this;
			output.find("#form_title").bind('click', function () {
				$this.fire(properties);
			});
			
			return output;
		};
		
		this.__changeControlHandlerFn =  function (item) {
		};
		
		this.changeControlHandler =  function (item) {
			$this.__changeControlHandlerFn(item);
		};

		this.setChangeControlHandler = function (fn) {
			this.__changeControlHandlerFn = fn;
			return this;
		}
		
		this.control.initialize();
		this.subscribe(this.changeControlHandler);

		return this;
	};
	
} catch (e) {
    console.log(e);
}

