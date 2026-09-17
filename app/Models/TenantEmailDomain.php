<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class TenantEmailDomain extends Model
{
    use CentralConnection;

    protected $table = 'tenant_email_domains';

    protected $fillable = [
        'tenant_id',
        'email_domain',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}