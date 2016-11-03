try {
	window.XTD.form = function () {
		this.initialize();
	};
	
	window.XTD.form.prototype = new item();
	window.XTD.form.prototype.serialize = function () {
	};
	window.XTD.form.prototype.initialize = function () {
		
	};
} catch (e) {
    console.log(e);
}

