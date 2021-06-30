// JavaScript Document
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	window.divnumber = 1;
	window.setInterval('reLoadPage()',5000);
	window.showingNext = 0;
});
function showNext() {
window.showingNext +=1;
	$('.sublist' + parseInt(window.divnumber+1)).addClass('show');
}
function reLoadPage() {
	if (window.showingNext==0) {
		location.reload(true);
	} else if (window.fieldActive==true) {

	}
	else {
		window.location='index.php?showmore=' + window.showingNext;
	}
}
