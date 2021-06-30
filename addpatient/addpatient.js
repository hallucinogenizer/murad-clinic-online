// JavaScript Document
$(document).ready(function(){
	Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);




});//date function ends


	 $('#datefield').val(new Date().toDateInputValue());
	 $('[data-toggle="tooltip"]').tooltip();

$('.expand_tests').click(function(event) {
	window.expandFunction(event.target.id);
});
$('.expand_tests span').click(function(event) {
	var theparent = $(event.target).parent();
	window.expandFunction(theparent.attr('id'));
});
});

function expandFunction(id) {
	if (id=='tr0') {$('.second_expand').slideToggle();$('.third_expand').slideUp();$('.expanded_list').slideUp();}
	else if (id=='el0') {$('#el1').slideToggle();}
	else if (id=='tr2') {$('#el2').slideToggle();}
	else if (id=='tr3') {$('#el3').slideToggle();}
	else if (id=='tr4') {$('.third_expand').slideToggle();}
	else if (id=='el4') {$('#el5').slideToggle();}
	else if (id=='tr6') {$('#el6').slideToggle();}
	else if (id=='tr7') {$('#el7').slideToggle();}
	else if (id=='tr8') {$('#el8').slideToggle();}
}
var tests_array = [];
function handleChange(element) {
	if ($(element).is(":checked")) {
	tests_array.push($(element).val());
	} //if is checked ends
	else {
    const index = tests_array.indexOf($(element).val());
    if (index !== -1) {
        tests_array.splice(index, 1);
    	}
	}//else ends
}


function submitForm() {
	if ($('#namefield').val().length<2) {$('div.modal-body').empty().append('Name must be at least 2 characters long.');$('#myModal').modal('show');}
	else if ($('#agefield').val().length<1) {$('div.modal-body').empty().append('Age must be at least 1 character long.');$('#myModal').modal('show');}
	else if ($('#agefield').val().length>3) {$('div.modal-body').empty().append('Age must be less than 3 characters long.');$('#myModal').modal('show');}
	else {

	$("#submit").attr("disabled", "disabled");
	$('#submit').text('...Please Wait');
	$('#submit').removeClass('btn-primary');
	$('#submit').addClass('btn-info');

	//retrieve data from form starts

	//tests_array is the array of tests selected
	var name,age,sex,date,pc,treatment,tests,price,i;

	name = $('#namefield').val();
	if ($('#agefield').val()=='') {
		$('#agefield').val(0);
	}
	age = $('#agefield').val();
	if ($('#ageMonthField').val()=='') {
		$('#ageMonthField').val(0);
	}
	ageMonth = $('#ageMonthField').val();
	sex = $('#sexfield').val();
	pc = $('#pcfield').val();
	treatment = $('#treatmentfield').val();
	price = $('#pricefield').val();
tests_text = $('#tests_text').val();
	if (pc=='') {pc='null'}
	if (treatment=='') {treatment='null'}
	if (price=='') {price=0}
	if (tests=='') {tests='null'}
	if (tests_text=='') {tests='null'}
	//retrieve data from form ends


	//ajax request starts

	$.post('add_patient_to_db.php',{
		name:name,
		age:age,
		ageMonth:ageMonth,
		sex:sex,
		pc:pc,
		treatment:treatment,
		price:price,
		tests_text:tests_text,
		id:window.id
		},function(data,status) {
			if (status=='success' && data.indexOf('Success') !== -1) {
			//on success code starts
			$('#submit').text('✓ Done');$('#submit').removeClass('btn-info').removeClass('btn-danger');
			$('#submit').addClass('btn-success');$('#newPatient').fadeIn();$('.third_expand').slideUp();$('.expanded_list').slideUp();
			//on success code ends
			} else {
			$('#submit').text('Try Again');$('#submit').removeClass('btn-info');
			$('#submit').addClass('btn-danger');$('#submit').prop('disabled',false);
			$('#demo').append(data);
			}
		});
	//ajax request ends


	}//form validation else ends

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
		if ($('#submit').text()!='✓ Done') {
    submitForm();
	} else {
		$('#newPatient').click();
	}
})
});
