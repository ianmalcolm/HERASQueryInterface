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

	<div class="entry-content">
		<h1>Plot</h1>

	<?php
	if(isset($_POST['reqs'])) {

		$limLegend = 20;

		$reqs = json_decode(str_replace('\"','"',$_POST['reqs']), true);
	
		$cmd = "python heraimg/plot.py -o heraimg";

		$nCmaph = 0;
		$nCreim = 0;
	
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
				$nCmaph += count(explode(',',$mat));
			}
			if ($pha or $maph) {
				$cmd = $cmd . " -p " . $fname . " " . $mat;
				$nCmaph += count(explode(',',$mat));
			}
			if ($real or $reim) {
				$cmd = $cmd . " -r " . $fname . " " . $mat;
				$nCreim += count(explode(',',$mat));
			}
			if ($imag or $reim) {
				$cmd = $cmd . " -i " . $fname . " " . $mat;
				$nCreim += count(explode(',',$mat));
			}


		}

		if (($nCmaph <= $limLegend) and ($nCreim <= $limLegend)) {
			$cmd = $cmd . " -l";
		}

		$cmd = $cmd . " 2>&1";
		exec($cmd, $output, $return);

		console_log($cmd);
		console_log($output);
		console_log($return);
	
		echo "<br>";
		$imgLst = explode(",", $output[0]);
		
		foreach ($imgLst as $img){
			$path_parts = pathinfo($img);
			echo "<img src=\"/$img\" alt=\"" . $path_parts['filename'] . "\" class=\"s4pimg\" onclick=\"showModal(this)\"></img>";
			echo "<div class=\"s4pimg\">" . $path_parts['filename'] . "</div>";
			echo "<br>";
		}
	}
	?>

		<!-- The Modal -->
		<div id="myModal" class="modal">
		
			<!-- The Close Button -->
			<span id="myModalClose" onclick="hideModal()">&times;</span>
		
			<!-- Modal Content (The Image) -->
			<img id="myModalContent"></img>
		
			<!-- Modal Caption (Image Text) -->
			<div id="myModalCaption"></div>
		</div>

		<script>
			jQuery(document).keyup(function(e) {
				if (e.keyCode == 27) { // escape key maps to keycode `27`
					// <DO YOUR WORK HERE>
					hideModal();
				}
			});
		</script>
	
	</div>

</div>

</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
