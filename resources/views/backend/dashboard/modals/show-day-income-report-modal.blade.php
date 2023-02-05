<div class="modal fade bs-example-modal-lg" id="showDayIncomeReportModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog custom-fullscreen-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0"><span id="date"></span> | Income/Expense Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-dark-shadow">
                            <div class="card-body">
                                <h3>Profit: <span id="totalProfit"></span> {{ env("CURRENCY", "Ksh") }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-dark-shadow">
                            <div class="card-body">
                                <h5>Income</h5>
                                <table class="table datatable table-borderless dt-responsive nowrap w-100"
                                       style="border-collapse: collapse; border-spacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>Collected By</th>
                                        <th>Member</th>
                                        <th>Reg Fees ({{ env("CURRENCY", "Ksh") }})</th>
                                        <th>Fees ({{ env("CURRENCY", "Ksh") }})</th>
                                        <th>PTF ({{ env("CURRENCY", "Ksh") }})</th>
                                        <th>IHTF ({{ env("CURRENCY", "Ksh") }})</th>
                                        <th>Extra Charges ({{ env("CURRENCY", "Ksh") }})</th>
                                        <th>Classes Fees ({{ env("CURRENCY", "Ksh") }})</th>
                                    </tr>
                                    </thead>
                                    <tbody id="incomeTable">
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right"><b>Total: </b><span
                                                id="totalIncome"></span> {{ env("CURRENCY", "Ksh") }}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-dark-shadow">
                            <div class="card-body">
                                <h5>Expense</h5>
                                <table class="table datatable table-borderless dt-responsive nowrap w-100"
                                       style="border-collapse: collapse; border-spacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>Label</th>
                                        <th>Amount ({{ env("CURRENCY", "Ksh") }})</th>
                                    </tr>
                                    </thead>
                                    <tbody id="expenseTable">
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right"><b>Total: </b><span
                                                id="totalExpense"></span> {{ env("CURRENCY", "Ksh") }}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
