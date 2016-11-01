try {
	window.XTD.controls = window.XTD.controls || {};
	window.XTD.controls.singleline = function (definition) {
		this.definition = definition;
		this.value = '';
	};
	window.XTD.controls.singleline.prototype = new window.XTD.item('singleline', '單行文字');
	window.XTD.controls.singleline.prototype.render = function () {
		var style = '';
		console.log(this.definition);
		for (var i = 0; i < this.definition.style.length; i++) {
			style += this.definition.style[i].name + ':' + this.definition.style[i].value + ';';
		}
		return '<label>' + this.definition.properties.display + '</label>' + '<div class="item-control"><input type="text" name="' + this.definition.properties.__id + '" id="' + this.definition.properties.__id + '" style="' + style + '" />';
	};
	window.XTD.controls.singleline.prototype.renderSettings = function () {
		return $("<div />")
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<input >").attr("type", "text").value("").on("input", function () { window.XTD.controls.singleline.valueChanged('property 1'); } ))
							)
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<input >").attr("type", "text").value("").on("input", function () { window.XTD.controls.singleline.valueChanged('property 1'); } ))
							);
	};
	window.XTD.controls.singleline.prototype.serialize = function () {
	};
	window.XTD.controls.singleline.prototype.valueChanged = function (setting) {
		fire(setting);
	}

} catch (e) {
    console.log(e);
}

