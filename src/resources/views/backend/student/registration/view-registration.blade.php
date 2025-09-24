@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Student list</h3>
              <a
                href="{{route('student.registration.add')}}"
                class="btn btn-success pull-right">
                Add student
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('student.registration.view')"
                      :docs="$docs->students" />
                    <form class="flex items-center gap-4" method="GET" action="{{ route('student.registration.view') }}" id="searchForm">

                      <div class="flex items-center py-2">
                        <span class="mr-2">Class</span>
                        <div class="controls">
                          <select name="year_id" required class="form-control">
                            <option value="" disabled selected>Select year</option>
                            @foreach($docs->years as $year)
                            <option value="{{ $year->id }}" @selected(request('year_id')==$year->id)>
                              {{ $year->name }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="flex items-center py-2">
                        <span class="mr-2">Class</span>
                        <div class="controls">
                          <select name="class_id"  class="form-select appearence-none">
                            <option value="" disabled selected>Select class</option>
                            @foreach($docs->classes as $class)
                            <option value="{{ $class->id }}" @selected(request('class_id')==$class->id)>
                              {{ $class->name }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <input type="submit"  class="btn btn-primary" value="Filter">

                    </form>

                    <x-ui.search :action="route('student.registration.view')" :search="$docs->search"/>
                  </div>

                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs->students"
                    :columns="[
                      'user.name' => 'Name',
                      'year.name' => 'Year',
                      'class.name' => 'Class',
                      'profile.image' => 'Image',
                      'profile.id_no' => 'Student no',
                    ]"
                    :images="['profile.image']"
                    :actions="[
                      'Edit' => fn($doc) => [
                        'href' => route('student.registration.edit',$doc),
                        'class' => 'btn-info',  
                      ],
                      'Promotion' => fn($doc) => [
                        'href' => route('student.promotion.edit',$doc),
                        'class' => 'btn-primary',
                         
                      ],
                      'Details' => fn($doc) => [
                        'href' => route('student.registration.details',$doc),
                        'class' => 'btn-primary',
                        'attrs' => ['target' => '_blank'], 
                      ],
                    ] " />

                  <div class="row items-center justify-between">
                    <x-ui.pagination-info :docs="$docs->students" class="text-muted" />
                    <x-ui.paginator :docs="$docs->students" />
                  </div>

                </div>
              </div><!-- table-responsive -->
            </div> <!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
      
    </section>
  </div><!-- container-full -->
</div>
@endsection