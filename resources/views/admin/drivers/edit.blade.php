@extends('admin.layouts.app')

@section('main-content')
  <style>
      #all-users,#driver-menu{
          color:white;
      }
  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update Driver</h3>
            </div>

            <form role="form" action="{{ route('driver.update',$driver->id) }}" method="post">
            {{ csrf_field() }}
              <div class="box-body">
                <div class="col-sm-offset-1 col-sm-9 col-md-offset-3 col-md-6">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="@if (old('name')){{ old('name') }}@else{{ $driver->name }}@endif">
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="email" value="@if (old('email')){{ old('email') }}@else{{ $driver->email }}@endif">
                  </div>

                  <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" value="@if (old('phone_number')){{ old('phone_number') }}@else{{ $driver->phone_number }}@endif">
                  </div>

                  <div class="form-group">
                    <label for="profile_url">Profile Url</label>
                    <input type="text" class="form-control" id="profile_url" name="profile_url" placeholder="Profile Url" value="@if (old('profile_url')){{ old('profile_url') }}@else{{ $driver->profile_url }}@endif">
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{url('admin/home')}}" class="btn btn-warning">Back</a>
                  </div>








              </div>




          
        </div>

            </form>
          </div>
          <!-- /.box -->

          
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@endsection