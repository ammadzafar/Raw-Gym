@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{URL::asset('/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{URL::asset('/js/printThis.js')}}"></script>

    <script src="{{URL::asset('/js/html2canvas.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).on('click','#download_pdf',function () {
            $('#pdf-download').printThis();
        })
    </script>

    <script>
        $('.select2-multiple').select2();
        $('.select2-container').addClass('d-block');

        $('.member-profile-image').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            }
        });

        var discount = 0;
        var weekly = false;
        var loadingBtn = null;
        var memberId = null;
        var registrationFees = 0;
        var memberFees = 0;
        var pendingFee = 0;
        var personalTrainingFees = 0;
        var personalTrainingPendingFees = 0;
        var pending1 = 0;
        var pending2 = 0;
       var classesFees = 0;

        $(document).ready(function (e) {
            var search_route = "{{ route('dashboard.autocomplete-search') }}";
            $('#search_query').typeahead({
                source: function (query, process) {
                    return $.get(search_route, {
                        query: query
                    }, function (data) {
                        return process(data);
                    });
                }
            });



            $('.fee_structure_div').show();
            $('.reg_fee_div').show();
            $('.select_membership_div').hide();
            $('.fee_structure').val('');
            $('#personal_training_fees_div').hide();
            $('#edit_personal_training_fees_div').hide();
            $('#in_house_training_fees_div').hide();
            $('#edit_in_house_training_fees_div').hide();
            $('#member_fees_div').hide();
            /*$('.select_classes_div').hide()
            $('.select_classes_fees_div').hide();
            $('.select_classes_fees_div').hide();
            $('.edit_select_classes_div').hide();*/
            $('#is_member_guest').hide();
            $('#guest_member_checkbox').prop('checked', true);



        });

        $('.select_member_type').on('change', function (e) {
            let value = $(this).val();

            if (value === 'guest-member-value') {
                $('.fee_structure_div').show();
                $('.reg_fee_div').show();
                $('.select_membership_div').hide();
                $('#guest_member_checkbox').prop('checked', true);
                $('.select_membership option').prop('selected', false);
                $('.select_membership').trigger('change');
            } else {
                $('#guest_member_checkbox').prop('checked', false);
                $('#guest_member_checkbox').trigger('change');
                $('.fee_structure_div').hide();
                $('.reg_fee_div').hide();
                $('.select_membership_div').show();
                $('#fee_structure').val('');
                $('#reg_fee').val('');
            }
        });

        $('.edit_select_member_type').on('change', function (e) {
            let value = $(this).val();

            if (value === 'guest-member-value') {
                $('.edit_fee_structure_div').show();
                $('.edit_reg_fee_div').show();
                $('.edit_select_membership_div').hide();
                $('#edit_member_membership option').prop('selected', false);
                $('#edit_member_membership').trigger('change');
            } else {
                $('.edit_fee_structure_div').hide();
                $('.edit_reg_fee_div').hide();
                $('.edit_select_membership_div').show();
            }
        });

        $('.in_house_training_checkbox').click(function (e) {
            if (this.checked) {
                $('#in_house_training_fees_div').show();
                $('#edit_in_house_training_fees_div').show();
            } else {
                $('#in_house_training_fees_div').hide();
                $('#edit_in_house_training_fees_div').hide();
                $('#in_house_training_fees').val('');
            }
        });

        $('.personal_training_checkbox').click(function (e) {
            if (this.checked) {
                $('#personal_training_fees_div').show();
                $('#edit_personal_training_fees_div').show();
            } else {
                $('#personal_training_fees_div').hide();
                $('#edit_personal_training_fees_div').hide();
                $('#personal_training_fees').val('');
                // $('#edit_personal_training_fees').val('');
            }
        });







        $('.classes_checkbox').click(function (e) {

            if (this.checked) {
                $('.select_classes_div').show();
                $('.select_classes_fees_div').show()

            } else {
                $('.select_classes_div').hide();
                $('.select_classes_fees_div').hide()
                // $('#edit_personal_training_fees').val('');
            }
        });

        $('#pendingFees').html(0);

        $('#member_total_payment').on('keyup', function (e) {

            if (pendingFee == null) {
                pendingFee = parseInt($('#member_pending_fees').val()
                );
            }
            let thisValue = parseInt($(this).val());
            let total = null;
            let result = null;

            total = pendingFee + memberFees + registrationFees /*+ classesFees??0*/;
            if (thisValue) {
                if (thisValue < total) {
                    result = total - thisValue;
                    pending1 = result;

                } else {
                    result = 0;
                    pending1 = result;
                }
            } else {
                result = total;
                pending1 = result;
            }

            $('#member_pending_fees').val(result);
            $('#pendingFees').html(result);
        })

        $('#PTPF').html(0);
        $('#mp_member_per_tra_fees').on('keyup', function (e) {
            if (personalTrainingPendingFees == null) {
                personalTrainingPendingFees = parseInt($('#mp_member_per_tra_pen_fees').val());
            }

            let thisValue = parseInt($(this).val());
            let total = null;
            let result = null;

            total = personalTrainingPendingFees + personalTrainingFees;

            if (thisValue) {
                if (thisValue < total) {
                    result = total - thisValue;
                    pending2 = result;
                } else {
                    result = 0;
                    pending2 = result;
                }
            } else {
                result = total;
                pending2 = result;
            }

            $('#mp_member_per_tra_pen_fees').val(result);
            $('#PTPF').html(result);
        })

        $('#yes_payment_confirmed').on('click', function (event) {
            $('.make_payment_s_btn_created').remove();
            $('#make-payment').append('<button type="submit" class="make_payment_s_btn_created" style="display: none;"></button>');
            $('.make_payment_s_btn_created').click();
        })

        $('body').on('click', '.action-payment', function (e) {
            $('#pendingFees').html(0);

            e.preventDefault();
            weekly = $(this).hasClass('weekly');
            if (weekly == false){
                $('#pay_month').show();
            }else {
                $('#pay_month').hide();
            }

            memberId = $(this).data('id');

            $.ajax({
                url: '{{ url("/member/edit") }}' + '/' + memberId,
                method: 'GET',

                success: function (response) {
                    let paymentDate = response.paymentDate;
                    let regFee = 0;
                    let subFee = 0;
                    let pendingFee = 0;
                    let payableFee = 0;
                    let extraCharges = 0;
                    let classesFee = 0;

                    let personalFee = 0;
                    let inHouseTrainingFee = 0;
                    let personalPendingFee = 0;
                    let payablePersonalFee = 0;

                    let lastFees = 0;

                    let ribbon_bgColor = '#FFD72A';
                    let ribbon_text = '';
                    if (response.member.personal_training) {
                        personalFee = parseInt(response.memberPtf);
                        payablePersonalFee = personalFee;
                        personalTrainingFees = payablePersonalFee;
                        $('#mp_member_per_tra_fees_div').show()
                        $('#mp_member_per_tra_pen_fees_div').show()
                    } else {
                        $('#mp_member_per_tra_fees_div').hide()
                        $('#mp_member_per_tra_pen_fees_div').hide()
                    }

                    if (response.member.in_house_training) {
                        inHouseTrainingFee = parseInt(response.memberIhtf);
                        $('#in_house_fees').val(inHouseTrainingFee);
                    }


                    if ((response.member.fees).length) {
                        lastFees = (response.member.fees).at(-1);
                        pendingFee = parseInt(lastFees.pending_fees||0);
                        personalPendingFee = parseInt(lastFees.pending_personal_training_fees||0);
                        payablePersonalFee = personalFee + personalPendingFee;
                        personalTrainingFees = parseInt(payablePersonalFee);

                        // ribbon_text = 'Due Fee';
                        if (ribbon_text === 'pending') {
                            ribbon_bgColor = "#EEB902";
                        } else {
                            ribbon_bgColor = "#45CB85";
                            ribbon_text = 'Pay Next Month Fee';
                        }
                        if (response.member.is_expired && response.member.is_expired==1 ) {
                        ribbon_bgColor = 'red';
                            ribbon_text = 'Due Fee';
                        }
                    } else {
                        ribbon_bgColor = "#3498db";
                        ribbon_text = 'New Member';
                    }

                    $('.custom_ribbon_text').text(ribbon_text).css({"background-color": ribbon_bgColor})

                    $('#mp_member_per_tra_fees').val(payablePersonalFee)

                    if (response.member.membership) {

                        if (!(response.member.fees).length) {
                            regFee = parseInt(response.member.membership.reg_fee);
                            registrationFees = regFee;
                        }

                        memberFees = parseInt(response.member.membership.fees) + lastFees;
                        subFee = parseInt(response.member.membership.fees);
                        /*classesFee = parseInt(response.member.classes_fees);*/
                        $('#member_classes_fees').val(classesFee);
                        payableFee = subFee + pendingFee; /*+classesFee;*/

                        $('#member_total_payment_div').hide();
                        $('#member_total_payment').val(0);

                        $('#member_pending_fees_div').hide();
                        $('#member_pending_fees').val(0);
                        $('#member_total_payment').val(payableFee);
                        $('#make_payment_name').html(response.member.name + '<small><b class="text-success"> (' + response.member.membership.name + ')</b></small>');
                    } else {
                        if (!(response.member.fees).length) {
                            regFee = parseInt(response.member.reg_fee);
                            registrationFees = regFee;
                        }
                        memberFees = parseInt(response.memberFee) + pendingFee;
                        /*classesFee = parseInt(response.member.classes_fees);*/
                        subFee = parseInt(response.memberFee);
                        payableFee = regFee + subFee + pendingFee ;/*+classesFee ;*/
                        $('#member_total_payment_div').show();
                        $('#member_total_payment').val(payableFee);
                        $('#member_pending_fees_div').show();
                        $('#member_pending_fees').val(0);
                        $('#member_fees').val(subFee);
                        /*$('#member_classes_fees').val(classesFee);*/
                        $('#member_total_payment').on('keyup', function () {
                            var netpayment = $(this).val();
                            if (netpayment >= regFee) {
                                subFee = netpayment - regFee
                                $('#member_fees').val(subFee);

                            } else {
                                $('#member_fees').val(0);
                            }

                        });


                        $('#make_payment_name').html(response.member.name + '<small><b class="text-secondary"> (No Membership)</b></small>');
                    }

                    $('#on_payment_description').html(
                        '<td>' + parseInt(regFee) + '</td>' +
                        '<td>' + parseInt(subFee) + '</td>' +
                        '<td>' + parseInt(pendingFee||0) + '</td>' +
                        '<td>' + parseInt(personalFee||0) + '</td>' +
                        '<td>' + parseInt(inHouseTrainingFee||0) + '</td>' +
                        '<td>' + parseInt(personalPendingFee||0) + '</td>' +

                     /*   '<td>' + classesFee + '</td>' +*/
                        '<td id="total_paid">' + parseInt((payableFee + payablePersonalFee + inHouseTrainingFee - discount)) + '</td>'
                    );

                    $(document).on('keyup','#discount',function () {
                        let total_amount = parseInt((payableFee + payablePersonalFee + inHouseTrainingFee));
                        total_amount = parseInt(total_amount - $(this).val());
                        $('#total_paid').text(total_amount)
                        // console.log("value is",$('#total_paid').text());
                    })
                    $(document).on('click','.waves-effect',function () {
                        $('#total_paid').text(parseInt((payableFee + payablePersonalFee + inHouseTrainingFee - discount)))
                        // console.log("value is",$('#total_paid').text());
                    })

                    $('#make_payment_modal_btn').click(function () {

                        discount = $('#discount').val();
                        loadingBtn = Ladda.create($('#yes_payment_confirmed')[0]);
                        loadingBtn.stop();
                        memberFeePaying = parseInt($('#member_total_payment').val());
                        PersonalPayableFee = parseInt($('#mp_member_per_tra_fees').val());
                        extraCharges = parseInt($('#member_extra_charges').val());
                        let totalAmount = parseInt(inHouseTrainingFee + payableFee + PersonalPayableFee);
                        totalPending = pendingFee + personalPendingFee;
                        if (isNaN(memberFeePaying)) memberFeePaying = 0;
                        if (isNaN(extraCharges)) extraCharges = 0;
                        if (isNaN(extraCharges)) extraCharges = 0;
                        totalPending = parseInt(pending1 + pending2)
                        if (response.member.membership) {
                            $('.sureText').html(`Are You Sure Collecting <b>${totalAmount - discount}</b> from <b>${response.member.name}</b> and Pending Amount is ${totalPending}`);
                            // $('.sureText').html(`Are You Sure Collecting <b>${payableFee + PersonalPayableFee - discount}</b> from <b>${response.member.name}</b> and Pending Amount is ${totalPending}`);
                        } else {
                            // $('.sureText').html(`Are You Sure Collecting <b>${memberFeePaying + extraCharges + PersonalPayableFee}</b> from <b>${response.member.name}</b> and Pending Amount is <b>${totalPending}</b>`);
                            $('.sureText').html(`Are You Sure Collecting <b>${memberFeePaying + extraCharges + PersonalPayableFee + inHouseTrainingFee}</b> from <b>${response.member.name}</b> and Pending Amount is <b>${totalPending}</b>`);
                        }

                    });
                    $('#yes_payment_confirmed').click(function () {
                        loadingBtn.start();
                    })
                    pendingFee = null;

                    $('#member_payment_date').val(new Date().toISOString().split('T')[0]);
                    // $('#member_payment_date').prop('disabled', false);
                    // if (paymentDate) {
                    //     $('#member_payment_date').val(new Date(paymentDate).toISOString().split('T')[0]);
                    //     // $('#member_payment_date').prop('disabled', true);
                    // }

                },

                error: function (error) {
                    toastrErrors(error);
                    loadingBtn.stop();
                }
            })
        });

        // $(document).on('click','.action-payment',function () {
        //     var currentDate = new Date();
        //     var curMonth = currentDate.getMonth();
        //     $('#member_payment_month').prop('selectedIndex', curMonth);
        //     $('#member_payment_month option:gt(' + curMonth + ')').prop('disabled', true);
        // })

        $('#make-payment').on('submit', function (e) {

            e.preventDefault();

            var self = $(this);
            loading(self, true);

            $.ajax({
                url: '{{ url("member/payment") }}' + '/' + memberId,
                method: 'POST',
                data: self.serialize(),

                success: function (response) {
                    toastr.success(response.message);
                    loading(self, false);
                    let fee_paid = parseInt(response.details.last_payment.fees || 0) - parseInt(response.details.last_payment.discount || 0);
                    let total_fee_paid = parseInt(response.details.last_payment.personal_training_fees || 0) + parseInt(response.details.last_payment.in_house_training_fees || 0) + fee_paid;
                    $('#confirm-payment-modal').modal('hide');
                    $('#make-payment-modal').modal('hide');
                    refreshDiv('.members_list');
                    // confirm - payment - modal
                    self[0].reset();
                    $('#select_membership').trigger('change');
                    $('#payment-receipt-pdf').modal('show');
                    $('#receipt_member_name').text(response.details.member.name)
                    $('#receipt_member_phone').text(response.details.member.phone)
                    $('#receipt_registration_fees').text('Ksh. ' + parseInt(response.details.last_payment.reg_fee || 0))
                    $('#receipt_paid_extra_charges').text('Ksh. ' + parseInt(response.details.last_payment.extra_charges || 0))
                    $('#receipt_paid_fees').text('Ksh. ' + fee_paid)
                    $('#receipt_ptf').text('Ksh. ' + parseInt(response.details.last_payment.personal_training_fees || 0))
                    $('#receipt_ihtf').text('Ksh. ' + parseInt(response.details.last_payment.in_house_training_fees || 0))
                    $('#receipt_discount').text('Ksh. ' + parseInt(response.details.last_payment.discount || 0))
                    $('#receipt_pending_fees').text('Ksh. ' + parseInt(response.details.last_payment.pending_fees || 0))
                    $('#receipt_ptf_pending').text('Ksh. ' + parseInt(response.details.last_payment.pending_personal_training_fees || 0))
                    $('#receipt_payment_method').text(response.details.last_payment.payment_method)
                    // $('#receipt_total_payment').text(+parseInt(response.details.last_payment.fees || 0) + parseInt(response.details.last_payment.personal_training_fees || 0) + parseInt(response.details.last_payment.reg_fee || 0) + parseInt(response.details.last_payment.extra_charges || 0)/*+parseInt(response.details.last_payment.classes_fees || 0)*/)
                    $('#receipt_total_payment').text('Ksh. ' + total_fee_paid)
                    $('#receipt_total_pending_fees').text('Ksh. ' +parseInt(response.details.last_payment.pending_fees) + parseInt(response.details.last_payment.pending_personal_training_fees || 0))
                    $('#receipt_payment_date').html('<small> Payment on: <span class="receipt_date" style="color:#000000;">' + new Date(response.details.last_payment.payment_date).toISOString().substr(0, 10) + '</span></small>')
                },

                error: function (error) {
                    toastrErrors(error);
                    loading(self, false);
                    $('#confirm-payment-modal').modal('hide');
                }
            });
        });
        $('#member_create_date').val(new Date().toISOString().split('T')[0]);
        $('#create-member').parsley();

        $('#create-member').on('submit', function (e) {

            e.preventDefault();
            var formData = new FormData(this);
            var self = $(this);
            loading(self, true);
            if ($('#create-member').parsley().isValid()) {
                $.ajax({
                    url: '{{ route("member.store") }}',
                    method: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        loading(self, false);
                        toastr.success(response.message);
                        $('#create-member-modal').modal('hide');
                        refreshDiv('.members_list');
                        refreshDiv('.new-sidebar');

                        self[0].reset();
                        $('.select_member_type').trigger('change');
                        $('.select_excercise_type').trigger('change');
                        $('#gender').trigger('change');
                        $('#personal_training_fees_div, .select_classes_fees_div').hide();
                        $('.reg_fee_div, .fee_structure_div').show();

                        $('#member_create_date').val(new Date().toISOString().split('T')[0]);
                        $('.select_membership_div').hide();
                        $('.select_membership option').prop('selected', false);
                        $('.select_membership').trigger('change');
                        $('.select_classes option').prop('selected', false);
                        $('.select_classes').trigger('change');
                        $('.select_classes_div').hide();
                        $('.file-ok').css({'background-image': 'none'});
                        $('.file-ok span').css({'display': 'none'});
                        $('.file_text').removeAttr('style').text('Change Profile Picture');

                    },

                    error: function (error) {
                        // console.log('errors are:',error.responseJSON.errors)
                        loading(self, false);
                        toastrErrors(error);
                    }
                });
            }
        });

        $('body').on('click', '.action-payment-history', function (e) {
            e.preventDefault();
            memberId = $(this).data('id');

            $.ajax({
                url: '{{ url("/member/payment/history") }}' + '/' + memberId,
                method: 'GET',

                success: function (response) {
                    console.log("my-response",response)

                    $('#member_payment_tr').empty();

                    let membership_icon = '';
                    if (response.member.membership) {
                        membership_icon = '<img width="30" class="mr-1" src="{{ asset('/images/membership.png') }}">';
                    }

                    $('#member_payment_history_heading').html(membership_icon + response.member.name);

                    if ((response.member.fees).length) {
                        // let fees_history = (response.member.fees).reverse();
                        $.each((response.member.fees).reverse(), function (key, value) {
                            let payment_date = new Date(value.payment_date).toISOString().substr(0, 10);
                            let expire_date = new Date(value.expire_date).toISOString().substr(0, 10);
                            let reg_date = new Date(value.reg_date).toISOString().substr(0, 10);
                            let membership_name = '';
                            let status_color = null;

                            let fees = value.fees;

                            if (value.membership) {
                                membership_name = ' <small><b class="text-success"> (' + value.membership.name + ')</b></small>';
                                fees = value.membership.fees;
                            }

                            if (value.status === 'paid') {
                                status_color = 'text-success';
                            } else if (value.status === 'unpaid') {
                                status_color = 'text-danger';
                            } else if (value.status === 'pending') {
                                status_color = 'text-info';
                            } else {
                                status_color = 'text-dark';
                            }
                            var timeString = null;
                            var options = {day: 'numeric', year: 'numeric', month: 'long'};

                            var date = new Date(value.created_at);
                            var time = {
                                hour: 'numeric',
                                minute: 'numeric',
                                hour12: true
                            };
                            timeString = date.toLocaleString('en-US', time);
                            $('#member_payment_tr').append(
                                '<tr class="text-center">' +
                                // '<td>' + new Date(value.reg_date).toLocaleDateString("en-US", options) + '</td>' +
                                '<td>' + new Date(value.payment_date).toLocaleDateString("en-US", options) + '</td>' +
                                '<td>' + timeString + '</td>' +
                                // '<td>' + new Date(value.expire_date).toLocaleDateString("en-US", options) + '</td>' +
                                '<td>' + value.collected_by.name + membership_name + '</td>' +
                                // '<td>' + value.reg_fee + '</td>' +
                                // '<td>' + fees + '</td>' +
                                // '<td>' + parseInt(value.personal_training_fees || 0) + '</td>' +
                                '<td>' + parseInt(value.extra_charges || 0) + '</td>' +
                                '<td class="text-success">' + (parseInt(value.total_payment || 0)) + '</td>' +
                                '<td>' + (parseInt(value.discount || 0)) + '</td>' +
                                '<td>' + parseInt(value.pending_fees || 0) + '</td>' +
                                '<td>' + parseInt(value.pending_personal_training_fees || 0) + '</td>' +
                                '<td>' + parseInt(value.in_house_training_fees || 0) + '</td>' +
                                '<td>' + value.payment_method + '</td>' +
                                '<td class="' + status_color + '">' + value.status + '</td>' +
                                '<td>' + value.notes + '</td>' +
                                '<td><span class="download_payment_receipt" data-id="' + value.id + '" style="cursor: pointer;"><i class="mdi mdi-cloud-download"></i></span></td>' +
                                '<td><span class="action-expense-delete btn btn-link btn-sm text-danger btn-sm delete-payment" data-id="' + value.id + '"><i class="far fa-trash-alt"></i> Delete</span></td>' +
                                '</tr>'
                            )

                            if(key==0){
                                $("#fee_str").empty();
                                let gym_fee = response.memberFee - parseInt(value.discount || 0);
                                $("#fee_str").append(
                            '<tr>' +
                                '<td>' + new Date(reg_date).toLocaleDateString("en-US", options) + '</td>' +
                                '<td>' + new Date(expire_date).toLocaleDateString("en-US", options) + '</td>' +
                                '<td>' + response.memberRegFee + '</td>' +
                                '<td>' + gym_fee + '</td>' +
                                '<td>' + parseInt(response.memberPtf || 0) + '</td>' +
                                '<td>' + parseInt(value.in_house_training_fees || 0) + '</td>' +
                                '<td>' + parseInt(value.classes_fees || 0) + '</td>' +
                                '<td>' + parseInt(value.discount || 0) + '</td>' +

                                // '<td class="text-danger"><strong>' + (parseInt(value.pending_fees || 0) || parseInt(value.pending_personal_training_fees || 0) > 0 ? (parseInt(value.reg_fee || 0) + parseInt(fees) + parseInt(value.personal_training_fees || 0) + parseInt(value.pending_fees || 0) + parseInt(value.pending_personal_training_fees || 0)) : parseInt(value.fees || 0) + parseInt(value.reg_fee || 0) + parseInt(value.personal_training_fees || 0) + parseInt(value.extra_charges || 0)) + '</strong></td>' +
                                '<td class="text-danger"><strong>' + (parseInt(response.memberFee|| 0) + parseInt(response.memberPtf|| 0)+ parseInt(response.reg_fee|| 0)+ parseInt(value.in_house_training_fees || 0)+ parseInt(response.extra_charges|| 0)+ parseInt(value.classes_fees|| 0) - parseInt(value.discount|| 0)) + '</strong></td>' +

                                    '</tr>'


                        )
                            }

                        });

                    } else {
                        $('#member_payment_tr').append(
                            '<tr><td colspan="12" class="text-center">No Payment Found!</td></tr>'
                        )
                    }
                },

                error: function (error) {
                    toastrErrors(error);

                }
            });
        });
        $('.edit_select_classes_fees_div').hide()
        $('.edit_classes_checkbox').click(function (e) {

            if (this.checked) {
                $('.edit_select_classes_div').show();
                $('.edit_select_classes_fees_div').show()

            } else {
                $('.edit_select_classes_div').hide();
                $('.edit_select_classes_fees_div').hide()
                // $('#edit_personal_training_fees').val('');
                $('.edit_select_classes_fees_div').hide();
                $('.edit_select_classes_div').hide();
            }
        });

        $('body').on('click', '.action-edit', function (e) {
            e.preventDefault();

            memberId = $(this).data('id');
            var html;
            var selected_values;
            /*$('.edit_select_classes').empty();*/
            $('.edit_select_classes_div').hide();
            $('.edit_select_classes_fees_div').hide()
            $('.edit_classes_checkbox').prop('checked', false);

            $.ajax({
                url: '{{ url("/member/edit") }}' + '/' + memberId,
                method: 'GET',

                success: function (response) {
                    // console.log("my-response",response)
                    let image = response.member.image ?? '/images/users/noprofile.jfif';

                    $('#edit_member_name').val(response.member.name);
                    $('#edit_member_email').val(response.member.email);
                    $('#edit_member_phone').val(response.member.phone);
                    $('#edit_member_gender').val(response.member.gender);
                    $('#edit_member_exercise').val(response.member.exercise_type);
                    $('#edit_member_exercise').trigger('change');
                    $('#edit_member_create_date').val(moment(response.memberRegDate).format('YYYY-MM-DD'));
                    $('#edit_member_create_date').trigger('change');
                    $('#edit_member_dob').val(response.member.dob ? new Date(response.member.dob).toISOString().substr(0, 10) : '');
                    $('#edit_member_address').val(response.member.address);
                    $('.edit-member-profile-image').addClass('file-ok')
                    $('.edit-member-profile-image').css('background-image', 'url(' + '{{ env("ASSET_URL") }}' + image + ')')

                    /*if(response.member.classes_fees >0)
                    {
                        $('.edit_select_classes_div').show();
                        $('.edit_select_classes_fees_div').show()
                        $('.edit_classes_checkbox').prop('checked', true);
                    }
                    $.each(response.classes ,function (key,val)
                    {
                        if(val.is_active)
                        {
                            selected_values ='selected';
                        }else
                    {
                        selected_values = '';
                    }
                       html += '<option value="'+val.id+'" '+selected_values+' >' +val.name+'</option>'
                        $(".edit_select_classes option[value='val.is_active=true']").prop('selected', true);

                    });
                    $('.edit_select_classes').append(html);*/

                    if (response.member.personal_training) {
                        $('#edit_personal_training_checkbox').prop('checked', true);
                        $('#edit_personal_training_fees_div').show();
                        $('#edit_personal_training_fees').val(response.member.personal_training_fees);
                    } else {
                        $('#edit_personal_training_checkbox').prop('checked', false);
                        $('#edit_personal_training_fees_div').hide();
                        $('#edit_personal_training_fees').val(0);
                    }

                    if (response.member.in_house_training) {
                        $('#edit_in_house_training_checkbox').prop('checked', true);
                        $('#edit_in_house_training_fees_div').show();
                        $('#edit_in_house_training_fees').val(response.member.in_house_training_fees);
                    } else {
                        $('#edit_in_house_training_checkbox').prop('checked', false);
                        $('#edit_in_house_training_fees_div').hide();
                        $('#edit_in_house_training_fees').val(0);
                    }



                    if (response.member.membership) {

                        $('#edit_member_membership').val(response.member.membership_id);
                        $('#edit_member_membership').trigger('change');

                        $('#edit_select_member_type').val('membership');
                        $('#edit_select_member_type').trigger('change');

                        $('.edit_fee_structure_div').hide();
                        $('.edit_select_membership_div').show();

                        $('#member_total_payment').val(response.member.membership.fees);
                    } else {

                        $('#edit_member_fee_structure').val(response.memberFee);
                        $('#edit_reg_fee').val(response.member.reg_fee);

                        $('#edit_select_member_type').val("guest-member-value");
                        $('#edit_select_member_type').trigger('change');

                        $('.edit_fee_structure_div').show();
                        $('.edit_select_membership_div').hide();

                        $('#member_total_payment').val(response.memberFee);
                    }
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });
        $('#update-member').parsley();

        $('body').on('submit', '#update-member', function (e) {

            e.preventDefault();
            if ($('#update-member').parsley().isValid()) {
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ url("/member/update") }}' + '/' + memberId,
                    method: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        loading(self, false);
                        $('#edit-member-modal').modal('hide');
                        refreshDiv('.members_list');
                        $('.file-ok').css({'background-image': 'none'});
                        $('.file-ok span').css({'display': 'none'});
                        $('.file_text').removeAttr('style').text('Change Profile Picture');
                        toastr.success(response.message);

                    },
                    error: function (error) {
                        toastrErrors(error);
                        loading(self, false);
                    }
                });
            }
        });

        $('body').on('click', '#yes_member_delete_confirmed', function (e) {
            loadingBtn = Ladda.create($('#yes_member_delete_confirmed')[0]);

            e.preventDefault();
            loadingBtn.start();

            $.ajax({
                url: '{{ url("/member/delete") }}' + '/' + memberId,
                method: 'GET',

                success: function (response) {
                    toastr.success(response.message);
                    refreshDiv('.members_list');
                    loadingBtn.stop();
                    $('#confirm-member-delete-modal').modal('hide');

                },

                error: function (error) {
                    toastrErrors(error)
                    loadingBtn.stop();
                }
            });
        });

        $('body').on('click', '.toggle-status-member', function (e) {
            e.preventDefault();
            memberId = $(this).data('id');
            $.ajax({
                url: '{{ url("/member/status") }}' + '/' + memberId,
                method: 'GET',
                success: function (response) {
                    toastr.success(response.message);
                    refreshDiv('.members_list');
                },
                error: function (error) {
                    toastrErrors(error)
                }
            });
        });

        // document.getElementById("export_payment_receipt_pdf").addEventListener("click", function () {
        //     exportToImage();
        // });

        $(document).ready(function () {

            $('body').on('change', '#image1', function (event) {

                var $file = $(this),
                    $label = $file.next('label'),
                    $labelText = $label.find('span'),
                    labelDefault = $labelText.text();

                var fileName = $file.val().split('\\').pop(),
                    tmppath = URL.createObjectURL(event.target.files[0]);

                if (fileName) {
                    $label
                        .addClass('file-ok')
                        .css({
                            'background-image': 'url(' + tmppath + ')',
                            'background-size': 'cover'
                        });
                    $labelText.text(fileName)
                    $labelText.css({
                        'position': 'absolute',
                        'bottom': '0',
                        'font-size': '12px'
                    });
                } else {
                    $label.removeClass('file-ok');
                    $labelText.text(labelDefault);
                }
            });

            $('body').on('change', '#edit-image1', function (event) {

                var $file = $(this),
                    $label = $file.next('label'),
                    $labelText = $label.find('span'),
                    labelDefault = $labelText.text();

                var fileName = $file.val().split('\\').pop(),
                    tmppath = URL.createObjectURL(event.target.files[0]);

                if (fileName) {
                    $label
                        .addClass('file-ok')
                        .css({
                            'background-image': 'url(' + tmppath + ')',
                            'background-size': 'cover'
                        });
                    $labelText.text(fileName)
                    $labelText.css({
                        'position': 'absolute',
                        'bottom': '0',
                        'font-size': '12px'
                    });
                } else {
                    $label.removeClass('file-ok');
                    $labelText.text(labelDefault);
                }
            });
        });
        var gendergetValue = '{{ request()->get('gender') }}';
        $(document).on('submit', '#searchForm', function (e) {

            e.preventDefault()
            let type = '{{ request()->get('type') }}';
            let query = $('#search_query').val();

            let url = '{{ url("/members") }}' + '?type=' + type + '&query=' + query + '&gender=' + gendergetValue;
            ;

            window.location.replace(url);
        });

        $('#mebergender').on('change', function () {

            var gender = $(this).val();
            if (gender != '') {
                let type = '{{request()->get('type')}}';
                let url = '{{url('/members')}}' + '?type=' + type + '&gender=' + gender;
                window.location.replace(url);
            } else {
                let type = '{{request()->get('type')}}';
                let url = '{{url('/members')}}' + '?type=' + type;
                window.location.replace(url);
            }

        });
        $('#mebergender').val(gendergetValue);

        $(document).on('click', '.download_payment_receipt', function () {

            let id = $(this).data('id');

            $.ajax({
                url: '{{ url("/member/payment") }}' + '/' + id,
                method: 'GET',

                success: function (response) {
                    if (response.fees) {
                        let latestFees = response.fees;
                        $('#receipt_member_name').text(latestFees.member.name)
                        $('#receipt_member_phone').text(latestFees.member.phone)
                        $('#receipt_registration_fees').text('Ksh. ' + latestFees.reg_fee || 0 )
                        $('#receipt_paid_extra_charges').text('Ksh. ' + (parseInt(latestFees.extra_charges || 0)) )
                        $('#receipt_classes_fees').text('Ksh. ' + (parseInt(latestFees.classes_fees || 0)) )
                        $('#receipt_paid_fees').text('Ksh. ' + (parseInt(latestFees.fees || 0)) )
                        $('#receipt_ptf').text('Ksh. ' + parseInt(latestFees.personal_training_fees || 0) )
                        $('#receipt_pending_fees').text('Ksh. ' + parseInt(latestFees.pending_fees || 0) )
                        $('#receipt_ptf_pending').text('Ksh. ' + parseInt(latestFees.pending_personal_training_fees || 0) )
                        $('#receipt_payment_method').text(latestFees.payment_method)
                        $('#receipt_total_payment').text(parseInt(latestFees.fees || 0) + parseInt(latestFees.personal_training_fees || 0) + parseInt(latestFees.reg_fee || 0) + parseInt(latestFees.extra_charges || 0) + parseInt(latestFees.classes_fees || 0))
                        $('#receipt_total_pending_fees').text('Ksh. '+ parseInt(latestFees.pending_fees || 0) + parseInt(latestFees.pending_personal_training_fees || 0))
                        $('#receipt_payment_date').html('<small> Payment on: <span class="receipt_date" style="color:#000000;">' + new Date(latestFees.payment_date).toISOString().substr(0, 10) + '</span></small>')

                        $('#payment-receipt-pdf').modal('show');
                    } else {
                        toastr.info('No Payment History Found!');
                    }
                },

                error: function (error) {
                    toastrErrors(error);
                }
            })
        });

        // function exportToImage() {
        //     html2canvas(document.getElementById("target_payment_receipt")).then(function (canvas) {
        //         var anchorTag = document.createElement("a");
        //         document.body.appendChild(anchorTag);
        //         anchorTag.download = $('.receipt_date').text() + '-' + $('#receipt_member_name').text() + '-receipt';
        //         anchorTag.href = canvas.toDataURL();
        //         anchorTag.target = '_blank';
        //         anchorTag.click();
        //     });
        // }


        $('body').on('click', '.pending-payment', function (e) {
            memberId = $(this).data('id');
            $.ajax({
                url: '{{ url("/member/edit") }}' + '/' + memberId,
                method: 'GET',
                success: function (response) {
                    if ((response.member.fees).length) {
                        lastFees = (response.member.fees).at(-1);
                        pendingFee = parseInt(lastFees.pending_fees);
                        personalPendingFee = parseInt(lastFees.pending_personal_training_fees);
                        totalPending = pendingFee + personalPendingFee;
                        $('#member_name').html(response.member.name);
                        $('#pending-fee-notice').html("<h5 style='color: red;display: inline'>Please make sure you have collected</h5>" + "<b style='color: black; float: right'>" + totalPending + "<b>");

                        $('#on_pending_payment_description').html(
                            '<td>' + pendingFee + '</td>' +
                            '<td>' + personalPendingFee + '</td>' +
                            '<td style="color: red">' + totalPending + '</td>'
                        );
                    }
                }
            })
        });

        $('#pending-payments').on('submit', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);

            $.ajax({
                url: '{{ url('member/pending')}}' + '/' + memberId,
                type: 'Post',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    toastr.success(response.message);
                    loading(self, false);
                    $('#confirm-pending-modal').modal('hide');
                    refreshDiv('.members_list');
                    refreshDiv('.new-sidebar');

                },
                error: function (error) {
                    toastrErrors(error);
                    loading(self, true);
                }
            });

        });
        $('body').on('click', '.action-member-delete', function (e) {
            e.preventDefault();
            memberId = $(this).data('id');
            $.ajax({
                url: '{{ url("/member/edit") }}' + '/' + memberId,
                method: 'GET',
                success: function (response) {
                    $('#confirm_member_delete_modal_desc').html("Are you sure to delete " + "<b style='color: red'>" + response.member.name + '</b>');
                },


            });
        });

        $('.action-member-fees-update').on('click', function (e) {
            e.preventDefault();
            memberId = $(this).data('id');
            $.ajax(
                {
                    url: '{{url('feelog/index')}}' + '/' + memberId,
                    method: 'GET',
                    success: function (response) {
                        $('#member-already-fee').text("Member current fee is " + response.memberFee);
                        $('#member_already_fees').val(response.memberFee);
                    },
                    error: function (error) {
                        toastrErrors(error);
                    },
                }
            )

        });


        $(document).on('click', '.action-member-reg-date-update', function (e) {
            e.preventDefault();
            $('#update-member-reg-date').val();
            memberId = $(this).data('id');
            $.ajax(
                {
                    url: '{{url('reglog/index')}}' + '/' + memberId,
                    method: 'GET',
                    success: function (response) {
                        if (response.memberReg != 'no') {
                            $('#update-member-reg-date').val(moment(response.memberReg).format('YYYY-MM-DD'));
                            $('#update-member-reg-date').trigger('change');
                        }


                    },
                    error: function (error) {
                        toastrErrors(error);
                    },
                }
            )

        });
        $(document).on('click', '.action-member-ptf-update', function (e) {
            e.preventDefault();
            memberId = $(this).data('id');
            $.ajax(
                {
                    url: '{{url('ptflog/index')}}' + '/' + memberId,
                    method: 'GET',
                    success: function (response) {

                        if (response) {
                            $('#member-already-ptf-fee').text("Member current PTF  is " + response.memberptf);
                            $('#member_already_ptf_fees').val(response.memberptf);
                        }


                    },
                    error: function (error) {
                        toastrErrors(error);
                    },
                }
            )

        });


        $('#member-fee').parsley();
        $('#member-fee').on('submit', function (e) {
            if ($('#member-fee').parsley().isValid()) {


                e.preventDefault();
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                $.ajax({
                    url: '{{url("feelog/store")}}' + '/' + memberId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        loading(self, false);
                        $('#member-fee-update-modal').modal('hide');
                    },
                    error: function (error) {
                        loading(self, false);
                        toastrErrors(error);
                    }
                });
            }
        });

        $('#member-ptf-fee').parsley();
        $('#member-ptf-fee').on('submit', function (e) {

            if ($('#member-ptf-fee').parsley().isValid()) {

                e.preventDefault();
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                $.ajax({
                    url: '{{url("ptflog/store")}}' + '/' + memberId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        loading(self, false);
                        $('#member-ptf-update-modal').modal('hide');
                    },
                    error: function (error) {
                        loading(self, false);
                        toastrErrors(error);
                    }
                });
            }
        });

        $('#member-regForm').parsley();
        $('#member-regForm').on('submit', function (e) {
            if ($('#member-regForm').parsley().isValid()) {
                e.preventDefault();
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                $.ajax({
                    url: '{{url("reglog/store")}}' + '/' + memberId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        loading(self, false);
                        $('#member-reg-update-modal').modal('hide');
                        $('#member-regForm')[0].reset();
                    },
                    error: function (error) {
                        loading(self, false);
                        toastrErrors(error);
                    }
                });
            }
        });

        $('#select-member-class').parsley();
        $('#select-member-class').on('submit', function (e) {
            if ($('#select-member-class').parsley().isValid()) {
                e.preventDefault();
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                $.ajax({
                    url: '{{url("member/classes")}}' + '/' + memberId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        loading(self, false);
                        $('#select-member-classes-modal').modal('hide');
                        $('#select-member-class')[0].reset();
                        $('.select-classes-formember'+'-'+memberId+'').empty();
                    },
                    error: function (error) {
                        loading(self, false);
                        toastrErrors(error);
                    }
                });
            }
        });

        $('.action-edit-classes').on('click',function (e) {
            e.preventDefault();
            memberId = $(this).data('id');
            $('.edit_select_classes').empty();
            var html;
            $.ajax(
                {
                    url: '{{url('member/classes/edit')}}' + '/' + memberId,
                    method: 'GET',

                    success: function (response) {

                        $('#edit_classes_fees_structure').val(response.member.classes_fees)
                        $.each(response.classes ,function (key,val)
                        {
                            if(val.is_active)
                            {
                                selected_values ='selected';
                            }else
                            {
                                selected_values = '';
                            }
                            html += '<option value="'+val.id+'" '+selected_values+' >' +val.name+'</option>'

                        });
                        $('.edit_select_classes').append(html);
                        $('.edit_select_classes').trigger('change');

                    },
                    error: function (error) {
                        toastrErrors(error);
                    },
                }
            )

        });

        $('#update-member-class').parsley();
        $('#update-member-class').on('submit', function (e) {
            if ($('#select-member-class').parsley().isValid()) {
                e.preventDefault();
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                $.ajax({
                    url: '{{url("member/classes/update")}}' + '/' + memberId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        loading(self, false);
                        $('#edit-member-classes-modal').modal('hide');
                        $('#select-member-class')[0].reset();
                    },
                    error: function (error) {
                        loading(self, false);
                        toastrErrors(error);
                    }
                });
            }
        });


        $('body').on('click', '.action-payment-classes', function (e) {
            memberId = $(this).data('id');
            $.ajax({
                url: '{{ url("/member/edit") }}' + '/' + memberId,
                method: 'GET',
                success: function (response) {
                        $('#class-member_name').html("Your Collecting Classes Fees From "+response.member.name);
                        $('#on_classes_payment_description').html("<h5 style='color: red;display: inline'>Please make sure you have collected</h5>" + "<b style='color: black; float: right'>" + response.member.classes_fees??0 + "<b>");
                        $('#member-classes-fees-payment').val(response.member.classes_fees??0);



                }
            })
        });


        $('#payment-classes').parsley();
        $('#payment-classes').on('submit', function (e) {
            if ($('#payment-classes').parsley().isValid()) {
                e.preventDefault();
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                $.ajax({
                    url: '{{url("member/classes/payment")}}' + '/' + memberId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        refreshDiv('.members_list');
                        loading(self, false);
                        $('#classes-fees-modal').modal('hide');
                        $('#payment-classes')[0].reset();
                    },
                    error: function (error) {
                        loading(self, false);
                        toastrErrors(error);
                    }
                });
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click','.delete-payment',function () {
            let memberId = $(this).data('id')
            $(this).parent().parent().remove();
            $.ajax({
                url: '{{url("member/payment/delete")}}' + '/' + memberId,
                type: 'DELETE',
                processData: false,
                contentType: false,
                // data: formData,
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function (error) {
                    loading(self, false);
                    toastrErrors(error);
                }
            });
        })



    </script>
@endsection
