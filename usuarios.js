jQuery("#rowed2").jqGrid({
   	url:'seguridad.php?q=usuarios',
	datatype: "json",
	colNames:['ID','Usuario','Contrasenia', 'Nombre'],
   	colModel:[
   		{name:'id',index:'id', width:30,editable:false},
   		{name:'user',index:'user', width:190,editable:true},
   		{name:'pass',index:'pass', width:190,editable:true,formatter:formatpassword},
   		{name:'nombre',index:'nombre', width:300, editable:true}  		
   ],
   	rowNum:20,
   	rowList:[10,20,30],
   	pager: '#prowed2',
   	sortname: 'id',
    viewrecords: true,
	//croll:1,
    sortorder: "desc",	
    caption:"Mantenimiento de Usuarios.",
	//autoheight: true
	height: "auto"
});
jQuery("#rowed2").jqGrid('navGrid',"#prowed2",{edit:false,add:false,del:false});

 jQuery('#rowed2').jqGrid('inlineNav','#prowed2',{
  
 });

  function formatpassword ()
 {
	return '*****';
 }