<div class="jumbotron">
	<p class="lead">
		Select database to see it's schema and modify it.
	</p>
	<p>
		This is the table description page here you can find different table schemas. Or column description make sure to read them if you like 
	</p>
</div>


<?php 
	$tableManagerDb = new TableDb();
	$tables = $tableManagerDb->getTableDesc('dan_options');
?>

<div class="container">
	<?php include('include/navbar.php'); ?>
	<div class="section">
		<ul class="list-group">
			<table class="table table-responsive">
				<thead>
					<tr>
						<?php foreach (array_keys($tables[0]) as $value): ?>
							<th><?php echo $value; ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 0; $i < count($tables) ; $i++) { ?>
						<tr>
							<?php foreach ($tables[$i] as $key => $value ): ?>
								<td><?php echo $value; ?></td>
							<?php endforeach ?>
						</tr>
					<?php } ?>
				</tbody>
				
			</table>
				
		</ul>
	</div>

</div>