try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.properties = XTD.definitions.properties || {};
	XTD.definitions.properties.MultipleOptions = function (property) {
		this.__proto__ = new XTD.definitions.Property(property);
		if (this.property && this.property.value) {
			this.setValue(this.property.value);
		}
		this.render = function () {
			var $this = this;
			var items = $("<div/>");
			var values = this.property.value.split("\n");
			for (var i = 0; i < values.length; i++) {
				$("<div />").append(
					$("<input />").attr('id', 'txt_display_'+this.__id+'_'+i).attr('data-id', this.__id).attr('data-parent-id', this.parent.__id).addClass("property-item-label-display").attr("type", "text").val(this._value).bind('input', function () {
						$this.setValue($(this).val());
						$this.property.value = $this._value;
						$this.fire($(this).val(), this);
					})
				).append(
					$("<input />").attr('id', 'txt_value_'+this.__id+'_'+i).attr('data-id', this.__id).attr('data-parent-id', this.parent.__id).addClass("property-item-label-value").attr("type", "text").val(this._value).bind('input', function () {
						$this.setValue($(this).val());
						$this.property.value = $this._value;
						$this.fire($(this).val(), this);
					})
				).appendTo(items);
			}
			return $("<div />").addClass("property-item")
							.append(
								$("<label />").addClass("property-item-label").html(this.property.name)
							).append(
								$("<div />").addClass("property-item-control")
								.append(
									items
								)
							);
		};
		
		return this;
	}
} catch (e) {
    console.log(e);
}

