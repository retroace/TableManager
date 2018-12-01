var tables = databaseTables.map(function(index, elem) {
	return index;
})

var tablesArray = tables.map(function(key,value){
	return key[Object.keys(key)];
});

jQuery(document).on('click', '.fetch-table-desc', function(event) {
	event.preventDefault();
	var table = jQuery(this).data('table');
	$.ajax({
		url: ajaxurl,
		type: 'POST',
		dataType: 'HTML',
		data: {action: 'get_table_details_table_manager',table: table},
	})
	.done(function(data) {
		console.log("success");
		console.log(data);
	})
	.fail(function(error) {
		console.log("error");
		console.log(error);
	});
	
});
var dbData = [];

// Fetching database data from here
jQuery(document).on('click', '.fetch-database', function(event) {
	event.preventDefault();
	var db = jQuery(this).data('db');
	
	jQuery(this).closest('tr').addClass('table-active').siblings('tr').removeClass('table-active');
	
	$.ajax({
		url: ajaxurl,
		type: 'POST',
		dataType: 'HTML',
		data: {action: 'get_table_table_manager',database: db},
	})
	.done(function(data) {
		var parsedData = JSON.parse(data);
		dbData = parsedData[0];
	
		var tables = dbData.map(function(data,index){
			return data[Object.keys(data)];
		});

		jQuery('#info').removeClass("d-none");
		jQuery('#selectedDbTitle').html("Selected database : "+parsedData['database']).removeClass('d-none');

		jQuery('#selectedDbData').html("<ul class='list-group'>"+returnList(tables,"fetchTable")+"</ul>").removeClass('d-none');
		console.log('called');
		jQuery('#table-lists').html(returnTableRow(tables,"fetchTable"));
		jQuery('#totalStatus').text(Object.keys(response.table).length);
		jQuery('#currentDatabase').text(response.dbName);

	})
	.fail(function(error) {
		console.log("error");
		console.log(error);
	});
	
	$.ajax({
		url: ajaxurl,
		type: 'POST',
		dataType: 'HTML',
		data: {action: 'get_database_schema_table_manager',database: db},
	})
	.done(function(data) {
		response = JSON.parse(data);		
	})
	.fail(function(error) {
		console.log("error");
		console.log(error);
	});


});


function returnList(list,classname = null){
	var li = "";

	for (var i = 0; i < list.length; i++) {
		li = li+"<li class='list-group-item "+classname+"'>"+list[i]+"</li>";
	}
	return li;
}

function returnTableRow(list,classname = null){
	var li = "";
	classname = (classname.length) ? 'class="'+classname+'"' : null;
	
	for (var i = 0; i < list.length; i++) {
		var count = i+1;
		li += "<tr "+classname+" data-table="+list[i]+">";
		li += "<td>"+count+"</td>";
		li += "<td>"+list[i]+"</td>";
		li += "</tr>";
	}
	return li;
}


function tableData(tableData){

	var tr = '<tr>';
	var td = '<td class="font-weight-bold">1</td>';
	// var td2 = '<td><a class="tableName fetch-table-desc" data-table="'+name+'" class="btn btn-link" href="#"> '+name+'</a></td>';
	var closetr = '</tr>';
}


jQuery(document).on("click",'.toggle',function(e){
	e.preventDefault();
	jQuery('.toggle').removeClass('bg-success text-light');
	jQuery(this).addClass('bg-success text-light');
	var toggle = jQuery(this).data('toggle');
	
	if (jQuery(this).data('connect')) {
		var connect = jQuery(this).data('connect');
		jQuery(connect).hide();
		jQuery(toggle).show();
	}else{
		jQuery(toggle).toggle();		
	}
});

var response = [];

jQuery(document).on('click', '.fetch-schema-database', function(event) {
	event.preventDefault();
	var db = jQuery(this).data('db');
	
	if (db.length == 0) {
		var db = jQuery(this).text();

	}
	
	$.ajax({
		url: ajaxurl,
		type: 'POST',
		dataType: 'HTML',
		data: {action: 'get_database_schema_table_manager',database: db},
	})
	.done(function(data) {
		response = JSON.parse(data);
		
		// All the table information are in table Array 
		// Need to extract the array in the heirarchy form to have good data source
		// When the array are in heirarchy form it is easy to get everything in order
		// Need to send only some data instead of sending every data from backend so that
		// User will get only some data instead of whole schema

		// var structure = {
		// 	dbname: response[0].TABLE_SCHEMA,
		// 	tables: [

		// 	]
		// };
		// var table = {
		// 	name: 
		// };
		// var tableArray = [];
		// var currentTable = '';
		// for(var i = 0; i < data.length; i++){
		//     if(currentTable != data[i].TABLE_NAME){
		// 		currentTable = data[i].TABLE_NAME;
		// 		if(tableArray.indexOf(data[i].TABLE_NAME) < 1){
		// 			tableArray.push(data[i].TABLE_NAME);
		// 		}
		// 	}
		// 	table.push({name: data[i].TABLE_NAME,column: data[i].COLUMN_NAME,type: data[i].COLUMN_TYPE,default: data[i].COLUMN_DEFAULT,comment: data[0].COLUMN_COMMENT});
			
		// }



		// for (var i = 0; i < response.length; i++) {
		// 	var columnName = response[i].COLUMN_NAME;
		// 	var columnType = response[i].COLUMN_TYPE;
		// 	tableName = response[0].TABLE_NAME;
		// 	var defaultValue = (response[i].COLUMN_DEFAULT == undefined) ? 'notDefined' : response[i].COLUMN_DEFAULT;
		// 	var nullable = response[i].IS_NULLABLE;

		// 	var a = {"columnName": columnName,"type": columnType,"default": defaultValue,"isNullable": nullable};
		// 	console.log("Column :" + properData.column);
			
		// 	if (properData[tableName] == undefined) {
		// 		properData[tableName] = tableName;
		// 	}
			
		// 	if (properData[tableName].columns == undefined) {
		// 		properData[tableName].columns = [];
		// 	}
		// 	console.log("Table property " + properData[tableName]);
		// 	console.log("Column property " + properData[tableName].columns);
		// 	var columnsData = properData[tableName].columns;
		// 	columnsData.concat(a);
		// }
		// console.log(properData);

	})
	.fail(function(error) {
		console.log("error");
		console.log(error);
	});
	

});

var prevTableName = '';
jQuery(document).on('click',".fetchTable",function(e){
	e.preventDefault();

	if (jQuery(this).data('table')) {
		var tableName = jQuery(this).data('table');
	}else{
		var tableName = jQuery(this).text();
	}
	
	if (prevTableName != tableName) {
		var contents = modelDisplayData(response,tableName);

		jQuery("#table-model").remove();
		jQuery('#status').append(contents);
	
		prevTableName = tableName;
	}

	$('#table-model').dialog({
		modal: true,
		"width": "60%",
		title: "Table Schema",
	});
});

jQuery(document).keyup(function(e) {
	if (jQuery('#table-model').dialog('isOpen')) {
		if (e.which == 39 || e.which == 37) {
			var table = jQuery('#table-model').children('p.lead').data('table');
			var tableKeys = Object.keys(response.table);
			
			if (e.which == 39) {
				if (tableKeys.indexOf(table) == tableKeys.length-1) {
					var tableName = tableKeys[0];
				}else{
					var tableName =	tableKeys[tableKeys.indexOf(table) + 1];
				}
			}

			if (e.which == 37) {
				if (tableKeys.indexOf(table) == 0) {
					var tableName = tableKeys[tableKeys.length -1];
				}else{
					var tableName =	tableKeys[tableKeys.indexOf(table) - 1];
				}
			}
				

			var data = changeModelData(tableName);
			jQuery('#model-table-name').data('table',tableName);
			jQuery('#model-table').children('tbody').html(data['body']);
			jQuery('#model-table-name').text(data['title']);
		}
	}

});

function getTableName(tableName){
	var title = tableName.split('_').join(" ");
	title = title.charAt(0).toUpperCase() + title.slice(1);
	return title;
}

function changeModelData(tableName){
	var content = response.table[tableName].column;
	var column = '';

	for (var i = 0; i < content.length; i++) {
		column+='<tr>';
			column += '<td>'+content[i].name+'</td>';	
			column += '<td>'+content[i].type+'</td>';	
			column += '<td>'+content[i].nullable+'</td>';	
		column+='</tr>';
	}

	return {"title":getTableName(tableName),'body': column};
}

function modelDisplayData(data,tableName){
	var totalTable = Object.keys(data.table).length;
	var key = Object.keys(data.table); 
	var content = data.table[tableName].column;
	
	var title = getTableName(tableName);

	var column = ''; 
	column += "<div class='table-model' id='table-model'>";
	column += "<p class='lead' id='model-table-name' data-table='"+tableName+"'> Table name: "+title+"</p>";
	column += '<table class="table table-hover" id="model-table"><thead><tr>';
	column += '<th>Name</th>';
	column += '<th>Type</th>';
	column += '<th>Nullable</th>';
	column += '</tr><thead><tbody>';
			
	for (var i = 0; i < content.length; i++) {
		column+='<tr>';
			column += '<td>'+content[i].name+'</td>';	
			column += '<td>'+content[i].type+'</td>';	
			column += '<td>'+content[i].nullable+'</td>';	
		column+='</tr>';
	}
	column+='</tbody>';

	column += '</table>';	
	column += "</div>";
	
	return column;
}
