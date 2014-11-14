<?php 
add_action( 'add_meta_boxes', 'xyz_smap_add_custom_box' );
function xyz_smap_add_custom_box()
{	
	$posttype="";
	if(isset($_GET['post_type']))
	$posttype=$_GET['post_type'];
	
if(isset($_GET['action']) && $_GET['action']=="edit")
	{
		$postid=$_GET['post'];
		
		$postpp= get_post($postid);
		if($postpp->post_status=="publish")
			add_meta_box("xyz_smap1", ' ', 'xyz_smap_addpostmetatags1') ;
		
		$get_post_meta=get_post_meta($postid,"xyz_smap",true);
		if($get_post_meta==1)
			return ;
		global $wpdb;
		$table='posts';
		$accountCount = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.$table.' WHERE id="'.$postid.'" and post_status!="draft" LIMIT 0,1' ) ;
		if($accountCount>0)
		return ;
	}

	if($posttype=="")
		$posttype="post";

	if ($posttype=="page")
	{

		$xyz_smap_include_pages=get_option('xyz_smap_include_pages');
		if($xyz_smap_include_pages==0)
			return;
	}
	else if($posttype!="post")
	{

		$xyz_smap_include_customposttypes=get_option('xyz_smap_include_customposttypes');


		$carr=explode(',', $xyz_smap_include_customposttypes);
		if(!in_array($posttype,$carr))
			return;

	}
	if((get_option('xyz_smap_af')==0 && get_option('xyz_smap_fb_token')!="") || (get_option('xyz_smap_twconsumer_id')!="" && get_option('xyz_smap_twconsumer_secret')!="" && get_option('xyz_smap_tw_id')!="" && get_option('xyz_smap_current_twappln_token')!="" && get_option('xyz_smap_twaccestok_secret')!="") || (get_option('xyz_smap_lnaf')==0) )
	add_meta_box( "xyz_smap", '<strong>Social Media Auto Publish - Post Options</strong>', 'xyz_smap_addpostmetatags') ;
}

function xyz_smap_addpostmetatags1()
{
	?>
	
	<input type="hidden" name="xyz_smap_hidden_meta" value="1" >
	<script type="text/javascript">
		jQuery('#xyz_smap1').hide();
		</script>
	<?php 
}
function xyz_smap_addpostmetatags()
{
	$imgpath= plugins_url()."/social-media-auto-publish/admin/images/";
	$heimg=$imgpath."support.png";
	?>
<script>
var fcheckid;
var tcheckid;
var lcheckid;
function displaycheck()
{
	if(document.getElementById("xyz_smap_post_permission"))
	{
		fcheckid=document.getElementById("xyz_smap_post_permission").value;
		if(fcheckid==1)
		{
			document.getElementById("fpmd").style.display='';	
			document.getElementById("fpmf").style.display='';	
			document.getElementById("fpmftarea").style.display='';	
		}
		else
		{
			document.getElementById("fpmd").style.display='none';	
			document.getElementById("fpmf").style.display='none';		
			document.getElementById("fpmftarea").style.display='none';	
		}
	}

	if(document.getElementById("xyz_smap_twpost_permission"))
	{
		tcheckid=document.getElementById("xyz_smap_twpost_permission").value;
		if(tcheckid==1)
		{
			
			document.getElementById("twmf").style.display='';
			document.getElementById("twmftarea").style.display='';	
			document.getElementById("twai").style.display='';	
		}
		else
		{
			
			document.getElementById("twmf").style.display='none';
			document.getElementById("twmftarea").style.display='none';
			document.getElementById("twai").style.display='none';			
		}
	}

	if(document.getElementById("xyz_smap_lnpost_permission"))
	{
		lcheckid=document.getElementById("xyz_smap_lnpost_permission").value;
		if(lcheckid==1)
		{
		
		    document.getElementById("lnimg").style.display='';
			document.getElementById("lnmf").style.display='';	
			document.getElementById("lnmftarea").style.display='';	
			document.getElementById("shareprivate").style.display='';	
		}
		else
		{
		    document.getElementById("lnimg").style.display='none';
			document.getElementById("lnmf").style.display='none';	
			document.getElementById("lnmftarea").style.display='none';	
			document.getElementById("shareprivate").style.display='none';		
		}
	}


}


</script>
<script type="text/javascript">
function detdisplay(id)
{
	document.getElementById(id).style.display='';
}
function dethide(id)
{
	document.getElementById(id).style.display='none';
}

function drpdisplay()
{
	var shmethod= document.getElementById('xyz_smap_ln_sharingmethod').value;
	if(shmethod==1)	
	{
		document.getElementById('shareprivate').style.display="none";
	}
	else
	{
		document.getElementById('shareprivate').style.display="";
	}
}

</script>
<table class="xyz_smap_metalist_table">
<?php 

if(get_option('xyz_smap_af')==0 && get_option('xyz_smap_fb_token')!="")
{

?>

<tr ><td colspan="2" >

<table class="xyz_smap_meta_acclist_table"><!-- FB META -->


<tr>
		<td colspan="2" class="xyz_smap_pleft15 xyz_smap_meta_acclist_table_td"><strong>Facebook</strong>
		</td>
</tr>

<tr><td colspan="2" valign="top">&nbsp;</td></tr>
	
	<tr valign="top">
		<td class="xyz_smap_pleft15" width="60%">Enable auto publish post to my facebook account
		</td>
		<td width="40%"><select id="xyz_smap_post_permission" name="xyz_smap_post_permission"
			onchange="displaycheck()"><option value="0"
			<?php  if(get_option('xyz_smap_post_prmission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_post_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	<tr valign="top" id="fpmd">
		<td class="xyz_smap_pleft15">Posting method
		</td>
		<td><select id="xyz_smap_po_method" name="xyz_smap_po_method">
				<option value="3"
				<?php  if(get_option('xyz_smap_po_method')==3) echo 'selected';?>>Simple text message</option>
				
				<optgroup label="Text message with image">
					<option value="4"
					<?php  if(get_option('xyz_smap_po_method')==4) echo 'selected';?>>Upload image to app album</option>
					<option value="5"
					<?php  if(get_option('xyz_smap_po_method')==5) echo 'selected';?>>Upload image to timeline album</option>
				</optgroup>
				
				<optgroup label="Text message with attached link">
					<option value="1"
					<?php  if(get_option('xyz_smap_po_method')==1) echo 'selected';?>>Attach
						your blog post</option>
					<option value="2"
					<?php  if(get_option('xyz_smap_po_method')==2) echo 'selected';?>>
						Share a link to your blog post</option>
					</optgroup>
		</select>
		</td>
	</tr>
	<tr valign="top" id="fpmf">
		<td class="xyz_smap_pleft15">Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_fb')" onmouseout="dethide('xyz_fb')">
						<div id="xyz_fb" class="informationdiv" style="display: none;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.<br />{USER_NICENAME} - Insert the nicename
							of the author.
						</div>
		</td>
	<td>
	<select name="xyz_smap_fb_info" id="xyz_smap_fb_info" onchange="xyz_smap_fb_info_insert(this)">
		<option value ="0" selected="selected">--Select--</option>
		<option value ="1">{POST_TITLE}  </option>
		<option value ="2">{PERMALINK} </option>
		<option value ="3">{POST_EXCERPT}  </option>
		<option value ="4">{POST_CONTENT}   </option>
		<option value ="5">{BLOG_TITLE}   </option>
		<option value ="6">{USER_NICENAME}   </option>
		</select> </td></tr>
		
		<tr id="fpmftarea"><td>&nbsp;</td><td>
		<textarea id="xyz_smap_message"  name="xyz_smap_message" style="height:80px !important;" ><?php echo esc_textarea(get_option('xyz_smap_message'));?></textarea>
	</td></tr>
	
	</table>
	</td></tr>
	<?php }?>
	
	<?php 
	if(get_option('xyz_smap_twconsumer_id')!="" && get_option('xyz_smap_twconsumer_secret')!="" && get_option('xyz_smap_tw_id')!="" && get_option('xyz_smap_current_twappln_token')!="" && get_option('xyz_smap_twaccestok_secret')!="")
	{
	?>
	
	<tr ><td colspan="2" >

<table class="xyz_smap_meta_acclist_table"><!-- TW META -->


<tr>
		<td colspan="2" class="xyz_smap_pleft15 xyz_smap_meta_acclist_table_td"><strong>Twitter</strong>
		</td>
</tr>

<tr><td colspan="2" valign="top">&nbsp;</td></tr>
	
	<tr valign="top">
		<td class="xyz_smap_pleft15" width="60%">Enable auto publish posts to my twitter account
		</td>
		<td width="40%"><select id="xyz_smap_twpost_permission" name="xyz_smap_twpost_permission"
			onchange="displaycheck()">
				<option value="0"
				<?php  if(get_option('xyz_smap_twpost_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_twpost_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="twai">
		<td class="xyz_smap_pleft15">Attach image to twitter post
		</td>
		<td><select id="xyz_smap_twpost_image_permission" name="xyz_smap_twpost_image_permission"
			onchange="displaycheck()">
				<option value="0"
				<?php  if(get_option('xyz_smap_twpost_image_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_twpost_image_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="twmf">
		<td class="xyz_smap_pleft15">Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_tw')" onmouseout="dethide('xyz_tw')">
						<div id="xyz_tw" class="informationdiv"
							style="display: none; font-weight: normal;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.<br />{USER_NICENAME} - Insert the nicename
							of the author.
						</div>
		</td>
		
		
	<td>
	<select name="xyz_smap_tw_info" id="xyz_smap_tw_info" onchange="xyz_smap_tw_info_insert(this)">
		<option value ="0" selected="selected">--Select--</option>
		<option value ="1">{POST_TITLE}  </option>
		<option value ="2">{PERMALINK} </option>
		<option value ="3">{POST_EXCERPT}  </option>
		<option value ="4">{POST_CONTENT}   </option>
		<option value ="5">{BLOG_TITLE}   </option>
		<option value ="6">{USER_NICENAME}   </option>
		</select> </td></tr>
		
		<tr id="twmftarea"><td>&nbsp;</td><td>
		<textarea id="xyz_smap_twmessage"  name="xyz_smap_twmessage" style="height:80px !important;" ><?php echo esc_textarea(get_option('xyz_smap_twmessage'));?></textarea>
	</td></tr>
	
	</table>
	
	</td></tr>
	<?php }?>
	
	<?php if(get_option('xyz_smap_lnaf')==0){?>
	
	<tr ><td colspan="2" >

<table class="xyz_smap_meta_acclist_table"><!-- LI META -->


<tr>
		<td colspan="2" class="xyz_smap_pleft15 xyz_smap_meta_acclist_table_td"><strong>LinkedIn</strong>
		</td>
</tr>

<tr><td colspan="2" valign="top">&nbsp;</td></tr>
	
	<tr valign="top" >
		<td class="xyz_smap_pleft15" width="60%">Enable auto publish	posts to my linkedin account
		</td>
		<td width="40%"><select id="xyz_smap_lnpost_permission" name="xyz_smap_lnpost_permission"
			onchange="displaycheck()">
				<option value="0"
				<?php  if(get_option('xyz_smap_lnpost_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_lnpost_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="lnimg">
		<td class="xyz_smap_pleft15">Attach image to linkedin post
		</td>
		<td><select id="xyz_smap_lnpost_image_permission" name="xyz_smap_lnpost_image_permission"
			onchange="displaycheck()">
				<option value="0"
				<?php  if(get_option('xyz_smap_lnpost_image_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_lnpost_image_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="shareprivate">
	<input type="hidden" name="xyz_smap_ln_sharingmethod" id="xyz_smap_ln_sharingmethod" value="0">
	<td class="xyz_smap_pleft15">Share post content with</td>
	<td>
		<select id="xyz_smap_ln_shareprivate" name="xyz_smap_ln_shareprivate" >
		 <option value="0" <?php  if(get_option('xyz_smap_ln_shareprivate')==0) echo 'selected';?>>
Public</option><option value="1" <?php  if(get_option('xyz_smap_ln_shareprivate')==1) echo 'selected';?>>Connections only</option></select>
	</td></tr>

	<tr valign="top" id="lnmf">
		<td class="xyz_smap_pleft15">Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_ln')" onmouseout="dethide('xyz_ln')">
						<div id="xyz_ln" class="informationdiv"
							style="display: none; font-weight: normal;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.<br />{USER_NICENAME} - Insert the nicename
							of the author.
						</div>
		</td>
	<td>
	<select name="xyz_smap_ln_info" id="xyz_smap_ln_info" onchange="xyz_smap_ln_info_insert(this)">
		<option value ="0" selected="selected">--Select--</option>
		<option value ="1">{POST_TITLE}  </option>
		<option value ="2">{PERMALINK} </option>
		<option value ="3">{POST_EXCERPT}  </option>
		<option value ="4">{POST_CONTENT}   </option>
		<option value ="5">{BLOG_TITLE}   </option>
		<option value ="6">{USER_NICENAME}   </option>
		</select> </td></tr>
		
		<tr id="lnmftarea"><td>&nbsp;</td><td>
		<textarea id="xyz_smap_lnmessage"  name="xyz_smap_lnmessage" style="height:80px !important;" ><?php echo esc_textarea(get_option('xyz_smap_lnmessage'));?></textarea>
	</td></tr>
	
	</table>
	
	</td></tr>
	<?php }?>
</table>
<script type="text/javascript">
	displaycheck();

	function xyz_smap_fb_info_insert(inf){
		
	    var e = document.getElementById("xyz_smap_fb_info");
	    var ins_opt = e.options[e.selectedIndex].text;
	    if(ins_opt=="0")
	    	ins_opt="";
	    var str=jQuery("textarea#xyz_smap_message").val()+ins_opt;
	    jQuery("textarea#xyz_smap_message").val(str);
	    jQuery('#xyz_smap_fb_info :eq(0)').prop('selected', true);
	    jQuery("textarea#xyz_smap_message").focus();

	}
	function xyz_smap_tw_info_insert(inf){
		
	    var e = document.getElementById("xyz_smap_tw_info");
	    var ins_opt = e.options[e.selectedIndex].text;
	    if(ins_opt=="0")
	    	ins_opt="";
	    var str=jQuery("textarea#xyz_smap_twmessage").val()+ins_opt;
	    jQuery("textarea#xyz_smap_twmessage").val(str);
	    jQuery('#xyz_smap_tw_info :eq(0)').prop('selected', true);
	    jQuery("textarea#xyz_smap_twmessage").focus();

	}

	function xyz_smap_ln_info_insert(inf){
		
	    var e = document.getElementById("xyz_smap_ln_info");
	    var ins_opt = e.options[e.selectedIndex].text;
	    if(ins_opt=="0")
	    	ins_opt="";
	    var str=jQuery("textarea#xyz_smap_lnmessage").val()+ins_opt;
	    jQuery("textarea#xyz_smap_lnmessage").val(str);
	    jQuery('#xyz_smap_ln_info :eq(0)').prop('selected', true);
	    jQuery("textarea#xyz_smap_lnmessage").focus();

	}
	</script>
<?php 
}
?>