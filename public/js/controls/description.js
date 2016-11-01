var list = $('.control-list');
var item = $('<div />').addClass('list-group-item half').text('Description');
list.append(item);

var $description = {};
$description.onChange = function () {
	
};

generateItem(item, function () {
	var row = $('<div />').addClass('row form-item').css('bottom','auto').attr('data-item', '').attr('data-type', 'description');
	var controlContainer = $('<div />').addClass('col-md-12 col-lg-12').appendTo(row);
	var controlDisplay = $('<div />')
							.attr({ class: 'cls-display', 'data-size': '12' })
							.css('font-size', '12pt')
							.html('Description').appendTo(controlContainer);
	//var control = $('<input />').attr({ type: 'hidden', id: 'test', name: 'test', value: 'Description', class: 'cls-value'}).appendTo(controlContainer);
	
	return row;
}, function () {
	if (!$form.showProperties['description']){
		$form.showProperties['description'] = function () {
			$('#properties').empty();
			
			var defaultValue = '';
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-display').html() : '';
			generatePropertyItem('label', 
				$('<input />')
				.attr('id','p-text')
				.attr('type','text')
				.val(defaultValue)
				.on('input', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-display').html($(this).val());
						//$form.currentControl.find('.cls-value').val($(this).val());
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-display').attr('data-size') : '';
			generatePropertyItem('size', 
				$('<input />')
				.attr('id','p-size')
				.attr('type','text')
				.val(defaultValue)
				.on('input', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-display').attr('data-size', $(this).val());
						$form.currentControl.find('.cls-display').css('font-size', $(this).val()+"pt");
						//$form.currentControl.find('.cls-value').val($(this).val());
					}
				})
			);
			//var container = $('#properties');
			//$('<div />').addClass('property-row').append(
			//	$('<label />').html('text')
			//).append(
			//	$('<input />').attr('id','p-text').attr('type','text').on('input', function () {
			//		obj.find('.cls-display').html($(this).val());
			//		obj.find('.cls-value').html($(this).val());
			//	})
			//).appendTo(container);
		};
	}
});

//item.draggable({
//	addClasses: true,
//	connectToSortable: '#form_content',
//	helper: function () {
//		var row = $('<div />').addClass('row form-item').css('bottom','auto').attr('data-item', '');
//		var controlContainer = $('<div />').addClass('col-md-12 col-lg-12').appendTo(row);
//		var controlDisplay = $('<div />').attr({ id: 'test'}).text('Description').appendTo(controlContainer);
//		var control = $('<input />').attr({ type: 'hidden', id: 'test', name: 'test'}).appendTo(controlContainer);
//		
//		return row;
//	},
//	revert: 'invalid',
//	cursor: 'move',
//	stop: function( event, ui ) {
//		ui.helper.css('width', '').css('height', '');
//	}
//});