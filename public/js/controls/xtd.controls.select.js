try {
	window.XTD.controls = window.XTD.controls || {};
	window.XTD.controls.select = function (definition) {
		this.definition = definition;
		this.value = '';
	};
	window.XTD.controls.select.prototype = new window.XTD.item('select', '下拉列表');
	window.XTD.controls.select.prototype.render = function () {
		var style = '';
		console.log(this.definition);
		for (var i = 0; i < this.definition.style.length; i++) {
			style += this.definition.style[i].name + ':' + this.definition.style[i].value + ';';
		}
		return '<label>' + this.definition.properties.display + '</label>' + '<div class="item-control"><select name="' + this.definition.properties.__id + '" id="' + this.definition.properties.__id + '" style="' + style + '" />';
	};
	window.XTD.controls.select.prototype.renderSettings = function () {
		return $("<div />")
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<select />").append("<option value='Value'>无</option>").on("onselect", function () { window.XTD.controls.select.valueChanged('property 1'); } ))
							)
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<select />").append("<option value='Value'>无</option>").on("onselect", function () { window.XTD.controls.select.valueChanged('property 1'); } ))
							);
	};
	window.XTD.controls.select.prototype.serialize = function () {
	};
	window.XTD.controls.select.prototype.valueChanged = function (setting) {
		fire(setting);
	}

} catch (e) {
    console.log(e);
}

