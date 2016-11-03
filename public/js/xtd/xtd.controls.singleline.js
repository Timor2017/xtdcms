try {
	XTD.factories = XTD.factories || {};
	XTD.factories.SinglelineFactory = XTD.factories.SinglelineFactory || (function () {
		return {
			create: function (definition) {
				return new XTD.controls.Singleline(definition);
			}
		}
	})();
	
	XTD.controls = XTD.controls || {};
	XTD.controls.Singleline = function(definition) {
		this.definition = definition;
		
		this.initialize = function () {
			$this = this;
			this.properties.add(new XTD.definitions.properties.TextBox('display', 'display').subscribe(function (value) {
				$('#lbl_'+$this.__id).html(value);
			}));
		};
		this.render = function () {
			var style = '';
			return $('<div />')
							.append(
								$('<label />').attr('id', 'lbl_'+this.__id).html(this.properties.get('display').getValue()) 
							)
							.append(
								$('<div />').addClass('item-control')
								.append(
									$('<input />').attr('type','text').attr('name', this.__id).attr('id', this.__id).attr('style', style)
								)
							);
		};

		this.initialize();
		
		return this;
	};
	XTD.controls.Singleline.prototype = new XTD.definitions.Item('singleline', '單行文字');

} catch (e) {
    console.log(e);
}

