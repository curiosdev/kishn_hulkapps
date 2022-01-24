@extends('layout.dashboard-header')

@section('title','New Appointment')

@section('main')

<div class="container">

    <h2>User Data</h2>
    <table class="table data-table">
    <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    
</div>


<script>
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_all_user_data') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });

    function delete_user_rec(id){
        if (confirm("Are you sure want to Delete This Record?")) {

        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                //   data: $('#registration_form').serialize(),
                data: '',
                url: "delete_user_record/"+id,
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