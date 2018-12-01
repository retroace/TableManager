<?php 
	global $tableManager;
	$tables = $tableManager->getTables();
	$tableName = array_keys($tables[0])[0];
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo TABLE_PLUGIN_PATH_URL ?>css/tooltipster.bundle.min.css">


<div class="container">
	<?php include('include/navbar.php'); ?>
	<div id="status" class="jumbotron">
		<p class="lead">Status</p>
		<a class="lead" >Currently Selected Database :<span id="currentDatabase">Dan</span></a>
		<p><span id="totalStatusText"> Total tables</span>: <strong id="totalStatus"><?php echo count($tables); ?></strong></p>	
		<?php 
			$table = new TableManagerConfig();
			$databases = $table->getDatabases();
		?>
	</div>
	<div class="d-flex w-100 justify-content-between">
		<p class="lead" id="title">Databases</p>
		<div class="d-flex m-0 p-0 h-0">
			<div style="height: fit-content;" data-toggle="#dbContainers" data-connect="#tableContainers" class="toggle ">
				<i title="Database And Columns" class="btn btn-link fa fa-database"></i>
			</div>
			<div style="height: fit-content;" data-toggle="#tableContainers" data-connect="#dbContainers" class="toggle">
				<i title="Table And Columns" class="btn btn-link fa fa-list-ul"></i>
			</div>
			<div style="height: fit-content;" data-toggle="#status" class="toggle">
				<i title="Status" class="btn btn-link fa fa-list-alt"></i> 
			</div>
		</div>
	</div>
	
	<!-- dbContainers -->
	<div id="dbContainers" class="row">
		<div class="col-md-4" id="databaseContainer">
			<table id="database" class="table table-hover table-responsive">
				<thead>
					<tr>
						<th>S.No</th>
						<th>Database Name</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($databases as $index => $value): ?>
						<tr>
							<td class="font-weight-bold"><?php echo $index+1; ?></td>
							<td><a class="dbName fetch-database" data-db='<?php echo $value[0]; ?>' class="btn btn-link" href="#"><?php echo $value[0]; ?></a></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			
		</div>
		
		<div class="col-md-8" id="info">
			<p id="selectedDbTitle" class="lead alert d-none"></p>
			<div id="selectedDbData" class="d-none">
				
			</div>
		</div>
	</div>
	<!--/ dbContainers -->
	

	<!-- tableContainers -->
	<div id="tableContainers" style="display: none;" class="row">
		<div class="col-md-4"  id="tableContainer">
			<table id="databaseTables" class="table table-hover table-responsive">
				<thead>
					<tr>
						<th>S.No</th>
						<th>Table Name</th>
					</tr>
				</thead>
				<tbody id="table-lists">
					<?php foreach ($tables as $index => $value): ?>
						<tr>
							<td class="font-weight-bold"><?php echo $index+1; ?></td>
							<td><a class="tableName fetchTable fetch-schema-database fetch-table-desc" data-table='<?php echo $value[$tableName]; ?>' class="btn btn-link" href="#"><?php echo $value[$tableName]; ?></a></td>
						</tr>
					<?php endforeach ?>
				</tbody>

			</table>
		</div>
		
		<div class="col-md-8" id="columnsContainer">
			<p id="selectedTableTitle" class="lead alert d-none"></p>
			<div id="selectedTableData" class="d-none">
				
			</div>
		</div>
	</div>
	<!--/ tableContainers -->
	
	<div class="tooltip_templates">
		<div id="tooltip_content">
			<div class="card">
				<div class="card-header" id="tooltipHeader"></div>
				<div class="card-body" id="tooltipBoby"></div>
			</div>
		</div>
	</div>
</div>
<script>
	var databaseTables = <?php echo json_encode($tables); ?>; 
	var databases = <?php echo json_encode($databases); ?>; 
	var currentDatabase = '<?php echo DB_NAME; ?>'; 
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>'; 
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo TABLE_PLUGIN_PATH_URL ?>js/tooltipster.bundle.min.js"></script>
<script src="<?php echo TABLE_PLUGIN_PATH_URL ?>/js/admin.js"></script>