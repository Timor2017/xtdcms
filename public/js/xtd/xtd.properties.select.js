try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.properties = XTD.definitions.properties || {};
	XTD.definitions.properties.Select = function (property) {
		this.__proto__ = new XTD.definitions.Property(property);
		this.setValue(this.property.value);
		
		this.render = function () {
			var $this = this;
			return $("<div />").addClass("property-item")
							.append(
								$("<label />").addClass("property-item-label").html(this.property.name)
							).append(
								$("<div />").addClass("property-item-control")
								.append(
									$("<select />").attr('id', 'select88888'+this.__id).attr('data-id', this.__id).attr('data-parent-id', this.parent.__id).addClass("property-item-label").attr("type", "radio").prop('checked' , this._value.toString() == "true").bind('change', function () {
										//$this.setValue($(this).prop('checked'));
										//$this.property.value = $this._value;
										//$this.fire($(this).prop('checked'), this);
										
									})
								)
							);
		};
		
		return this;
	}
} catch (e) {
    console.log(e);
}

