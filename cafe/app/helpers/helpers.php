<?php

if (!function_exists('generate_order_code')) {
    function generate_order_code()
    {
        $date = date('ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        return "ORD-{$date}-{$random}";
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('calculate_service_fee')) {
    function calculate_service_fee($subtotal, $percentage = 5)
    {
        return $subtotal * ($percentage / 100);
    }
}

if (!function_exists('log_activity')) {
    function log_activity($action, $description)
    {
        if (auth()->check()) {
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
}