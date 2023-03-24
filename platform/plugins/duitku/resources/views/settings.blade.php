@php $duitkuStatus = get_payment_setting('status', DUITKU_PAYMENT_METHOD_NAME); @endphp

<table class="table payment-method-item">
    <tbody>
    <tr class="border-pay-row">
        <td class="border-pay-col"><i class="fa fa-theme-payments"></i></td>
        <td style="width: 20%;">
            <img class="filter-black" src="{{ url('vendor/core/plugins/duitku/images/duitku.png') }}"
                    alt="DUITKU">
        </td>
        <td class="border-right">
            <ul>
                <li>
                    <a href="https://www.duitku.com/" target="_blank">DUITKU</a>
                    <p>Pelanggan dapat membeli produk dan membayar langsung menggunakan Visa, kartu kredit melalui Duitku</p>
                </li>
            </ul>
        </td>
    </tr>
    <tr class="bg-white">
        <td colspan="3">
            <div class="float-start" style="margin-top: 5px;">
                <div
                    class="payment-name-label-group @if (get_payment_setting('status', DUITKU_PAYMENT_METHOD_NAME) == 0) hidden @endif">
                    <span class="payment-note v-a-t">{{ trans('plugins/payment::payment.use') }}:</span> <label
                        class="ws-nm inline-display method-name-label">{{ get_payment_setting('name', DUITKU_PAYMENT_METHOD_NAME) }}</label>
                </div>
            </div>
            <div class="float-end">
                <a class="btn btn-secondary toggle-payment-item edit-payment-item-btn-trigger @if ($duitkuStatus == 0) hidden @endif">{{ trans('plugins/payment::payment.edit') }}</a>
                <a class="btn btn-secondary toggle-payment-item save-payment-item-btn-trigger @if ($duitkuStatus == 1) hidden @endif">{{ trans('plugins/payment::payment.settings') }}</a>
            </div>
        </td>
    </tr>
    <tr class="paypal-online-payment payment-content-item hidden">
        <td class="border-left" colspan="3">
            {!! Form::open() !!}
            {!! Form::hidden('type', DUITKU_PAYMENT_METHOD_NAME, ['class' => 'payment_type']) !!}
            <div class="row">
                <div class="col-sm-6">
                    <ul>
                        <li>
                            <label>{{ trans('plugins/payment::payment.configuration_instruction', ['name' => 'Duitku']) }}</label>
                        </li>
                        <li class="payment-note">
                            <p>{{ trans('plugins/payment::payment.configuration_requirement', ['name' => 'Duitku']) }}
                                :</p>
                            <ul class="m-md-l" style="list-style-type:decimal">
                                <li style="list-style-type:decimal">
                                    <a href="https://www.duitku.com/" target="_blank">
                                        Daftar dengan Duitku
                                    </a>
                                </li>
                                <li style="list-style-type:decimal">
                                    <p>Setelah pendaftaran di Duitku, Anda akan memiliki Public, Secret keys</p>
                                </li>
                                <li style="list-style-type:decimal">
                                    <p>Masukkan Public, Secret key ke dalam kotak di tangan kanan</p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <div class="well bg-white">
                        <div class="form-group mb-3">
                            <label class="text-title-field"
                                   for="duitku_name">{{ trans('plugins/payment::payment.method_name') }}</label>
                            <input type="text" class="next-input" name="payment_{{ DUITKU_PAYMENT_METHOD_NAME }}_name"
                                   id="duitku_name" data-counter="400"
                                   value="{{ get_payment_setting('name', DUITKU_PAYMENT_METHOD_NAME, __('Online payment via :name', ['name' => 'Duitku'])) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-title-field" for="payment_{{ DUITKU_PAYMENT_METHOD_NAME }}_description">{{ trans('core/base::forms.description') }}</label>
                            <textarea class="next-input" name="payment_{{ DUITKU_PAYMENT_METHOD_NAME }}_description" id="payment_{{ DUITKU_PAYMENT_METHOD_NAME }}_description">{{ get_payment_setting('description', DUITKU_PAYMENT_METHOD_NAME, __('Payment with Duitku')) }}</textarea>
                        </div>

                        <p class="payment-note">
                            {{ trans('plugins/payment::payment.please_provide_information') }} <a target="_blank" href="https://www.duitku.com/">Duitku</a>:
                        </p>
                        <div class="form-group mb-3">
                            <label class="text-title-field" for="duitku_key">{{ __('Key') }}</label>
                            <input type="text" class="next-input"
                                   name="payment_{{ DUITKU_PAYMENT_METHOD_NAME }}_key" id="duitku_key"
                                   value="{{ get_payment_setting('key', DUITKU_PAYMENT_METHOD_NAME) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-title-field" for="duitku_secret">{{ __('Secret') }}</label>
                            <input type="password" class="next-input" id="duitku_secret"
                                   name="payment_{{ DUITKU_PAYMENT_METHOD_NAME }}_secret"
                                   value="{{ get_payment_setting('secret', DUITKU_PAYMENT_METHOD_NAME) }}">
                        </div>

                        {!! apply_filters(PAYMENT_METHOD_SETTINGS_CONTENT, null, DUITKU_PAYMENT_METHOD_NAME) !!}
                    </div>
                </div>
            </div>
            <div class="col-12 bg-white text-end">
                <button class="btn btn-warning disable-payment-item @if ($duitkuStatus == 0) hidden @endif"
                        type="button">{{ trans('plugins/payment::payment.deactivate') }}</button>
                <button
                    class="btn btn-info save-payment-item btn-text-trigger-save @if ($duitkuStatus == 1) hidden @endif"
                    type="button">{{ trans('plugins/payment::payment.activate') }}</button>
                <button
                    class="btn btn-info save-payment-item btn-text-trigger-update @if ($duitkuStatus == 0) hidden @endif"
                    type="button">{{ trans('plugins/payment::payment.update') }}</button>
            </div>
            {!! Form::close() !!}
        </td>
    </tr>
    </tbody>
</table>
