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
		,'//js/xtd/xtd.controls.phone.js'
		,'//js/xtd/xtd.validators.mandatory.js'
		,'//js/xtd/xtd.validators.checkexists.js'
		,'//js/xtd/xtd.validators.checknotexists.js'
		,'//js/xtd/xtd.handlers.displayhandler.js'
	),
	'js'=>array(
		//'//plugins/jquery/jquery-2.2.4.min.js'
		//,'//plugins/jquery-ui/jquery-ui.min.js'
		//'//plugins/history/html4+html5/jquery.history.js'
		//,'//plugins/daterangepicker/daterangepicker.js'
		//,'//plugins/datepicker/bootstrap-datepicker.js'
		//,'//plugins/dragula/dragula.js'
		//,'//plugins/bootstrap/bootstrap.min.js'
		//,'//plugins/slimScroll/jquery.slimscroll.min.js'
		//,'//plugins/fastclick/fastclick.js'
		//,'//plugins/bootstrap/adminlte.min.js'
		
		'//plugins/history/html4+html5/jquery.history.js'
		,'//plugins/dragula/dragula.js'
		,'//plugins/bootstrap/bootstrap.min.js'
		,'//plugins/select2/select2.full.min.js'
		//,'//plugins/morris/morris.min.js' 
		//,'//plugins/sparkline/jquery.sparkline.min.js'
		//,'//plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'
		//,'//plugins/jvectormap/jquery-jvectormap-world-mill-en.js'
		//,'//plugins/knob/jquery.knob.js'
		//,'//plugins/datatables/jquery.dataTables.min.js'
		//,'//plugins/datatables/dataTables.bootstrap.min.js'
		,'//plugins/daterangepicker/moment.js'
		,'//plugins/daterangepicker/daterangepicker.js'
		,'//plugins/datepicker/bootstrap-datepicker.js'
		//,'//js/bootstrap-datetimepicker.min.js'		
		,'//plugins/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js'
		//,'//plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'
		//,'//plugins/slimScroll/jquery.slimscroll.min.js'
		//,'//plugins/fastclick/fastclick.js'
		,'//js/adminlte.min.js'
	),
	'css'=>array(
		 '//css/bootstrap.min.css'
		,'//plugins/jquery-ui-1.11.4/jquery-ui.min.css'
		,'//css/font-awesome.min.css'
		,'//css/AdminLTE.min.css'
		,'//css/skins/skin-green-light.min.css'
		,'//plugins/iCheck/flat/green.css'
		,'//plugins/datepicker/datepicker3.css'
		,'//plugins/daterangepicker/daterangepicker.css'
		,'//plugins/daterangepicker/daterangepicker-bs3.css'
		,'//plugins/jquery-ui-1.11.4/jquery-ui.min.css'
		,'//css/dragula.css'
		,'//css/style.css'
		,'//css/bootstrap-datetimepicker.min.css'
		,'//plugins/select2/select2.min.css'
		,'//plugins/perfect-scrollbar/css/perfect-scrollbar.min.css'
	),
    // 'js' => array('//js/file1.js', '//js/file2.js'),
    // 'css' => array('//css/file1.css', '//css/file2.css'),
);