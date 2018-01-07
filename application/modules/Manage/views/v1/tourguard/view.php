<div id="nav2">
    <a href="<?php echo site_url("manage/siskamling")?>">Siskamling</a>
    <a href="<?php echo site_url("manage/guardian")?>">Family Guard</a>
    <a href="javascript:void(0)" class="selected">Tour Guard</a>
    <a href="<?php echo site_url("manage/poi")?>">POI</a>
</div>
<div class="table_show">
			<div class="table_head">
				<div class="info"><?php echo $tour_guard->total?> Tour Guard</div>
				<div class="clearfix"></div>
			</div>
			<table id="table_tour" class="table_style" cellspacing="0" width="100%"data-page-length="10" >
			    <thead>
			        <tr>
			            <th>Group Name</th>
			            <th>Start Date</th>
			            <th>End Date</th>
			            <th>Total Member</th>
			            <th width="100px" class="arrow_non">Status</th>
			        </tr>
			    </thead>
			</table>
</div>
<script type="text/javascript">
	$(document).ready(function () {
			$('#table_tour').dataTable({
				"processing": true,
				"serverSide": true,
				"order": [[ 0, "asc" ]],
				"columns": [
					{ "width": "40%", "targets": 0 },
					{ "width": "10%", "targets": 1 },
					{ "width": "10%", "targets": 2 },
					{ "width": "20%", "targets": 3 },
					{ "width": "20%", "targets": 4 },
				],
				"ajax": {
					"url": "<?php echo site_url(); ?>manage/tourguard/getTourGuardAjax",
					"type": "GET"
				}
			});

	});
</script>