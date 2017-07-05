<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen_HERA
 * @since Twenty Fifteen HERA 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">
<div class="hentry">
	<?php
	if(isset($_POST['reqs'])) {
	
		$reqs = json_decode(str_replace('\"','"',$_POST['reqs']), true);
	
		$cmd = "rm -f heraimg/*.png";
		exec($cmd, $output, $return);
	
		$cmd = "python heraimg/plot.py -o heraimg";
	
		foreach ($reqs as $req) {
	
			$fname = realpath(".".$req['fname']);
			$mat = $req['mat'];
			$mag = $req['mag'];
			$pha = $req['pha'];
			$maph = $req['maph'];
			$real = $req['real'];
			$imag = $req['imag'];
			$reim = $req['reim'];
	
			$path_parts = pathinfo($fname);
	
			if ($mag or $maph) {
				$cmd = $cmd . " -m " . $fname . " " . $mat;
			}
			if ($pha or $maph) {
				$cmd = $cmd . " -p " . $fname . " " . $mat;
			}
			if ($real or $reim) {
				$cmd = $cmd . " -r " . $fname . " " . $mat;
			}
			if ($imag or $reim) {
				$cmd = $cmd . " -i " . $fname . " " . $mat;
			}
	
		}
		
		$cmd = $cmd . " 2>&1";
		exec($cmd, $output, $return);
		if ($return!=0){
			print_r($cmd);
			echo "<br>";
			print_r($output);
			echo "<br>";
			print_r($return);
			echo "<br>";
		}
	
		echo "<br>";
		$imgLst = glob('heraimg/*.png');
		foreach ($imgLst as $img){
			$path_parts = pathinfo($img);
			echo "<img src=\"/$img\" alt=\"" . $path_parts['filename'] . "\" class=\"s4pimg\" onclick=\"showModal(this)\"></img>";
			echo "<div class=\"s4pimg\">" . $path_parts['filename'] . "</div>";
			echo "<br>";
		}
	}
	?>

	<div class="entry-content">
		<h1>Plot</h1>
		<!-- The Modal -->
		<div id="myModal" class="modal">
		
			<!-- The Close Button -->
			<span id="myModalClose" onclick="hideModal()">&times;</span>
		
			<!-- Modal Content (The Image) -->
			<img id="myModalContent"></img>
		
			<!-- Modal Caption (Image Text) -->
			<div id="myModalCaption"></div>
		</div>
	
		<div id="myImgDiv">
			<div class="loader"></div> 
			<br>
			<br>
			<br>
			<br>
			<div style="text-align:center">Loading ...</div>
		</div> 
	
	</div>

</div>

</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
