$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();
});

function showDateField(type) {

  //this function is called when he clicks on one of the two buttons of Date selection
  if (type=='single') {//if he wants to search for a single date

    //see if the multi date selector is visible
    if ($('#multiDatePicker').css('display')=='block') {
      $('#multiDatePicker').slideToggle(500);//if yes, hide it
      window.setTimeout("$('.simple').slideToggle(500);",700);
    }
    else {

      $('.simple').css('display','block!important');

    }

  }//if type==simple
  else if (type=='range') {
    //check if the single date selector is visible
    if ($('.simple').css('display')=='block') {
      $('.simple').slideToggle(500);//hide it
      window.setTimeout("$('#multiDatePicker').slideToggle(500);",700);//show the multi-date selector
    }
    else {
      $('#multiDatePicker').slideToggle(500);
    }
  }
}

function showDetails(x) {
  if ($(x).attr('id')=='patientShow') {

    $('#patientdetails').toggle();
    if ($('#patientdetails').is( ":visible" )) {

      $('#toShowOrToHide1').text('Hide');
      $('#patientArrow').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
      //$('#patientArrowCircle').css('color','#00a1ff');

    } else {
      $('#toShowOrToHide1').text('Show');
      $('#patientArrow').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
      //$('#patientArrowCircle').css('color','grey');
    }

  } else if ($(x).attr('id')=='expenseShow') {

    $('#expensedetails').toggle();
    if ($('#expensedetails').is( ":visible" )) {
      $('#expenseArrow').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
      $('#toShowOrToHide2').text('Hide');
      //$('#expenseArrowCircle').css('color','#00a1ff');
    } else {
      $('#toShowOrToHide2').text('Show');
      $('#expenseArrow').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
      //$('#expenseArrowCircle').css('color','grey');
    }

  }


}//function ends


function reDirectToSearch(id) {
  var location='';
  location = location + "../expenses/index.php?";

  if (window.type_of_display=='today') {

    location = location + "searchtype=" + id + "&searchexpense=&";
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

    location = location + "searchdate=" + date;

} else if (window.type_of_display=='range') {

    location = location + "range&from=" + window.from + "&to=" + window.to + "&searchtype=" + id;

} else if (window.type_of_display=='date') {

    location+="searchtype=" + id + "&searchexpense=&searchdate=" + window.chosenDate;
}


location+="&searchtitle=&searching=&comingfromstatspage";
window.location=location;
}




function reDirectToSearchPatient(id) {
  var location='';
  location = location + "../searchpatient/index.php?";

  if (window.type_of_display=='today') {

    location = location + "sex=" + id;
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    location = location + "&date=" + date;

} else if (window.type_of_display=='range') {

    location = location + "sex=" + id + "&from=" + window.from + "&to=" + window.to;

} else if (window.type_of_display=='date') {

    location+="sex=" + id + "&date=" + window.chosenDate;
}

window.location=location;
}




//canvasJS graphs drawn


//CanvasJS.addColorSet("customColorSet1",["#39e47e","#3995e4","#e1e439","#e439df"]);
//CanvasJS.addColorSet("customColorSet1",["#5E412F","#FCEBB6","#93f9ae","#bfbfbf", "#a8b6f9", "#cfa8f9", "#f9a8ef", "#f9a8a8"]);
window.onload = function () {



//male female chart starts
  var patientChart = new CanvasJS.Chart("patientPieChart",
	{
    animationEnabled:true,
		colorSet:  "customColorSet1",
		theme: "theme2",
    backgroundColor:'transparent',
		title:{
			text: "Patients by Gender",
			fontFamily:'Century Gothic',
			fontWeight:'bold',
      fontSize:26
		},
		axisY:{
   labelFontFamily: "tahoma",
 		},
		subtitles: [{
			text:"Number of Male, Female and Other Patients",
			fontFamily:'tahoma',
			fontSize:12
		}],

		data: [
		{
			type: "pie",
			//showInLegend: true,
			//legendText: "{indexLabel}",
			dataPoints: [
				{  y: malePatients, indexLabel: "Male Patients", indexLabelFontColor: 'grey', indexLabelFontFamily:'Helvetica', indexLabelFontSize: 16},
				{  y: femalePatients, indexLabel: "Female Patients", indexLabelFontColor: 'grey', indexLabelFontFamily:'Helvetica', indexLabelFontSize: 16},
				{  y: otherPatients, indexLabel: "Other Gender Patients", indexLabelFontFamily:'Helvetica', indexLabelFontSize: 16}
			]
		}
		]
	});
	patientChart.render();
//male female chart ends


}
