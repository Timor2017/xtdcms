<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array(
    'formjs' => array(
		'//js/xtd/xtd.sequencegenerator.js'
		,'//js/xtd/xtd.collection.js'
		,'//js/xtd/xtd.baseitem.js'
		,'//js/xtd/xtd.item.js'
		,'//js/xtd/xtd.editableitem.js'
		,'//js/xtd/xtd.property.js'
		,'//js/xtd/xtd.form.js'
		,'//js/xtd/xtd.properties.textbox.js'
		,'//js/xtd/xtd.properties.checkbox.js'
		,'//js/xtd/xtd.properties.textarea.js'
		,'//js/xtd/xtd.controls.singleline.js'
		,'//js/xtd/xtd.controls.textarea.js'
		,'//js/xtd/xtd.controls.checkbox.js'
		,'//js/xtd/xtd.controls.radio.js'
		,'//js/xtd/xtd.controls.select.js'
		,'//js/xtd/xtd.controls.datetime.js'
		,'//js/xtd/xtd.controls.daterangepicker.js'
		,'//js/xtd/xtd.controls.date.js'
		,'//js/xtd/xtd.controls.time.js'
		,'//js/xtd/xtd.controls.fileupload.js'
		,'//js/xtd/xtd.validators.mandatory.js'
	),
	'js'=>array(
		//'//js/plugins/jquery/jquery-2.2.4.min.js'
		//,'//js/plugins/jquery-ui/jquery-ui.min.js'
		//'//js/plugins/history/html4+html5/jquery.history.js'
		//,'//js/plugins/daterangepicker/daterangepicker.js'
		//,'//js/plugins/datepicker/bootstrap-datepicker.js'
		//,'//js/plugins/dragula/dragula.js'
		//,'//js/plugins/bootstrap/bootstrap.min.js'
		//,'//js/plugins/slimScroll/jquery.slimscroll.min.js'
		//,'//js/plugins/fastclick/fastclick.js'
		//,'//js/plugins/bootstrap/adminlte.min.js'
		
		'//js/plugins/history/html4+html5/jquery.history.js'
		,'//js/plugins/dragula/dragula.js'
		,'//js/plugins/bootstrap/bootstrap.min.js'
		,'//js/plugins/select2/select2.full.min.js'
		//,'//js/plugins/morris/morris.min.js' 
		//,'//js/plugins/sparkline/jquery.sparkline.min.js'
		//,'//js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'
		//,'//js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'
		//,'//js/plugins/knob/jquery.knob.js'
		//,'//js/plugins/datatables/jquery.dataTables.min.js'
		//,'//js/plugins/datatables/dataTables.bootstrap.min.js'
		,'//js/plugins/daterangepicker/moment.js'
		,'//js/plugins/daterangepicker/daterangepicker.js'
		,'//js/plugins/datepicker/bootstrap-datepicker.js'
		//,'//js/bootstrap-datetimepicker.min.js'		
		,'//js/plugins/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js'
		//,'//js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'
		//,'//js/plugins/slimScroll/jquery.slimscroll.min.js'
		//,'//js/plugins/fastclick/fastclick.js'
		,'//js/adminlte.min.js'
	),
	'css'=>array(
		 '//css/bootstrap.min.css'
		,'//js/plugins/jquery-ui-1.11.4/jquery-ui.min.css'
		,'//css/font-awesome.min.css'
		,'//css/AdminLTE.min.css'
		,'//css/skins/skin-blue-light.min.css'
		,'//js/plugins/iCheck/flat/blue.css'
		,'//js/plugins/datepicker/datepicker3.css'
		,'//js/plugins/daterangepicker/daterangepicker.css'
		,'//js/plugins/daterangepicker/daterangepicker-bs3.css'
		,'//js/plugins/jquery-ui-1.11.4/jquery-ui.min.css'
		,'//css/dragula.css'
		,'//css/style.css'
		,'//css/bootstrap-datetimepicker.min.css'
		,'//js/plugins/select2/select2.min.css'
		,'//js/plugins/perfect-scrollbar/css/perfect-scrollbar.min.css'
	),
    // 'js' => array('//js/file1.js', '//js/file2.js'),
    // 'css' => array('//css/file1.css', '//css/file2.css'),
);