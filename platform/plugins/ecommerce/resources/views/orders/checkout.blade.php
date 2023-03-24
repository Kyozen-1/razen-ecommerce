@extends('plugins/ecommerce::orders.master')
@section('title')
    {{ __('Checkout') }}
@stop

@push('header')
<style>
    .hiddenRow {
        padding: 0 !important;
    }
</style>
@endpush

@section('content')

    @if (Cart::instance('cart')->count() > 0)
        @include('plugins/payment::partials.header')
        {!! Form::open(['route' => ['public.checkout.process', $token], 'class' => 'checkout-form payment-checkout-form', 'id' => 'checkout-form']) !!}
        <input type="hidden" name="checkout-token" id="checkout-token" value="{{ $token }}">

        <div class="container" id="main-checkout-product-info">
            <div class="row">
                <div class="order-1 order-md-2 col-lg-5 col-md-6 right">
                    <div class="d-block d-sm-none">
                        @include('plugins/ecommerce::orders.partials.logo')
                    </div>
                    <div id="cart-item" class="position-relative">

                        <div class="payment-info-loading" style="display: none;">
                            <div class="payment-info-loading-content">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>

                        {!! apply_filters(RENDER_PRODUCTS_IN_CHECKOUT_PAGE, $products) !!}

                        <div class="mt-2 p-2">
                            <div class="row">
                                <div class="col-6">
                                    <p>{{ __('Subtotal') }}:</p>
                                </div>
                                <div class="col-6">
                                    <p class="price-text sub-total-text text-end"> {{ format_price(Cart::instance('cart')->rawSubTotal()) }} </p>
                                </div>
                            </div>
                            @if (session('applied_coupon_code'))
                                <div class="row coupon-information">
                                    <div class="col-6">
                                        <p>{{ __('Coupon code') }}:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="price-text coupon-code-text"> {{ session('applied_coupon_code') }} </p>
                                    </div>
                                </div>
                            @endif
                            @if ($couponDiscountAmount > 0)
                                <div class="row price discount-amount">
                                    <div class="col-6">
                                        <p>{{ __('Coupon code discount amount') }}:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="price-text total-discount-amount-text"> {{ format_price($couponDiscountAmount) }} </p>
                                    </div>
                                </div>
                            @endif
                            @if ($promotionDiscountAmount > 0)
                                <div class="row">
                                    <div class="col-6">
                                        <p>{{ __('Promotion discount amount') }}:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="price-text"> {{ format_price($promotionDiscountAmount) }} </p>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($shipping) && Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                                <div class="row">
                                    <div class="col-6">
                                        <p>{{ __('Shipping fee') }}:</p>
                                    </div>
                                    <div class="col-6 float-end">
                                        <p class="price-text shipping-price-text">{{ format_price($shippingAmount) }}</p>
                                    </div>
                                </div>
                            @endif

                            @if (EcommerceHelper::isTaxEnabled())
                                <div class="row">
                                    <div class="col-6">
                                        <p>{{ __('Tax') }}:</p>
                                    </div>
                                    <div class="col-6 float-end">
                                        <p class="price-text tax-price-text">{{ format_price(Cart::instance('cart')->rawTax()) }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-6">
                                    <p><strong>{{ __('Total') }}</strong>:</p>
                                </div>
                                <div class="col-6 float-end">
                                    <p class="total-text raw-total-text"
                                       data-price="{{ format_price(Cart::instance('cart')->rawTotal(), null, true) }}"> {{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount) }} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-3 mb-5">
                        @include('plugins/ecommerce::themes.discounts.partials.form')
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 left">
                    <div class="d-none d-sm-block">
                        @include('plugins/ecommerce::orders.partials.logo')
                    </div>
                    <div class="form-checkout">
                        @if (Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                            <div>
                                <h5 class="checkout-payment-title">{{ __('Shipping information') }}</h5>
                                <input type="hidden" value="{{ route('public.checkout.save-information', $token) }}" id="save-shipping-information-url">
                                @include('plugins/ecommerce::orders.partials.address-form', compact('sessionCheckoutData'))
                            </div>
                            <br>
                        @endif

                        @if (EcommerceHelper::isBillingAddressEnabled())
                            <div>
                                <h5 class="checkout-payment-title">{{ __('Billing information') }}</h5>
                                @include('plugins/ecommerce::orders.partials.billing-address-form', compact('sessionCheckoutData'))
                            </div>
                            <br>
                        @endif

                        @if (!is_plugin_active('marketplace'))
                            @if (Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                                <div id="shipping-method-wrapper">
                                    <h5 class="checkout-payment-title">{{ __('Shipping method') }}</h5>
                                    <div class="shipping-info-loading" style="display: none;">
                                        <div class="shipping-info-loading-content">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                    @if (!empty($shipping))
                                        <div class="payment-checkout-form">
                                            <input type="hidden" name="shipping_option" value="{{ old('shipping_option', $defaultShippingOption) }}">
                                            <ul class="list-group list_payment_method">
                                                @foreach ($shipping as $shippingKey => $shippingItems)
                                                    @foreach($shippingItems as $shippingOption => $shippingItem)
                                                        @include('plugins/ecommerce::orders.partials.shipping-option', [
                                                            'shippingItem' => $shippingItem,
                                                            'attributes' =>[
                                                                'id' => 'shipping-method-' . $shippingKey . '-' . $shippingOption,
                                                                'name' => 'shipping_method',
                                                                'class' => 'magic-radio',
                                                                'checked' => old('shipping_method', $defaultShippingMethod) == $shippingKey && old('shipping_option', $defaultShippingOption) == $shippingOption,
                                                                'disabled' => Arr::get($shippingItem, 'disabled'),
                                                                'data-option' => $shippingOption,
                                                            ],
                                                        ])
                                                    @endforeach
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p>{{ __('No shipping methods available!') }}</p>
                                    @endif
                                </div>
                                <br>
                            @endif
                        @endif

                        <div class="position-relative">
                            <div class="payment-info-loading" style="display: none;">
                                <div class="payment-info-loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            {{-- <h5 class="checkout-payment-title">{{ __('Payment method') }}</h5> --}}
                            <input type="hidden" name="amount" value="{{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? 0 : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount, null, true) }}">
                            <input type="hidden" name="currency" value="{{ strtoupper(get_application_currency()->title) }}">
                            {!! apply_filters(PAYMENT_FILTER_PAYMENT_PARAMETERS, null) !!}
                            <ul class="list-group list_payment_method">
                                @php
                                    $selected = session('selected_payment_method');
                                    $default = \Botble\Payment\Supports\PaymentHelper::defaultPaymentMethod();
                                    $selecting = $selected ?: $default;
                                @endphp

                                {!! apply_filters(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, null, [
                                        'amount'    => ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? 0 : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount, null, true),
                                        'currency'  => strtoupper(get_application_currency()->title),
                                        'name'      => null,
                                        'selected'  => $selected,
                                        'default'   => $default,
                                        'selecting' => $selecting,
                                    ]) !!}

                                @if (get_payment_setting('status', 'cod') == 1)
                                    {{-- <li class="list-group-item">
                                        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_cod"
                                            @if ($selecting == \Botble\Payment\Enums\PaymentMethodEnum::COD) checked @endif
                                            value="cod" data-bs-toggle="collapse" data-bs-target=".payment_cod_wrap" data-parent=".list_payment_method">
                                        <label for="payment_cod" class="text-start">{{ setting('payment_cod_name', trans('plugins/payment::payment.payment_via_cod')) }}</label>
                                        <div class="payment_cod_wrap payment_collapse_wrap collapse @if ($selecting == \Botble\Payment\Enums\PaymentMethodEnum::COD) show @endif" style="padding: 15px 0;">
                                            {!! BaseHelper::clean(setting('payment_cod_description')) !!}

                                            @php $minimumOrderAmount = setting('payment_cod_minimum_amount', 0); @endphp
                                            @if ($minimumOrderAmount > Cart::instance('cart')->rawSubTotal())
                                                <div class="alert alert-warning" style="margin-top: 15px;">
                                                    {{ __('Minimum order amount to use COD (Cash On Delivery) payment method is :amount, you need to buy more :more to place an order!', ['amount' => format_price($minimumOrderAmount), 'more' => format_price($minimumOrderAmount - Cart::instance('cart')->rawSubTotal())]) }}
                                                </div>
                                            @endif
                                        </div>
                                    </li> --}}
                                @endif

                                @if (get_payment_setting('status', 'bank_transfer') == 1)
                                    {{-- <li class="list-group-item">
                                        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_bank_transfer"
                                            @if ($selecting == \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER) checked @endif
                                            value="bank_transfer"
                                            data-bs-toggle="collapse" data-bs-target=".payment_bank_transfer_wrap" data-parent=".list_payment_method">
                                        <label for="payment_bank_transfer" class="text-start">{{ setting('payment_bank_transfer_name', trans('plugins/payment::payment.payment_via_bank_transfer')) }}</label>
                                        <label for="payment_bank_transfer" class="text-start">Duitku</label>
                                        <div class="payment_bank_transfer_wrap payment_collapse_wrap collapse @if ($selecting == \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER) show @endif" style="padding: 15px 0;">
                                            {!! BaseHelper::clean(setting('payment_bank_transfer_description')) !!}
                                            <div class="form-group">
                                                <label for="paymentMethod" class="text-start">Metode Pembayaran</label>
                                                <select name="paymentMethod" id="paymentMethod" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </li> --}}
                                    <li class="list-group-item">
                                        <input type="radio" class="magic-radio js_payment_method" name="payment_method" id="payment_bank_transfer"
                                            @if ($selecting == \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER) checked @endif
                                            value="bank_transfer"
                                            data-bs-toggle="collapse" data-bs-target=".payment_bank_transfer_wrap" data-parent=".list_payment_method"
                                        >
                                        <label for="payment_bank_transfer" class="text-start">Metode Pembayaran</label>
                                        <div class="payment_bank_transfer_wrap payment_collapse_wrap collapse @if ($selecting == \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER) show @endif" style="padding: 15px 0;">
                                            <div style="padding-left: 1rem">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#transfer_bank_collapse" class="accordion-toggle">Transfer Bank</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="transfer_bank_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="VA" id="va"></td>
                                                                                <td><label for="va"><img src="https://images.duitku.com/hotlink-ok/VA.PNG" class="img-responsive" id="img_va"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="BT" id="bt"></td>
                                                                                <td><label for="bt"><img src="https://images.duitku.com/hotlink-ok/BT.PNG" class="img-responsive" id="img_bt"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="B1" id="b1"></td>
                                                                                <td><label for="b1"><img src="https://images.duitku.com/hotlink-ok/B1.PNG" class="img-responsive" id="img_b1"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="A1" id="a1"></td>
                                                                                <td><label for="a1"><img src="https://images.duitku.com/hotlink-ok/A1.PNG" class="img-responsive" id="img_a1"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="I1" id="i1"></td>
                                                                                <td><label for="i1"><img src="https://images.duitku.com/hotlink-ok/I1.PNG" class="img-responsive" id="img_i1"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="M1" id="m1"></td>
                                                                                <td><label for="m1"><img src="https://images.duitku.com/hotlink-ok/M1.PNG" class="img-responsive" id="img_m1"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="M2" id="m2"></td>
                                                                                <td><label for="m2"><img src="https://images.duitku.com/hotlink-ok/MV.PNG" class="img-responsive" id="img_m2"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="AG" id="ag"></td>
                                                                                <td><label for="ag"><img src="https://images.duitku.com/hotlink-ok/AG.PNG" class="img-responsive" id="img_ag"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="BC" id="bc"></td>
                                                                                <td><label for="bc"><img src="https://images.duitku.com/hotlink-ok/BCA.SVG" style="height: 3rem;" id="img_bc"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="BR" id="br"></td>
                                                                                <td><label for="br"><img src="https://images.duitku.com/hotlink-ok/BR.PNG" class="img-responsive" id="img_br"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="NC" id="nc"></td>
                                                                                <td><label for="nc"><img src="https://images.duitku.com/hotlink-ok/NC.PNG" class="img-responsive" id="img_nc"></label><br></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#credit_card_collapse" class="accordion-toggle">Kartu Kredit</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="credit_card_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="VC" id="vc"></td>
                                                                                <td><label for="vc"><img src="https://images.duitku.com/hotlink-ok/VC.PNG" class="img-responsive" id="img_vc"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#retail_collapse" class="accordion-toggle">Retail</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="retail_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="FT" id="ft"></td>
                                                                                <td><label for="ft"><img src="https://images.duitku.com/hotlink-ok/FT.PNG" class="img-responsive" id="img_ft"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#ovo_collapse" class="accordion-toggle">OVO</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="ovo_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="OV" id="ov"></td>
                                                                                <td><label for="ov"><img src="https://images.duitku.com/hotlink-ok/OV.PNG" class="img-responsive" id="img_ov"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#qris_collapse" class="accordion-toggle">QRIS</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="qris_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="SP" id="sp"></td>
                                                                                <td><label for="sp"><img src="https://images.duitku.com/hotlink-ok/SHOPEEPAY.PNG" class="img-responsive" id="img_sp"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="LQ" id="lq"></td>
                                                                                <td><label for="lq"><img src="https://images.duitku.com/hotlink-ok/LINKAJA.PNG" class="img-responsive" id="img_lq"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="NQ" id="nq"></td>
                                                                                <td><label for="nq"><img src="https://images.duitku.com/hotlink-ok/NQ.PNG" class="img-responsive" id="img_nq"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#indodana_paylater_collapse" class="accordion-toggle">INDODANA PAYLATER</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="indodana_paylater_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="DN" id="dn"></td>
                                                                                <td><label for="dn"><img src="https://images.duitku.com/hotlink-ok/DN.PNG" class="img-responsive" id="img_dn"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#aplikasi_collapse" class="accordion-toggle">Aplikasi</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="aplikasi_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="LA" id="la"></td>
                                                                                <td><label for="la"><img src="https://images.duitku.com/hotlink-ok/LINKAJA.PNG" class="img-responsive" id="img_la"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="SA" id="sa"></td>
                                                                                <td><label for="sa"><img src="https://images.duitku.com/hotlink-ok/SHOPEEPAY.PNG" class="img-responsive" id="img_sa"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#dana_collapse" class="accordion-toggle">Dana</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="dana_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="DA" id="da"></td>
                                                                                <td><label for="da"><img src="https://images.duitku.com/hotlink-ok/DA.PNG" class="img-responsive" id="img_da"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#indomaret_collapse" class="accordion-toggle">Indomaret</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="indomaret_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="IR" id="ir"></td>
                                                                                <td><label for="ir"><img src="https://images.duitku.com/hotlink-ok/IR.PNG" class="img-responsive" id="img_ir"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-bs-toggle="collapse" data-bs-target="#link_collapse" class="accordion-toggle">LINK</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="hiddenRow">
                                                                <div class="collapse" id="link_collapse">
                                                                    <table class="table table-borderless">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="SL" id="sl"></td>
                                                                                <td><label for="sl"><img src="https://images.duitku.com/hotlink-ok/SHOPEEPAY.PNG" class="img-responsive" id="img_sl"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-middle"><input type="radio" name="paymentMethod" value="OL" id="ol"></td>
                                                                                <td><label for="ol"><img src="https://images.duitku.com/hotlink-ok/OV.PNG" class="img-responsive" id="img_ol"></label></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <br>

                        <div class="form-group mb-3 @if ($errors->has('description')) has-error @endif">
                            <label for="description" class="control-label">{{ __('Order notes') }}</label>
                            <br>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="{{ __('Notes about your order, e.g. special notes for delivery.') }}">{{ old('description') }}</textarea>
                            {!! Form::error('description', $errors) !!}
                        </div>

                        @if (EcommerceHelper::getMinimumOrderAmount() > Cart::instance('cart')->rawSubTotal())
                            <div class="alert alert-warning">
                                {{ __('Minimum order amount is :amount, you need to buy more :more to place an order!', ['amount' => format_price(EcommerceHelper::getMinimumOrderAmount()), 'more' => format_price(EcommerceHelper::getMinimumOrderAmount() - Cart::instance('cart')->rawSubTotal())]) }}
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6 d-none d-md-block" style="line-height: 53px">
                                    <a class="text-info" href="{{ route('public.cart') }}"><i class="fas fa-long-arrow-alt-left"></i> <span class="d-inline-block back-to-cart">{{ __('Back to cart') }}</span></a>
                                </div>
                                <div class="col-md-6 checkout-button-group">
                                    <button type="submit" @if (EcommerceHelper::getMinimumOrderAmount() > Cart::instance('cart')->rawSubTotal()) disabled @endif class="btn payment-checkout-btn payment-checkout-btn-step float-end" data-processing-text="{{ __('Processing. Please wait...') }}" data-error-header="{{ __('Error') }}">
                                        {{ __('Checkout') }}
                                    </button>
                                </div>
                            </div>
                            <div class="d-block d-md-none back-to-cart-button-group">
                                <a class="text-info" href="{{ route('public.cart') }}"><i class="fas fa-long-arrow-alt-left"></i> <span class="d-inline-block">{{ __('Back to cart') }}</span></a>
                            </div>
                        </div>

                    </div> <!-- /form checkout -->
                </div>
            </div>
        </div>

        @include('plugins/payment::partials.footer')
    @else
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning my-5">
                        <span>{!! __('No products in cart. :link!', ['link' => Html::link(route('public.index'), __('Back to shopping'))]) !!}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@push('footer')
    <script>
        var TOKEN = "{{$token}}";
        $(document).ready(function(){
            $.ajax({
                url: "{{ route('public.checkout.get-payment-method', "+TOKEN+") }}",
                dataType: "json",
                success: function(data)
                {
                    // $.each(data.paymentFee, function(key, value){
                    //     $('#paymentMethod').append('<option value="' + value.paymentMethod + '">' + value.paymentName + '</option>');
                    // });

                    // $.each(data.paymentFee, function(key, value){
                    //     if(value.paymentMethod == 'VA')
                    //     {
                    //         $('#img_va').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'BT')
                    //     {
                    //         $('#img_bt').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'B1')
                    //     {
                    //         $('#img_b1').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'A1')
                    //     {
                    //         $('#img_a1').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'I1')
                    //     {
                    //         $('#img_i1').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'M1')
                    //     {
                    //         $('#img_m1').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'M2')
                    //     {
                    //         $('#img_m2').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'AG')
                    //     {
                    //         $('#img_ag').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'BC')
                    //     {
                    //         $('#img_bc').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'BR')
                    //     {
                    //         $('#img_br').attr('src', value.paymentImage);
                    //     }

                    //     if(value.paymentMethod == 'NC')
                    //     {
                    //         $('#img_nc').attr('src', value.paymentImage);
                    //     }
                    // });
                }
            });
        });
    </script>
@endpush
