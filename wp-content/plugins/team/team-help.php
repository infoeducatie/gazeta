<?php

if ( ! defined('ABSPATH')) exit; // if direct access 

?>


<div class="wrap">
	<?php echo "<h2>".__(team_plugin_name.' Help','team')."</h2>";?>
    <br />

	<div class="para-settings">  
        
        
	<h2><?php _e('Have any issue ?','team');?></h2>

	<p>Feel free to Contact with any issue for this plugin, Ask any question via forum <a href="http://paratheme.com/qa/">http://paratheme.com/qa/</a> <strong style="color:#139b50;">(free)</strong>
</p>


	<?php
    
    $team_customer_type = get_option('team_customer_type');
    $team_version = get_option('team_version');
    

    if($team_customer_type=="free")
        {
    
            echo '<p>'.__('You are using <strong>'.$team_customer_type.' version  '.$team_version.'</strong> of '.team_plugin_name.', To get more feature you could try our premium version. ','team');
            
            echo '<a href="'.team_pro_url.'">'.team_pro_url.'</a></p>';
            
        }
    elseif($team_customer_type=="pro")
        {
    
            echo '<p>'.__('Thanks for using <strong> premium version  '.$team_version.'</strong> of <strong>'.team_plugin_name.'</strong>','team').'</p>';	
            
            
        }
    
     ?>


	<h2><?php _e('Tutorial','team'); ?></h2>
	<p><?php _e('Please watch this video tutorial.','team'); ?></p>
    
	<iframe width="640" height="480" src="//www.youtube.com/embed/8OiNCDavSQg?rel=0" frameborder="0" allowfullscreen></iframe>


<?php
if($team_customer_type=="free")
	{
?>

</div>

        
      <?php
      }
	  
	  ?>  
      
<br /> <br /> <br /> 
<h3>Please share this plugin with your friends?</h3>
<table>
<tr>
<td width="100px"> 
<!-- Place this tag in your head or just before your close body tag. -->
<script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>

<!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-size="medium" data-href="<?php echo team_share_url; ?>"></div>

</td>
<td width="100px">
<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo team_share_url; ?>&amp;width=100&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=743541755673761" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>

 </td>
<td width="100px"> 





<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo team_share_url; ?>" data-text="<?php echo team_plugin_name; ?>">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</td>

</tr>

</table>
        


         
</div>
