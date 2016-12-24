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
			if (item && item.name) {
				if (!this._items[item.name]) {
					this._items[item.name] = item;
					this._keys[this._count] = item.name;
					++this._count;
				}
			}
		},
		insert: function (index, item) { 
			if (item && item.name) {
				if (!this._items[item.name]) {
					this._items[item.name] = item;
					for (var i = this._count - 1; i >= index; i--) {
						this._keys[i+1] = this._keys[i];
					}
					this._keys[index] = item.name;
					++this._count;
				}
			}
		},
		remove: function (item) {
			if (item && item.name) {
				if (this._items[item.name]) {
					delete this._items[item.name];
					for (var i = 0; i < this._count; i++) {
						if (this._keys[i] == item.name) {
							//delete this._keys[i];
							this._keys.splice(i, 1);
							break;
						}
					}
					--this._count;
				}
			}
		},
		removeAll: function () {
			for (var i = this._count - 1; i >= 0; i--){
				this.removeAt(i);
			}
		},
		removeAt: function (index) {
			if ((index >= 0) && (index < this._count)) {
				delete this._items[this._keys[index]];
				//delete this._keys[index];
				this._keys.splice(index, 1);
				--this._count;
			}
		},
		at: function (index) {
			return this._items[this._keys[index]];
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
			this._index = this._count - 1 ;
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