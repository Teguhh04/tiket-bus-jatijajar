<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket JATIJAJAR - {{ $booking->ticket_code }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .ticket-container {
            max-w: 800px;
            margin: 0 auto;
            border: 2px solid #e2e8f0;
            border-radius: 24px;
            overflow: hidden;
            background-color: #ffffff;
        }

        /* Top Header Brand */
        .ticket-header {
            background-color: #1e2a78;
            color: #ffffff;
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-name {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -0.025em;
        }
        .brand-sub {
            font-size: 9px;
            letter-spacing: 0.2em;
            font-weight: 700;
            color: #93c5fd;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .voucher-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background-color: #22c55e;
            padding: 6px 16px;
            border-radius: 12px;
            color: #ffffff;
        }

        /* Operator and Code bar */
        .ticket-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px;
            border-bottom: 2px dashed #e2e8f0;
            background-color: #f8fafc;
        }
        .operator-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .operator-logo {
            width: 50px;
            height: 50px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .operator-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .operator-text .name {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }
        .operator-text .class {
            font-size: 11px;
            font-weight: 600;
            color: #f5a623;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .booking-code {
            text-align: right;
        }
        .booking-code .label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .booking-code .code {
            font-size: 24px;
            font-weight: 900;
            color: #1e2a78;
            letter-spacing: 0.05em;
            font-family: monospace;
            margin-top: 2px;
        }

        /* Two columns: details & QR */
        .ticket-body {
            display: flex;
            padding: 32px;
            gap: 32px;
        }
        .ticket-details {
            flex: 1;
        }
        .ticket-qrcode {
            width: 200px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            border-left: 2px solid #f1f5f9;
            padding-left: 32px;
        }
        .qr-image {
            width: 150px;
            height: 150px;
            border: 2px solid #f1f5f9;
            border-radius: 16px;
            padding: 8px;
            background-color: #ffffff;
            margin-bottom: 12px;
        }
        .qr-image img {
            width: 100%;
            height: 100%;
        }
        .qr-label {
            font-size: 10px;
            color: #64748b;
            font-weight: 600;
            line-height: 1.4;
        }

        /* Section titles */
        .section-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            color: #1e2a78;
            letter-spacing: 0.1em;
            margin-bottom: 16px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 6px;
        }

        /* Detail Items Grid */
        .grid-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px 24px;
            margin-bottom: 32px;
        }
        .info-item .label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .info-item .val {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
        }
        .info-item .val-seat {
            font-size: 18px;
            font-weight: 900;
            color: #f5a623;
        }

        /* Passengers table */
        .passenger-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        .passenger-table th {
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            padding: 8px 12px;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .passenger-table td {
            padding: 12px;
            font-size: 12px;
            font-weight: 600;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Terms / Rules footer */
        .ticket-rules {
            background-color: #f8fafc;
            padding: 24px 32px;
            border-top: 2px dashed #e2e8f0;
        }
        .rules-title {
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .rules-list {
            margin: 0;
            padding-left: 16px;
            font-size: 11px;
            color: #64748b;
        }
        .rules-list li {
            margin-bottom: 4px;
        }

        /* Print Media styling override */
        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
                padding: 0;
            }
            .ticket-container {
                border: none;
                max-w: 100%;
            }
            .no-print {
                display: none;
            }
        }

        /* Responsive for mobile viewing */
        @media screen and (max-width: 600px) {
            body { padding: 10px; }
            .ticket-header { flex-direction: column; text-align: center; gap: 8px; padding: 16px; }
            .ticket-meta { flex-direction: column; align-items: flex-start; gap: 16px; padding: 16px; }
            .booking-code { text-align: left; }
            .ticket-body { flex-direction: column; padding: 16px; gap: 24px; }
            .ticket-qrcode { width: 100%; border-left: none; border-top: 2px solid #f1f5f9; padding-left: 0; padding-top: 24px; }
            .grid-info { grid-template-columns: 1fr; gap: 12px; }
            .ticket-rules { padding: 16px; }
            .no-print { flex-direction: column; text-align: center; gap: 12px; }
        }
    </style>
</head>
<body>

    <!-- Floating Print Button (Visible only on screen, not on print) -->
    <div class="no-print" style="max-w: 800px; margin: 0 auto 20px auto; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: bold; color: #64748b;">Pratinjau E-Tiket Resmi</span>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" style="padding: 10px 20px; background-color: #1e2a78; color: white; border: none; border-radius: 12px; font-weight: bold; cursor: pointer;">Cetak Sekarang</button>
            <button onclick="window.close()" style="padding: 10px 20px; background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 12px; font-weight: bold; cursor: pointer;">Tutup</button>
        </div>
    </div>

    <!-- MAIN TICKET VOUCHER -->
    @foreach($booking->passengers as $passenger)
    <div class="ticket-container" style="{{ !$loop->last ? 'margin-bottom: 40px; page-break-after: always;' : '' }}">
        
        <!-- Header -->
        <div class="ticket-header">
            <div>
                <div class="brand-name">JATIJAJAR</div>
                <div class="brand-sub">Tiket Online</div>
            </div>
            <div class="voucher-title">E-Tiket Resmi</div>
        </div>

        <!-- Operator and Code bar -->
        <div class="ticket-meta">
            <div class="operator-info">
                <div class="operator-logo">
                    <img src="{{ asset($booking->trip->operator->logo_url) }}" alt="Logo PO">
                </div>
                <div class="operator-text">
                    <div class="name">{{ $booking->trip->operator->name }}</div>
                    <div class="class">{{ $booking->trip->bus_class }}</div>
                </div>
            </div>
            <div class="booking-code">
                <div class="label">Kode Booking</div>
                <div class="code">{{ $booking->ticket_code }}</div>
            </div>
        </div>

        <!-- Ticket Body columns -->
        <div class="ticket-body">
            
            <div class="ticket-details">
                <!-- Trip Route details -->
                <div class="section-title">Detail Perjalanan</div>
                <div class="grid-info">
                    <div class="info-item">
                        <div class="label">Kota Asal (Origin)</div>
                        <div class="val">{{ $booking->trip->origin->city }}</div>
                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">{{ $booking->trip->origin->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">Kota Tujuan (Destination)</div>
                        <div class="val">{{ $booking->trip->destination->city }}</div>
                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">{{ $booking->trip->destination->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">Tanggal Keberangkatan</div>
                        <div class="val">{{ \Carbon\Carbon::parse($booking->trip->departure_time)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">Jam Keberangkatan</div>
                        <div class="val" style="color: #1e2a78;">{{ \Carbon\Carbon::parse($booking->trip->departure_time)->format('H:i') }} WIB</div>
                    </div>
                </div>

                <!-- Passenger info -->
                <div class="section-title">Detail Penumpang & Kursi</div>
                <div class="grid-info">
                    <div class="info-item">
                        <div class="label">Nama Penumpang</div>
                        <div class="val">{{ $passenger->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">NIK / Identitas</div>
                        <div class="val">{{ $passenger->nik }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">No. Telepon</div>
                        <div class="val">{{ $passenger->phone }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">No. Kursi</div>
                        <div class="val-seat">{{ $passenger->seat_number }}</div>
                    </div>
                </div>
            </div>

            <!-- QR Code panel -->
            <div class="ticket-qrcode">
                <div class="section-title" style="border: none; margin-bottom: 24px;">Scan Barcode</div>
                <div class="qr-image">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($booking->ticket_code . '-SEAT-' . $passenger->seat_number) }}" alt="QR Code">
                </div>
                <div class="qr-label">
                    Tunjukkan QR Code ini kepada petugas Terminal Jatijajar untuk divalidasi dan ditukarkan dengan tiket boarding fisik.
                </div>
            </div>

        </div>

        <!-- Rules and guidelines -->
        <div class="ticket-rules">
            <div class="rules-title">Syarat & Ketentuan Perjalanan:</div>
            <ul class="rules-list">
                <li>Penumpang diharap sudah tiba di terminal keberangkatan selambat-lambatnya <strong>45 menit</strong> sebelum jadwal keberangkatan bus.</li>
                <li>Tunjukkan lembar e-tiket fisik ini atau pratinjau digital di HP Anda langsung kepada agen resmi PO Bus di terminal.</li>
                <li>Bagasi gratis maksimal 15 kg per penumpang. Barang bawaan berlebih akan dikenakan charge bagasi sesuai PO bersangkutan.</li>
                <li>Tiket resmi ini lunas dan sah diterbitkan oleh sistem JATIJAJAR Online Ticket.</li>
            </ul>
        </div>

    </div>
    @endforeach

    <!-- Auto Print Script -->
    <script>
        window.onload = function() {
            // Beri jeda 500ms agar QR code termuat sempurna sebelum dialog print terbuka
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
