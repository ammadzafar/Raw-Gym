@extends('layouts.master')

@section('title', 'Expense')

@section('css')
    <link href="{{ URL::asset('/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') Expense Category @endslot
        @slot('li_1') Listing @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            @include('backend.expense-category.modals.create-expense-category')
        </div>
    </div>

    <div class="row expenses_list">
            <div class="col-md-12">
                <table class="table mt-5" style="background-color: #ffffff">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $key => $category)
                    <tr>
                        <th scope="row">{{$key +1}}</th>
                        <td>{{$category->name}}</td>
                        <td>
                            <span class="action-edit btn btn-link btn-sm text-dark expense-cat-edit" data-id="{{$category->id}}" data-toggle="modal"
                                  data-target="#edit-expense-modal" id="edit-expense-category"><i class="far fa-edit"></i> Edit</span>
                            <span class="action-expense-delete btn btn-link btn-sm text-danger" id="exp_delete" data-id="{{$category->id}}"><i class="far fa-trash-alt"></i> Delete</span>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
                {!! $categories->links() !!}
            </div>


{{--            <div class="col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="pb-1 text-secondary mt-2">--}}
{{--                            <div class="row align-items-center">--}}
{{--                                <div class="col-12 text-center">--}}
{{--                                    <h2>No record found!</h2>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}


    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#create-expense-category').parsley();
            $('#create-expense-category').on('submit', function (e) {
                e.preventDefault();
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                if ($('#create-expense-category').parsley().isValid()) {
                    $.ajax({

                        url: "{{route('expense.category.store')}}",
                        type: 'post',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (response) {
                            loading(self, false);
                            toastr.success(response.message);
                            $('#create-expense-modal').modal('hide');
                            self[0].reset();
                            refreshDiv('.expenses_list')
                            // $('.datatable').DataTable().ajax.reload(null, false);
                        },
                        error: function (error) {
                            toastrErrors(error);
                            loading(self, false);
                        }
                    });
                }

            });
        })

        $(document).on('click','.expense-cat-edit',function () {
            var id = $(this).data('id');
            $.ajax({
                url: '{{route('expense.category.edit')}}',
                data: {
                    id: id,
                },
                success: function (result) {
                    $('#exp-cat').val(result['name']);
                    $('#category_id').val(result['id']);
                }
            });
        });

        $('#edit-expense-category').parsley();
        $('#edit-expense-category').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#edit-expense-category').parsley().isValid()) {
                $.ajax({

                    url: "{{route('expense.category.update')}}",
                    type: 'post',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        loading(self, false);
                        toastr.success(response.message);
                        $('#edit-expense-modal').modal('hide');
                        self[0].reset();
                        refreshDiv('.expenses_list')
                        // $('.datatable').DataTable().ajax.reload(null, false);
                    },
                    error: function (error) {
                        toastrErrors(error);
                        loading(self, false);
                    }
                });
            }
        });
        $(document).on('click','#exp_delete',function (e) {
            e.preventDefault();
            var self = $(this);
            var id = $(this).data('id');
            $.ajax({
                method: 'DELETE',
                url: '{{route('expense.category.delete')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                success: function (result) {
                    refreshDiv('.expenses_list')
                    toastr.success(result.success);
                }
            });
        });
    </script>
@endsection
