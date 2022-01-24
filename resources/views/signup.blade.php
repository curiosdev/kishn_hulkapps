@extends('layout.header')

@section('title','Registration')

<style>
.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 10px;
  border-radius: 5px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: #04AA6D;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: #04AA6D;
  cursor: pointer;
}
</style>

@section('main')


<div class="container">
    
        <div class="row">

            <div class="col">
                <img src="{{ url('/images/regg1.png') }}" style="height:400;" />
            </div>

            <div class="col">
                
                <div class="alert alert-danger print-reg-error-msg" style="display:none">
                    <ul></ul>
                </div>

                <div class="alert alert-success print-reg-success-msg" style="display:none">
                   
                </div>

                <form name="registration_form" id="registration_form" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="name" placeholder="Name *" >
                    
                    <input type="email" name="email" placeholder="Email *" >
                    <input type="password" name="password" placeholder="Password *" >
                    <input type="password" name="confirm_password" placeholder="Confirm Password *" >
                
                
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                </form>
            </div>

        </div>
    
</div>

<script>
    
    $('#registration_form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(document.getElementById("registration_form"));
        
        $.ajax({
          data: formData,
          url: "{{ route('create_registration') }}",
          type: "POST",
          dataType: 'json',
          contentType: false,
           processData: false,
          success: function (response) {

             if(response.code == 422){
                printErrorRegMsg(response.error);
             }

             if(response.code == 200){
                $(".print-reg-error-msg").css('display','none');
                $(".print-reg-success-msg").css('display','block');
                $(".print-reg-success-msg").html(response.msg);
                $('#registration_form')[0].reset();
             }
         
          },
          error: function (response) {
            printErrorRegMsg(response.error);
          }
      });
       
    });


    function printErrorRegMsg (msg) {
        $(".print-reg-success-msg").css('display','none');
        $(".print-reg-error-msg").find("ul").html('');
        $(".print-reg-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-reg-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
</script>
@endsection