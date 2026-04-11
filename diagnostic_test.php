<?php
/**
 * Diagnostic Testing Script for UHO-Datasync
 * Tests all critical functionality
 */

require __DIR__.'/bootstrap/app.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

echo "=== UHO-DATASYNC DIAGNOSTIC TEST ===\n\n";

// Test 1: Database Connection
echo "TEST 1: Database Connection\n";
try {
    DB::connection()->getPdo();
    echo "✓ Database connection successful\n";
} catch (\Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}

// Test 2: Check Pengaju Table Structure
echo "\nTEST 2: Pengaju Table Structure\n";
try {
    $columns = DB::select('DESCRIBE pengaju');
    echo "✓ Table exists with " . count($columns) . " columns\n";
    $columnNames = array_map(function($col) { return $col->Field; }, $columns);
    echo "  Columns: " . implode(', ', $columnNames) . "\n";
    
    // Check for required columns
    $requiredCols = ['id', 'email', 'password', 'nama_lengkap', 'nim', 'nik'];
    foreach ($requiredCols as $col) {
        if (in_array($col, $columnNames)) {
            echo "  ✓ Column '$col' exists\n";
        } else {
            echo "  ✗ MISSING Column '$col'\n";
        }
    }
} catch (\Exception $e) {
    echo "✗ Error checking table: " . $e->getMessage() . "\n";
}

// Test 3: Pengaju Model
echo "\nTEST 3: Pengaju Model\n";
try {
    $count = \App\Models\Pengaju::count();
    echo "✓ Model works - Found $count pengaju records\n";
} catch (\Exception $e) {
    echo "✗ Model error: " . $e->getMessage() . "\n";
}

// Test 4: Authentication (without remember)
echo "\nTEST 4: Authentication System\n";
try {
    $pengaju = \App\Models\Pengaju::where('email', 'test@example.com')->first();
    if ($pengaju) {
        echo "✓ Test user found: " . $pengaju->email . "\n";
        
        // Test password verification
        if (Hash::check('password123', $pengaju->password)) {
            echo "✓ Password verification works\n";
        } else {
            echo "✗ Password verification failed\n";
        }
        
        // Test remember token methods
        echo "\nTesting remember token overrides:\n";
        echo "  getRememberToken(): " . var_export($pengaju->getRememberToken(), true) . "\n";
        echo "  getRememberTokenName(): " . var_export($pengaju->getRememberTokenName(), true) . "\n";
        $pengaju->setRememberToken('test_token');
        echo "  ✓ setRememberToken() executed without error\n";
    } else {
        echo "✗ Test user not found\n";
    }
} catch (\Exception $e) {
    echo "✗ Authentication error: " . $e->getMessage() . "\n";
}

// Test 5: Routes
echo "\nTEST 5: Route Registration\n";
try {
    $routes = Route::getRoutes();
    $routeCount = count($routes);
    echo "✓ Routes loaded - Total: $routeCount routes\n";
    
    $criticalRoutes = ['home', 'login', 'daftar', 'identitas.store', 'dashboard'];
    foreach ($criticalRoutes as $routeName) {
        if (Route::has($routeName)) {
            echo "  ✓ Route '$routeName' exists\n";
        } else {
            echo "  ✗ MISSING Route '$routeName'\n";
        }
    }
} catch (\Exception $e) {
    echo "✗ Route error: " . $e->getMessage() . "\n";
}

// Test 6: Views
echo "\nTEST 6: View Files\n";
try {
    $viewPath = resource_path('views');
    $criticalViews = [
        'halaman_depan.blade.php',
        'register.blade.php',
        'auth/login.blade.php',
        'layouts/guest.blade.php'
    ];
    
    foreach ($criticalViews as $view) {
        $fullPath = $viewPath . '/' . $view;
        if (file_exists($fullPath)) {
            echo "  ✓ View '$view' exists\n";
        } else {
            echo "  ✗ MISSING View '$view'\n";
        }
    }
} catch (\Exception $e) {
    echo "✗ View error: " . $e->getMessage() . "\n";
}

// Test 7: Storage
echo "\nTEST 7: Storage & Logo\n";
try {
    $logoPath = storage_path('app/public/Logo-UHO-Normal-1.png');
    if (file_exists($logoPath)) {
        echo "✓ Logo file exists\n";
        echo "  Size: " . filesize($logoPath) . " bytes\n";
    } else {
        echo "✗ Logo file NOT found at: $logoPath\n";
    }
    
    // Check storage link
    if (is_link(public_path('storage'))) {
        echo "✓ Storage symlink exists\n";
    } else {
        echo "⚠ Storage symlink does not exist (run: php artisan storage:link)\n";
    }
} catch (\Exception $e) {
    echo "✗ Storage error: " . $e->getMessage() . "\n";
}

// Test 8: Configuration
echo "\nTEST 8: Configuration\n";
try {
    echo "  App Name: " . config('app.name') . "\n";
    echo "  App Debug: " . (config('app.debug') ? 'ON' : 'OFF') . "\n";
    echo "  Database: " . config('database.default') . "\n";
    echo "  DB Database: " . config('database.connections.mysql.database') . "\n";
    echo "✓ Configuration loaded successfully\n";
} catch (\Exception $e) {
    echo "✗ Config error: " . $e->getMessage() . "\n";
}

echo "\n=== DIAGNOSTIC TEST COMPLETE ===\n";
