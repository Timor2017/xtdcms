try {
	XTD.definitions = XTD.definitions || {};
	XTD.definitions.properties = XTD.definitions.properties || {};
	XTD.definitions.properties.Radio = function (property) {
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
									$('#datetimepicker').bind("click",function(){alert("dfdf");datetimepicker({format: 'yyyy-mm-dd hh:ii'	})});									
								)
							);
		};
		
		return this;
	}
} catch (e) {
    console.log(e);
}

