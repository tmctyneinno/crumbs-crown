@extends('admin.layout')

@section('title', 'Orders')
@section('heading', 'Orders')

@section('content')
    <section class="overflow-hidden rounded-md border border-stone-200 bg-white">
        <div class="border-b border-stone-200 px-5 py-4">
            <h2 class="font-semibold text-[#34231d]">Customer orders</h2>
            <p class="mt-1 text-sm text-stone-500">Payment status, delivery details, and saved line items</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1040px] text-left text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">S/N</th>
                        <th class="px-5 py-3 font-semibold">Order</th>
                        <th class="px-5 py-3 font-semibold">Customer</th>
                        <th class="px-5 py-3 font-semibold">Items</th>
                        <th class="px-5 py-3 font-semibold">Fulfilment</th>
                        <th class="px-5 py-3 font-semibold">Payment</th>
                        <th class="px-5 py-3 text-right font-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($orders as $order)
                        <tr class="align-top">
                            <td class="px-5 py-4 text-stone-500">{{ $orders->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-stone-900">{{ $order->order_number }}</p>
                                <p class="mt-1 text-xs text-stone-500">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-stone-900">{{ $order->customer_name }}</p>
                                <a href="mailto:{{ $order->customer_email }}" class="mt-1 block text-[#633e2c] hover:underline">{{ $order->customer_email }}</a>
                                <a href="tel:{{ $order->customer_phone }}" class="mt-1 block text-stone-600 hover:underline">{{ $order->customer_phone }}</a>
                            </td>
                            <td class="px-5 py-4">
                                <ul class="space-y-2">
                                    @foreach ($order->items as $item)
                                        <li>
                                            <p class="font-medium text-stone-800">{{ $item->product_name }} × {{ $item->quantity }}</p>
                                            @if (! empty($item->options['size']))
                                                <p class="text-xs text-stone-500">{{ $item->options['size'] }}@if (! empty($item->options['flavour'])) · {{ $item->options['flavour'] }}@endif</p>
                                            @endif
                                            @if (! empty($item->options['inscription']))
                                                <p class="text-xs text-stone-500">Inscription: {{ $item->options['inscription'] }}</p>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-5 py-4 text-stone-700">
                                <p>{{ ucfirst($order->delivery_method) }}</p>
                                @if ($order->delivery_address)
                                    <p class="mt-1 max-w-48 whitespace-normal text-xs text-stone-500">{{ $order->delivery_address }}</p>
                                @endif
                                @if ($order->delivery_postcode)
                                    <p class="mt-1 text-xs text-stone-500">Postcode: {{ $order->delivery_postcode }}</p>
                                @endif
                                <p class="mt-1 text-xs text-stone-500">{{ $order->delivery_date->format('M j, Y') }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-800' : ($order->payment_status === 'failed' ? 'bg-rose-50 text-rose-800' : 'bg-amber-50 text-amber-800') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                <p class="mt-2 text-xs text-stone-500">Order: {{ str_replace('_', ' ', ucfirst($order->status)) }}</p>
                                @if ($order->payment_error === 'stripe_authentication')
                                    <p class="mt-2 max-w-48 whitespace-normal text-xs text-rose-700">Stripe credentials were rejected. Check the server payment configuration.</p>
                                @elseif ($order->payment_error)
                                    <p class="mt-2 max-w-48 whitespace-normal text-xs text-rose-700">Stripe Checkout could not be started.</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right font-semibold text-stone-900">&#8358;{{ number_format($order->subtotal) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-stone-500">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($orders->hasPages())
            <div class="border-t border-stone-200 px-5 py-4">{{ $orders->links() }}</div>
        @endif
    </section>
@endsection