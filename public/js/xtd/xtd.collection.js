try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.Collection = function () {
		this._items = {};
		this._keys = [];
		this._count = 0;
		this._index = 0;
	};

	XTD.definitions.Collection.prototype = {
		add: function (item) {
			if (!this._items[item.name]) {
				this._items[item.name] = item;
				this._keys.push(item.name);
				++this._count;
			}
		},
		remove: function (item) {
			if (this._items[item.name]) {
				delete this._items[item.name];
				for (var i = 0; i < this._count; i++) {
					if (this._keys[i] == item.name) {
						delete this._keys[i];
						break;
					}
				}
				--count;
			}
		},
		removeAll: function () {
			while (this._count > 0) {
				this.removeAt(0);
			};
		},
		removeAt: function (index) {
			if ((index >= 0) && (index < count)) {
				delete this._items[this._keys[i]];
				delete this._keys[i];
				--count;
			}
		},
		get: function (name) {
			return this._items[name];
		},
		getCount: function () {
			return this._count;
		},
		first: function() {
			this.reset();
			return this.next();
		},
		last: function() {
			this._index = this._count - 1;
			return this.next();
		},
		previous: function() {
			if (this._index > 0) {
				return this._items[this._keys[--this._index]];
			}
			
			return null;
		},
		hasPrevious: function() {
			return this._index >= 0;
		},
		next: function() {
			
			if (this._index < this._count) {
				return this._items[this._keys[++this._index]];
			}
			return null;
		},
		hasNext: function() {
			return this._index < this._count;
		},
		reset: function() {
			this._index = -1;
		},
		each: function(callback) {
			for (var item = this.first(); this.hasNext(); item = this.next()) {
				callback(item);
			}
		}
	};
} catch (e) {
	console.log(e);
}