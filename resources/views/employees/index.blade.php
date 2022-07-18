<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>


   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                <form class="form-inline" method="get" action="{{url('employees')}}">
                  <div class="form-group mb-2">
                <x-input  type="text" class="col-md-12" placeholder="Enter Email "  name="email_filter" value="{{ request()->email_filter }}" id="email_filter"></x-input >
                </div>
                <div class="form-group mx-sm-3 mb-2">
                <select style="width:300px;height:43px; !important;"name="department_filter" id="department_filter"  class=" form-control" >
              @foreach($departments as $department)
              <option value="{{$department->id}}">{{$department->name}}</option>
              @endforeach
            </select>
            </div>
                   <x-button class="ml-5 mb-4 btn-success">
                    {{ __('Search') }}
                  </x-button>
                
</form>
<x-button class="ml-4 mb-4 float-right" data-toggle="modal" data-target="#employeeModal">
                    {{ __('Add Employee') }}
                </x-button>
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Code</th>
      <th scope="col">Email</th>
      <th scope="col">Departments</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      @foreach($employees as $key => $employee)
      <th scope="row">{{$key+1}}</th>
      <td>{{$employee->name}}</td>
      <td>{{$employee->code}}</td>
      <td>{{$employee->email}}</td>
      <td>
        @foreach($employee->departments as $department)
       <span class="badge badge-primary"> {{$department->name}}</span>
        @endforeach
      </td>
      <td><x-button class="btn-primary" onclick="editEmp({{$employee->id}})">Edit</x-button><x-button class="btn-danger">Delete</x-button></td>
    </tr>
    @endforeach
  </tbody>
</table>
<div class="modal" id="employeeModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
            @csrf
            <label for="email1"> Name :</label>
            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Employee Name">
        </div>
      
      <div class="form-group">
            
            <label for="email1"> Email :</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter Employee Email">
          
      </div>
      <div class="form-group">
            
            <label for="email1"> Code :</label>
            <input type="text" class="form-control" id="code" aria-describedby="emailHelp" placeholder="Enter Employee Code">
          </div>
      <div class="form-group">
          <label for="email1"> Departments :</label><br>
          <select id="multiple"style="width:460px !important;" class="js-select2-multi" multiple>
              @foreach($departments as $department)
              <option value="{{$department->id}}">{{$department->name}}</option>
              @endforeach
            </select>
      </div>
    </div>
      <div class="modal-footer">
         <x-button type="button"  class="btn-danger" data-dismiss="modal">Close</x-button>
         <x-button id="btnSubmit" class="btn-success" type="button">Save changes</x-button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="employeeModal1" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="emp_id">
            <label for="email1"> Name :</label>
            <input type="text" class="form-control" id="name1" aria-describedby="emailHelp" placeholder="Enter Employee Name">
        </div>
      
      <div class="form-group">
            
            <label for="email1"> Email :</label>
            <input type="email" class="form-control" id="email1" aria-describedby="emailHelp" placeholder="Enter Employee Email">
          
      </div>
      <div class="form-group">
            
            <label for="email1"> Code :</label>
            <input type="text" class="form-control" id="code1" aria-describedby="emailHelp" placeholder="Enter Employee Code">
          </div>
      <div class="form-group">
          <label for="email1"> Departments :</label><br>
          <select id="multiple1"style="width:460px !important;" class="js-select2-multi" multiple>
              @foreach($departments as $department)
              <option value="{{$department->id}}">{{$department->name}}</option>
              @endforeach
            </select>
      </div>
    </div>
      <div class="modal-footer">
         <x-button type="button"  class="btn-danger" data-dismiss="modal">Close</x-button>
         <x-button id="btnUpdate" class="btn-success" type="button">Save changes</x-button>
      </div>
    </div>
  </div>
</div>
@section('scripts')
<script>
  $(document).ready(function()
  {
    $("#btnSubmit").click(function(){
      var employeeName=$("#name").val();
      var employeeCode=$("#code").val();
      var employeeEmail=$("#email").val();
      var employeeDepartments=$("#multiple").val();
      
      //console.log(employeeName,employeeCode,employeeEmail,employeeDepartments);
      if(employeeName)
      {
        $.ajax({
              type: "post",
              url: "{{route('employees.store')}}",
              data: {name:employeeName,_token: "{{ csrf_token() }}",code:employeeCode,email:employeeEmail,department_ids:employeeDepartments},
              dataType: 'json',
              success: function (data) {
                console.log(data);
                // $("#employeeModal").modal('toggle');
                location.reload();
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      }
      else
      {
        alert("Department Name is Required ");
      }
    });

    $("#btnUpdate").click(function(){
      var employeeName=$("#name1").val();
      var employeeCode=$("#code1").val();
      var employeeEmail=$("#email1").val();
      var employeeDepartments=$("#multiple1").val();
      var empid=$("#emp_id").val();
      var method=document.getElementsByName("_method")[0].value;
      //console.log(employeeName,employeeCode,employeeEmail,employeeDepartments);
      if(employeeName)
      {
        $.ajax({
              type: "post",
              url: "{{url('/employees')}}"+"/"+empid,
              data: {name:employeeName,_token: "{{ csrf_token() }}",_method:method,code:employeeCode,email:employeeEmail,department_ids:employeeDepartments},
    
              success: function (data) {
                console.log(data);
                // $("#employeeModal").modal('toggle');
                location.reload();
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      }
      else
      {
        alert("Department Name is Required ");
      }
    });
  })
  function editEmp(empid)
    {
      $.ajax({
              type: "get",
              url: "{{url('/employees')}}"+"/"+empid+"/edit",
              data: {id:empid},
              dataType: 'json',
              success: function (data) {
                console.log(data);
                $("#emp_id").val(data[0]['id']);
                $("#name1").val(data[0]['name']);
                $("#code1").val(data[0]['code']);
                $("#email1").val(data[0]['email']);
                $("#multiple1").val(data[1]);
              //  $("select").find("option[value="+optionVal+"]").prop("selected", "selected");

                
                 $("#employeeModal1").modal('show');

               // location.reload();
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
    }
   
</script>
@endsection
</x-app-layout>