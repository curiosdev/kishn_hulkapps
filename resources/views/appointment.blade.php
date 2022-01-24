@extends('layout.dashboard-header')

@section('title','New Appointment')

@section('main')

<div class="container">

    @if(Auth::user()->role != 'Doctor')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#appointmentModal" style="margin:20px;">
        Book Appointment
    </button>
    @endif

    <table class="table data-table">
    <thead>
            <tr>
                <th>No</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Status</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <div class="alert alert-success print-success-msg" style="display:none">
                
            </div>

            <div class="alert alert-danger print-danger-msg" style="display:none">
                
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
                        <input type="hidden" name="id" id="id">
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
                        <input type="date" name="app_date" class="form-control app_date" id="app_date" aria-describedby="emailHelp" placeholder="Enter Last Name">
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
</div>


<script>

    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_appointment_data') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'patient_name', name: 'patient_name'},
                {data: 'dr_name', name: 'dr_name'},
                {data: 'date', name: 'date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
    

    $('#appointment_form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(document.getElementById("appointment_form"));

        $('#appointment_form')[0].reset();
        $(".print-error-msg").css('display','none');
        $(".print-success-msg").css('display','none');
        $(".print-danger-msg").css('display','none');
      
        $.ajax({
        //   data: $('#registration_form').serialize(),
          data: formData,
          url: "{{ route('create_appointment') }}",
          type: "POST",
          dataType: 'json',
          contentType: false,
           processData: false,
          success: function (response) {

             if(response.code == 422){
                printErrorMsg(response.error);
             }

             if(response.code == 200){
                $(".print-error-msg").css('display','none');
                $(".print-danger-msg").css('display','none');
                $(".print-success-msg").css('display','block');
                $(".print-success-msg").html(response.msg);
                $('.data-table').DataTable().ajax.reload();
                $('#appointmentModal').modal('hide');
                $('.data-table').DataTable().ajax.reload();
             }

             if(response.code == 202){
                $(".print-danger-msg").css('display','block');
                $(".print-danger-msg").html(response.msg);
             }
         
          },
          error: function (response) {
            printErrorMsg(response.error);
          }
      });
       
    });

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }



    function delete_rec(id){
        if (confirm("Are you sure want to Delete This Rcord?")) {

        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                //   data: $('#registration_form').serialize(),
                data: '',
                url: "delete_record/"+id,
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.success(response.msg);
                    $('.data-table').DataTable().ajax.reload();
                },
                error: function (response) {
                
                }
            });
        }
        return false;
    }

    function get_update_data(id){

        $(".print-error-msg").css('display','none');
        $(".print-success-msg").css('display','none');

        $.ajax({
            //   data: $('#registration_form').serialize(),
            data: '',
            url: "get_record/"+id,
            type: "GET",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {

                $('#app_dr_name').val(response.data.doctor_id);
                $('#app_date').val(response.data.date);
                $('#app_time').val(response.data.time);
                $('#id').val(response.data.id);
               
                $('#appointmentModal').modal('show');
            },
            error: function (response) {
            
            }
        });
        // $('#usereditmodal').modal('show');
    }

    function change_status(id,type){
        if (confirm("Are you sure want to Change Status?")) {

                    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                //   data: $('#registration_form').serialize(),
                data: '',
                url: "change_status/"+id+"/"+type,
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.success(response.msg);
                    $('.data-table').DataTable().ajax.reload();
                },
                error: function (response) {
                
                }
            });
        }
        return false;
    }

</script>
@endsection