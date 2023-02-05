@can('expense_create')
    <div class="d-flex justify-content-between mb-2">
        <span>All expenses are shown in <b>{{ env('CURRENCY', 'Ksh') }}</b></span>
        <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                data-target="#create-expense-modal" id="create-new-expense">Create
            New Expense Category
        </button>
    </div>
@endcan

{{-------------- Create Expense Modal ----------------}}
<div class="modal fade bs-example-modal-lg" id="create-expense-modal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">New expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="create-expense-category">

                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Category Name<span style="color: red"> *</span></label>
                                <input name="name" type="text" class="form-control" placeholder="Category Name"
                                       data-parsley-minlength="4" data-parsley-required="true"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="submit"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        data-size="xs">
                                    Create
                                </button>
                                <button type="reset" class="btn btn-outline-dark waves-effect">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-------------- edit Expense Modal ----------------}}
<div class="modal fade bs-example-modal-lg" id="edit-expense-modal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Expense Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-expense-category">

                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Category Name<span style="color: red"> *</span></label>
                                <input id="exp-cat" name="name" type="text" class="form-control" placeholder="Category Name" value=""
                                       data-parsley-minlength="4" data-parsley-required="true"/>
                            </div>
                            <input id="category_id" name="category_id" type="hidden" class="form-control" value=""
                                   data-parsley-minlength="4" data-parsley-required="true"/>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0 text-right">
                                <button type="submit"
                                        class="btn btn-dark bg-dark-red waves-effect waves-light mr-1 add-spinner"
                                        data-size="xs">
                                    Update
                                </button>
                                <button type="reset" class="btn btn-outline-dark waves-effect">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
