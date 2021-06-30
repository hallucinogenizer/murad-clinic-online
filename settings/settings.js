


if (window.imagehai==true) {
  $('#changeImage').css('display','block');
}




$(document).ready(function(){



  $('#closeButton').click(function() {
     window.location='index.php';
  });



  $('#hasImage').click(function(){
    if (window.imagehai==true) {

    } else {
      if ($('#hasImage').prop('checked')==true) {
        $('#logoImageUploader').css('display','block');
      } else {
        $('#logoImageUploader').css('display','none');
      }
    }
  });

  $('#changeImage').click(function(e){
    e.preventDefault();
    $('#logoImageUploader').toggle();
  });

});
