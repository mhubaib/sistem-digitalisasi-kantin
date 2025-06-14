<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.fonnte.api_key');
        $this->baseUrl = 'https://api.fonnte.com/send';
    }

    /**
     * Kirim pesan WhatsApp
     *
     * @param string $phone Nomor telepon penerima (format: 628xxxxxxxxxx)
     * @param string $message Pesan yang akan dikirim
     * @return array
     */
    public function sendMessage($phone, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->post($this->baseUrl, [
                'target' => $phone,
                'message' => $message
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp notification sent successfully', [
                    'phone' => $phone,
                    'response' => $response->json()
                ]);
                return [
                    'success' => true,
                    'message' => 'Pesan WhatsApp berhasil dikirim'
                ];
            }

            Log::error('Failed to send WhatsApp notification', [
                'phone' => $phone,
                'response' => $response->json()
            ]);
            return [
                'success' => false,
                'message' => 'Gagal mengirim pesan WhatsApp'
            ];
        } catch (\Exception $e) {
            Log::error('Error sending WhatsApp notification', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pesan WhatsApp'
            ];
        }
    }

    /**
     * Kirim notifikasi transaksi
     *
     * @param object $transaction Data transaksi
     * @param object $santri Data santri (opsional)
     * @return array
     */
    public function sendTransactionNotification($transaction, $santri = null)
    {
        $message = "🔔 *Notifikasi Transaksi Baru*\n\n";
        $message .= "ID Transaksi: #" . str_pad($transaction->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "Tanggal: " . $transaction->created_at->format('d/m/Y H:i') . "\n";
        $message .= "Total: Rp " . number_format($transaction->total, 0, ',', '.') . "\n";
        $message .= "Metode Pembayaran: " . ($transaction->payment_type === 'saldo' ? 'Saldo Digital' : 'Tunai') . "\n\n";

        if ($santri) {
            $message .= "Pembeli: " . $santri->name . "\n";
            $message .= "Saldo Terakhir: Rp " . number_format($santri->saldo, 0, ',', '.') . "\n\n";
        }

        $message .= "Detail Produk:\n";
        foreach ($transaction->items as $item) {
            $message .= "- " . $item->product->name . " (x" . $item->quantity . ")\n";
        }

        // Kirim ke admin
        $adminPhone = config('services.fonnte.admin_phone');
        return $this->sendMessage($adminPhone, $message);
    }

    /**
     * Kirim notifikasi saldo
     *
     * @param object $santri Data santri
     * @param float $amount Jumlah perubahan saldo
     * @param string $type Tipe transaksi (credit/debit)
     * @return array
     */
    public function sendBalanceNotification($santri, $amount, $type)
    {
        $message = "💰 *Notifikasi Saldo*\n\n";
        $message .= "Halo " . $santri->name . ",\n\n";

        if ($type === 'credit') {
            $message .= "Saldo Anda telah ditambahkan sebesar:\n";
            $message .= "Rp " . number_format($amount, 0, ',', '.') . "\n\n";
        } else {
            $message .= "Saldo Anda telah dikurangi sebesar:\n";
            $message .= "Rp " . number_format($amount, 0, ',', '.') . "\n\n";
        }

        $message .= "Saldo Terakhir:\n";
        $message .= "Rp " . number_format($santri->saldo, 0, ',', '.') . "\n\n";
        $message .= "Terima kasih telah menggunakan layanan kami.";

        return $this->sendMessage($santri->phone, $message);
    }
}
