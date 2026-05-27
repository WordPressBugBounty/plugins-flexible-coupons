<?php

namespace FlexibleCouponsVendor\Mpdf\Http;

use FlexibleCouponsVendor\Psr\Http\Message\RequestInterface;
interface ClientInterface
{
    public function sendRequest(RequestInterface $request);
}
