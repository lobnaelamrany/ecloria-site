<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductReturn;
use App\Models\Promotion;
use App\Models\Purchase;
use App\Models\ReturnItem;
use App\Models\Review;
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
        // ==========================================
        // 1. Users (Admin, Employees, Clients)
        // ==========================================
        $admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@ecloria.ma',
            'phone' => '+212600000000',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $employees = [
            ['first_name' => 'Youssef', 'last_name' => 'Alami', 'email' => 'employe1@ecloria.ma', 'phone' => '+212611111111'],
            ['first_name' => 'Fatima', 'last_name' => 'Zahra', 'email' => 'employe2@ecloria.ma', 'phone' => '+212622222222'],
        ];

        foreach ($employees as $emp) {
            User::create([
                'first_name' => $emp['first_name'],
                'last_name' => $emp['last_name'],
                'email' => $emp['email'],
                'phone' => $emp['phone'],
                'password' => Hash::make('password'),
                'role' => 'employee',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        $clients = [
            ['first_name' => 'Sara', 'last_name' => 'El Amrani', 'email' => 'sara@test.ma', 'phone' => '+212633333333', 'city' => 'Casablanca'],
            ['first_name' => 'Ali', 'last_name' => 'Alaoui', 'email' => 'ali@test.ma', 'phone' => '+212644444444', 'city' => 'Rabat'],
            ['first_name' => 'Meryem', 'last_name' => 'Bennani', 'email' => 'meryem@test.ma', 'phone' => '+212655555555', 'city' => 'Marrakech'],
        ];

        $clientModels = [];
        foreach ($clients as $client) {
            $clientModels[] = User::create([
                'first_name' => $client['first_name'],
                'last_name' => $client['last_name'],
                'email' => $client['email'],
                'phone' => $client['phone'],
                'password' => Hash::make('password'),
                'role' => 'client',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        // ==========================================
        // 2. Categories
        // ==========================================
        $categories = [
            ['name_fr' => 'Soins du visage', 'name_en' => 'Skincare', 'description_fr' => 'Sérums, crèmes et nettoyants.', 'image' => 'categories/soins-visage.jpg'],
            ['name_fr' => 'Maquillage', 'name_en' => 'Makeup', 'description_fr' => 'Rouges à lèvres, palettes et mascaras.', 'image' => 'categories/maquillage.jpg'],
            ['name_fr' => 'Soins capillaires', 'name_en' => 'Haircare', 'description_fr' => 'Shampoings et masques.', 'image' => 'categories/soins-capillaires.jpg'],
            ['name_fr' => 'Parfums & Corps', 'name_en' => 'Fragrances & Body', 'description_fr' => 'Parfums et soins corporels.', 'image' => 'categories/parfums-corps.jpg'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::create([
                'name_fr' => $cat['name_fr'],
                'name_en' => $cat['name_en'],
                'slug' => Str::slug($cat['name_fr']),
                'description_fr' => $cat['description_fr'],
                'image' => $cat['image'],
                'is_active' => true,
            ]);
        }

        // ==========================================
        // 3. Brands
        // ==========================================
        $brands = [
            ['name' => 'Écloria Signature', 'description' => 'Notre marque exclusive.', 'logo' => 'brands/ecloria-signature.png'],
            ['name' => 'Lumière', 'description' => 'Soins de luxe.', 'logo' => 'brands/lumiere.png'],
            ['name' => 'Botanica', 'description' => 'Ingrédients naturels.', 'logo' => 'brands/botanica.png'],
            ['name' => 'Noor', 'description' => 'Parfums du Maroc.', 'logo' => 'brands/noor.png'],
        ];

        $brandModels = [];
        foreach ($brands as $brand) {
            $brandModels[] = Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'description' => $brand['description'],
                'logo' => $brand['logo'],
                'is_active' => true,
            ]);
        }

        // ==========================================
        // 4. Products
        // ==========================================
        $products = [
            ['category' => 0, 'brand' => 0, 'name' => 'Sérum Éclat Vitamine C', 'desc' => 'Un sérum concentré pour un teint lumineux.', 'price' => 289, 'stock' => 50, 'image' => 'products/serum-vitamine-c.jpg'],
            ['category' => 0, 'brand' => 1, 'name' => 'Crème Hydratante Riche', 'desc' => 'Crème nourrissante pour les peaux sèches.', 'price' => 195, 'stock' => 40, 'image' => 'products/creme-hydratante.jpg'],
            ['category' => 0, 'brand' => 2, 'name' => 'Nettoyant Doux Aloe Vera', 'desc' => 'Nettoie en douceur sans agresser.', 'price' => 120, 'stock' => 60, 'image' => 'products/nettoyant-aloe.jpg'],
            ['category' => 1, 'brand' => 0, 'name' => 'Rouge à Lèvres Mat', 'desc' => 'Couleur intense, tenue longue durée.', 'price' => 149, 'stock' => 35, 'image' => 'products/rouge-a-levres.jpg'],
            ['category' => 1, 'brand' => 1, 'name' => 'Palette Fards à Paupières', 'desc' => '12 teintes nude et rosées.', 'price' => 259, 'stock' => 20, 'image' => 'products/palette-fards.jpg'],
            ['category' => 1, 'brand' => 0, 'name' => 'Mascara Volume', 'desc' => 'Volume intense dès la première application.', 'price' => 99, 'stock' => 80, 'image' => 'products/mascara-volume.jpg'],
            ['category' => 2, 'brand' => 2, 'name' => 'Shampooing Argan & Kératine', 'desc' => 'Répare et fortifie les cheveux abîmés.', 'price' => 85, 'stock' => 70, 'image' => 'products/shampooing-argan.jpg'],
            ['category' => 2, 'brand' => 1, 'name' => 'Masque Capillaire Nutrition', 'desc' => 'Nutrition intense pour des cheveux doux.', 'price' => 135, 'stock' => 45, 'image' => 'products/masque-capillaire.jpg'],
            ['category' => 3, 'brand' => 3, 'name' => 'Eau de Parfum Rose & Oud', 'desc' => 'Parfum envoûtant aux notes orientales.', 'price' => 450, 'stock' => 25, 'image' => 'products/parfum-rose-oud.jpg'],
            ['category' => 3, 'brand' => 2, 'name' => 'Lait Corporel Hydratant', 'desc' => 'Hydratation 24h pour une peau douce.', 'price' => 110, 'stock' => 55, 'image' => 'products/lait-corporel.jpg'],
        ];

        $productModels = [];
        foreach ($products as $index => $item) {
            $product = Product::create([
                'category_id' => $categoryModels[$item['category']]->id,
                'brand_id' => $brandModels[$item['brand']]->id,
                'sku' => 'ECL-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'name_fr' => $item['name'],
                'slug' => Str::slug($item['name']) . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'description_fr' => $item['desc'],
                'price' => $item['price'],
                'stock_quantity' => $item['stock'],
                'low_stock_threshold' => 10,
                'image' => $item['image'],
                'is_active' => true,
            ]);
            $productModels[] = $product;

            // Batch
            ProductBatch::create([
                'product_id' => $product->id,
                'batch_number' => 'INIT-' . $product->sku,
                'expiry_date' => now()->addYear(),
                'quantity_received' => $item['stock'],
                'quantity_remaining' => $item['stock'],
                'received_at' => now(),
            ]);
        }

        // ==========================================
        // 5. Promotions
        // ==========================================
        $promo1 = Promotion::create([
            'title' => 'Promo Skincare -20%',
            'description' => 'Profitez de -20% sur tous les soins du visage.',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDays(30),
            'is_active' => true,
            'created_by' => $admin->id,
        ]);
        $promo1->products()->syncWithPivotValues([$productModels[0]->id, $productModels[1]->id, $productModels[2]->id], ['created_at' => now()]);

        $promo2 = Promotion::create([
            'title' => 'Offre Maquillage -50 DH',
            'description' => 'Remise de 50 DH sur une sélection de maquillage.',
            'discount_type' => 'fixed',
            'discount_value' => 50,
            'starts_at' => now(),
            'ends_at' => now()->addDays(15),
            'is_active' => true,
            'created_by' => $admin->id,
        ]);
        $promo2->products()->syncWithPivotValues([$productModels[3]->id, $productModels[4]->id, $productModels[5]->id], ['created_at' => now()]);

        // ==========================================
        // 6. Orders + Payments + Reviews
        // ==========================================
        $sara = $clientModels[0];
        $ali = $clientModels[1];

        // Order 1 (Sara - Delivered)
        $order1 = Order::create([
            'order_number' => 'ORD-' . now()->format('Ymd') . '-0001',
            'user_id' => $sara->id,
            'order_status' => 'delivered',
            'delivery_method' => 'delivery',
            'customer_name' => $sara->full_name,
            'customer_phone' => $sara->phone,
            'shipping_city' => 'Casablanca',
            'shipping_address' => '123 Rue Test',
            'subtotal' => 289,
            'discount_amount' => 0,
            'shipping_fee' => 30,
            'total_amount' => 319,
            'delivered_at' => now()->subDays(2),
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $productModels[0]->id,
            'product_name' => $productModels[0]->name_fr,
            'product_sku' => $productModels[0]->sku,
            'unit_price' => 289,
            'quantity' => 1,
            'line_total' => 289,
        ]);
        Payment::create([
            'order_id' => $order1->id,
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'paid',
            'amount' => 319,
            'paid_at' => now()->subDays(2),
            'received_by' => $admin->id,
        ]);
        Review::create([
            'user_id' => $sara->id,
            'product_id' => $productModels[0]->id,
            'order_item_id' => $order1->items->first()->id,
            'rating' => 5,
            'comment' => 'Produit excellent, je recommande !',
            'is_visible' => true,
        ]);

        // Order 2 (Ali - Delivered)
        $order2 = Order::create([
            'order_number' => 'ORD-' . now()->format('Ymd') . '-0002',
            'user_id' => $ali->id,
            'order_status' => 'delivered',
            'delivery_method' => 'store_pickup',
            'customer_name' => $ali->full_name,
            'customer_phone' => $ali->phone,
            'shipping_city' => 'Rabat',
            'subtotal' => 149,
            'discount_amount' => 0,
            'shipping_fee' => 0,
            'total_amount' => 149,
            'delivered_at' => now()->subDay(),
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $productModels[3]->id,
            'product_name' => $productModels[3]->name_fr,
            'product_sku' => $productModels[3]->sku,
            'unit_price' => 149,
            'quantity' => 1,
            'line_total' => 149,
        ]);
        Payment::create([
            'order_id' => $order2->id,
            'payment_method' => 'payment_at_store',
            'payment_status' => 'paid',
            'amount' => 149,
            'paid_at' => now()->subDay(),
            'received_by' => $admin->id,
        ]);
        Review::create([
            'user_id' => $ali->id,
            'product_id' => $productModels[3]->id,
            'order_item_id' => $order2->items->first()->id,
            'rating' => 4,
            'comment' => 'Très bon rouge à lèvres.',
            'is_visible' => true,
        ]);

        // Order 3 (Meryem - Pending)
        $order3 = Order::create([
            'order_number' => 'ORD-' . now()->format('Ymd') . '-0003',
            'user_id' => $clientModels[2]->id,
            'order_status' => 'pending',
            'delivery_method' => 'delivery',
            'customer_name' => $clientModels[2]->full_name,
            'customer_phone' => $clientModels[2]->phone,
            'shipping_city' => 'Marrakech',
            'shipping_address' => '45 Avenue Test',
            'subtotal' => 450,
            'discount_amount' => 0,
            'shipping_fee' => 30,
            'total_amount' => 480,
        ]);
        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $productModels[8]->id,
            'product_name' => $productModels[8]->name_fr,
            'product_sku' => $productModels[8]->sku,
            'unit_price' => 450,
            'quantity' => 1,
            'line_total' => 450,
        ]);
        Payment::create([
            'order_id' => $order3->id,
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'pending',
            'amount' => 480,
        ]);

        // ==========================================
        // 7. Returns + Complaints
        // ==========================================
        $return = ProductReturn::create([
            'return_number' => 'RET-' . now()->format('Ymd') . '-0001',
            'order_id' => $order1->id,
            'user_id' => $sara->id,
            'return_status' => 'requested',
            'reason' => 'Le produit ne me convient pas.',
        ]);
        ReturnItem::create([
            'return_id' => $return->id,
            'order_item_id' => $order1->items->first()->id,
            'quantity' => 1,
            'item_condition' => 'unopened',
            'restockable' => true,
            'refund_amount' => 289,
        ]);

        Complaint::create([
            'user_id' => $ali->id,
            'order_id' => $order2->id,
            'subject' => 'Problème de livraison',
            'message' => 'Ma commande est arrivée en retard.',
            'status' => 'open',
        ]);

        // ==========================================
        // 8. Suppliers & Purchases
        // ==========================================
        $suppliers = [
            ['name' => 'Maroc Cosmétiques', 'contact_person' => 'Hassan Benali', 'email' => 'contact@maroccosmetiques.ma', 'phone' => '+212522123456', 'address' => '123 Bd Zerktouni', 'city' => 'Casablanca'],
            ['name' => 'Beauty Distribution SARL', 'contact_person' => 'Salma Tazi', 'email' => 'info@beautydist.ma', 'phone' => '+212537654321', 'address' => '45 Avenue Mohammed V', 'city' => 'Rabat'],
        ];

        $supplierModels = [];
        foreach ($suppliers as $sup) {
            $supplierModels[] = Supplier::create([
                'name' => $sup['name'],
                'contact_person' => $sup['contact_person'],
                'email' => $sup['email'],
                'phone' => $sup['phone'],
                'address' => $sup['address'],
                'city' => $sup['city'],
                'is_active' => true,
            ]);
        }

        // Purchase 1
        $purchase = Purchase::create([
            'purchase_number' => 'PUR-' . now()->format('Ymd') . '-0001',
            'supplier_id' => $supplierModels[0]->id,
            'created_by' => $admin->id,
            'purchase_status' => 'received',
            'purchase_date' => now()->subDays(5),
            'received_at' => now()->subDays(4),
            'total_cost' => 1000,
        ]);

        $purchaseItem = $purchase->items()->create([
            'product_id' => $productModels[0]->id,
            'quantity_ordered' => 10,
            'quantity_received' => 10,
            'unit_cost' => 100,
            'line_total' => 1000,
        ]);

        $purchaseBatch = ProductBatch::create([
            'product_id' => $productModels[0]->id,
            'purchase_item_id' => $purchaseItem->id,
            'batch_number' => 'BATCH-PUR-001',
            'expiry_date' => now()->addMonths(18),
            'quantity_received' => 10,
            'quantity_remaining' => 10,
            'received_at' => now()->subDays(4),
        ]);

        StockMovement::create([
            'product_id' => $productModels[0]->id,
            'product_batch_id' => $purchaseBatch->id,
            'purchase_item_id' => $purchaseItem->id,
            'movement_type' => 'purchase',
            'direction' => 'in',
            'quantity' => 10,
            'created_by' => $admin->id,
            'notes' => 'Achat ' . $purchase->purchase_number,
        ]);
    }
}
