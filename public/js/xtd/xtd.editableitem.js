try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.EditableItem = function (name, display) {
		this.__proto__ = new XTD.definitions.Item(name, display);
		this.handlers = [];
		this.subscribe = function(fn) {
			this.handlers.push(fn);
			return this;
		};
		this.unsubscribe = function(fn) {
			this.handlers = this.handlers.filter(
				function(item) {
					if (item !== fn) {
						return item;
					}
				}
			);
			return this;
		};
		this.fire = function(o, thisObj) {
			var scope = thisObj || window;
			this.handlers.forEach(function(item) {
				item.call(scope, o);
			});
			return this;
		};
		
		return this;
	}
} catch (e) {
    console.log(e);
}

