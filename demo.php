

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::::</title>

<!--link rel="stylesheet" type="text/css" media="screen" href="path_to_ui_css_file/jquery-ui-1.7.1.custom.css" /-->
  
<link rel="stylesheet" type="text/css" media="screen" href="themes/redmond/jquery-ui-1.8.2.custom.css" />
<!--link rel="stylesheet" type="text/css" media="screen" href="themes/smoothness/jquery-ui-1.8.18.custom.css" /-->
<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.multiselect.css" />
<style>
html, body {
	margin: 0;			/* Remove body margin/padding */
	padding: 0;
	overflow: hidden;	/* Remove scroll bars on browser window */	
    font-size: 75%;
	/*background-image: url('../imgs/logo.jpg'); definir un logo*/
}
/*Splitter style */

#LeftPane {
	/* optional, initial splitbar position */
	overflow: auto;
}
/*
 * Right-side element of the splitter.
*/

#RightPane {
	padding: 2px;
	overflow: auto;
}
.ui-tabs-nav li {position: relative;}
.ui-tabs-selected a span {padding-right: 10px;}
.ui-tabs-close {display: none;position: absolute;top: 3px;right: 0px;z-index: 800;width: 16px;height: 14px;font-size: 10px; font-style: normal;cursor: pointer;}
.ui-tabs-selected .ui-tabs-close {display: block;}
.ui-layout-west .ui-jqgrid tr.jqgrow td { border-bottom: 0px none;}
.ui-datepicker {z-index:1200;}
.rotate

    {

        /* for Safari */

        -webkit-transform: rotate(-90deg);



        /* for Firefox */

        -moz-transform: rotate(-90deg);



        /* for Internet Explorer */

        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);

    }
</style>

<!--script src="js/jquery.js" type="text/javascript"></script-->
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
<script src="js/jquery.layout.js" type="text/javascript"></script>
<script src="js/i18n/grid.locale-sp.js" type="text/javascript"></script>
<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
</script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="js/src/grid.inlinedit.js" type="text/javascript"></script>
<script src="js/jquery.tablednd.js" type="text/javascript"></script>
<script src="js/jquery.contextmenu.js" type="text/javascript"></script>
<script src="js/ui.multiselect.js" type="text/javascript"></script>
<script type="text/javascript">

jQuery(document).ready(function(){
    //$('#switcher').themeswitcher();

	$('body').layout({
		resizerClass: 'ui-state-default',
        west__onresize: function (pane, $Pane) {
            jQuery("#west-grid").jqGrid('setGridWidth',$Pane.innerWidth()-2);
		}
	});
	$.jgrid.defaults = $.extend($.jgrid.defaults,{loadui:"enable"});
var maintab =jQuery('#tabs','#RightPane').tabs({
        add: function(e, ui) {
            // append close thingy
            $(ui.tab).parents('li:first')
					.append('<span class="ui-tabs-close ui-icon ui-icon-close" title="Close Tab"></span>')
                .find('span.ui-tabs-close')
                .click(function() {
                    maintab.tabs('remove', $('li', maintab).index($(this).parents('li:first')[0]));
                });
            // select just added tab
            maintab.tabs('select', '#' + ui.panel.id);
        }
    });	/**/
    jQuery("#west-grid").jqGrid({
         url: "menu.xml",    
        datatype: "xml",
        height: "auto",
        pager: false,
        loadui: "disable",
        colNames: ["id","Menu de aplicación","url"],
        colModel: [
            {name: "id",width:1,hidden:true, key:true},
            {name: "menu", width:80, resizable: false, sortable:false},
            {name: "url",width:1,hidden:true}
        ],
        treeGrid: true,
		caption: "Administrador",
        ExpandColumn: "menu",
        autowidth: true,
        //width: 580,
		//height: 500,
        //rowNum: 200,
        ExpandColClick: true,
        treeIcons: {leaf:'ui-icon-document-b'},
        onSelectRow: function(rowid) {
            var treedata = $("#west-grid").jqGrid('getRowData',rowid);
            if(treedata.isLeaf=="true") {
                //treedata.url
                var st = "#t"+treedata.id;
				if($(st).html() != null ) {
					maintab.tabs('select',st);
				} else {
					if (treedata.url=='login/salir.php') {
						window.location="login/salir.php";
					} else {
						maintab.tabs('add',st, treedata.menu);
						$(st,"#tabs").load(treedata.url);
					}
				}
            }
        }
    });
	
// end splitter

});
</script>
</head>
<body >
<script type="text/javascript" src="http://ui.jquery.com/themeroller/themeswitchertool/">
	;
</script>

  	<div id="LeftPane" class="ui-layout-west ui-widget ui-widget-content">
		
		<div id="funtions">
			<table id="t-funtions" width=100%>
				<tr>

				</tr>
			</table>
		</div>
		
		<table id="west-grid">
		
		<!-- modulos -->
		</table>
	</div> <!-- #LeftPane -->
	
	<div id="RightPane" class="ui-layout-center ui-helper-reset ui-widget-content" ><!-- Tabs pane -->

		<div id="switcher">
		
		</div>
		<div id="tabs" class="jqgtabs">
			<ul>
				<li><a href="#tabs-1">  </a></li>
			</ul>
			<div id="tabs-1" style="font-size:12px;">Ejemplos: <br/>
			* Opciones de  menú a la izquierda<br/>	
			* Pestañas que se abren según la opción de menú elegida<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<div>
			<span style=" float: right; margin-right:100px; position: relative;"> desarrollado por <a href="mailto:ryv.developers@gmail.com">RyV Desarrollos Web</a> </span>
			</div>
			<br/>
			</div>
		</div>
	</div> <!-- #RightPane -->
</body>
</html>				 