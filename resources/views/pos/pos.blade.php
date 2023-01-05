<x-pos-layout>
    <!--//row-->
    <div class="row mb-4">
        <div class="col-12 col-lg-4" style="height: 80vh;">
            <div class="app-card app-card-chart shadow-sm">
                <!--//app-card-header-->
                <div class="app-card-body p-3">
                    <form>
                        <input type="text" name="search_product" class="form-control search-docs" id="search_barcode"
                            placeholder="Enter barcode or product name here" autofocus onkeyup="searchProducts(this)">
                    </form>
                </div>
                <!--//app-card-body-->
            </div>
            <!--//app-card-->
            <div id="product-items" style="">
                @unless(count($products) == 0)
                    @foreach ($products as $row)
                        <div class="mt-2">
                            <div class="app-card app-card-doc shadow-sm row p-2">
                                <div class="col-auto">
                                    <img class="thumb-image"
                                        src="{{ $row->image ? asset('storage/' . $row->image) : asset('/images/product.png') }}"
                                        alt="" width="50">
                                    <a class="app-card-link-mask" href="#addQTY" data-bs-toggle="modal"
                                        data-qty="{{ $row->stock_out_qty + $row->stock_in_qty }}"
                                        data-barcode="{{ $row->barcode }}" data-name="{{ $row->name }}"
                                        data-unit="{{ $row->unit }}" data-price="{{ $row->mark_up }}"
                                        onclick="itemSelect(this)"></a>
                                </div>
                                <div class="col-auto">
                                    <h2 class="app-doc-title mb-0">
                                        <a href="#addQTY" data-bs-toggle="modal" data-qty="{{ $row->stock_out_qty }}"
                                            data-barcode="{{ $row->barcode }}" data-name="{{ $row->name }}"
                                            data-unit="{{ $row->unit }}" data-price="{{ $row->mark_up }}"
                                            onclick="itemSelect(this)">{{ $row->name }}</a>
                                    </h2>

                                    <div class="app-doc-meta row mt-1">
                                        <div class="col-auto">
                                            <span class="text-muted">
                                                Stocks:</span> {{ $row->stock_out_qty + $row->stock_in_qty }}
                                        </div>
                                        <div class="col-auto ">
                                            <span class="text-muted">
                                                Unit:</span> {{ $row->unit }}
                                        </div>
                                        <div class="col-auto ">
                                            <span class="text-muted">
                                                Price:</span> P
                                            {{ number_format($row->mark_up, 2) }}</li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-6 col-md-4 mt-2">
                            <div class="app-card app-card-doc shadow-sm">
                                <div class="app-card-thumb-holder p-3">
                                    <div class="app-card-thumb">
                                        <img class="thumb-image"
                                            src="{{ $row->image ? asset('storage/' . $row->image) : asset('/images/product.png') }}"
                                            alt="">
                                    </div>
                                    <a class="app-card-link-mask" href="#addQTY" data-bs-toggle="modal"
                                        data-qty="{{ $row->stock_out_qty }}" data-barcode="{{ $row->barcode }}"
                                        data-name="{{ $row->name }}" data-unit="{{ $row->unit }}"
                                        data-price="{{ $row->mark_up }}" onclick="itemSelect(this)"></a>
                                </div>
                                <div class="app-card-body p-3 has-card-actions">
                                    <h4 class="app-doc-title truncate mb-0"><a href="#addQTY" data-bs-toggle="modal"
                                            data-qty="{{ $row->stock_out_qty }}" data-barcode="{{ $row->barcode }}"
                                            data-name="{{ $row->name }}" data-unit="{{ $row->unit }}"
                                            data-price="{{ $row->mark_up }}"
                                            onclick="itemSelect(this)">{{ $row->name }}</a>
                                    </h4>
                                    <div class="app-doc-meta">
                                        <ul class="list-unstyled mb-0">
                                            <li><span class="text-muted">Stocks:</span> {{ $row->stock_out_qty }}</li>
                                            <li><span class="text-muted">Unit:</span> {{ $row->unit }}</li>
                                            <li><span class="text-muted">Price:</span> P
                                                {{ number_format($row->mark_up, 2) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    @endforeach
                @endunless

            </div>

            <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-12 col-lg-5">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="table-responsive" id="items-sale">
                        <table class="table table-borderless table-hover" id="sale-items" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th class="text-right no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5 d-flex justify-content-end">
                        <a onclick="return confirm('Do you wish to suspend/cancel?');" href="{{ URL::current() }}"
                            class="btn btn-danger text-white"><i class="fas fa-trash-alt"></i>
                            Suspend/Cancel</a>
                    </div>
                </div>
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-12 col-lg-3">
            <div class="app-card app-card-chart shadow-sm mb-2">
                <div class="app-card-body p-3 p-lg-4" style="height: 120px">
                    <div class="text-right">
                        <p class="mb-0 font-size-bold">Grand Total:</p>
                        <h2 class="text-right mb-0" style="float: left;">₱</h2>
                        <h2 class="text-right mb-0" id="grandtotal" style="float: right;">0</h2>
                    </div>

                </div>

                <!--//app-card-body-->
            </div>
            <div class="app-card app-card-chart shadow-sm">
                <div class="app-card-body p-3 p-lg-4">
                    <div class="d-flex justify-content-start">
                        <div>
                            <div class="app-utility-item app-notifications-dropdown dropdown">
                                <a class="app-logo" href="/admin/dashboard"><img class="logo-icon me-2"
                                        src="{{ !empty($system->logo) ? asset('storage/' . $system->logo) : asset('/images/app-logo.svg') }}"
                                        alt="logo" width="80"></a>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $system->business_name ?? 'John Shop' }}</h5>
                            <small class="text-muted"> {{ $system->contact ?? '0912345678' }}</small></br>
                            <small class="text-muted">
                                {{ $system->address ?? 'Russel st 50,Bostron,MA USA' }}</small></br>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <table class="table right-table">
                            <tbody>
                                <tr class="d-flex align-items-center justify-content-between">
                                    <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                        Total Items
                                    </th>
                                    <td class="border-0 justify-content-end d-flex text-dark font-size-base"
                                        id="totalqty">0</td>

                                </tr>
                                <tr class="d-flex align-items-center justify-content-between">
                                    <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                        Subtotal (₱)
                                    </th>
                                    <td class="border-0 justify-content-end d-flex text-dark font-size-base"
                                        id="subtotal">0</td>

                                </tr>
                                <tr class="d-flex align-items-center justify-content-between">
                                    <th class="border-0 ">
                                        <div
                                            class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
                                            DISCOUNT (<span id="discount_percentage"></span> %)<a href="#discountModal"
                                                data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></a>
                                        </div>
                                    </th>
                                    <td class="border-0 justify-content-end d-flex text-dark font-size-base"><span
                                            id="discount" class="text-danger">0</span></td>
                                </tr>
                                <tr class="d-flex align-items-center justify-content-between item-price">
                                    <th class="border-0 font-size-h5 mb-0 font-size-bold text-primary">

                                        TOTAL (₱)
                                    </th>
                                    <td class="border-0 justify-content-end d-flex text-primary font-size-base"
                                        id="grandtotal1">0
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                        <hr>
                    </div>
                    <div class="mt-5 text-center">
                        <a type="button" href="#paynow" class="btn btn-primary text-white" data-bs-toggle="modal"
                            onclick="payNow()"><i class="fas fa-money-bill-wave"></i>
                            Pay Now</a>

                    </div>
                </div>

                <!--//app-card-body-->
            </div>
            <!--//app-card-->
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addQTY" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Enter Quantity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="form-control text-center" id="product_name"
                                style="height:40px;font-size:20px" readonly>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control text-center" id="product_qty"
                                style="height:80px;font-size:30px" required>
                            <div>
                                <small class="text-danger">Please enter not more than <span id="max_qty"></span>
                                    <span id="unit_t"></span>.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="product_unit">
                        <input type="hidden" id="product_price">
                        <input type="hidden" id="barcode">
                        <input type="hidden" id="max_qty">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn app-btn-primary" onclick="addItem()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editQTY" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Quantity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="form-control text-center" id="edit_product_name"
                                style="height:40px;font-size:20px" readonly>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control text-center" id="edit_product_qty"
                                style="height:80px;font-size:30px" required>
                            <div>
                                <small class="text-danger">Please enter not more than <span id="edit_max_qty"></span>
                                    <span id="unit_t"></span>.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="edit_product_unit">
                        <input type="hidden" id="edit_product_price">
                        <input type="hidden" id="edit_barcode">
                        <input type="hidden" id="edit_max_qty1">
                        <input type="hidden" id="rowcount">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn app-btn-primary" onclick="editItem()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="discountModal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Enter Discount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label>Enter Passcode:</label>
                            <input type="password" class="form-control text-center" id="pin"
                                style="height:40px;" required>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Enter Discount:</label>
                            <input type="text" class="form-control text-center" id="sale_discount"
                                style="height:80px;font-size:30px" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="{{ $system->passcode }}" id="pos-pin">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn app-btn-primary" onclick="addDiscount()">Add
                            Discount</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="paynow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Enter Cash</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" step="0.5" class="form-control text-center" id="payment_cash"
                                onkeyup="paymentChange(this)" style="height:80px;font-size:30px" required>
                            <div>
                                <small class="text-danger">Amount to pay ₱ <span id="payment_to_pay"></span>.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h3 class="text-center">Change: ₱ <span id="payment_change">0.00</span>
                            </h3>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn app-btn-primary" onclick="payment_okay()">Okay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-pos-layout>
