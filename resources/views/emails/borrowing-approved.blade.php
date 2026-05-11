<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; margin: 0; padding: 24px; }
  .container { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
  .header { background: linear-gradient(135deg, #1a1a2e, #0f3460); padding: 28px 32px; text-align: center; }
  .header h1 { color: #fff; font-size: 1.2rem; margin: 0; }
  .header p  { color: #a0b4cc; font-size: .85rem; margin: 6px 0 0; }
  .body { padding: 28px 32px; }
  .greeting { font-size: 1rem; color: #333; margin-bottom: 16px; }
  .status-badge {
    display: inline-block; padding: 6px 16px; border-radius: 20px;
    font-size: .85rem; font-weight: 700; margin-bottom: 20px;
    background: #d4edda; color: #155724;
  }
  .detail-box { background: #f8f9fa; border-radius: 8px; padding: 16px 20px; margin-bottom: 20px; }
  .detail-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #eee; font-size: .88rem; }
  .detail-row:last-child { border-bottom: none; }
  .detail-label { color: #666; }
  .detail-value { color: #333; font-weight: 600; }
  .footer { background: #f8f9fa; padding: 16px 32px; text-align: center; font-size: .78rem; color: #999; border-top: 1px solid #eee; }
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>🏢 Smart-Hub Management</h1>
    <p>Sistem Manajemen Peralatan</p>
  </div>
  <div class="body">
    <p class="greeting">Halo, <strong>{{ $checkIn->member->name }}</strong>!</p>

    @if($checkIn->check_in_type === 'borrow')
      <span class="status-badge">✅ Pengambilan Disetujui</span>
      <p style="color:#555;font-size:.9rem;margin-bottom:20px">
        Permintaan pengambilan peralatan Anda telah <strong>disetujui</strong> oleh admin.
        Silakan ambil peralatan sesuai jadwal yang telah ditentukan.
      </p>
    @else
      <span class="status-badge">✅ Pengembalian Dikonfirmasi</span>
      <p style="color:#555;font-size:.9rem;margin-bottom:20px">
        Pengembalian peralatan Anda telah <strong>dikonfirmasi</strong> oleh admin.
        Terima kasih telah mengembalikan peralatan tepat waktu.
      </p>
    @endif

    <div class="detail-box">
      <div class="detail-row">
        <span class="detail-label">Peralatan</span>
        <span class="detail-value">{{ $checkIn->equipment->name }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Kode</span>
        <span class="detail-value">{{ $checkIn->equipment->code }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Tanggal Pinjam</span>
        <span class="detail-value">{{ $checkIn->borrowingSchedule->borrow_date->format('d M Y') }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Tanggal Kembali</span>
        <span class="detail-value">{{ $checkIn->borrowingSchedule->return_date->format('d M Y') }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Disetujui Pada</span>
        <span class="detail-value">{{ $checkIn->approved_at->format('d M Y, H:i') }}</span>
      </div>
    </div>
  </div>
  <div class="footer">
    Email ini dikirim otomatis oleh sistem Smart-Hub. Jangan balas email ini.
  </div>
</div>
</body>
</html>
