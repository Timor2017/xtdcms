try {
	window.XTD.controls = window.XTD.controls || {};
	window.XTD.controls.Checkbox = function (definition) {
		this.definition = definition;
		this.value = '';
	};
	window.XTD.controls.Checkbox.prototype = new window.XTD.item('Checkbox', '复选框');
	window.XTD.controls.Checkbox.prototype.render = function () {
		var style = '';
		console.log(this.definition);
		for (var i = 0; i < this.definition.style.length; i++) {
			style += this.definition.style[i].name + ':' + this.definition.style[i].value + ';';
		}
		return '<label>' + this.definition.properties.display + '</label>' + '<div class="item-control"><input type="checkbox" name="' + this.definition.properties.__id + '" id="' + this.definition.properties.__id + '" style="' + style + '" />';
	};
	window.XTD.controls.Checkbox.prototype.renderSettings = function () {
		return $("<div />")
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<input >").attr("type", "checkbox").value("").on("input", function () { window.XTD.controls.Checkbox.valueChanged('property 1'); } ))
							)
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<input >").attr("type", "checkbox").value("").on("input", function () { window.XTD.controls.Checkbox.valueChanged('property 1'); } ))
							);
	};
	window.XTD.controls.Checkbox.prototype.serialize = function () {
	};
	window.XTD.controls.Checkbox.prototype.valueChanged = function (setting) {
		fire(setting);
	}

} catch (e) {
    console.log(e);
}

