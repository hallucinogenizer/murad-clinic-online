function showModal(title,body,showid) {
	$(document).ready(function(){
	$('.modal-title').text(title);

	$('.modal-body').append('<p>' + body + '</p>');
	$('#myModal').modal('show');
	if(showid!='') {
		$('#' + showid).css('display','block');
	}
	
});
}
