public function uploadProof(Request $request, $id)
{
    $order = Order::findOrFail($id);

    // Hanya izinkan upload jika masih UNPAID
    if ($order->payment_status !== 'unpaid') {
        return redirect()
            ->route('order.success', $order->id)
            ->with('success', 'Pembayaran Anda sudah diproses. Tidak perlu mengirim bukti lagi.');
    }

    // Validasi Foto
    $request->validate([
        'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:10240', // Maksimal 10MB
    ]);

    // Hapus bukti lama jika ada (opsional)
    if ($order->payment_proof && file_exists(public_path('uploads/proofs/' . $order->payment_proof))) {
        @unlink(public_path('uploads/proofs/' . $order->payment_proof));
    }

    // Proses Upload File
    if ($request->hasFile('payment_proof')) {
        $image = $request->file('payment_proof');
        $imageName = 'proof_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/proofs'), $imageName);

        // Simpan nama file ke database
        $order->update([
            'payment_proof' => $imageName,
            // Status tetap 'pending', admin yang mengubah ke 'paid'
        ]);
    }

    return redirect()
        ->route('order.success', $order->id)
        ->with('success', 'Anda sudah mengirim bukti pembayaran. Silakan tunggu pesanan diproses oleh toko.');
}