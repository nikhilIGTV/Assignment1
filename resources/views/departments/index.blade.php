<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <x-button class="ml-4">
                    {{ __('Add Department') }}
                </x-button>
                </div>
            </div>
        </div>
    </div> -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  
                <x-button class="ml-4 mb-4 float-right" data-toggle="modal" data-target="#departmentModal">
                    {{ __('Add Department') }}
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
      <th scope="col">Created At</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($departments as $index=>$department)
    <tr>
      <th scope="row">{{$index+1}}</th>
      <td>{{$department->name}}</td>
      <td>{{$department->created_at}}</td>
      <td><x-button class="btn-primary">Edit</x-button><x-button class="btn-danger">Delete</x-button></td>
    </tr>
  @endforeach
  </tbody>
</table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="departmentModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
            @csrf
            <label for="email1">Department Name :</label>
            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Department">
            <small id="emailHelp" class="form-text text-muted">Example HR,Sales.</small>
          </div>
      </div>
      <div class="modal-footer">
         <x-button type="button"  class="btn-danger" data-dismiss="modal">Close</x-button>
         <x-button id="btnSubmit" class="btn-success" type="button">Save changes</x-button>
      </div>
    </div>
  </div>
</div>
@section('scripts')
<script>
  $(document).ready(function()
  {
    $("#btnSubmit").click(function(){
      var departmentName=$("#name").val();
      if(departmentName)
      {
        $.ajax({
              type: "post",
              url: "{{route('departments.store')}}",
              data: {name:departmentName,_token: "{{ csrf_token() }}"},
              dataType: 'json',
              success: function (data) {
                console.log(data);
                $("#departmentModal").modal('toggle');
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
</script>
@endsection
</x-app-layout>
