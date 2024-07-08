
# Panduan Menghubungkan Fonnte dengan Laravel

## Langkah 1: Daftar ke Fonnte

1. **Daftar ke Fonnte**: 
   Daftar terlebih dahulu ke Fonnte melalui situs resminya.
   
2. **Terima Balasan Pendaftaran**: 
   Setelah mendaftar, Anda akan menerima balasan `registered` dari Fonnte.

3. **Login**: 
   Login dengan user ID dan password yang diberikan oleh pihak Fonnte.

4. **Tambah Device**:
   Kaitkan WhatsApp Anda ke Fonnte dengan cara menambah device (`Add Device`) di dashboard Fonnte.

## Langkah 2: Konfigurasi Laravel

1. **Tambahkan Token di .env**:
   Dapatkan token Fonnte dan tambahkan ke file `.env` di Laravel.

   ```env
   FONNTE_API_KEY="token_fonnte"
   ```

## Langkah 3: Membuat Service Fonnte

1. **Buat Folder Services**:
   Buat folder `Services` di dalam folder `app`.

   ```bash
   mkdir app/Services
   ```

2. **Buat File FonnteService.php**:
   Buat file `FonnteService.php` di dalam folder `Services` dan isi dengan kode berikut:

   ```php
   <?php

   namespace App\Services;

   use GuzzleHttp\Client;

   class FonnteService
   {
       protected $client;
       protected $apiKey;

       public function __construct()
       {
           $this->client = new Client();
           $this->apiKey = env('FONNTE_API_KEY');
       }

       public function sendMessage($to, $message)
       {
           $response = $this->client->post('https://api.fonnte.com/send', [
               'headers' => [
                   'Authorization' => $this->apiKey,
                   'Content-Type' => 'application/json',
               ],
               'json' => [
                   'target' => $to,
                   'message' => $message,
               ],
           ]);

           return json_decode($response->getBody(), true);
       }
   }
   ```

## Langkah 4: Daftarkan Service

1. **Edit AppServiceProvider**:
   Daftarkan service di `AppServiceProvider.php` yang terletak di `app/Providers`. Tambahkan kode berikut di dalam metode `register`:

   ```php
   <?php

   namespace App\Providers;

   use Illuminate\Support\ServiceProvider;
   use App\Services\FonnteService;

   class AppServiceProvider extends ServiceProvider
   {
       public function register()
       {
           $this->app->singleton(FonnteService::class, function ($app) {
               return new FonnteService();
           });
       }
   }
   ```

## Langkah 5: Buat Controller

1. **Buat MessageController**:
   Buat controller `MessageController` dengan isi sebagai berikut:

   ```php
   <?php

   namespace App\Http\Controllers;

   use App\Models\User;
   use App\Services\FonnteService;
   use Illuminate\Http\Request;

   class MessageController extends Controller
   {
       protected $fonnte;

       public function __construct(FonnteService $fonnte)
       {
           $this->fonnte = $fonnte;
       }

       public function send()
       {
           $users = User::all();

           foreach ($users as $key => $user) {
               $to = $user->no_hp;
               $message = 'Halo selamat datang, ini hanya pesan testing';
               $response = $this->fonnte->sendMessage($to, $message);
               return response()->json($response);
           }
       }
   }
   ```

   > **Note**: Sesuaikan dengan tabel yang Anda gunakan.

## Langkah 6: Tambahkan Route

1. **Tambah Route untuk Mengirim Pesan**:
   Tambahkan route di `routes/web.php` untuk mengakses controller tersebut.

   ```php
   use App\Http\Controllers\MessageController;

   Route::post('/send-message', [MessageController::class, 'send']);
   ```

Dengan mengikuti langkah-langkah di atas, Anda akan dapat menghubungkan dan menggunakan layanan Fonnte untuk mengirim pesan WhatsApp melalui aplikasi Laravel Anda. Pastikan untuk menyesuaikan sesuai dengan struktur dan tabel di proyek Anda.
