$(document).ready(function() {

  $('#btn-login').click(function(e){
    e.preventDefault()

    var userName = $('#username').val()
    var password = $('#password').val()

    if(userName.trim() == ""){
      $('#username').addClass('is-invalid')
      $('#username-feedback').show()
      $('#username-feedback').html('<span style="color:red">Please input username</span>')

      return
    }else{
      $('#username-feedback').hide()
      $('#username').removeClass('is-invalid')
    }

    if(password.trim() == ""){
      $('#password').addClass('is-invalid')
      $('#password-feedback').show()
      $('#password-feedback').html('<span style="color:red">Please input password</span>')

      return
    }else{
      $('#password-feedback').hide()
      $('#password').removeClass('is-invalid')
    }

    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "Authenticate",
        username: userName,
        password: password
      }
    }).done(function( msg ) {
      try{
        if(msg == true){
          window.location.replace("systemmonitoring.php")
        }else{
          showPopup("User name or password is incorrect","danger")
        }
      }catch(e){
        showPopup("User name or password is incorrect","danger")
      }
    });
  })

  $('#datepicker-monitoring').daterangepicker({
		opens: 'left',
		autoUpdateInput: true,
		locale: {
            format: 'DD/MM/YYYY'
        }

	}, function(start,end,label){

	});

  $('#delivery-vendor').multiselect({
		selectAll: true,
    buttonWidth: '100%',
		placeholder: 'Select vendor'
	});

  $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
       $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
   });

})

function showPopup(message,type){
  $.notify({
    message: message,
  },{
    type: type,
    placement: {
		from: "bottom",
		align: "center",
    delay: 2000,
    timer: 1000,
	},
  });
}

function showLoading(){
  $('.loading').show()
}

function hideLoading(){
  $('.loading').hide()
}
