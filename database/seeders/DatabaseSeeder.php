<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Locations
        $locPusat = Location::create(['name' => 'Gudang Pusat', 'address' => 'Jl. Pusat No. 1', 'is_active' => true]);
        $locCabang1 = Location::create(['name' => 'Cabang Jakarta', 'address' => 'Jl. Jakarta No. 10', 'is_active' => true]);

        // 2. Create Users
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $staffCabang1 = User::create([
            'name' => 'Staff Jakarta',
            'email' => 'staff1@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'location_id' => $locCabang1->id,
        ]);

        // 3. Create Categories
        $catElektronik = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Barang elektronik']);
        $catFurniture = Category::create(['name' => 'Furniture', 'slug' => 'furniture', 'description' => 'Perabotan kantor']);

        // 4. Create Suppliers
        $supA = Supplier::create(['name' => 'PT. Sumber Makmur', 'contact_person' => 'Budi', 'phone' => '08123456789']);

        // 5. Create Products
        $laptop = Product::create([
            'category_id' => $catElektronik->id,
            'sku' => 'ELK-LAP-001',
            'name' => 'Laptop Asus ROG',
            'unit' => 'pcs',
            'min_stock_level' => 5,
            'price' => 15000000,
        ]);

        $meja = Product::create([
            'category_id' => $catFurniture->id,
            'sku' => 'FURN-MJ-001',
            'name' => 'Meja Kerja Minimalis',
            'unit' => 'pcs',
            'min_stock_level' => 10,
            'price' => 1200000,
        ]);

        // 6. Create Product Stocks & Movements
        // Stock In untuk Laptop di Pusat
        ProductStock::create([
            'product_id' => $laptop->id,
            'location_id' => $locPusat->id,
            'quantity' => 20,
        ]);
        StockMovement::create([
            'product_id' => $laptop->id,
            'location_id' => $locPusat->id,
            'user_id' => $admin->id,
            'type' => 'in',
            'quantity' => 20,
            'reference_number' => 'PO-2026-001',
            'notes' => 'Initial stock dari PT. Sumber Makmur',
        ]);

        // Stock In untuk Meja di Cabang 1
        ProductStock::create([
            'product_id' => $meja->id,
            'location_id' => $locCabang1->id,
            'quantity' => 15,
        ]);
        StockMovement::create([
            'product_id' => $meja->id,
            'location_id' => $locCabang1->id,
            'user_id' => $admin->id,
            'type' => 'in',
            'quantity' => 15,
            'reference_number' => 'PO-2026-002',
            'notes' => 'Initial stock',
        ]);
    }
}
