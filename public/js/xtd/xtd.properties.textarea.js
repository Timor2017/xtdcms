try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.properties = XTD.definitions.properties || {};
	XTD.definitions.properties.TextBox = function (property) {
		this.__proto__ = new XTD.definitions.Property(property);
		if (this.property && this.property.value) {
			this.setValue(this.property.value);
		}
		this.render = function () {
			var $this = this;
			return $("<div />").addClass("property-item")
							.append(
								$("<label />").addClass("property-item-label").html(this.property.name)
							).append(
								$("<div />").addClass("property-item-control")
								.append(
									$("<input />").attr('id', 'txt_'+this.__id).attr('data-id', this.__id).attr('data-parent-id', this.parent.__id).addClass("property-item-label").attr("type", "text").val(this._value).bind('input', function () {
										$this.setValue("");
										$this.property.value = $this._value;
										$this.fire($(this).val(), this);
									})
								)
							);
		};
		
		return this;
	}
} catch (e) {
    console.log(e);
}

