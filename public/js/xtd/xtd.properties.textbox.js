try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.properties = XTD.definitions.properties || {};
	XTD.definitions.properties.TextBox = function (name, display) {
		this.__proto__ = new XTD.definitions.Property(name, display);
		this.name = name;
		this.display = display;
		
		this.render = function () {
			$this = this;
			return $("<div />").addClass("property-item")
							.append(
								$("<label />").addClass("property-item-label").html(this.display)
							).append(
								$("<div />").addClass("property-item-control")
								.append(
									$("<input />").attr('id', 'txt_'+this.__id).attr('data-id', this.__id).attr('data-parent-id', this.parent.__id).addClass("property-item-label").attr("type", "text").val(this.value).bind('input', function () {
										$this.fire($(this).val(), this);
									})
								)
							);
		};
		
		return this;
	}
	//XTD.definitions.properties.TextBox.prototype = new XTD.definitions.Property();
} catch (e) {
    console.log(e);
}

