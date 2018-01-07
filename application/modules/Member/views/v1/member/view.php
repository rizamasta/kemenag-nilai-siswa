<div class="">
    <div class="table_show">
        <div class="table_head">
            <div class="info">
                <?php echo $total_member->total ?> Total Member</div>
                <div class="clearfix"></div>
        </div>
        <table id="table_member" class="table_style" cellspacing="0" width="100%" data-page-length="10">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Telephone</th>
                    <th>E-mail</th>
                    <th width="50px" class="arrow_non">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="pop_box2" class="pop_box" style="display:none;">
    <div class="popbox_bg_close"></div>
    <div class="pop_box_content pop_box_content_member">
        <div class="member_left">
            <form method="POST" action="" id="form_user">
                <div align="left">
                    <strong>Account Management</strong>
                </div>
                <div class="inactive_switch">
                    <span class="off">Inactive</span>
                    <div class="flipswitch">
                        <input type="checkbox" name="is_suspend" class="flipswitch-cb is_suspend" id="fs" checked>
                        <label class="flipswitch-label" for="fs">
                            <div class="flipswitch-inner"></div>
                            <div class="flipswitch-switch"></div>
                        </label>
                    </div>
                    <span>Active</span>
                </div>
                <div class="clearfix"></div>
                <div class="form-group form-group-col-2">
                    <strong>Mobile Number</strong>
                    <input type="text" name="tel" readonly class="tel">
                    <div class="clearfix"></div>
                </div>
                <div class="form-group form-group-col-2">
                    <strong>Email Address</strong>
                    <input type="text" name="email" readonly class="email" >
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div align="left">
                    <strong>Personal Informasi</strong>
                </div>
                <div class="clearfix"></div>
                <div class="form-group form-group-col-2">
                    <strong>Full Name</strong>
                    <input type="text" name="fullname" class="fullname name" readonly  >
                    <div class="clearfix"></div>
                </div>
                <div class="form-group form-group-col-2">
                    <strong>Birthday</strong>
                    <input type="text" name="birth_date" class="bod" readonly >
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                
                <div class="form-group  form-group-col-2">
                    <strong>Gender</strong>
                    <input type="text" name="gender" class="gender" readonly >
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="foto">
                </div>
                <br>
                <div align="center">
                    <input type="reset" value="CANCEL" class="btn_cancel close_box">
                    <input type="submit" value="SAVE" class="btn_save">
                </div>
            </form>
        </div>
        <div class="member_right">
            <div class="title">History</div>
            <ul class="list_history">
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
        $('#table_member').dataTable({
            "processing": true,
            "serverSide": true,
            "createdRow": function( row, data, dataIndex ) {
                $(row).addClass('show_detail');
                $(row).on('click',function(){
                    editButton(data[4]);
                })
            },
            "order": [[ 1, "desc" ]],
            "ajax": {
                "url": "<?php echo site_url(); ?>member/getMemberAjax",
                "type": "GET"
            }
        });
});
$(".btn_add").click(function() {
    $("#form_user").attr("action", "<?php echo site_url('user/add')?>");
});

function closeLoading() {
    $("#pop_box_loading").hide();
};

function editButton(v) {
    $("#pop_box2").hide();
    $("#pop_box_loading").show();
    $("#form_user").attr("action", "<?php echo site_url('member/edit')?>/" + v);
    $.ajax({
        url: "<?php echo site_url('member/getMemberJSON/')?>" + v,
        type: "get",
        success: function(response) {
            $("#pop_box_loading").hide();
            $("#pop_box2").show();

            var res = JSON.parse(response);
            var foto = res.foto;
            $(".fullname").val(res.fullname);
            $(".bod").val(res.birth_date==null?"-":res.birth_date);
            $(".tel").val(res.phone_no);
            $(".email").val(res.email==null?"-":res.email);
            if(res.is_suspend==1){
                $("#fs").removeAttr('checked');                
            }
            else{
                $("#fs").attr("checked","checked");
            }
            $(".gender").val(res.jenis_kelamin==null?"-":(res.jenis_kelamin==0?"Male":"Female"));
            var  value_foto = "";
            foto.forEach(function(val){
                value_foto +="<a href='"+val.path+"' data-fancybox='images'><img src='"+val.path+"' alt=''></a>";
            });
            $(".foto").html(value_foto);
            $(".list_history").html("loading..");
            $.ajax({
                url: "<?php echo site_url('member/getHistory/')?>" + res.uid,
                type: "get",
                success: function(response) {
                    try{
                        var d="";
                        var dataHist = [];
                        var r = JSON.parse(response);
                        r.forEach(function(v,key){
                            if(d==""){
                                d = v.create_date.substring(0,10);
                            }
                            if(dataHist.length==0){
                                dataHist.push({
                                    date : d,
                                    detail :[{
                                        time : v.create_date.substring(11,20),
                                        place_name : v.place_name
                                    }]
                                })
                            }
                            else{
                                if(d==v.create_date.substring(0,10)){
                                    dataHist[dataHist.length-1].detail.push(
                                        {
                                            time : v.create_date.substring(11,20),
                                            place_name : v.place_name
                                        }
                                    )
                                }
                                else{
                                    d = v.create_date.substring(0,10);
                                    dataHist.push({
                                    date : d,
                                    detail :[{
                                            time : v.create_date.substring(11,20),
                                            place_name : v.place_name
                                        }]
                                    })
                                }
                            }
                        });
                        var content_hsit="";
                        dataHist.forEach(function(v){
                            var detail ="";
                            v.detail.forEach(function(de){
                                detail +="<div class='list_time'>"+
                                                    "<div class='time'>"+de.time+"</div>"+
                                                    de.place_name+
                                        "</div>";
                            });
                            content_hsit +="<li>"+
                                            "<div class='date'>"+
                                            getDate(v.date,"month")+"<strong>"+getDate(v.date,"date")+"</strong>"+
                                            "</div>"+
                                            "<div class='line'></div>"+
                                            "<div class='info_history'>"+
                                                detail+
                                           "</div>"+
                                           "<div class='clearfix'></div>"+
                                        "</li>";
                        });
                        $(".list_history").html(content_hsit!=''?content_hsit:'History is not availble.');
                    }
                    catch(e){
                        console.log(e);
                        $(".list_history").html("failed load history");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    $(".list_history").html("failed load history");
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $(".msg_loading").html("<strong>Error while fetching data</strong><br/><br/><br/><div align='right'>" +
                "<input type='reset' value='OK' class='btn_save close_box' onclick='closeLoading()'>" +
                "</div>");
        }
    });
};
function getDate(val,format){
    var r="";
    if(format=="month"){
        var b = parseInt(val.substring(5,7));
        if(b==1){
            r = "JAN";
        }
        else if(b==2){
            r = "FEB";
        }
        else if(b==3){
            r = "MAR";
        }
        else if(b==4){
            r = "APR";
        }
        else if(b==5){
            r = "MAY";
        }
        else if(b==6){
            r = "JUN";
        }
        else if(b==7){
            r = "JUL";
        }
        else if(b==8){
            r = "AUG";
        }
        else if(b==9){
            r = "SEP";
        }
        else if(b==10){
            r = "OKT";
        }
        else if(b==11){
            r = "NOV";
        }
        else if(b==12){
            r = "DEC";
        }
        else{
            r = b;
        }
    }
    else if(format=="date"){
        r = val.substring(8,10);
    }
    else{
        r = "error";
    }
    return r;
}
</script>
