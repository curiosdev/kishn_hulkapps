<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .container {
            position: relative;
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px 0 30px 0;
            margin-top:50px;
        }

        input,
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            margin: 5px 0;
            opacity: 0.85;
            display: inline-block;
            font-size: 17px;
            line-height: 20px;
            text-decoration: none;
        }

        input:hover,
        .btn:hover {
            opacity: 1;
        }

        .fb {
            background-color: #3B5998;
            color: white;
        }

        .twitter {
            background-color: #55ACEE;
            color: white;
        }

        .google {
            background-color: #dd4b39;
            color: white;
        }

        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        input[type=button] {
            background-color: #04AA6D;
            color: white;
            cursor: pointer;
        }

        input[type=button]:hover {
            background-color: #45a049;
        }

        .col {
            float: left;
            width: 50%;
            margin: auto;
            padding: 0 50px;
            margin-top: 6px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .vl {
            position: absolute;
            left: 50%;
            transform: translate(-50%);
            border: 2px solid #ddd;
            height: 175px;
        }

        .vl-innertext {
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 50%;
            padding: 8px 10px;
        }

        .hide-md-lg {
            display: none;
        }

        .bottom-container {
            text-align: center;
            background-color: #666;
            border-radius: 0px 0px 4px 4px;
        }


        @media screen and (max-width: 650px) {
            .col {
                width: 100%;
                margin-top: 0;
            }

            /* hide the vertical line */
            .vl {
                display: none;
            }

            /* show the hidden text on small screens */
            .hide-md-lg {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="{{ route('welcome') }}">Welcome</a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                <li class="nav-item ">
                    <a class="nav-link" href="" data-toggle="modal" data-target="#signInModal">Sign In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('signup') }}">Registration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="" data-toggle="modal" data-target="#appointmentModal">Appointment</a>
                </li>
            </ul>
        </div>
    </nav>


    <!-- Modal -->
    <div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            <div class="alert alert-danger print-login-error-msg" style="display:none">
                <ul></ul>
            </div>

            <div class="alert alert-danger print-login-invalid-msg" style="display:none">
                
            </div>

            <form name="login_form" id="login_form">
            @csrf                
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            <div class="alert alert-danger print-appointment-error-msg" style="display:none">
                <ul></ul>
            </div>

            <div class="alert alert-danger print-appointment-invalid-msg" style="display:none">
                
            </div>

            <form name="appointment_form" id="appointment_form">
            @csrf                
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Book Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name" class="form-control name" id="name" aria-describedby="emailHelp" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control email" id="email" aria-describedby="emailHelp" placeholder="Enter Email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Doctor Name</label>
                        <select class="form-control" aria-label="Default select example" name="app_dr_name" id="app_dr_name">
                           
                            @foreach($doctor_list as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Date</label>
                        <input type="date" name="app_date" class="form-control app_date" id="app_date" aria-describedby="emailHelp" placeholder="Enter Date">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Time</label>
                        <select class="form-control" aria-label="Default select example" name="app_time" id="app_time">
                           
                            <option value="1">1 Hrs</option>
                            <option value="2">2 Hrs</option>
                            <option value="3">3 Hrs</option>
                            <option value="4">4 Hrs</option>
                            <option value="5">5 Hrs</option>
                        </select>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit">Book</button>
                </div>
            </form>
            </div>
        </div>
    </div>


    

    @yield('main')

    
    <script>
     
     $('#login_form').submit(function(e) {
         e.preventDefault();
         var formData = new FormData(document.getElementById("login_form"));
         

         $.ajax({
             data: formData,
             url: "{{ route('login') }}",
             type: "POST",
             dataType: 'json',
             contentType: false,
             processData: false,
             success: function (response) {

                 if(response.code == 422){
                     printErrorMsg(response.error);
                 }

                 if(response.code == 404){
                     $(".print-login-error-msg").css('display','none');
                     $(".print-login-invalid-msg").css('display','block');
                     $(".print-login-invalid-msg").html(response.msg);
                     // $('#login_form')[0].reset();
                 }

                 if(response.code == 200){
                     window.location.href = '/dashboard';
                 }
             
             },
             error: function (response) {
                 printErrorMsg(response.error);
             }
         });
        
     });

     function printErrorMsg (msg) {
         $(".print-login-error-msg").find("ul").html('');
         $(".print-login-error-msg").css('display','block');
         $(".print-login-invalid-msg").css('display','none');
         $.each( msg, function( key, value ) {
             $(".print-login-error-msg").find("ul").append('<li>'+value+'</li>');
         });
     }


     $('#appointment_form').submit(function(e) {
         e.preventDefault();
         var formData = new FormData(document.getElementById("appointment_form"));
         

         $.ajax({
             data: formData,
             url: "{{ route('without_login_appointment') }}",
             type: "POST",
             dataType: 'json',
             contentType: false,
             processData: false,
             success: function (response) {

                 if(response.code == 422){
                     printappointmentErrorMsg(response.error);
                 }

                 if(response.code == 202){
                     $(".print-appointment-error-msg").css('display','none');
                     $(".print-appointment-invalid-msg").css('display','block');
                     $(".print-appointment-invalid-msg").html(response.msg);
                     // $('#login_form')[0].reset();
                 }

                 if(response.code == 200){
                    $(".print-appointment-error-msg").css('display','none');
                     $(".print-appointment-invalid-msg").css('display','none');
                   
                    $('#appointment_form')[0].reset();
                    $('#appointmentModal').modal('hide');
                    toastr.success(response.msg);
                 }
             
             },
             error: function (response) {
                 printappointmentErrorMsg(response.error);
             }
         });
        
     });


     function printappointmentErrorMsg (msg) {
         $(".print-appointment-error-msg").find("ul").html('');
         $(".print-appointment-error-msg").css('display','block');
         $(".print-appointment-invalid-msg").css('display','none');
         $.each( msg, function( key, value ) {
             $(".print-appointment-error-msg").find("ul").append('<li>'+value+'</li>');
         });
     }
 </script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>