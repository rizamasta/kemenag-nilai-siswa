<div class="">
		<div id="nav2">
			<a href="<?php echo site_url("manage/siskamling")?>">Siskamling</a>
			<a href="javascript:void(0)" class="selected">Family Guard</a>
			<a href="<?php echo site_url("manage/tourguard")?>">Tour Guard</a>
			<a href="<?php echo site_url("manage/poi")?>">POI</a>
		</div>
		<div class="table_show">
			<div class="table_head">    
				<div class="info"><?php echo $guardian->total?> Family Guard</div>
				<div class="clearfix"></div>
			</div>
			<table id="table_fg" class="table_style" cellspacing="0" width="100%"data-page-length="10" >
			    <thead>
			        <tr>
						<!-- <th>No</th> -->
			            <th>Family Guard</th>
			            <th>Create Date</th>
			            <th>Guardian Name</th>
			            <th>Underguard</th>
			        </tr>
			    </thead>
			</table>
		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function () {
			$('#table_fg').dataTable({
				"processing": true,
				"serverSide": true,
				"order": [[ 0, "asc" ]],
				"columns": [
					{ "width": "20%", "targets": 0 },
					{ "width": "10%", "targets": 1 },
					{ "width": "20%", "targets": 2 },
					{ "width": "50%", "targets": 3 },
				],
				"ajax": {
					"url": "<?php echo site_url(); ?>manage/guardian/getGuardianAjax",
					"type": "GET"
				}
			});

	});
</script>