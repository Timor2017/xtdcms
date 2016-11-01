try {
	window.XTD.item = function (name, display_name) {
		this.definition = {};
		this.name = name;
		this.display_name = display_name;
		this.items = [];
		this.validators = [];
		this.__basic_validators = [];
		this.handlers = [];
	};
	window.XTD.item.prototype = {
		add: function (item)  {
			this.items.push(item);
		},
		remove: function (item) {
			var length = this.items.length;
			for (var i = 0; i < length; i++) {
				if (this.items[i] === item) {
					this.items.splice(i, 1);
					return;
				}
			}
		},
		render: function () {},
		getItem: function(i) {
			if (i < 0){
				throw {"Error":"Index cannot smaller than 0(zero)"};
			} else if (i >= items.length) {
				throw {"Error":"Index out of range"};
			}
			return this.items[i];
		},
		setValue: function (value) {
			this.value = value;
		},
		subscribe: function(fn) {
			this.handlers.push(fn);
		},
		unsubscribe: function(fn) {
			this.handlers = this.handlers.filter(
				function(item) {
					if (item !== fn) {
						return item;
					}
				}
			);
		},
		fire: function(o, thisObj) {
			var scope = thisObj || window;
			this.handlers.forEach(function(item) {
				item.call(scope, o);
			});
		},
		getItems: function () {
			return this.items;
		},
		hasChildren: function () {
			return this.children.length > 0;
		},
		validate: function () {
			var length = this.__basic_validators.length;
			for (var i = 0; i < length; i++) {
				this.__basic_validators[i].validate(this.value);
			}
			var length = this.validators.length;
			for (var i = 0; i < length; i++) {
				this.validators[i].validate(this.value);
			}
		},
		
	}
} catch (e) {
    console.log(e);
}

