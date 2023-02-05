@can('expense_create')
    <div class="d-flex justify-content-between mb-2">
        <span>All expenses are shown in <b>{{ env('CURRENCY', 'Ksh') }}</b></span>
        <button class="btn btn-dark bg-dark-red btn-sm" data-toggle="modal"
                data-target="#create-expense-modal" id="create-new-expense">Create
            New expense
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
                <form id="create-expense">

                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Category<span style="color: red"> *</span></label>
                                <select name="expense_category" type="text" class="form-control" data-parsley-required-message="You must select at least one option." data-parsley-required="true">
                                    <option value=""> Select Category </option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date<span style="color: red"> *</span></label>
                                <input name="date" type="date" class="form-control" placeholder="Name"
                                       data-parsley-minlength="4" data-parsley-required="true"/>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row expenseRow">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Amount ({{ env('CURRENCY', 'Ksh') }})<span style="color: red"> *</span></label>
                                                        <input name="expenses[0][amount]" type="number" class="form-control"
                                                               placeholder="amount" data-parsley-type="digits"
                                                               data-parsley-required="true" data-parsley-required-message="Amount should be in digit"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Label<span style="color: red"> *</span></label>
                                                        <input name="expenses[0][label]" type="text" class="form-control"
                                                               placeholder="Label"data-parsley-required="true"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Status<span style="color: red"> *</span></label>
                                                        <select name="expenses[0][status]" id="select_expense_status" class="form-control select2-multiple"
                                                                data-placeholder="Choose ..." data-parsley-required="true"
                                                                data-parsley-required-message="Please select status">
                                                            @if ($statuses)
                                                                @foreach ($statuses as $status)
                                                                    <option class="text-capitalize" value="{{ $status }}">
                                                                        {{ $status }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mt-3">
                                                <input type="button" value="Add"
                                                       class="addNewExpenseBtn col-md-12 btn btn-dark bg-dark-red waves-effect waves-light mt-2 add-spinner">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
