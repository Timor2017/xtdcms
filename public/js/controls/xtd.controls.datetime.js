try {
	window.XTD.controls = window.XTD.controls || {};
	window.XTD.controls.Datetime = function (definition) {
		this.definition = definition;
		this.value = '';
	};
	window.XTD.controls.Datetime.prototype = new window.XTD.item('datetime', '日期时间');
	window.XTD.controls.Datetime.prototype.render = function () {
		var style = '';
		console.log(this.definition);
		for (var i = 0; i < this.definition.style.length; i++) {
			style += this.definition.style[i].name + ':' + this.definition.style[i].value + ';';
		}
		return '<label>' + this.definition.properties.display + '</label>' + '<div class="item-control"><input type="text"  value="2012-05-15 21:05" id="datetimepicker" name="' + this.definition.properties.__id + '" style="' + style + '" />';
	};
	window.XTD.controls.Datetime.prototype.renderSettings = function () {
		return $("<div />")
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<input >").attr("type", "text").value("").on("input", function () { window.XTD.controls.Datetime.valueChanged('property 1'); } ))
							)
							.append($("<div />").addClass("item")
								.append($("<label >").html("property 1"))
								.append($("<input >").attr("type", "text").value("").on("input", function () { window.XTD.controls.Datetime.valueChanged('property 1'); } ))
							);
	};
	window.XTD.controls.Datetime.prototype.serialize = function () {
	};
	window.XTD.controls.Datetime.prototype.valueChanged = function (setting) {
		fire(setting);
	}

} catch (e) {
    console.log(e);
}

