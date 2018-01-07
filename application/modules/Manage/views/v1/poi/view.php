<div id="nav2">
			<a href="<?php echo site_url("manage/siskamling")?>">Siskamling</a>
            <a href="<?php echo site_url("manage/guardian")?>">Family Guard</a>
            <a href="<?php echo site_url("manage/tourguard")?>">Tour Guard</a>
            <a href="javascript:void(0)" class="selected">POI</a>
</div>
<div class="table_show">
    <div class="table_head">
        <form method="get" id="form_poi_type">
        <div class="select-style fl mr20">
            <span></span>
            <?php $poi_type = !empty($_GET['poi_type'])?$_GET['poi_type']:"1";
            $poi_type_url = !empty($_GET['poi_type'])?'?poi_type='.$_GET['poi_type']:""; ?>
                <select name="poi_type" required="" class="poi_type">
                    <option value="1" <?php echo $poi_type==1?'selected':''; ?> >Kantor Polisi</option>
                    <option value="2" <?php echo $poi_type==2?'selected':''; ?>>Rumah Sakit</option>
                    <option value="3" <?php echo $poi_type==3?'selected':''; ?>>Pemadam Kebakaran</option>
                    <option value="4" <?php echo $poi_type==4?'selected':''; ?>>Ambulan</option>
                    <option value="5" <?php echo $poi_type==5?'selected':''; ?>>Rumah Sakit Hewan</option>
                    <option value="6" <?php echo $poi_type==6?'selected':''; ?>>Bengkel</option>
                    <option value="7" <?php echo $poi_type==7?'selected':''; ?>>Pangkalan Militer</option>
                    <option value="8" <?php echo $poi_type==8?'selected':''; ?>>Komnasham Perempuan</option>
                    <option value="9" <?php echo $poi_type==9?'selected':''; ?>>Komnasham Anak</option>
                </select>
        </div>
        <a href="javascript:void(0)" class="btn_add box_modal2 mt5">+ Add POI</a>
        <div class="clearfix"></div>
        </form>
    </div>
    <table id="table_poi" class="table_style" cellspacing="0" width="100%"data-page-length="10" >
        <thead>
            <tr>
                <!-- <th width="50px" class="arrow_non">No</th> -->
                <th>POI Name</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Region</th>
                <th>Is 24 Hours</th>
                <th width="100px" class="action">Action</th>
            </tr>
        </thead>
    </table>
</div>
<div id="pop_box2" class="pop_box" style="display:none;">
    <div class="popbox_bg_close"></div>
    <div class="pop_box_content">
        <form action="" method="post" id="form_poi" onsubmit="return setImageName();" enctype="multipart/form-data">
            <div class="form-group form-group-col-2">
                <strong>Category</strong>
                <div class="select-style">
                    <span></span>
                    <select name="poi_type" required="" class="poi_type2">
                        <option value="1" <?php echo $poi_type==1?'selected':''; ?> >Kantor Polisi</option>
                        <option value="2" <?php echo $poi_type==2?'selected':''; ?>>Rumah Sakit</option>
                        <option value="3" <?php echo $poi_type==3?'selected':''; ?>>Pemadam Kebakaran</option>
                        <option value="4" <?php echo $poi_type==4?'selected':''; ?>>Ambulan</option>
                        <option value="5" <?php echo $poi_type==5?'selected':''; ?>>Rumah Sakit Hewan</option>
                        <option value="6" <?php echo $poi_type==6?'selected':''; ?>>Bengkel</option>
                        <option value="7" <?php echo $poi_type==7?'selected':''; ?>>Pangkalan Militer</option>
                        <option value="8" <?php echo $poi_type==8?'selected':''; ?>>Komnasham Perempuan</option>
                        <option value="9" <?php echo $poi_type==9?'selected':''; ?>>Komnasham Anak</option>
                    </select>
                </div>
            </div>
            <div class="form-group form-group-col-2">
                <strong>POI Name</strong>
                <input type="text" name="poi_name" class="poi_name name" required="true">
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group form-group-col-2">
                <strong>Latitude</strong>
                <input type="text" name="latitude" class="latitude coor" required="true">
                <div class="clearfix"></div>
            </div>
            <div class="form-group form-group-col-2">
                <strong>Longitude</strong>
                <input type="text" name="longitude" class="longitude coor" required="true">
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <strong>Address</strong>
                <input type="text" name="address" class="address">
                <div class="clearfix"></div>
            </div>
            <div align="left" style="top: 20px !important;padding-top: 20px;">
                    <strong>24 Hours</strong>
                    <div class="inactive_switch switch_hours">
                    <span class="off">No</span>
                            <div class="flipswitch">
                                <input type="checkbox" name="is_24hours" class="flipswitch-cb is24hours" id="fs" checked>
                                <label class="flipswitch-label" for="fs">
                                    <div class="flipswitch-inner"></div>
                                    <div class="flipswitch-switch"></div>
                                </label>
                            </div>
                    <span>Yes</span>
            </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group form-group-col-2 div_open" style="display:none">
                <strong>Open</strong>
                <div class="select-style">
                    <span></span>
                    <select id="open" name="open" required="true" class="open">
                        <option value="06:00:00">06:00</option>
                        <option value="06:30:00">06:30</option>
                        <option value="07:00:00">07:00</option>
                        <option value="07:30:00">07:30</option>
                        <option value="08:00:00">08:30</option>
                        <option value="08:30:00">08:00</option>
                        <option value="09:00:00">09:00</option>
                        <option value="09:30:00">09:30</option>
                        <option value="10:00:00">10:00</option>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group div_close form-group-col-2" style="display:none">
                <strong>Close</strong>
                <div class="select-style">
                    <span></span>
                    <select id="close" name="close" required="true" class="open">
                        <option value="15:00:00">15:00</option>
                        <option value="15:30:00">15:30</option>
                        <option value="16:00:00">16:00</option>
                        <option value="16:30:00">16:30</option>
                        <option value="17:00:00">17:30</option>
                        <option value="17:30:00">17:00</option>
                        <option value="18:00:00">18:00</option>
                        <option value="18:30:00">18:30</option>
                        <option value="19:00:00">19:00</option>
                        <option value="20:00:00">17:30</option>
                        <option value="20:30:00">17:00</option>
                        <option value="21:00:00">21:00</option>
                        <option value="21:30:00">21:30</option>
                        <option value="22:00:00">22:00</option>
                        <option value="22:30:00">22:30</option>
                        <option value="23:00:00">23:00</option>
                        <option value="23:30:00">23:30</option>
                        <option value="00:00:00">00:00</option>
                        <option value="00:30:00">00:30</option>
                        <option value="01:00:00">01:00</option>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group form-group-col-2">
                <strong>Phone Number 24 Hours</strong>
                <input type="text" name="phone_no_24" class="phone_no_24 phone"  maxlength="15">
                <div class="clearfix"></div>
            </div>
            <div class="form-group form-group-col-2">
                <strong>Phone Number</strong>
                <input type="text" name="phone_no" class="phone_no phone" maxlength="15">
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <strong>
                    Upload Attachment
                    <label class="btn_add_plus" >
                        <span>+Upload File</span>
                        <input type="file" accept=".png, .jpg, .jpeg" name="gambar" class="gambar">
                    </label>
                </strong>
                <div class="list_attach">
                    <span class="ico">
                        <img src="<?php echo site_url('/assets/images/ico_doc.png')?>" alt="">
                    </span>
                    <input type="hidden" name="image_name" id="img_name">
                    <div class="filename"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <strong>Region</strong>
                <input type="text" name="region" class="region">
                <div class="clearfix"></div>
            </div>
            <br>
            <div align="center">
                <input type="reset" value="CANCEL" class="btn_cancel close_box">
                <input type="submit" value="SAVE" class="btn_save">
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {
            $('#table_poi').dataTable({
                "processing": true,
                "serverSide": true,
                "createdRow": function( row, data, dataIndex ) {
                                $('td', row).eq(4).text(data[4]==1?'Yes':'No');
                                if(data[2]&&data[5]){
                                    $('td', row).eq(2).text(data[2]+' / '+data[5]);
                                }
                                else if(data[2]!='' && data[5]==''){
                                    $('td', row).eq(2).text(data[2]);
                                }
                                else if(data[2]==''&&data[5]!=''){
                                    $('td', row).eq(2).text(data[5]);
                                }
                                else {
                                    $('td', row).eq(2).text('-');
                                }
                                $('td', row).eq(5).addClass('action');
                                $('td', row).eq(5).html("<a href='javascript:void(0)' class='' onclick='editButton("+data[6]+")'><img src='<?php echo site_url('assets/images/ico_edit.png')?>' alt=''></a>"+
                                                        "<a href='javascript:void(0)' class='delete_btn' class='delete' onclick='deleteButton(\"<?php echo site_url('manage/poi/delete/')?>"+data[6]+"\")'><img src='<?php echo site_url('assets/images/ico_delete.png')?>' alt=''></a>");
                            },
                "order": [[ 0, "asc" ]],
                "columns": [
                    { "width": "20%", "targets": 0 },
                    { "width": "30%", "targets": 1 },
                    { "width": "20%", "targets": 2 },
                    { "width": "10%", "targets": 3 },
                    { "width": "10%", "targets": 4 },
                    { "width": "10%", "targets": 5 },
                ],
                "ajax": {
                    "url": "<?php echo site_url(); ?>manage/poi/getPoiAjax/<?php echo $poi_type?>",
                    "type": "GET"
                }
            });

});
function setImageName (){
    $("#img_name").val($(".filename").text());
}
$(".is24hours").on('click',function (v){
    if($("#fs").is(":checked")){
        $(".div_open").hide();  
        $(".div_close").hide();
    }
    else{
        $(".div_open").show();  
        $(".div_close").show();
    }
});
$(".poi_type").on('change',function(){
    $("#form_poi_type").submit();
})
$(".btn_add").click(function() {
    $(".list_attach").hide();
    $("#form_poi").attr("action", "<?php echo site_url('manage/poi/add'.$poi_type_url)?>");
});

function closeLoading() {
    $("#pop_box_loading").hide();
};

function editButton(v) {
    $("#pop_box2").hide();
    $("#pop_box_loading").show();
    $("#form_poi").attr("action", "<?php echo site_url('manage/poi/edit')?>/" + v+'<?php echo $poi_type_url?>');
    $.ajax({
        url: "<?php echo site_url('manage/poi/getPOI/')?>" + v,
        type: "get",
        success: function(response) {
            $("#pop_box_loading").hide();
            $("#pop_box2").show();
            var res = JSON.parse(response);
            
            $(".poi_name").val(res.poi_name);
            $(".phone_no_24").val(res.phone_no_24);
            $(".phone_no").val(res.phone_no);
            $(".image_name").val(res.image_name);
            $(".filename").val(res.image_name);
            $(".region").val(res.region);
            $(".latitude").val(res.latitude);
            $(".longitude").val(res.longitude);
            $(".address").val(res.address);
            if(res.image_name){
                $(".list_attach").show();
                $(".filename").text(res.image_name);
            }
            if(res.is_24hours==0){
                $(".is24hours").click();
                $(".div_open").show();  
                $(".div_close").show();
                $("#open").val(res.open);
                $("#close").val(res.close);
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