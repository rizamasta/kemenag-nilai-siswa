<div id="nav2">
			<a href="<?php echo site_url('report/all')?>">All</a>
			<a href="<?php echo site_url('report/called')?>">Called by CS</a>
			<a href="javascript:void(0)" class="selected">Waiting</a>
			<a href="<?php echo site_url('report/helped')?>">Helped</a>
</div>
<div class="table_show">
    <div class="table_head">
		<div class="select-style fl mr20">
			<span></span>
			<form id="formFilter">
			<?php  $va = !empty($_GET['type'])?$_GET['type']:1?> 
				<select name="type" onchange="submitFilter()">
					<option value="1" <?php echo $va==1?'selected':'' ?> >Family Guard</option>
					<option value="2" <?php echo $va==2?'selected':'' ?> >Siskamling</option>
					<option value="3" <?php echo $va==3?'selected':'' ?> >Tour Guard</option>
				</select>
			</form>
		</div>
        <div class="info"></div>
        <div class="clearfix"></div>
    </div>
    <table id="table_all" class="table_style" cellspacing="0" width="100%"data-page-length="10" >
        <thead>
            <tr>
                <!-- <th width="50px" class="arrow_non">No</th> -->
                <th>Date & Time</th>
                <th>Person Name</th>
                <th>Type of Accident</th>
                <th>Location</th>
                <th width="100px" class="arrow_non">Status</th>
            </tr>
        </thead>
        </tbody>
    </table>
</div>
<script>
	$(document).ready(function () {
			$('#table_all').dataTable({
				"processing": true,
				"serverSide": true,
				"columns": [
						{ "width": "20%", "targets": 0 },
						{ "width": "20%", "targets": 1 },
						{ "width": "20%", "targets": 2 },
						{ "width": "30%", "targets": 3 },
						{ "width": "10%", "targets": 4 },
					],
				"createdRow": function( row, data, dataIndex ) {
					$(row).addClass('show_detail');
					$('td:eq(4)', row).html( "<span class='label_status r_waiting'>Waiting</span>" );
					$(row).on('click',function(){
						formCalling(data[9],data[8]);
					});
				},
				"order": [[ 0, "desc" ]],
				"ajax": {
					"url": "<?php echo site_url(); ?>report/getAllWaitingAjax/<?php echo empty($_GET['type'])?1:$_GET['type'];?>",
					"type": "GET"
				},
				"initComplete": function(settings, res){ 
						$(".info").text(formatNumber(res.recordsFiltered)+" Record(s)")
					}
			});
			var opened = "<?php echo  !empty($_GET['opened'])?$_GET['opened']:'';?>";
			var id = "<?php echo !empty($_GET['id'])?$_GET['id']:'';?>";
			var type = <?php echo empty($_GET['type'])?1:$_GET['type'];?>;
			var tbl =""
			if(opened =="true" && id!=""){
				if(type == 1 || type == 3){
					tbl = "tbl_guard_help"
				}
				else{
					tbl = "tbl_siskamling_help"
				}
				formCalling(id,tbl);
			}
	});
</script>