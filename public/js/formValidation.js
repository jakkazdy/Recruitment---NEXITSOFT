var url = 'http://localhost/NEXITSOFT/recruitment/public/';
var Confir =  {first_name:false, 
  last_name:false, 
  dob:false, 
  education:true, 
  email:false, 
  attachmentLM:false, 
  attachmentCV:false,
};
var Internship =  {};
var _validFileExtensions = [".jpg", ".jpeg", ".pdf", ".doc"]; 

$(document).ready(function () {

  $("#infoSubmit").hide();
  // Wrong validate hide
  $("#first_nameValidation").hide();
  $("#last_nameValidation").hide();
  $("#emailValidation").hide();
  $("#dobValidation").hide(); //DOB
  $("#attachmentLMValidation").hide();
  $("#attachmentCVValidation").hide();
  $(".attachmentOther").hide();
  $("#attachmentOtherValidation").hide();

  // Validate email
  $("input[name='email']").change(function () {
    let status = emailValidation('email');
    validateChangeClass('email',status);
  });

  // Validate date
  $(document).on('change',"input.dateValidation", function() {
    let status = dateValidation($(this));
    validateChangeClass($(this).attr('name'),status);
  });

  // View form attachment other
  $(".attachmentOtherViewButton").click(function () {
  Confir['attachmentOther']=false;
    $("input[name=attachment_other_status]").val(1);
    $(".attachmentOther").show();
    $(this).hide();
  })
  // Validate attachment
  $("input[name='attachmentLM']").change(function () {
    let status = fileValidation('attachmentLM');
    Confir['attachmentLM']=status;
    validateChangeClass('attachmentLM',status);
  });
  $("input[name='attachmentCV']").change(function () {
    let status = fileValidation('attachmentCV');
    Confir['attachmentCV']=status;
    validateChangeClass('attachmentCV',status);
  });
  $("input[name='attachmentOther']").change(function () {
    let status = fileValidation('attachmentOther');
    Confir['attachmentOther']=status;
    validateChangeClass('attachmentOther',status);
  });

  // Validate input type text/varchar
  $(document).on('change',".internshipValidateName, input[name=first_name], input[name=last_name]", function() {
  //$(".internshipValidateName").change(function () {
    let status = varcharValidation($(this));
    validateChangeClass($(this).attr('name'),status);
  });


  // View status valid
  function validateChangeClass(inputName,status){
    if(status==true){
      $("input[name='"+inputName+"']").removeClass('is-valid, is-invalid');
      $("input[name='"+inputName+"']").addClass('is-valid');
    }else{
      $("input[name='"+inputName+"']").removeClass('is-valid, is-invalid');
      $("input[name='"+inputName+"']").addClass('is-invalid');
    }
  }

  //Validate Varchar
  function varcharValidation(input) {
    //console.log(input.attr('name'));
    let inputData = input.val();
    if (inputData.length == "") {
      $("#"+input.attr('name')+"Validation").show();
      Confir[input.attr('name')]=false;
      return false;
    } else if (inputData.length > 100) {
      $("#"+input.attr('name')+"Validation").show();
      $("#"+input.attr('name')+"Validation").html("*Pole jest za długie");
      Confir[input.attr('name')]=false;
      return false;
    }  else if (inputData.length < 2) {
      $("#"+input.attr('name')+"Validation").show();
      $("#"+input.attr('name')+"Validation").html("*Pole musi zawierać przynajmniej 2 znaki");
      Confir[input.attr('name')]=false;
      return false;
    } else {
      $("#"+input.attr('name')+"Validation").hide();
      Confir[input.attr('name')]=true;
      return true;
    }
  }
 
  //Validate Email
  function emailValidation(inputName) {
     const email = $("input[name='"+inputName+"']").val();
       let regex = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
       let s = email;
       if (regex.test(s)) {
        $("#"+inputName+"Validation").hide();
        Confir[inputName]=true;
        return true;
       } else {
        $("#"+inputName+"Validation").show();
        $("#"+inputName+"Validation").html("*Podany adres email jest błędny.");
        Confir[inputName]=false;
     
         return false;
       }   
     }

  //Validate Date
  function dateValidation(input) {
     const date = input.val();
     //console.log(date);
     let regex = /^([0-9]+)-([0-9]+)-([0-9]+)$/;
       if (regex.test(date)) {
        $("#"+input.attr('name')+"Validation").hide();
        Confir[input.attr('name')]=true;
        return true;
       } else {
        $("#"+input.attr('name')+"Validation").show();
        $("#"+input.attr('name')+"Validation").html("*Niewłaściwy format daty.");
        Confir[input.attr('name')]=false;
         return false;
       }   
     }

  //Validate Files
  function fileValidation(inputName) {
    var arrInputs = document.getElementsByTagName("input");;
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        Confir[inputName]=true;
                        blnValid = true;
                        break;
                    }
                }
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                    Confir[inputName]=false;
                    oInput.value='';
                    return false;
                }
            }
        }
    }
    Confir[inputName]=true;
    return true;
  }
  // View form for next Internship
  $(".internshipAddButton").click(function () {
    var number = Object.keys(Internship).length;
    //Confir['internship'+number]=false;
     $.ajax({
       url: url+'form/ajaxGeneratingFormInternship/'+number,
       success: function(data){
        $('.formInternship').append(data);
          Confir['internship['+(number-1)+'][name]']=false;
          Confir['internship['+(number-1)+'][start]']=false;
          Confir['internship['+(number-1)+'][end]']=false;
       },
     });
    $('input[name=internshipCount]').val(number++);
    Internship[number] = true;
  }) 

  // Submit button
  $("a.sendButton").click(function () {
    var error=0;
    for (const [key, value] of Object.entries(Confir)) {
      validateChangeClass(key,value);
      if(value===false){
        error++;
        $("#infoSubmit").show();
      }
    }
    if(error==0){
      $("#infoSubmit").hide();
      $("input[name=formSubmit]").prop( "disabled", false );
      $("input[name=formSubmit]").click();
    }
  });
});

//delete form Internship
$(document).on('click',".deleteInternshipButton", function() {
  var number = $(this).attr('data-id');
  console.log(number);
  console.log('#internship'+number);
  console.log($('.formInternship'));
  Confir['internship['+(number)+'][name]']=true;
  Confir['internship['+(number)+'][start]']=true;
  Confir['internship['+(number)+'][end]']=true;
  $( "#internship"+number ).remove();

})