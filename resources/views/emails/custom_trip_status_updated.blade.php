<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Custom Trip Anda Diperbarui</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang elegan */
            font-family: 'Roboto', Arial, sans-serif;
            color: #333;
        }
        .email-container {
            max-width: 500px; /* Ukuran lebih kecil */
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
            overflow: hidden;
        }
        .email-header {
            background-color: #0056b3;
            color: #fff;
            text-align: center;
            padding: 20px 15px;
        }
        .email-header img {
            max-width: 140px;
            margin-bottom: 10px;
        }
        .email-header h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        .email-body {
            padding: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-accepted {
            background-color: #17a2b8;
            color: white;
        }
        .status-rejected {
            background-color: #dc3545;
            color: white;
        }
        .details {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        .details p {
            margin: 0 0 8px;
            font-size: 14px;
            line-height: 1.6;
        }
        .details p strong {
            color: #000;
        }
        .cta {
            text-align: center;
            margin-top: 25px;
        }
        .cta a {
            background-color: #0056b3;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .cta a:hover {
            background-color: #004494;
            transform: translateY(-2px);
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #0056b3;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="https://via.placeholder.com/140x40?text=Your+Logo" alt="Logo Perusahaan">
            <h1>Status Custom Trip Anda Diperbarui</h1>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <div class="text-center mb-3">
                <!-- Status Badge -->
                <?php if ($status === 'Diterima'): ?>
                    <span class="status-badge status-accepted">Status: Diterima</span>
                <?php elseif ($status === 'Ditolak'): ?>
                    <span class="status-badge status-rejected">Status: Ditolak</span>
                <?php endif; ?>
            </div>
            
            <div class="details">
                <p><strong>Nama Pemesan:</strong> {{ $customTrip->nama_pemesan }}</p>
                <p><strong>Trip:</strong> {{ $customTrip->judul_trip }}</p>
                <p><strong>Jumlah Peserta:</strong> {{ $customTrip->jumlah_peserta }} Orang</p>
                <p><strong>Tanggal Mulai:</strong> {{ $customTrip->start_date }}</p>
                <p><strong>Tanggal Selesai:</strong> {{ $customTrip->end_date }}</p>
            </div>
            
            <div class="cta">
                <?php if ($status === 'Diterima'): ?>
                    <p class="mb-3">Untuk informasi lebih lanjut, silakan hubungi kami:</p>
                    <a href="https://wa.me/6289678904782" target="_blank">Hubungi Kami di WhatsApp</a>
                <?php elseif ($status === 'Ditolak'): ?>
                    <p class="mb-3">Mohon maaf, Custom Trip Anda tidak dapat kami proses saat ini.</p>
                    <p class="mb-3">Silakan hubungi kami untuk informasi lebih lanjut.</p>
                    <a href="https://wa.me/6289678904782" target="_blank">Hubungi Kami di WhatsApp</a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah memilih layanan kami!</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di:</p>
            <p><a href="mailto:info@customtrip.com">info@customtrip.com</a></p>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
