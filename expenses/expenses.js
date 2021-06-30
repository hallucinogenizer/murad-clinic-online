// JavaScript Document
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
//to set default input field  date value to today

		Date.prototype.toDateInputValue = (function() {
	    var local = new Date(this);
	    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
	    return local.toJSON().slice(0,10);


});//date function ends

});
$(document).ready(function(){
$('#dateField').val(new Date().toDateInputValue());

$('#select_type').change(function(){
	var optionSelected = $(this).find('option:selected').text();

	if (optionSelected=='Add new type') {
		var newtype = prompt('Name your new category:');
		if (newtype!=null) {
		$.get('add_category.php',
		{category:newtype},
	function(data,status) {
		if (data=='Success') {
			showModal('Success','A new category has been added.','continue');
			$('#continue').attr('onClick',"window.location='index.php';");
		}
		else if (data=='Failed') {showModal('Failed','A new category has not been added.','');}

	});
}//if prompt wasn't null
}//if Add new type was selected
	else if (optionSelected=='Delete a type') {
		$('#continue').fadeIn('fast');
		showModal('Choose a Type to remove',"",'deleteSelector');
		$('#continue').attr('onClick',"setTimeout(continueDelete(),1000)");
	}
});//on select value change


});


function continueDelete() {
	var deleteType = $('#deleteSelector').find(':selected').text();
	$.get('deleteCategory.php',{category:deleteType},function(data,status) {
		if (data=='Success') {
			window.location='index.php?success';
		} else {
			window.location='index.php?failed'
		}
	});//get request ends
}



function showerRedirect() {
	if (showing==true) {
		$('table.show').slideToggle(000);
	}
	else {
		window.location='index.php?show';
	}
}

function pickMultipleDates() {
		showModal('Pick a Range of Dates:','','multiDatePicker');
		$('#continue').fadeIn();
		$('#continue').attr('onClick',"replaceDateWithMultiple()");
}
function replaceDateWithMultiple() {
	var from = $('input.from').val();
	var to = $('input.to').val();
	window.location='index.php?range&from=' + from + '&to=' + to;
}
function deleteExpense(x) {
	var ID = $(x).attr('id');
	$.get('deleteExpense.php', {ID:ID}, function(data,status) {
		if  (data=='Success') {
			showModal('Success','Entry deleted successfully.');

		} else {
			showModal('Failed','Entry could not be deleted successfully. Please try again or contact the developer.');
		}
		$('#continue').css('display','block');
		$('#continue').attr('onClick',"window.location='index.php?show'");
	});
}
