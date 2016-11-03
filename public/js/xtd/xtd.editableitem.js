try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.EditableItem = function (name, display) {
		this.name = name;
		this.display = display;
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
	XTD.definitions.EditableItem.prototype = new XTD.definitions.Item();
} catch (e) {
    console.log(e);
}

