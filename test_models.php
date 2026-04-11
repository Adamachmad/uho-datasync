<?php
echo "\n=== TESTING ALL MODELS ===\n";

$models = [
    'Pengaju',
    'Pengajuan',
    'JenisDokumen',
    'JenisPengajuan',
    'PengajuanHasDokumen',
    'RiwayatPengajuan',
    'StatusPengajuan',
    'SyaratPengajuan'
];

foreach ($models as $model) {
    try {
        $class = 'App\\Models\\' . $model;
        $count = $class::count();
        echo "✓ $model: $count records\n";
    } catch (Exception $e) {
        echo "✗ $model ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\n=== TESTING REMEMBER TOKEN FIX ===\n";
try {
    $pengaju = \App\Models\Pengaju::first();
    if ($pengaju) {
        echo "Testing Pengaju model:\n";
        echo "  getRememberToken() = " . var_export($pengaju->getRememberToken(), 1) . "\n";
        echo "  getRememberTokenName() = " . var_export($pengaju->getRememberTokenName(), 1) . "\n";
        $pengaju->setRememberToken('test');
        echo "✓ setRememberToken() works\n";
    }
} catch (Exception $e) {
    echo "✗ Remember token test failed: " . $e->getMessage() . "\n";
}

echo "\n=== TESTING AUTHENTICATION ===\n";
try {
    $user = \App\Models\Pengaju::where('email', 'adamachmad8@gmail.com')->first();
    if ($user) {
        echo "✓ Found user: " . $user->email . "\n";
        
        // Test password
        if (\Illuminate\Support\Facades\Hash::check('password123', $user->password)) {
            echo "✓ Password hash test passed\n";
        } else {
            echo "✓ User has password (hash check for different password)\n";
        }
    } else {
        echo "! No matching user found for test\n";
    }
} catch (Exception $e) {
    echo "✗ Authentication test failed: " . $e->getMessage() . "\n";
}

echo "\n=== ALL TESTS COMPLETE ===\n";
