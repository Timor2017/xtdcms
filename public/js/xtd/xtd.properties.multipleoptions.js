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
				var data = values[i].split("||");
				var name = "";
				var value = "";
				if (data.length == 1){
					name = data[0];
					value = data[1];
				} else if (data.length == 2 {
					name = data[0];
					value = data[1];
				}
				$("<div />").append(
					$("<input />").attr('id', 'txt_display_'+this.__id+'_'+i).attr('data-options-name-id', this.__id+'_'+i).attr('data-id', this.__id).attr('data-parent-id', this.parent.__id).addClass("property-item-label-display").attr("type", "text").val(name).bind('input', function () {
						var items = $('[data-id='+$this.__id+']');
						var $value = '';
						items.each(function (index, item) {
							$value += $('#txt_display_'+$(item).data('options-name-id')).val() + "||" + $('#txt_value_'+$(item).data('options-name-id')).val() + "\n";
						});
						$this.setValue($value);
						$this.property.value = $this._value;
						$this.fire($value, this);
					})
				).append(
					$("<input />").attr('id', 'txt_value_'+this.__id+'_'+i).attr('data-options-value-id', this.__id+'_'+i).attr('data-id', this.__id).attr('data-parent-id', this.parent.__id).addClass("property-item-label-value").attr("type", "text").val(value).bind('input', function () {
						var items = $('[data-id='+$this.__id+']');
						var $value = '';
						items.each(function (index, item) {
							$value += $('#txt_display_'+$(item).data('options-name-id')).val() + "||" + $('#txt_value_'+$(item).data('options-name-id')).val() + "\n";
						});
						$this.setValue($value);
						$this.property.value = $this._value;
						$this.fire($value, this);
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

