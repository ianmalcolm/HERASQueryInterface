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

	<form role="search" method="post" class="entry-content" action="">
	<label>
		<?php

			if ($_GET['type']=='pam'){
				echo '<h2>PAM Database</h2>';
				echo 'Here you can download or plot the standard 4-port s-parameter data for any of the PAM-75 modules.  Each module has a barcode and a serial number.  The serial numbers are 751YY for the PAMs.';
				echo '<br>';
				echo '<br>';
				echo 'Search S parameter files (for batch return enter e.g. 751*, which will return the files for all PAMs):';
			} else if ($_GET['type']=='fem') {
				echo '<h2>FEM Database</h2>';
				echo 'Here you can download or plot the standard 3-port s-parameter data for any of the FEM-75 modules.  Each module has a barcode and a serial number.  The serial numbers are 750XX for the FEMs.';
				echo '<br>';
				echo '<br>';
				echo 'Search S parameter files (for batch return enter e.g. 750*, which will return the files for all FEMs):';
			}
		?>
		<br>
		<br>
		<span class="screen-reader-text">Search for:</span>
		<input type='hidden' name='type' value="<?php echo $_GET['type']; ?>"/>
		<input type="search" class="search-field" placeholder="Search …" value="<?php echo $_POST['sn']; ?>" name="sn">
	</label>
	<input type="submit" class="search-submit screen-reader-text" value="Search">
	</form>	

	<?php
		function femFilter($var){
			return strpos($var, 's3p') !== false;
		}

		function pamFilter($var){
			return strpos($var, 's4p') !== false;
		}

		if (!empty($_POST['sn'])){
			$str=$_POST['sn'];
			$type=$_GET['type'];
			$files = glob("heras/$str");
			if ($type=='pam'){
				$files = array_filter($files, "pamFilter");
			} else if ($type=='fem'){
				$files = array_filter($files, "femFilter");
			}
		}
		if (count($files)>0) {
			echo '<div class="entry-content">';

			echo '<table class="s4p">';
			echo '<tr>';
				echo '<th class="name">Name</td>';
				echo '<th class="mat">Mat</td>';
				echo '<th class="mag"  onclick="colToggle(\'.mag\')" >Mag</td>';
				echo '<th class="pha"  onclick="colToggle(\'.pha\')" >Pha</td>';
				echo '<th class="maph" onclick="colToggle(\'.maph\')" >M+P</td>';
				echo '<th class="real" onclick="colToggle(\'.real\')" >Real</td>';
				echo '<th class="imag" onclick="colToggle(\'.imag\')" >Imag</td>';
				echo '<th class="reim" onclick="colToggle(\'.reim\')" >R+I</td>';
				echo '<th class="down" onclick="colToggle(\'.down\')" ><img src="';
				echo get_stylesheet_directory_uri();
				echo '/img/download.png" height="24" width="24"/></td>';
			echo '</tr>';
			foreach ($files as $filename) {
				$info = pathinfo($filename);
				$namenoext =  basename($filename,'.'.$info['extension']);
				echo '<tr class="record" id=$namenoext>';
				echo '<td class="name"><a href=/'.$filename.'>'.basename($filename).'</a></td>';
				echo '<td class="mat" ><input name="".$namenoext."mat"                                           type="text"></td>';
				echo '<td class="mag" ><input name="".$namenoext."mag"  onclick="toggle(\'.mag\')"  class="mag"  type="checkbox"></td>';
				echo '<td class="pha" ><input name="".$namenoext."pha"  onclick="toggle(\'.pha\')"  class="pha"  type="checkbox"></td>';
				echo '<td class="maph"><input name="".$namenoext."maph" onclick="toggle(\'.maph\')" class="maph" type="checkbox"></td>';
				echo '<td class="real"><input name="".$namenoext."real" onclick="toggle(\'.real\')" class="real" type="checkbox"></td>';
				echo '<td class="imag"><input name="".$namenoext."imag" onclick="toggle(\'.imag\')" class="imag" type="checkbox"></td>';
				echo '<td class="reim"><input name="".$namenoext."reim" onclick="toggle(\'.reim\')" class="reim" type="checkbox"></td>';
				echo '<td class="down"><input name="".$namenoext."down"                             class="down" type="checkbox"></td>';
				echo '</tr>';
			}

			echo '</table>';

			echo '<table class="button">';
			echo '<tr>';
			echo '<td><button onclick="plot()">Plot</td>';
			echo '<td><button onclick="download()">Download</td>';
			echo '</tr>';
			echo '</table>';
	?>

	<?php
			echo '<table class="s4p">';
			echo '<tr>';
				echo '<th colspan="3">S Parameter Selector</th>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan="3">';
				if ($_GET['type']=='pam'){
					echo '<table class="sarray">';
					echo '<tr>';
					echo '<td>S11<input name="S11" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S12<input name="S12" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S13<input name="S13" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S14<input name="S14" type="checkbox" onclick="sArrayApply()"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>S21<input name="S21" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S22<input name="S22" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S23<input name="S23" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S24<input name="S24" type="checkbox" onclick="sArrayApply()"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>S31<input name="S31" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S32<input name="S32" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S33<input name="S33" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S34<input name="S34" type="checkbox" onclick="sArrayApply()"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>S41<input name="S41" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S42<input name="S42" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S43<input name="S43" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S44<input name="S44" type="checkbox" onclick="sArrayApply()"></td>';
					echo '</tr>';
					echo '</table>';
				} else if ($_GET['type']=='fem') {
					echo '<table class="sarray">';
					echo '<tr>';
					echo '<td>S11<input name="S11" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S12<input name="S12" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S13<input name="S13" type="checkbox" onclick="sArrayApply()"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>S21<input name="S21" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S22<input name="S22" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S23<input name="S23" type="checkbox" onclick="sArrayApply()"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>S31<input name="S31" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S32<input name="S32" type="checkbox" onclick="sArrayApply()"></td>';
					echo '<td>S33<input name="S33" type="checkbox" onclick="sArrayApply()"></td>';
					echo '</tr>';
					echo '</table>';
				}
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><button onclick="sArrayAll()">All</button></td>';
				echo '<td><button onclick="sArrayNone()">None</button></td>';
				echo '<td><button onclick="sArrayReset()">Reset</button></td>';
			echo '</tr>';
			echo '</table>';


			echo '<table class="z4p">';
			echo '<tr>';
				echo '<th colspan="4">Z Parameter Selector</th>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan="4">';
					echo '<table class="zarray">';
					echo '<tr>';
					echo '<td>Z11<input name="Z11" type="checkbox"></td>';
					echo '<td>Z12<input name="Z12" type="checkbox"></td>';
					echo '<td>Z13<input name="Z13" type="checkbox"></td>';
					echo '<td>Z14<input name="Z14" type="checkbox"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>Z21<input name="Z21" type="checkbox"></td>';
					echo '<td>Z22<input name="Z22" type="checkbox"></td>';
					echo '<td>Z23<input name="Z23" type="checkbox"></td>';
					echo '<td>Z24<input name="Z24" type="checkbox"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>Z31<input name="Z31" type="checkbox"></td>';
					echo '<td>Z32<input name="Z32" type="checkbox"></td>';
					echo '<td>Z33<input name="Z33" type="checkbox"></td>';
					echo '<td>Z34<input name="Z34" type="checkbox"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>Z41<input name="Z41" type="checkbox"></td>';
					echo '<td>Z42<input name="Z42" type="checkbox"></td>';
					echo '<td>Z43<input name="Z43" type="checkbox"></td>';
					echo '<td>Z44<input name="Z44" type="checkbox"></td>';
					echo '</tr>';
					echo '</table>';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><button onclick="zArrayAll()">All</button></td>';
				echo '<td><button onclick="zArrayNone()">None</button></td>';
				echo '<td><button onclick="zArrayReset()">Reset</button></td>';
				echo '<td><button onclick="sArrayApply()">Apply</button></td>';
			echo '</tr>';
			echo '</table>';


			echo '</div>';

			echo '<script type="text/javascript">',
			     'sArrayReset();',
//			     'zArrayReset();',
			     'sArrayApply();',
			     'jQuery("input.mag:checkbox").prop("checked",true);',
			     'jQuery("input.down:checkbox").prop("checked",true);',
			     '</script>';
		}

	?>
</div>

</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
