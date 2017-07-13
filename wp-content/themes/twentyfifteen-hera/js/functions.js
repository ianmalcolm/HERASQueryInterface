function toggle(selector) {
	if (selector==".mag"){
		uncheck(".pha");
		uncheck(".maph");
	} else if (selector==".pha"){
		uncheck(".mag");
		uncheck(".maph");
	} else if (selector==".maph"){
		uncheck(".mag");
		uncheck(".pha");
	} else if (selector==".real"){
		uncheck(".imag");
		uncheck(".reim");
	} else if (selector==".imag"){
		uncheck(".real");
		uncheck(".reim");
	} else if (selector==".reim"){
		uncheck(".real");
		uncheck(".imag");
	}
}

function colToggle(selector) {
	toggle(selector);

	boxes = jQuery( selector.concat(":checkbox"));
	var first = boxes[0].checked;
	for(var i=0, n=boxes.length;i<n;i++) {
	        boxes[i].checked = !first;
	}
}

function uncheck(selector) {
	boxes = jQuery( selector.concat(":checkbox"));
        for(var i=0, n=boxes.length;i<n;i++) {
                boxes[i].checked = false;
        }
}

function check(selector) {
	boxes = jQuery( selector.concat(":checkbox"));
        for(var i=0, n=boxes.length;i<n;i++) {
                boxes[i].checked = true;
        }
}

function plot() {

	rows = jQuery( "tr.record" );
	var files=[];
	for(var i=0, n=rows.length; i<n; i++){
		var row = {
			fname:jQuery(rows[i]).find("a").attr('href'),
			mat:jQuery(rows[i]).find(":text").val(),
			mag:jQuery(rows[i]).find(".mag:checkbox").is(':checked'),
			pha:jQuery(rows[i]).find(".pha:checkbox").is(':checked'),
			maph:jQuery(rows[i]).find(".maph:checkbox").is(':checked'),
			real:jQuery(rows[i]).find(".real:checkbox").is(':checked'),
			imag:jQuery(rows[i]).find(".imag:checkbox").is(':checked'),
			reim:jQuery(rows[i]).find(".reim:checkbox").is(':checked')
		}

		if (row["mat"] == ""){
			continue;
		}

		if (!row["mag"] && !row["pha"] && !row["maph"] && !row["real"] && !row["imag"] && !row["reim"]) {
			continue;
		}
		
		files.push(row);
	}

	if (files.length == 0) {
		return;
	}

	plotForm(files);
}

function plotForm(requests) {

	var form = document.createElement("form");
	form.setAttribute("method", "POST");
	form.setAttribute("target", "_blank");
	form.setAttribute("action", "/plot");
	
	//Move the submit function to another variable
	//so that it doesn't get overwritten.
	form._submit_function_ = form.submit;
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "reqs");
	hiddenField.setAttribute("value", JSON.stringify(requests));
	
	form.appendChild(hiddenField);

	document.body.appendChild(form);
	form._submit_function_();

}

function showModal(img) {
	jQuery('#myModal').css("display","block");
	jQuery('#myModalContent').attr("src",jQuery(img).attr("src"));
	jQuery('#myModalContent').height(jQuery(window).height());
	jQuery('#myModalCaption').text(jQuery(img).attr("alt"));
	
}

function hideModal() {
	jQuery('#myModal').css("display","none");
}

function sArrayAll(){
	jQuery('table.sarray :checkbox').attr('checked',true);
	sArrayApply();
}

function sArrayNone(){
	jQuery('table.sarray :checkbox').attr('checked',false);
	sArrayApply();
}

function sArrayReset(){
	type = getParameterByName('type');
	if (type=='pam') {
		//console.log('pam reset');
		jQuery("table.sarray :checkbox[name='S11']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S12']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S13']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S14']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S21']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S22']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S23']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S24']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S31']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S32']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S33']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S34']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S41']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S42']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S43']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S44']").attr('checked', true);
	} else if (type=='fem') {
		//console.log('fem reset');
		jQuery("table.sarray :checkbox[name='S11']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S12']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S13']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S21']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S22']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S23']").attr('checked', true);
		jQuery("table.sarray :checkbox[name='S31']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S32']").attr('checked', false);
		jQuery("table.sarray :checkbox[name='S33']").attr('checked', true);
	}

	sArrayApply();
}

function sArrayApply(){

	checkedlist = [];
	boxes = jQuery("table.sarray :checked").each(function(){
		checkedlist.push(jQuery(this).attr('name'));
	});
	boxes = jQuery("table.zarray :checked").each(function(){
		checkedlist.push(jQuery(this).attr('name'));
	});
	pliststr = checkedlist.join(",");
	jQuery("table.s4p :text").val(pliststr);
}

function zArrayAll(){
	jQuery('table.zarray :checkbox').attr('checked',true);
	sArrayApply();
}

function zArrayNone(){
	jQuery('table.zarray :checkbox').attr('checked',false);
	sArrayApply();
}

function zArrayReset(){
//	jQuery("table.zarray :checkbox[name='Z11']").attr('checked', true);
//	jQuery("table.zarray :checkbox[name='Z12']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z13']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z14']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z21']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z22']").attr('checked', true);
//	jQuery("table.zarray :checkbox[name='Z23']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z24']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z31']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z32']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z33']").attr('checked', true);
//	jQuery("table.zarray :checkbox[name='Z34']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z41']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z42']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z43']").attr('checked', false);
//	jQuery("table.zarray :checkbox[name='Z44']").attr('checked', true);

	jQuery("table.zarray :checkbox[name='Z11']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z12']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z13']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z14']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z21']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z22']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z23']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z24']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z31']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z32']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z33']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z34']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z41']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z42']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z43']").attr('checked', false);
	jQuery("table.zarray :checkbox[name='Z44']").attr('checked', false);
	sArrayApply();
}

// JSZip related functions

function download() {
	"use strict";

	var numChecked = jQuery("tr.record .down:checked").length;
	if (numChecked < 1) {
		return false;
	}

	var Promise = window.Promise;
	if (!Promise) {
		Promise = JSZip.external.Promise;
	}

	if(!JSZip.support.blob) {
		showError("This demo works only with a recent browser !");
		return;
	}

	resetMessage();

	var zip = new JSZip();


	var rows = jQuery( "tr.record" );

	for(var i=0, n=rows.length; i<n; i++){
		var url = jQuery(rows[i]).find("a").get(0).href;

		var fileNameIndex = url.lastIndexOf("/") + 1;
		var filename = url.substr(fileNameIndex);

		var down = jQuery(rows[i]).find(".down:checkbox").val();

		if (down){
			zip.file(filename, urlToPromise(url), {binary:true});
		}
	}

	// when everything has been downloaded, we can trigger the dl
	zip.generateAsync({type:"blob"}, function updateCallback(metadata) {
			var msg = "progression : " + metadata.percent.toFixed(2) + " %";
			if(metadata.currentFile) {
			msg += ", current file = " + metadata.currentFile;
			}
			showMessage(msg);
			updatePercent(metadata.percent|0);
			})
	.then(function callback(blob) {

			// see FileSaver.js
			saveAs(blob, "s4p.zip");

			showMessage("done !");
			}, function (e) {
			showError(e);
			});

	return false;

}


/**
 * Reset the message.
 */
function resetMessage () {
	jQuery("#result").removeClass().text("");
}
/**
 * show a successful message.
 * @param {String} text the text to show.
 */
function showMessage(text) {
	resetMessage();
	jQuery("#result")
		.addClass("alert alert-success")
		.text(text);
}
/**
 * show an error message.
 * @param {String} text the text to show.
 */
function showError(text) {
	resetMessage();
	jQuery("#result")
		.addClass("alert alert-danger")
		.text(text);
}
/**
 * Update the progress bar.
 * @param {Integer} percent the current percent
 */
function updatePercent(percent) {
	jQuery("#progress_bar").removeClass("hide")
		.find(".progress-bar")
		.attr("aria-valuenow", percent)
		.css({
width : percent + "%"
});
}

/**
 * Fetch the content and return the associated promise.
 * @param {String} url the url of the content to fetch.
 * @return {Promise} the promise containing the data.
 */
function urlToPromise(url) {
	return new Promise(function(resolve, reject) {
			JSZipUtils.getBinaryContent(url, function (err, data) {
					if(err) {
					reject(err);
					} else {
					resolve(data);
					}
					});
			});
}

function getParameterByName(name, url) {
	if (!url) url = window.location.href;
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	    results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}
