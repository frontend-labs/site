<?php 
?>
<div >


	<form method="post" name="xyz_smap_logs_form">
		<fieldset
			style="width: 99%; border: 1px solid #F7F7F7; padding: 10px 0px;">
			


<div style="text-align: left;padding-left: 7px;"><h3>Auto Publish Logs</h3></div>

		   <table class="widefat" style="width: 99%; margin: 0 auto; border-bottom:none;">
				<thead>
					<tr class="xyz_smap_log_tr">
						<th scope="col" width="1%">&nbsp;</th>
						<th scope="col" width="12%">Post Id</th>
						<th scope="col" width="18%">Account type</th>
						<th scope="col" width="18%">Published On</th>
						<th scope="col" width="15%">Status</th>
					</tr>
					</thead>
					<?php 
					
					$post_fb_logs = get_option('xyz_smap_fbap_post_logs' );
					$post_tw_logs = get_option('xyz_smap_twap_post_logs' );
					$post_ln_logs = get_option('xyz_smap_lnap_post_logs' );
					
					if($post_fb_logs!=""){
						
						$postid=$post_fb_logs['postid'];
					    $acc_type=$post_fb_logs['acc_type'];
						$publishtime=$post_fb_logs['publishtime'];
						if($publishtime!="")
							$publishtime=xyz_smap_local_date_time('Y/m/d g:i:s A',$publishtime);
						$status=$post_fb_logs['status'];
					
						
					
					
					?>
					<tr>
					    <td>&nbsp;</td>
						<td  style="vertical-align: middle !important;">
						<?php echo $postid;	?>
						</td>
						
						<td  style="vertical-align: middle !important;">
						<?php echo $acc_type;?>
						</td>
						
						<td style="vertical-align: middle !important;">
						<?php echo $publishtime;?>
						</td>
						
						<td style="vertical-align: middle !important;">
						<?php

						
					  if($status=="1")
							echo "<span style=\"color:green\">Success</span>";
						else if($status=="0")
							echo '';
						else
						{
							$arrval=unserialize($status);
							foreach ($arrval as $a=>$b)
								echo "<span style=\"color:red\">".$a." : ".$b."</span><br>";
						
						}
						
						 ?>
						</td>
						</tr>
						<?php  }
				if($post_tw_logs!=""){
				
					$postid=$post_tw_logs['postid'];
					$acc_type=$post_tw_logs['acc_type'];
					$publishtime=$post_tw_logs['publishtime'];
					if($publishtime!="")
						$publishtime=xyz_smap_local_date_time('Y/m/d g:i:s A',$publishtime);
					$status=$post_tw_logs['status'];
				
				
				
				
					?>
				<tr>
				 <td>&nbsp;</td>
				<td  style="vertical-align: middle !important;">
				<?php echo $postid;	?>
				</td>
				
				<td  style="vertical-align: middle !important;">
				<?php echo $acc_type;?>
				</td>
				
				<td style="vertical-align: middle !important;">
				<?php echo $publishtime;?>
				</td>
				
				<td style="vertical-align: middle !important;">
				<?php
				
				
				if($status=="1")
				echo "<span style=\"color:green\">Success</span>";
				else if($status=="0")
				echo '';
				else
				{
				$arrval=unserialize($status);
				foreach ($arrval as $a=>$b)
				echo "<span style=\"color:red\">".$a." : ".$b."</span><br>";
				
				}
				
				?>
				</td>
				</tr>
				<?php  }
				
				if($post_ln_logs!=""){
				
					$postid=$post_ln_logs['postid'];
					$acc_type=$post_ln_logs['acc_type'];
					$publishtime=$post_ln_logs['publishtime'];
					if($publishtime!="")
						$publishtime=xyz_smap_local_date_time('Y/m/d g:i:s A',$publishtime);
					$status=$post_ln_logs['status'];
				
				
				
				
					?>
				<tr>
				 <td>&nbsp;</td>
				<td  style="vertical-align: middle !important;">
				<?php echo $postid;	?>
				</td>
				
				<td  style="vertical-align: middle !important;">
				<?php echo $acc_type;?>
				</td>
				
				<td style="vertical-align: middle !important;">
				<?php echo $publishtime;?>
				</td>
				
				<td style="vertical-align: middle !important;">
				<?php
				
				
				if($status=="1")
				echo "<span style=\"color:green\">Success</span>";
				else if($status=="0")
				echo '';
				else
				{
				$arrval=unserialize($status);
				foreach ($arrval as $a=>$b)
				echo "<span style=\"color:red\">".$a." : ".$b."</span><br>";
				
				}
				
				?>
				</td>
				</tr>
				<?php  }
				if($post_fb_logs=="" && $post_tw_logs=="" && $post_ln_logs==""){?>
					<tr><td colspan="5" style="padding: 5px;">No logs Found</td></tr>
				<?php }?>
				
           </table>
			
		</fieldset>

	</form>

</div>
				