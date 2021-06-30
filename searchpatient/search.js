// JavaScript Document
function search(bool) {

	$.get('search.php',{
		name:$('#namefield').val(),
		age:$('#agefield').val(),
		ageMonth:$('#ageMonthField').val(),
		sex:$('#sexfield').val(),
		date:$('#datefield').val(),
		from:$('#fromField').val(),
		to:$('#toField').val(),
	},function(data,status) {
		if (data!='Failed') {
			if (bool==false) {
			$('tbody.append').empty();
		}

			$('tbody.append').append(data);
			if (window.rangeAyiHai==true) {
				window.searchSuccess=true;
				//restOfTheRangePatients();
				window.rangeAyiHai=false;
			}
		}
		else {alert('Failed.');}
	});
}

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();


});

function getDetails(x) {
		var id;
		window.original_id = $(x).attr('id');
		var original_id = $(x).data('original_id');
		if (original_id!='') {
			id = original_id;
		} else {
		id = window.original_id;
	}

		window.overallid = id;
		$.get('detailedsearch.php',
		{ID:id},
		function(data,status) {
				if (status = 'Success') {
					var toappend = "<table class='table'><tr>";
					toappend += $('#' + id).html() + "</tr></table>";
					toappend+="<table>" + data + "</table>";
					$('div.modal-body').empty().append(toappend);
					window.reDirectLocation="../addpatient/index.php?id=" + parseInt(id);
					$('#myModal').modal('show');
									}//if status is success
				else {alert('Request failed.');}
			}
	);//get request  ends
}
function reDirect() {
		window.location=window.reDirectLocation;
}
function deletePatient() {
	window.location="deleterecord.php?id=" + window.original_id;
}
$(document).ready(function(){
	$.fn.enterKey = function (fnc) {
	return this.each(function () {
			$(this).keypress(function (ev) {

					var keycode = (ev.keyCode ? ev.keyCode : ev.which);
					if (keycode == '13') {
						ev.preventDefault();
							fnc.call(this, ev);
					}
			})
	})
	}
	$("input").enterKey(function () {
    search(false);
});
});


	$(document).ready(function(){



		if (window.searchAyiHai==true) {

		$("#sexfield").val(window.sex);
		$('#datefield').val(window.date);
		search(false);

	}

	if (window.rangeAyiHai==true) {
		$('#fromField').val(window.from);
		$('#toField').val(window.to);
		$("#sexfield").val(window.sex);
		search(false);

	}

	});
function restOfTheRangePatients() {
	$('#datefield').val(window.to);
	search(true);
}

function showDatePicker(x) {
	if ($('#searchButton').css('display')=='none') {
	$('#searchButton').css('display','block');
}

	if (x=='single') {
		$('#fromField').val('');
		$('#toField').val('');
		$('#singleDateDiv').toggle();
		if ($('#rangeFields').is(':visible')) {
			$('#rangeFields').toggle();

		}
	} else if (x=='range') {
		$('#datefield').val('');
		$('#rangeFields').toggle();
		if ($('#singleDateDiv').is(':visible')) {
			$('#singleDateDiv').toggle();
		}
	}
}

function showHistory(x) {
	var id = $(x).data('id');
	window.location='patienthistory.php?id=' + id;
}
