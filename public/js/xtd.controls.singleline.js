try {
	XTD.factories = XTD.factories || {};
	XTD.factories.SinglelineFactory = XTD.factories.SinglelineFactory || (function () {
		this.create = function (definition) {
			return new XTD.controls.Singleline(definition);
		};
	})();
	
	XTD.controls = XTD.controls || {};
	XTD.controls.Singleline = function (definition) {
		this.definition = definition;
		this.initialize(definition);
		
		this.initialize = function (definiton) {
			this.properties.add(new XTD.definitions.properties.TextBox("display", "display").subscribe(function (value) {
				this.display = value;
				this.render();
			});
		};
		this.render = function () {
			var style = '';
			for (var i = 0; i < this.definition.style.length; i++) {
				style += this.definition.style[i].name + ':' + this.definition.style[i].value + ';';
			}
			return '<label>' + this.definition.properties.display + '</label>' + '<div class="item-control"><input type="text" name="' + this.definition.properties.__id + '" id="' + this.definition.properties.__id + '" style="' + style + '" />';
		};
		
	};
	XTD.controls.Singleline.prototype = new XTD.Item('singleline', '單行文字');

} catch (e) {
    console.log(e);
}

