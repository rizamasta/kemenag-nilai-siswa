<div id="nav2">
			<a href="<?php echo site_url('termcondition');?>">GTC</a>
			<a href="javascript:void(0)" class="selected">Privacy Policy</a>
		</div>
		<div class="table_show">
            <form action="<?php echo site_url('termcondition/update/'.$data->id);?>" method="post" class="form_1">
                <input type="hidden" name="cur_url" value="<?php echo $this->uri->uri_string?>">
				<textarea name="content" id="" cols="30" rows="10" class="tinymc">
                    <?php echo $data->content?>
                </textarea>
				<br>
				<div align="center">
			    	<input type="submit" value="SAVE" class="btn_save close_box">
			    </div>
			</form>
</div>