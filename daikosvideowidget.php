<?php
/*
Plugin Name: Daiko's Video Widget
Plugin URI: http://www.daikos.net/daikos-video-widget/
Description: Adds a sidebar widget to display random videos of your own choice. You can mix Google, Myspace and YouTube videos. Make your own videolist in the widget-control-panel. Syntax: [MySpaceID/Google video ID/YouTube ID]@[Title*]@[Link*]<Line Brake>. * Is optional. Do not add a <Line Brake> after the last video in the list.
Author: Rune Fjellheim
Version: 2.05
License: GPL
Author URI: http://www.daikos.net
*/


function widget_videos_init() {
                

	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	function widget_videos_control($number) {
		$options = $newoptions = get_option('widget_videos');
		if ( $_POST["videos-submit-$number"] ) {
			$newoptions[$number]['title'] = strip_tags(stripslashes($_POST["videos-title-$number"]));
			$newoptions[$number]['width'] = strip_tags(stripslashes($_POST["videos-width-$number"]));
			$newoptions[$number]['height'] = strip_tags(stripslashes($_POST["videos-height-$number"]));
			$newoptions[$number]['format'] = strip_tags(stripslashes($_POST["videos-format-$number"]));
			$newoptions[$number]['content'] = strip_tags(stripslashes($_POST["videos-content-$number"]));
			$newoptions[$number]['show'] = $_POST["videos-show-$number"];
			$newoptions[$number]['slug'] = strip_tags(stripslashes($_POST["videos-slug-$number"]));
			$newoptions['googlesimpleplayer'] = $_POST["videos-simplePlayer"];
		}
		if ($options[$number]['content']=='') {
			$newoptions[$number]['content'] = 'FBSvtnCr8Wc@Transjoik - "Gievrie"@http://www.transjoik.com
-3863240454354718398@iPhone features
8453442377878175440@Blue Man Group on Global Warming
dF0kMBTwDrM@Transjoik "Mustai Amaia"@http://www.transjoik.com
5301167223369517485@A Brief History of America
-4505462782975458603@Dribler in Amsterdam';
		}
		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_videos', $options);
		}
		$allSelected = $homeSelected = $postSelected = $pageSelected = $categorySelected = false;
		switch ($options[$number]['show']) {
			case "all":
			$allSelected = true;
			break;
			case "":
			$allSelected = true;
			break;
			case "home":
			$homeSelected = true;
			break;
			case "post":
			$postSelected = true;
			break;
			case "page":
			$pageSelected = true;
			break;
			case "category":
			$categorySelected = true;
			break;
		}    
		$formatws = ($options[$number]['format']=="ws");
		$GoogleSimplePlayer =  ($options['googlesimpleplayer']=="GoogleSimplePlayer");
	?>
		<label for="videos-title-<?php echo "$number"; ?>" title="Title above the widget" style="line-height:35px;display:block;">Title: <input type="text" style="width: 442px;" id="videos-title-<?php echo "$number"; ?>" name="videos-title-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['title']); ?>" /></label>
		<label for="videos-width-<?php echo "$number"; ?>" title="Specify Width (optional if Height is specified)" style="line-height:35px;">Width: <input type="integer" style="width: 80px;" id="videos-width-<?php echo "$number"; ?>" name="videos-width-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['width']); ?>" /></label>
		<label for="videos-height-<?php echo "$number"; ?>" title="Specify Height (optional if Width is specified)" style="line-height:35px;">Height: <input type="integer" style="width: 80px;" id="videos-height-<?php echo "$number"; ?>" name="videos-height-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['height']); ?>" /></label></br>
		<label for="videos-format-<?php echo "$number"; ?>"  title="Indicate whether you mainly have videos in 16:9 or 4:3. Not crucial but helps calculate width/height." style="line-height:35px;">Format: <input type="radio" name="videos-format-<?php echo "$number"; ?>" value="ns" <?php if ($formatws==false){echo "checked";} ?>> 4:3 <input type="radio" name="videos-format-<?php echo "$number"; ?>" value="ws" <?php if ($formatws==true){echo "checked";} ?>> 16:9 </label>
		<label for="videos-content-<?php echo "$number"; ?>" title="Insert your list of videos from MySpace, Google or YouTube separated by Line Brake. The options marked with * are optional. IMPORTANT: No Line Break after the last video!" style="width: 495px; height: 280px;display:block;">Videos [MySpace, Google or YouTube ID]@[TITLE*]@[LINK*]<textarea style="width: 470px; height: 240px;" id="videos-content-<?php echo "$number"; ?>" name="videos-content-<?php echo "$number"; ?>"><?php echo htmlspecialchars($options[$number]['content']); ?></textarea></label>
		<label for="videos-show-<?php echo "$number"; ?>"  title="Show only on specified page(s)/post(s)/category. Default is All" style="line-height:35px;">Display only on: <select name="videos-show-<?php echo"$number"; ?>" id="videos-show-<?php echo"$number"; ?>"><option label="All" value="all" <?php if ($allSelected){echo "selected";} ?>>All</option><option label="Home" value="home" <?php if ($homeSelected){echo "selected";} ?>>Home</option><option label="Post" value="post" <?php if ($postSelected){echo "selected";} ?>>Post(s)</option><option label="Page" value="page" <?php if ($pageSelected){echo "selected";} ?>>Page(s)</option><option label="Category" value="category" <?php if ($categorySelected){echo "selected";} ?>>Category</option></select></label> 
		<label for="videos-slug-<?php echo "$number"; ?>"  title="Optional limitation to specific page, post or category. Use ID, slug or title." style="line-height:35px;">Slug/Title/ID: <input type="text" style="width: 150px;" id="videos-slug-<?php echo "$number"; ?>" name="videos-slug-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['slug']); ?>" /></label>
		<label for="videos-simplePlayer"  title="Use Google's Simple Player, very useful in tight sidebars (below 200px)" style="line-height:25px;display:block;">Use Google Simple Player: <input type="checkbox" name="videos-simplePlayer" value="GoogleSimplePlayer" <?php if ($GoogleSimplePlayer==true){echo "checked";} ?>></label>
		<label for="videos-help" title="You can get more help and instructionc on www.daikos.net!" style="line-height:25px;display:block;"><a href="http://www.daikos.net/daikos-video-widget/">Help</a></label>
		<input type="hidden" name="videos-submit-<?php echo "$number"; ?>" id="videos-submit-<?php echo "$number"; ?>" value="1" />
	<?php
	}

	function widget_videos($args, $number = 1) {
		$dvwVersion = "Daiko's Video Widget v. 2.05";
		extract($args);
		$options = get_option('widget_videos');
		
		$title = $options[$number]['title'];
		$GoogleSimplePlayer =  ($options['googlesimpleplayer']=="GoogleSimplePlayer");


		if ($options[$number]['content']!='') {
			$videos = $options[$number]['content'];
		}
		else {
			$videos = 'FBSvtnCr8Wc@Transjoik - "Gievrie"@http://www.transjoik.com
-3863240454354718398@iPhone features
8453442377878175440@Blue Man Group on Global Warming
dF0kMBTwDrM@Transjoik "Mustai Amaia"@http://www.transjoik.com
5301167223369517485@A Brief History of America
-4505462782975458603@Dribler in Amsterdam';
		}

		$videos = explode("\n", $videos);										// First we make an array of the videolist
		$video = wptexturize( $videos[ mt_rand(0, count($videos) - 1 ) ] );     // Select a random video and make sure it contains regular text
		$pieces = explode("@", $video);                                         // Split the selected video into the various options
		$show = $options[$number]['show'];                                      // Get the setting on where to show the widget
		$slug = $options[$number]['slug'];                                      // Optional Slug/Title/PageID on where to show it
		$width = $options[$number]['width'];                                    // User specified with of player
		$height = $options[$number]['height'];                                  // User specified height of player
		$videoformat = $options[$number]['format'];                             // 16:9 or 4:3 format of videos
		$objecttype = 'application/x-shockwave-flash';                          // Set the object type for inclusion in the object finally displayed
		$mediaID = $pieces[0];                                                  // place the mediaID in a variable

		if ($mediaID{0}=="*") {                                                 // If ID is preceeded by a * then the videoformat is 16:9
			$videoformat="ws"; 
			$mediaID=substr($mediaID, 1);
			$pieces[0]=substr($pieces[0],1);
		}
		$simplePlayer = ''; 
	    if ($GoogleSimplePlayer==true) {
			$simplePlayer =  '&amp;playerMode=simple';
		}

/* Identify where the video is from by checking the ID property */

/* First we check if the ID is 18+ characters long. Typically Google Video operates with 18 digits IDs with the occasional - in front of it. */

		if (strlen($mediaID)>=18) {
			$murl = 'http://video.google.com/googleplayer.swf?docId=';          // Write the base url for Google's videoplayer
			$medialoc = 'http://video.google.com/videoplay?docid=';             // Write the url for the movie on Google Video
			$mediavalue = implode('',array($murl,$pieces[0],$simplePlayer));                  // Set value for object and parameters compliant with Google Video object
			$leadingtext = 'Watch on Google Video';                             // Set standard leading text
			$objectid ='id="VideoPlayback-'.$number.'" ';                       // Set object ID
			$parameters = '<param name="movie" value="'.$mediavalue.'" /><param name="allowScriptAccess" value="sameDomain" /><param name="quality" value="best" /><param name="scale" value="noScale" /><param name="salign" value="TL" />';	
		}						
		elseif (is_numeric($mediaID)) {                                         // If the mediaID is less than 18 characters but still an Integer then it is most likely a MySpace Video.
			$murl = 'http://lads.myspace.com/videos/vplayer.swf';
			$medialoc = 'http://vids.myspace.com/index.cfm?fuseaction=vids.individual&n=2&videoid=';
			$mediavalue = $murl;
			$objectid = '';
			$leadingtext = 'Watch on MySpace';
			$parameters = '<param name="allowScriptAccess" value="always" /><param name="quality" value="high" /><<param name="Align" value="" /><param name="flashvars" value="m='.$mediaID.'&type=video" />';
		}
		else {                                                                  // If the mediaID is less than 18 characters and non-Integer it is most likely a YouTube Video.
			$murl = 'http://www.youtube.com/v/';
			$medialoc = 'http://www.youtube.com/watch?v=';
			$mediavalue = implode('',array($murl,$pieces[0]));
			$objectid = '';
			$leadingtext = 'Watch on YouTube';
			$parameters = '<param name="movie" value="'.$mediavalue.'" />';
		}
        
/* Make a test for individual WS-switch to calculate the width and height according to the videoformat. It uses 16:9 or 4:3 formats.*/
		
        if ($videoformat=='ws'){$GVfactor = 9/16;$MSfactor = 0.60348837;$YTfactor = 0.61764706;}
		else {$GVfactor = 3/4;$MSfactor = 0.80465116;$YTfactor = 0.82352941;}

		$Googlepix = 27; 
	    if ($GoogleSimplePlayer==true) {
			$Googlepix = 0; 
		}

	   	if ($height=='') {
			if ($width==''){$width = 200;}
            switch ($murl) {
  				case "http://video.google.com/googleplayer.swf?docId=":
   					$height = round(($width*$GVfactor)+$Googlepix);
   					break;
   				case "http://lads.myspace.com/videos/vplayer.swf":
   					$height = round($width*$MSfactor);
   					break;						
       			case "http://www.youtube.com/v/":
   	   				$height = round($width*$YTfactor);
   	   				break;						
               	}
	   		}
	   	if ($width=='') {
			if ($height==''){$height = 180;}
            switch ($murl) {
   				case "http://video.google.com/googleplayer.swf?docId=":
   					$width = round(($height-$Googlepix)/$GVfactor);
   					break;
   				case "http://lads.myspace.com/videos/vplayer.swf":
   					$width = round($height/$MSfactor);
   					break;						
       			case "http://www.youtube.com/v/":
	   				$width = round($height/$YTfactor);
   	   				break;						
               	}
	   		}                         

/* Check the optional parameters and change the link and leading text accordingly */
        if ($pieces[2]==''){$mediaURL = $medialoc.$mediaID;}
		else {$mediaURL=$pieces[2]; $leadingtext = $pieces[1];}
		if ($pieces[1]==''){$videotitlelink='';}
		else {$videotitlelink='<a href="'.$mediaURL.'" title="'.$leadingtext.'">'.$pieces[1].'</a>';}
		
/* Print trailling credits. Not crucial for anything but support in marketing and credits to development efforts. */
		$credits = '<br /><small><a href="http://www.daikos.net" title="'.$dvwVersion.'">Video Widget by Daiko</a></small>'; 
		
/* Compose the actual media object to play the video. */
		$embeddedvideo = '<object '.$objectid.'type="'.$objecttype.'" data="'.$mediavalue.'" width="'.$width.'" height="'.$height.'">'.$parameters.'</object>'; 
		
/* Put it all together */
		$fulltext = $videotitlelink.$embeddedvideo.$credits;

/* And do the widget dance! */
		?>
		<?php echo $before_widget; ?>
		<?php 
             echo "<div class='DaikosVideos'>"; 
 
/* Do the conditional tag checks. */
   		switch ($show) {
				case "all": 
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
					break;
				case "home":
				if (is_home()) {
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		  		}
          		else {
            		echo "<!-- Daiko's Video Widget is disabled for this page/post! -->";
          		}
				break;
				case "post":
				if (is_single($slug)) {
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		  		}
          		else {
            		echo "<!-- Daiko's Video Widget is disabled for this page/post! -->";
          		}
				break;
				case "page":
				if (is_page($slug)) {
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		  		}
          		else {
            		echo "<!-- Daiko's Video Widget is disabled for this page/post! -->";
          		}
				break;
				case "category":
				if (is_category($slug)) {
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		  		}
          		else {
            		echo "<!-- Daiko's Video Widget is disabled for this page/post! -->";
          		}
				break;
								
			}
			
              echo "</div>"; ?>
			<?php echo $after_widget; ?>
	
			<?php
	}

	function widget_videos_setup() {
		$options = $newoptions = get_option('widget_videos');
		if ( isset($_POST['videos-number-submit']) ) {
			$number = (int) $_POST['videos-number'];
			if ( $number > 9 ) $number = 9;
			if ( $number < 1 ) $number = 1;
			$newoptions['number'] = $number;
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_videos', $options);
			widget_text_register($options['number']);
		}
	}
	
	function widget_videos_page() {
		$options = $newoptions = get_option('widget_videos');
	?>
		<div class="wrap">
			<form method="POST">
				<h2><?php _e("Daiko's Video Widgets", "widgets"); ?></h2>
				<p style="line-height: 30px;"><?php _e('How many video widgets would you like?', 'widgets'); ?>
				<select id="videos-number" name="videos-number" value="<?php echo $options['number']; ?>">
	<?php for ( $i = 1; $i < 10; ++$i ) echo "<option value='$i' ".($options['number']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
				<span class="submit"><input type="submit" name="videos-number-submit" id="videos-number-submit" value="<?php _e('Save'); ?>" /></span></p>
			</form>
		</div>
	<?php
	}
	
	function widget_videos_register() {
		$options = get_option('widget_videos');
		$number = $options['number'];
		if ( $number < 1 ) $number = 1;
		if ( $number > 9 ) $number = 9;
		for ($i = 1; $i <= 9; $i++) {
			$name = array('Daiko\'s Video Widget %s', 'widgets', $i);
			register_sidebar_widget($name, $i <= $number ? 'widget_videos' : /* unregister */ '', $i);
			register_widget_control($name, $i <= $number ? 'widget_videos_control' : /* unregister */ '', 490, 455, $i);
		}
		add_action('sidebar_admin_setup', 'widget_videos_setup');
		add_action('sidebar_admin_page', 'widget_videos_page');

	}
	
	
	add_action('init', 'widget_videos_register', 5);
    
}
add_action('plugins_loaded', 'widget_videos_init'); 

?>