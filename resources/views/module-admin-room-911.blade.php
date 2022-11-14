@extends('welcome')
 
@section('title', 'Module Room 911')

@section('content')
    <h1 class="text-center">Administrative Menu</h1>

		<hr>
		<div class="row">
			<div class="col-md-2">
				<input class="form-control" type="text" name="sid" id="sid" placeholder="Search by ID">
			</div>
			<div class="col-md-2">
				<input class="form-control" type="text" name="sname" id="sname" placeholder="Search by name">
			</div>
			<div class="col-md-2">
				<input class="form-control" type="text" name="slastname" id="slastname" placeholder="Search by lastname">
			</div>
			<div class="col-md-3">
				<select class="form-select" id="sdepartment" name="sdepartment">
					<option selected  value="">Select department</option>
					@foreach ($departments as $department)
						<option value="{{ $department->id }}">{{ $department->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="d-flex justify-content-end">
			<button class="mx-1 btn btn-secondary" onClick="filter();" id="btnFilter"><ion-icon name="filter-outline"></ion-icon> Filter</button>
			<button class="btn btn-secondary" onClick="onClear();" id="btnClear"><ion-icon name="close-outline"></ion-icon> Clear filter</button>
		</div>
		<hr>
		<div class="my-2">
			<a class="btn btn-primary" href="{{ route('employees.create') }}">New employee</a>
			<a class="btn btn-info" href="{{ route('employees.create.massive') }}">Create massive employees</a>
			<a target="_blank" href="{{route('employees.pdf.all')}}" class="btn btn-warning">
				<ion-icon name="document-text-outline"></ion-icon> All History
			</a>
		</div>
		<table class="table">
        <thead>
            <tr>
							<th scope="col">Employee ID</th>
							<th scope="col">Name</th>
							<th scope="col">Lastname</th>
							<th scope="col">Department</th>
							<th scope="col">Total access</th>
							<th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
						@foreach ($employees as $employee)
							<tr>
								<th scope="row">{{$employee->id}}</th>
								<td>{{$employee->name}}</td>
								<td>{{$employee->lastname}}</td>
								<td>{{$employee->department->name}}</td>
								<td>{{ count($employee->logs->where('status_id',4)->all()) }}</td>
								<td>
									<a href="{{route('employees.edit',$employee->id)}}" class="btn btn-info">
										<ion-icon name="reload-outline"></ion-icon> Update
									</a>
									<a href="{{route('employees.change',$employee->id)}}" class="btn btn-secondary"  onClick="return confirm('Are you sure?');">
										@if($employee->employees_modules->where('module_id',1)->first()->status_id == 1)
											<ion-icon name="person-remove-outline"></ion-icon> Disable
										@else
											<ion-icon name="person-add-outline"></ion-icon> Enable
										@endif
									</a>
									<a target="_blank" href="{{route('employees.pdf',$employee->id)}}" class="btn btn-warning">
										<ion-icon name="document-text-outline"></ion-icon> History
									</a>
									<form class="d-inline-block" action="{{route('employees.delete',$employee->id)}}" method="POST">
										@csrf
										@method('DELETE')
										<button class="btn btn-danger" type="submit" onClick="return confirm('Are you sure about DELETING this user');"><ion-icon name="trash-outline"></ion-icon> Delete</button>
									</form>
								</td>
							</tr>
						@endforeach
        </tbody>
    </table>
		<div class="row">{!! $employees->links() !!}</div>
@endsection
<script>
	function filter(){
		sid = document.querySelector("#sid").value;
		sname = document.querySelector("#sname").value;
		slastname = document.querySelector("#slastname").value;
		sdepartment = document.querySelector("#sdepartment").value;
		window.CSRF_TOKEN = '{{ csrf_token() }}';
		data = {
			"id": sid,
			"name": sname,
			"lastname": slastname,
			"department": sdepartment
		}
		
		fetch("{{route('employees.filter')}}", {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': window.CSRF_TOKEN
			},
			body: JSON.stringify(data),
		})
			.then((response) => response.json())
			.then((data) => {
				tbody = document.querySelector("table tbody");
				tbody.innerHTML = '';
				newContent = '';
				data.forEach(employee =>{
					newContent += `
					<tr>
								<th scope="row">${employee.id}</th>
								<td>${employee.name}</td>
								<td>${employee.lastname}</td>
								<td>${employee.dment}</td>
								<td>${employee.tlogs}</td>
								<td>
									<a href="/employees/${employee.id}/edit" class="btn btn-info">
										<ion-icon name="reload-outline"></ion-icon> Update
									</a>
									<a href="/employees/change/${employee.id}" class="btn btn-secondary"  onClick="return confirm('Are you sure?');">
										@if($employee->employees_modules->where('module_id',1)->first()->status_id == 1)
											<ion-icon name="person-remove-outline"></ion-icon> Disable
										@else
											<ion-icon name="person-add-outline"></ion-icon> Enable
										@endif
									</a>
									<a target="_blank" href="/employees/pdf/${employee.id}" class="btn btn-warning">
										<ion-icon name="document-text-outline"></ion-icon> History
									</a>
									<form class="d-inline-block" action="{{/employees/${employee.id}" method="POST">
										@csrf
										@method('DELETE')
										<button class="btn btn-danger" type="submit" onClick="return confirm('Are you sure about DELETING this user');"><ion-icon name="trash-outline"></ion-icon> Delete</button>
									</form>
								</td>
							</tr>
					`;
				});
				tbody.innerHTML = newContent;
			})
			.catch((error) => {
				console.error('Error:', error);
			});
	}

	function onClear(){
		document.querySelector("#sid").value = '';
		document.querySelector("#sname").value = '';
		document.querySelector("#slastname").value = '';
		document.querySelector("#sdepartment").value = '';
		document.querySelector("#btnFilter").click();
	}
</script>