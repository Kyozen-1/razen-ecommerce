<?php

namespace Botble\Payment\Enums;

use Botble\Base\Supports\Enum;

/**
 * @method static PaymentMethodEnum COD()
 * @method static PaymentMethodEnum BANK_TRANSFER()
 */
class PaymentMethodEnum extends Enum
{
    public const COD = 'cod';
    public const BANK_TRANSFER = 'bank_transfer';
    public const CREDIT_CARD = 'credit_card';
    public const RETAIL = 'retail';
    public const OVO = 'ovo';
    public const QRIS = 'qris';
    public const INDODANA_PAYLATER = 'indodana_paylater';
    public const APP = 'app';
    public const DANA = 'dana';
    public const INDOMARET = 'indomaret';
    public const LINK = 'link';

    public static $langPath = 'plugins/payment::payment.methods';

    public function getServiceClass(): ?string
    {
        return apply_filters(PAYMENT_FILTER_GET_SERVICE_CLASS, null, $this->value);
    }
}
