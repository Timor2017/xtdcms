try {
	window.XTD.form.prototype = new item();
	window.XTD.form.prototype.serialize = function () {
	};
} catch (e) {
    console.log(e);
}

