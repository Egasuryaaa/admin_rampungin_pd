<?php

namespace App\HTTP;

use CodeIgniter\HTTP\IncomingRequest as BaseIncomingRequest;

/**
 * Extended IncomingRequest to allow dynamic properties
 * This prevents PHP 8.2+ deprecation warnings when filters add properties
 */
#[\AllowDynamicProperties]
class IncomingRequest extends BaseIncomingRequest
{
    // No need to override anything, just allow dynamic properties
}
