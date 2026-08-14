<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\Passenger;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $now = now();
        
        $stats = [
            'total_bookings'   => Booking::count(),
            'total_revenue'    => Booking::where('status', 'lunas')->sum('total_amount'),
            'total_passengers' => Passenger::count(),
            'active_trips'     => Trip::count(),
            
            // Revenue Stats
            'revenue_today' => Booking::where('status', 'lunas')->whereDate('created_at', $now->toDateString())->sum('total_amount'),
            'revenue_week'  => Booking::where('status', 'lunas')->whereBetween('created_at', [$now->copy()->startOfWeek()->toDateTimeString(), $now->copy()->endOfWeek()->toDateTimeString()])->sum('total_amount'),
            'revenue_month' => Booking::where('status', 'lunas')->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->sum('total_amount'),
            
            // Booking Stats
            'bookings_today' => Booking::whereDate('created_at', $now->toDateString())->count(),
            'bookings_week'  => Booking::whereBetween('created_at', [$now->copy()->startOfWeek()->toDateTimeString(), $now->copy()->endOfWeek()->toDateTimeString()])->count(),
            'bookings_month' => Booking::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count(),
        ];

        // Real 7-day chart data from database
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $day           = $now->copy()->subDays($i);
            $chartLabels[] = $day->translatedFormat('D, d M');
            $chartData[]   = (int) Booking::where('status', 'lunas')
                                ->whereDate('created_at', $day->toDateString())
                                ->sum('total_amount');
        }

        $recentBookings = Booking::with(['trip.operator', 'passengers'])
            ->latest()
            ->take(5)
            ->get();

        // === TREND ANALYTICS ===
        $trendPeriod = request('trend_period', '1bulan');
        $periodStart = match($trendPeriod) {
            '6bulan' => $now->copy()->subMonths(6),
            '1tahun' => $now->copy()->subYear(),
            default  => $now->copy()->subMonth(),
        };

        // Top Destinations
        $topDestinations = Booking::where('bookings.status', 'lunas')
            ->where('bookings.created_at', '>=', $periodStart)
            ->join('trips', 'bookings.trip_id', '=', 'trips.id')
            ->join('terminals', 'trips.destination_id', '=', 'terminals.id')
            ->select('terminals.city', DB::raw('COUNT(bookings.id) as total_bookings'), DB::raw('SUM(bookings.total_passengers) as total_pax'))
            ->groupBy('terminals.city')
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->get();

        // Top Operators
        $topOperators = Booking::where('bookings.status', 'lunas')
            ->where('bookings.created_at', '>=', $periodStart)
            ->join('trips', 'bookings.trip_id', '=', 'trips.id')
            ->join('operators', 'trips.operator_id', '=', 'operators.id')
            ->select('operators.name', DB::raw('COUNT(bookings.id) as total_bookings'), DB::raw('SUM(bookings.total_amount) as total_revenue'))
            ->groupBy('operators.name')
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentBookings', 'chartLabels', 'chartData',
            'topDestinations', 'topOperators', 'trendPeriod'
        ));
    }

    public function poRevenue()
    {
        $allOperators = Operator::orderBy('name')->get();
        $poFilter = request('po_filter', null);
        $poRevenueData = collect();
        $selectedOperator = null;
        $poTotalRevenue = 0;
        $poTotalBookings = 0;
        $poTotalPassengers = 0;

        if ($poFilter) {
            $selectedOperator = Operator::find($poFilter);
            if ($selectedOperator) {
                $poRevenueData = Booking::where('bookings.status', 'lunas')
                    ->join('trips', 'bookings.trip_id', '=', 'trips.id')
                    ->join('terminals', 'trips.destination_id', '=', 'terminals.id')
                    ->where('trips.operator_id', $poFilter)
                    ->select(
                        'terminals.city as destination_city',
                        DB::raw('COUNT(bookings.id) as total_bookings'),
                        DB::raw('SUM(bookings.total_passengers) as total_passengers'),
                        DB::raw('SUM(bookings.total_amount) as total_revenue')
                    )
                    ->groupBy('terminals.city')
                    ->orderByDesc('total_revenue')
                    ->get();

                $poTotalRevenue = $poRevenueData->sum('total_revenue');
                $poTotalBookings = $poRevenueData->sum('total_bookings');
                $poTotalPassengers = $poRevenueData->sum('total_passengers');
            }
        }

        return view('admin.po_revenue', compact(
            'allOperators', 'poFilter', 'poRevenueData', 'selectedOperator',
            'poTotalRevenue', 'poTotalBookings', 'poTotalPassengers'
        ));
    }

    public function bookings(Request $request)
    {
        $q = $request->query('q');

        $query = Booking::with(['trip.operator', 'trip.origin', 'trip.destination', 'passengers'])
            ->latest();

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('ticket_code', 'like', "%{$q}%")
                    ->orWhereHas('passengers', function ($p) use ($q) {
                        $p->where('name', 'like', "%{$q}%")
                          ->orWhere('phone', 'like', "%{$q}%");
                    });
            });
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function editBooking($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->only('status', 'payment_method'));
        return redirect()->route('admin.bookings')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroyBooking($id)
    {
        Booking::destroy($id);
        return redirect()->route('admin.bookings')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function reports(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());
        $status = $request->query('status', 'all');

        $query = Booking::with(['trip.operator', 'trip.origin', 'trip.destination', 'passengers'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->get();

        // Calculate summary metrics
        $baseQuery = Booking::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        if ($status !== 'all') {
            $baseQuery->where('status', $status);
        }

        $totalRevenue = (clone $baseQuery)->where('status', 'lunas')->sum('total_amount');
        $totalTicketsSold = (clone $baseQuery)->where('status', 'lunas')->sum('total_passengers');
        $totalBookingsCount = (clone $baseQuery)->count();

        return view('admin.reports.index', compact(
            'bookings',
            'startDate',
            'endDate',
            'status',
            'totalRevenue',
            'totalTicketsSold',
            'totalBookingsCount'
        ));
    }

    public function exportReports(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());
        $status = $request->query('status', 'all');

        $query = Booking::with(['trip.operator', 'trip.origin', 'trip.destination', 'passengers'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->get();

        $filename = "laporan_penjualan_{$startDate}_sampai_{$endDate}.csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'Tanggal Pesan', 'Kode Booking', 'Nama Pemesan', 'Rute', 'PO Bus', 
            'Total Tiket', 'Total Harga', 'Status'
        ];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $row['Tanggal Pesan'] = $booking->created_at->format('Y-m-d H:i');
                $row['Kode Booking']  = $booking->ticket_code;
                $row['Nama Pemesan']  = $booking->passengers->first()->name ?? 'N/A';
                $row['Rute']          = $booking->trip->origin->city . ' - ' . $booking->trip->destination->city;
                $row['PO Bus']        = $booking->trip->operator->name;
                $row['Total Tiket']   = $booking->total_passengers;
                $row['Total Harga']   = $booking->total_amount;
                $row['Status']        = strtoupper($booking->status);

                fputcsv($file, [
                    $row['Tanggal Pesan'], $row['Kode Booking'], $row['Nama Pemesan'],
                    $row['Rute'], $row['PO Bus'], $row['Total Tiket'], 
                    $row['Total Harga'], $row['Status']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function trips()
    {
        $trips = Trip::with(['operator', 'origin', 'destination'])
            ->where('departure_time', '>=', now()->startOfDay())
            ->orderBy('departure_time', 'asc')
            ->paginate(10);

        return view('admin.trips.index', compact('trips'));
    }

    public function generateTrips()
    {
        \Illuminate\Support\Facades\Artisan::call('trips:generate-daily');
        $output = \Illuminate\Support\Facades\Artisan::output();
        return redirect()->route('admin.trips')->with('success', $output);
    }

    public function createTrip()
    {
        $operators = Operator::all();
        $terminals = \App\Models\Terminal::all();
        return view('admin.trips.create', compact('operators', 'terminals'));
    }

    public function storeTrip(Request $request)
    {
        $validated = $request->validate([
            'operator_id' => 'required',
            'origin_id' => 'required',
            'destination_id' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required|numeric',
            'bus_class' => 'required',
            'available_seats' => 'required|numeric',
            'facilities' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Calculate duration
        $departure = new \DateTime($validated['departure_time']);
        $arrival = new \DateTime($validated['arrival_time']);
        $interval = $departure->diff($arrival);
        $validated['duration'] = $interval->format('%h jam %i menit');

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('trips', 'public');
            $validated['image'] = $path;
        }

        // Handle facilities string to array
        if (isset($validated['facilities']) && is_string($validated['facilities'])) {
            $validated['facilities'] = array_map('trim', explode(',', $validated['facilities']));
        }

        Trip::create($validated);
        return redirect()->route('admin.trips')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function editTrip($id)
    {
        $trip = Trip::findOrFail($id);
        $operators = Operator::all();
        $terminals = \App\Models\Terminal::all();
        return view('admin.trips.edit', compact('trip', 'operators', 'terminals'));
    }

    public function updateTrip(Request $request, $id)
    {
        $validated = $request->validate([
            'operator_id' => 'required',
            'origin_id' => 'required',
            'destination_id' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required|numeric',
            'bus_class' => 'required',
            'available_seats' => 'required|numeric',
            'facilities' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Calculate duration
        $departure = new \DateTime($validated['departure_time']);
        $arrival = new \DateTime($validated['arrival_time']);
        $interval = $departure->diff($arrival);
        $validated['duration'] = $interval->format('%h jam %i menit');

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('trips', 'public');
            $validated['image'] = $path;
        }

        // Handle facilities string to array
        if (isset($validated['facilities']) && is_string($validated['facilities'])) {
            $validated['facilities'] = array_map('trim', explode(',', $validated['facilities']));
        }

        $trip = Trip::findOrFail($id);
        $trip->update($validated);
        return redirect()->route('admin.trips')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroyTrip($id)
    {
        Trip::destroy($id);
        return redirect()->route('admin.trips')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function operators()
    {
        $operators = Operator::withCount('trips')->latest()->paginate(10);
        return view('admin.operators.index', compact('operators'));
    }

    public function createOperator()
    {
        return view('admin.operators.create');
    }

    public function storeOperator(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'domain' => 'required',
            'logo_url' => 'nullable|url'
        ]);

        Operator::create($request->all());
        return redirect()->route('admin.operators')->with('success', 'Operator berhasil ditambahkan.');
    }

    public function editOperator($id)
    {
        $operator = Operator::findOrFail($id);
        return view('admin.operators.edit', compact('operator'));
    }

    public function updateOperator(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'domain' => 'required',
            'logo_url' => 'nullable|url'
        ]);

        $operator = Operator::findOrFail($id);
        $operator->update($request->all());
        return redirect()->route('admin.operators')->with('success', 'Operator berhasil diperbarui.');
    }

    public function destroyOperator($id)
    {
        Operator::destroy($id);
        return redirect()->route('admin.operators')->with('success', 'Operator berhasil dihapus.');
    }

    public function terminals()
    {
        $terminals = \App\Models\Terminal::latest()->paginate(10);
        return view('admin.terminals.index', compact('terminals'));
    }

    public function createTerminal()
    {
        return view('admin.terminals.create');
    }

    public function storeTerminal(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        \App\Models\Terminal::create($request->all());
        return redirect()->route('admin.terminals')->with('success', 'Terminal berhasil ditambahkan.');
    }

    public function editTerminal($id)
    {
        $terminal = \App\Models\Terminal::findOrFail($id);
        return view('admin.terminals.edit', compact('terminal'));
    }

    public function updateTerminal(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        $terminal = \App\Models\Terminal::findOrFail($id);
        $terminal->update($request->all());
        return redirect()->route('admin.terminals')->with('success', 'Terminal berhasil diperbarui.');
    }

    public function destroyTerminal($id)
    {
        \App\Models\Terminal::destroy($id);
        return redirect()->route('admin.terminals')->with('success', 'Terminal berhasil dihapus.');
    }
}
