@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Loan Requests</h1>

        <table class="min-w-full bg-white rounded shadow">
            <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-3 text-left"><input type="checkbox" /></th>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Repayment Schedule</th>
                <th class="p-3 text-left">Loan Amount</th>
                <th class="p-3 text-left">Interest Rate</th>
                <th class="p-3 text-left">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($loans as $loan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3"><input type="checkbox" /></td>
                    <td class="p-3">
                        <div class="flex items-center gap-2">
                            <img src="{{ $loan->user->profile_photo_url ?? 'https://via.placeholder.com/40' }}" alt="Avatar" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium">{{ $loan->borrower->first_name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3">
                        @if($loan->status === 'pending')
                            <span class="text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full text-sm">Pending</span>
                        @elseif($loan->status === 'active')
                            <span class="text-green-600 bg-green-100 px-2 py-1 rounded-full text-sm">Active</span>
                        @else
                            <span class="text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-sm">{{ ucfirst($loan->status) }}</span>
                        @endif
                    </td>
                    <td class="p-3">{{ $loan->repayment_schedule }}</td>
                    <td class="p-3">${{ number_format($loan->amount, 2) }}</td>
                    <td class="p-3 font-semibold">{{ $loan->interest_rate }}%</td>
                    <td class="p-3 flex gap-2">
                        <form action="{{ route('admin.loans.update', $loan->id) }}" method="POST" onsubmit="return confirm('Approve this loan?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="active">
                            <input type="hidden" name="interest_rate" value="{{ $loan->interest_rate }}">
                            <input type="hidden" name="repayment_schedule" value="{{ $loan->repayment_schedule }}">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded border border-green-600 shadow">
                                Approve
                            </button>
                        </form>

                        <form action="{{ route('admin.loans.destroy', $loan->id) }}" method="POST" onsubmit="return confirm('Reject this loan?');">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-red-400 px-3 py-2 rounded border border-red-600 shadow">
                                Reject
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
