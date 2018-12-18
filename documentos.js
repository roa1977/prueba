
   	

jQuery("#grps1").jqGrid({
   	url:'seguridad.php?q=usuarios',
	datatype: "json",
   	colNames:['Inv No', 'Date', 'Client', 'Amount','Tax','Total','Notes'],
   	colModel:[
   		{name:'id',	key : true,	index:'id',	width:55, searchtype:"integer"},
   		{name:'invdate',index:'invdate', width:90},
   		{name:'name', index:'name',	width:100},
   		{name:'amount',index:'amount', width:80, align:"right", searchtype:"number"},
   		{name:'tax',index:'tax', width:80, align:"right", searchtype:"number"},
   		{name:'total',index:'total', width:80,align:"right", searchtype:"number"},
   		{name:'note',index:'note', width:150, sortable:false}
   	],
   	rowNum:10,
    width:700,
   	rowList:[10,20,30],
   	pager: '#pgrps1',
   	sortname: 'invdate',
    viewrecords: true,
    sortorder: "desc",
	jsonReader: {
		repeatitems : false
	},
	caption: "Show query in search",
	height: '100%'
});
jQuery("#grps1").jqGrid('navGrid','#pgrps1',
{edit:false,add:false,del:false},
{},
{},
{},
{multipleSearch:true, multipleGroup:true, showQuery: true}
);