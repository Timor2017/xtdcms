try{
	window.XTD.controls = window.XTD.controls || {};
	window.XTD.controls.textarea = function (definition){
		this.definition = definition;
		this.value = '';
	};
	window.XTD.controls.textarea.prototype = new window.XTD.item('textarea','多行文本');
	window.XTD.controls.textarea.prototype.render = function(){
		var = style = '';
		console.log(this.definition);
		for(var i = 0;i < this.definition.style.length;i++){
			style += this.definition.style[i].name + ':' + this.definition.style[i].value + ';';
		}
		return '<textarea>' + this.definistion.properties.display + '</textarea>' + '<div class="item-control"><textarea name=">' + this.definistion.properties._id + '"id="' + this.definition.properties._id + '" style="' + style + '"/>';
	};
	window.XTD.controls.textarea.prototype.renderSettings = function () {
		return $("<div />")
		.append($("div /").addClass("item")
		.append($("label ").html("property 1"))
		.append($("<texearea >").value("").on("input",function () { window.XTD.controls.textarea.valueChanged('property 1');}))
		
		)
		.append($("div /").addClass("item")
		.append($("<label >").html("property 1"))
		.append($("texearea ").vlaue("").on("input"),function(){ window.XTD.controls.texearea.valueChanged('property 1');}))
		
		);
	};
	window.XTD.controls.texearea.prototype.serialize = function (){
		
	};
	window.XTD.controls.texearea.prototype.valueChanged = function (setting) {
		fire(setting);
	}
}catch(e){
	console.log(e);
}