var list = $('.control-list');
var item = $('<div />').addClass('list-group-item half').text('Multiline');
list.append(item);

generateItem(item, function () {
	var row = $('<div />').addClass('row form-item').css('bottom','auto').attr('data-type', 'singleline');
	var labelContainer = $('<div />').addClass('col-md-2 col-lg-2').appendTo(row);
	var label = $('<label />').text('Title').addClass('cls-display').appendTo(labelContainer);
	$('<label />').text('*').addClass('cls-required hidden').appendTo(labelContainer);
	var controlContainer = $('<div />').addClass('col-md-10 col-lg-10').appendTo(row);
	var control = $('<textarea />')
				.attr({ id: 'test', name: 'test', class: 'cls-value'})
				.attr({ 'data-width': 150, 'data-height': 50, 'data-value': '', 'data-hint': '', 'placeholder': '', 'data-required': '', 'data-searchable': ''})
				.css({ width: '150px', height: '50px' })
	.appendTo(controlContainer);
	
	
	return row;
}, function () {
	if (!$form.showProperties['singleline']){
		$form.showProperties['singleline'] = function () {
			$('#properties').empty();

			var defaultValue = '';
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-display').html() : '';
			generatePropertyItem('title', 
				$('<input />')
				.attr('id','p-title')
				.attr('type','text')
				.val(defaultValue)
				.on('input', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-display').html($(this).val());
						$form.currentControl.find('.cls-value').attr('id', $(this).val());
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value').attr('data-value') : '';
			generatePropertyItem('default value', 
				$('<textarea />')
				.attr('id','p-value')
				.attr('type','text')
				.val(defaultValue)
				.on('input', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-value').val($(this).val()).attr('data-value', $(this).val());
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value').attr('data-width') : '';
			generatePropertyItem('width', 
				$('<input />')
				.attr('id','p-width')
				.attr('type','text')
				.val(defaultValue)
				.on('input', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-value').css('width', $(this).val() + 'px').attr('data-width', $(this).val());
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value').attr('data-height') : '';
			generatePropertyItem('height', 
				$('<input />')
				.attr('id','p-height')
				.attr('type','text')
				.val(defaultValue)
				.on('input', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-value').css('height', $(this).val() + 'px').attr('data-height', $(this).val());
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value').attr('data-hint') : '';
			generatePropertyItem('hint', 
				$('<input />')
				.attr('id','p-hint')
				.attr('type','text')
				.val(defaultValue)
				.on('input', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-value').attr('placeholder', $(this).val()).attr('data-hint', $(this).val());
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value').attr('data-required') : '';
			generatePropertyItem('is required', 
				$('<input />')
				.attr('id','p-required')
				.attr('type','checkbox')
				.prop('checked', defaultValue)
				.on('change', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-value').attr('data-required', $(this).prop('checked'));
						if ($(this).prop('checked')){
							$form.currentControl.find('.cls-required').removeClass('hidden');
						}
						else{
							$form.currentControl.find('.cls-required').addClass('hidden');
						}
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value').attr('data-searchable') : '';
			generatePropertyItem('is searchable', 
				$('<input />')
				.attr('id','p-searchable')
				.attr('type','checkbox')
				.prop('checked', defaultValue)
				.on('change', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-value').attr('data-searchable', $(this).prop('checked'));
					}
				})
			);
			//var container = $('#properties');
			//$('<div />').addClass('property-row').append(
			//	$('<label />').html('width')
			//).append(
			//	$('<input />').attr('id','p-width').attr('type','text')
			//).appendTo(container);
		};
	}
});

//item.draggable({
//	addClasses: true,
//	connectToSortable: '#form_content',
//	helper: function () {
//		var row = $('<div />').addClass('row form-item').css('bottom','auto');
//		var labelContainer = $('<div />').addClass('col-md-2 col-lg-2').appendTo(row);
//		var label = $('<label />').text('Title').appendTo(labelContainer);
//		var controlContainer = $('<div />').addClass('col-md-10 col-lg-10').appendTo(row);
//		var control = $('<input />').attr({ type: 'text', id: 'test', name: 'test'}).appendTo(controlContainer);
//		
//		
//		row.updateControl = function () {
//			control.css('background-color', '#f00');
//		};
//		
//		return row;
//	},
//	revert: 'invalid',
//	cursor: 'move',
//	stop: function( event, ui ) {
//		ui.helper.css('width', '').css('height', '');
//	}
//});
