@extends('admin.dashboard')

@section('content')
    @if(!auth('admin')->check())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6" role="alert">
            <p class="font-bold">Access Denied</p>
            <p>You do not have permission to view this page.</p>
        </div>
    @else
        <div class="bg-white shadow rounded-lg p-6 m-6">
            <h2 class="text-2xl font-semibold mb-6">Payments</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Booking ID</th>
                            <th class="py-3 px-6 text-left">Amount</th>
                            <th class="py-3 px-6 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($payments as $payment)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">{{ $payment->id }}</td>
                                <td class="py-3 px-6">{{ $payment->booking_id }}</td>
                                <td class="py-3 px-6">${{ number_format($payment->amount, 2) }}</td>
                                <td class="py-3 px-6">{{ $payment->status }}</td>
                            </tr>
                        @endforeach
                        @if(empty($payments) || $payments->isEmpty())
                            <tr>
                                <td colspan="4" class="py-3 px-6 text-center">No payments available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection