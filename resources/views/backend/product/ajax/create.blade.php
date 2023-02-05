@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>

    <script>
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select2-multiple').select2();
        $('.select2-container').addClass('d-block');

        // Create
        $('#create-product').parsley();
        var productId = null;
        $('#create-product').on('submit', function (e) {
             e.preventDefault();
             var self = $(this);
             loading(self, true);

             var formData = new FormData(this);
             if ($('#create-product').parsley().isValid()) {

                 $.ajax({
                     url: "{{route('product.store')}}",
                     type: 'POST',
                     processData: false,
                     contentType: false,
                     data: formData,
                     success: function (response) {
                         toastr.success(response.message);
                         self[0].reset();
                         $('#selectAttributes, #tags').val([]).trigger('change');
                         $('#makeVariations').empty();
                         loading(self, false)
                     },
                     error: function (error) {
                         toastrErrors(error);
                         loading(self, false)
                     }
                 });
             }
         });

        $('body').on('change', '.category-on-change', function (e) {
            e.preventDefault();
            let self = $(this);
            let id = self.val();
            $.ajax({
                url: '{{ url("/category/change") }}' + '/' + id,
                method: 'GET',
                success: function (response) {
                    $('#child_categories').empty();
                    let options = '';
                    $.each(response.category.sub_categories, function (key, value) {
                        options += '<option value="' + value.id + '">' + value.name + '</option>';
                    })
                    $('#child_categories').append(options);
                },
                error: function (error) {
                    toastrErrors(error)
                }
            });
        });

        $('#selectAttributes').on('change', function () {
            let values = $(this).val();

            $.ajax({
                url: '{{ route("attribute.values") }}',
                method: 'GET',
                data: {
                    data: values
                },

                success: function (response) {
                    let values = response.values;

                    let variations = getAllCombinations(values);

                    $('#makeVariations').empty();
                    if (Object.keys(variations[0]).length) {
                        $.each(variations, function (key, value) {
                            $('#makeVariations').append(makeVariations(key, value))
                        })
                    }

                },
                error: function (error) {
                    toastrErrors(error)
                }
            });
        })

        let getProducts = (arrays) => {
            if (arrays.length === 0) {
                return [[]];
            }

            let results = [];

            getProducts(arrays.slice(1)).forEach((product) => {
                arrays[0].forEach((value) => {
                    results.push([value].concat(product));
                });
            });

            return results;
        };

        let getAllCombinations = (attributes) => {
            let attributeNames = Object.keys(attributes);

            let attributeValues = attributeNames.map((name) => attributes[name]);

            return getProducts(attributeValues).map((product) => {
                obj = {};
                attributeNames.forEach((name, i) => {
                    obj[name] = product[i];
                });
                return obj;
            });
        };

        function makeVariations(key, value) {

            let variantNames = '';
            $.each(value, function (k, v) {
                variantNames +=
                    '<div class="col-md-4">' +
                        '<input type="hidden" name="variants['+key+'][values][]" value="'+v.id+'" required>' +
                        '<h6 class="m-0">' + k + ': ' + v.name + '</h6>' +
                    '</div>';
            })

            let html =
            '<div class="row border mb-2">' +
                '<div class="col-md-12">' +
                    '<div class="row bg-light p-2 mb-2">' +
                        '<div class="col-md-1 border-dark border-right text-center">' +
                            '<span><b>'+(key+1)+'</b></span>' +
                        '</div>' +
                        '<div class="col-md-11">' +
                            '<div class="row">' +
                                variantNames +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                    '<div class="form-group">' +
                        '<label>Price<span class="text-danger">*</span></label>' +
                        '<input name="variants['+key+'][price]" type="number" class="form-control" value="0" placeholder="price" required>' +
                    '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                    '<div class="form-group">' +
                        '<label>SKU<span class="text-danger">*</span></label>' +
                        '<input name="variants['+key+'][sku]" type="text" class="form-control" placeholder="SKU" required>' +
                    '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                    '<div class="form-group">' +
                        '<label>Stock<span class="text-danger">*</span></label>' +
                        '<input name="variants['+key+'][stock]" type="number" class="form-control" value="0" placeholder="Stock" required>' +
                    '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                    '<div class="form-group">' +
                        '<label>Status<span class="text-danger">*</span></label>' +
                        '<select name="variants['+key+'][status]" class="form-control" required>' +
                            '<option value="in_stock">In Stock</option>' +
                            '<option value="out_of_stock">Out of Stock</option>' +
                        '</select>' +
                    '</div>' +
                '</div>' +
            '</div>';

            return html;
        }

    </script>

@endsection
