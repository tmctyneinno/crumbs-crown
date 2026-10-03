@extends('admin.layout')

@section('title', 'Enquiries')
@section('heading', 'Customer enquiries')

@section('content')
    <section class="overflow-hidden rounded-md border border-stone-200 bg-white">
        <div class="border-b border-stone-200 px-5 py-4">
            <h2 class="font-semibold text-[#34231d]">Connect form submissions</h2>
            <p class="mt-1 text-sm text-stone-500">Customer contact details and messages, newest first</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">S/N</th>
                        <th class="px-5 py-3 font-semibold">Customer</th>
                        <th class="px-5 py-3 font-semibold">Enquiry</th>
                        <th class="px-5 py-3 font-semibold">Message</th>
                        <th class="px-5 py-3 font-semibold">Received</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($enquiries as $enquiry)
                        <tr class="align-top">
                            <td class="px-5 py-4 text-stone-500">{{ $enquiries->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-stone-900">{{ $enquiry->full_name }}</p>
                                <a href="mailto:{{ $enquiry->email }}" class="mt-1 block text-[#633e2c] hover:underline">{{ $enquiry->email }}</a>
                                @if ($enquiry->phone)
                                    <a href="tel:{{ $enquiry->phone }}" class="mt-1 block text-stone-600 hover:underline">{{ $enquiry->phone }}</a>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-stone-700">{{ ucfirst(str_replace(['-', '_'], ' ', $enquiry->enquiry_type)) }}</td>
                            <td class="max-w-xl whitespace-pre-wrap break-words px-5 py-4 text-stone-700">{{ $enquiry->message }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-stone-500">{{ $enquiry->created_at->format('M j, Y g:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-stone-500">No customer enquiries yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($enquiries->hasPages())
            <div class="border-t border-stone-200 px-5 py-4">{{ $enquiries->links() }}</div>
        @endif
    </section>
@endsection