<div id="nav2">
    <a href="javascript:void(0)" class="selected">Siskamling</a>
    <a href="<?php echo site_url("manage/guardian")?>">Family Guard</a>
    <a href="<?php echo site_url("manage/tourguard")?>">Tour Guard</a>
    <a href="<?php echo site_url("manage/poi")?>">POI</a>
</div>
<div class="table_show">
			<div class="table_head">
				<div class="info"><?php echo $total->total ?> Siskamling</div>
				<div class="clearfix"></div>
			</div>
			<table id="table_siskamling" class="table_style" cellspacing="0" width="100%"data-page-length="10" >
			    <thead>
			        <tr>
			            <th>Group Name</th>
			            <th>Address</th>
			            <th>Total Member</th>
			            <th>Create Date</th>
			            <th width="100px" class="arrow_non">Status</th>
			        </tr>
			    </thead>
			</table>
</div>
<div id="pop_box_full2" class="pop_box" style="display:none">
	<div class="popbox_bg_close"></div>
	<div class="pop_box_content">
		<div class="form-group form-group-col-2">
	      	<strong>Group Name</strong>
	      	<input type="text" name="name" class="g_name" readonly="true">
	      	<div class="clearfix"></div>
	    </div>
	    <div class="form-group form-group-col-2">
	      	<strong>Address</strong>
	      	<input type="text" name="address" class="address" readonly="true">
	      	<div class="clearfix"></div>
	    </div>
	    <div class="clearfix"></div>
	    <br>
	    <div align="left" class="total_member">
			
		</div>
		<div class="clearfix"></div>
		<br>
	    <div class="list_member_2 members">
	    </div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
			$('#table_siskamling').dataTable({
				"processing": true,
				"serverSide": true,
				"order": [[ 0, "asc" ]],
				"createdRow": function( row, data, dataIndex ) {
						$(row).addClass('show_detail');
						$(row).on('click',function(){
								viewDetail(data[5]);
							});	
							var s ="";
							if (data[4]==1) {
								s="<span class='label_status'>Active</span>";
							} else {
								s="<span class='label_status past'>Inactive</span>";
							}
						$('td:eq(4)', row).html(s);		
					},
				"columns": [
					{ "width": "40%", "targets": 0 },
					{ "width": "10%", "targets": 1 },
					{ "width": "10%", "targets": 2 },
					{ "width": "20%", "targets": 3 },
					{ "width": "20%", "targets": 4 },
				],
				"ajax": {
					"url": "<?php echo site_url(); ?>manage/siskamling/getSiskamlingAjax",
					"type": "GET"
				}
			});

	});
	function viewDetail(v) {
    $("#pop_box_full2").hide();
    $("#pop_box_loading").show();
    $.ajax({
        url: "<?php echo site_url('manage/siskamling/getSiskamlingJSON/')?>" + v,
        type: "get",
        success: function(response) {
            $("#pop_box_loading").hide();
            $("#pop_box_full2").show();
            var res = JSON.parse(response);
			var total_member = "",list_member="";
			var members = res.member;
            $(".g_name").val(res.name);
            $(".address").val(res.address);
			total_member = "<strong> "+members.length+" Member(s) </strong>"
			$(".total_member").html(total_member);
			try {
				members.forEach(function(val){
					var image ="";
					if(val.path){
						image = "<img src='"+val.path+"'>";
					}
					else{
						image = val.fullname.substring(0,1).toUpperCase();
					}
					list_member +="<div class='user_member'>"+
										"<div class='ratio1_1 box_img'>"+
											"<div class='img_con'>"+
											image+
											"</div>"+
										"</div>"+
										val.fullname+
								"</div>";
				});
				$(".members").html(list_member);
				
			} catch (error) {
				console.log(error);
				list_member ="<strong>Doesn't have a member</strong>";
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $(".msg_loading").html("<strong>Error while fetching data</strong><br/><br/><br/><div align='right'>" +
                "<input type='reset' value='OK' class='btn_save close_box' onclick='closeLoading()'>" +
                "</div>");
        }
    });
};
</script>