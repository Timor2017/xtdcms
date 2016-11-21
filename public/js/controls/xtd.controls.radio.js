try {
	window.XTD.controls = window.XTD.controls || {};
	window.XTD.controls.radio = function (definition) {
		this.definition = definition;
		this.value = '';
	};
	window.XTD.controls.radio.prototype = new window.XTD.item('radio', '单选按钮');
	window.XTD.controls.radio.prototype.render = function () {
		var style = '';
		console.log(this.definition);
		for (var i = 0; i < this.definition.style.length; i++) {
			style += this.definition.style[i].name + ':' + this.definition.style[i].value + ';';
		}
		return '<label>' + this.definition.properties.display + '</label>' + '<div class="item-control"><input type="radio" name="' + this.definition.properties.__id + '" id="' + this.definition.properties.__id + '" style="' + style + '" />';
	};
	window.XTD.controls.singleline.prototype.renderSettings = function () {
		return $("<div />")
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<input >").attr("type", "radio").value("").on("input", function () { window.XTD.controls.radio.valueChanged('property 1'); } ))
							)
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<input >").attr("type", "radio").value("").on("input", function () { window.XTD.controls.radio.valueChanged('property 1'); } ))
							);
	};
	window.XTD.controls.radio.prototype.serialize = function () {
	};
	window.XTD.controls.radio.prototype.valueChanged = function (setting) {
		fire(setting);
	}

} catch (e) {
    console.log(e);
}

