var list = $('.control-list');
var item = $('<div />').addClass('list-group-item half').text('Radio Button');
list.append(item);

generateItem(item, function () {
	var row = $('<div />').addClass('row form-item').css('bottom','auto').attr('data-type', 'radiobutton');
	var labelContainer = $('<div />').addClass('col-md-2 col-lg-2').appendTo(row);
	var label = $('<label />').text('Title').addClass('cls-display').appendTo(labelContainer);
	$('<label />').text('*').addClass('cls-required hidden').appendTo(labelContainer);
	var controlContainer = $('<div />').addClass('col-md-10 col-lg-10 cls-value-container')
							.attr({ 'data-value': '[{"name": "value 1"}]', 'data-hint': '', 'placeholder': '', 'data-required': '', 'data-searchable': ''})
							.appendTo(row);
	var div = $('<div />').appendTo(controlContainer);
	var control = $('<input />')
				.attr({ type: 'radio', id: 'test', name: 'test', class: 'cls-value'})
				.css({ 'margin-right': '5px' })
				.appendTo(div);
	var controlDisplay = $('<label />')
				.attr({ 'for': 'test', class: 'cls-value-0'})
				.html("value 1")
				.appendTo(div);
	
	
	return row;
}, function () {
	if (!$form.showProperties['radiobutton']){
		$form.showProperties['radiobutton'] = function () {
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
						$form.currentControl.find('.cls-value-container').attr('id', $(this).val());
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value-container').attr('data-value') : '';
			var values = $.parseJSON(defaultValue); //.split('|');
			var container = $("<div />");
			for (var i = 0; i < values.length; i++) {
				$('<input />')
				.attr('id','p-value-' + i)
				.attr('data-index', i)
				.attr('type','text')
				.val(values[i].name)
				.on('input', function () {
					if ($form.currentControl){
						var index =  $(this).attr('data-index');
						$form.currentControl.find('.cls-value-' + index).html($(this).val());
						values[index]['name'] = $(this).val();
						$form.currentControl.find('.cls-value-container').attr('data-value', JSON.stringify(values));
					}
				})
				.appendTo(container);
				if (values.length > 1) {
					$('<a />')
					.attr('data-index', i)
					.html('del')
					.click(function () {
						var index = $(this).attr('data-index');
						values.splice(index, 1);
						$form.currentControl.find('.cls-value-container').attr('data-value', JSON.stringify(values));
						$form.showProperties['radiobutton']();
						$form.showProperties['radiobutton_generate']();
					})
					.appendTo(container);
				}
			}
			generatePropertyItem('default value', 
				container
			);
			generatePropertyItem('', 
				$('<div />').append(
					$('<a />').text('add').click(function () {
						values.push({"name": 'new value'});
						$form.currentControl.find('.cls-value-container').attr('data-value', JSON.stringify(values));
						$form.showProperties['radiobutton']();
						$form.showProperties['radiobutton_generate']();
					})
				)
				.append(
					$('<span />').html(' | ')
				)
				.append(
					$('<a />').text('batch edit').addClass("settings").popover({
						html : true, 
						content: function() {
							var content = '';
							for (var i = 0; i < values.length; i++) {
								if (content != '') {
									content += '\n';
								}
								content += values[i].name;
							}
							$("#txt_name").html(content);
							return $("#dialog-form").html();
						},
						title: function() {
							return '';
						},
						placement: 'auto',
					})
				)
			);
			
			$form.saveFunction = function () {
				var content = $(".txt-name").val();
				var items = content.split('\n');
				values = [];
				for (var i = 0; i < items.length; i++){
					values.push({'name': items[i]});
					$form.currentControl.find('.cls-value-container').attr('data-value', JSON.stringify(values));
					$form.showProperties['radiobutton']();
					$form.showProperties['radiobutton_generate']();
				}
				
				$(".settings").popover('hide');
			};
			$form.cancelFunction = function () {
			
				$(".settings").popover('hide');
			};
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value-container').attr('data-required') : '';
			generatePropertyItem('is required', 
				$('<input />')
				.attr('id','p-required')
				.attr('type','checkbox')
				.prop('checked', defaultValue)
				.on('change', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-value-container').attr('data-required', $(this).prop('checked'));
						if ($(this).prop('checked')){
							$form.currentControl.find('.cls-required').removeClass('hidden');
						}
						else{
							$form.currentControl.find('.cls-required').addClass('hidden');
						}
					}
				})
			);
			
			defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value-container').attr('data-searchable') : '';
			generatePropertyItem('is searchable', 
				$('<input />')
				.attr('id','p-searchable')
				.attr('type','checkbox')
				.prop('checked', defaultValue)
				.on('change', function () {
					if ($form.currentControl){
						$form.currentControl.find('.cls-value-container').attr('data-searchable', $(this).prop('checked'));
					}
				})
			);
		};
	}
});

$form.showProperties['radiobutton_generate'] = function () {
	var controlContainer = $form.currentControl.find('.cls-value-container');
	defaultValue = ($form.currentControl) ? $form.currentControl.find('.cls-value-container').attr('data-value') : '';
	var values = $.parseJSON(defaultValue); //.split('|');
	controlContainer.empty();
	for (var i = 0; i < values.length; i++) {
		var div = $('<div />').appendTo(controlContainer);
		var control = $('<input />')
					.attr({ type: 'radio', id: 'test', name: 'test', class: 'cls-value'})
					.css({ 'margin-right': '5px' })
					.appendTo(div);
		var controlDisplay = $('<label />')
					.attr({ 'for': 'test', class: 'cls-value-' + i})
					.html(values[i].name)
					.appendTo(div);
	}
};

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
