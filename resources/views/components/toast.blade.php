@php
    $initialToastMessage = session('error') ?? session('status') ?? session('toast') ?? session('message') ?? session('subscribed');
    $initialToastType = session()->has('error') ? 'error' : 'success';
@endphp

<div
    x-data="{ visible: @js(filled($initialToastMessage)), message: @js($initialToastMessage), type: @js($initialToastType), timeout: null }"
    x-init="if (visible) timeout = setTimeout(() => visible = false, 5000)"
    x-on:toast.window="message = $event.detail.message; type = $event.detail.type ?? 'success'; visible = true; clearTimeout(timeout); timeout = setTimeout(() => visible = false, 5000)"
    class="pointer-events-none fixed inset-x-4 top-4 z-[100] flex justify-end sm:inset-x-auto sm:right-6 sm:top-6"
>
    <div
        x-show="visible"
        x-transition
        style="display: none"
        x-bind:role="type === 'error' ? 'alert' : 'status'"
        x-bind:aria-live="type === 'error' ? 'assertive' : 'polite'"
        x-bind:class="{
            'border-emerald-200 text-emerald-950': type === 'success',
            'border-red-200 text-red-950': type === 'error',
            'border-sky-200 text-sky-950': type === 'info'
        }"
        class="pointer-events-auto flex w-full max-w-sm items-start gap-4 rounded-lg border bg-white p-4 shadow-lg"
    >
        <div class="min-w-0 flex-1">
            <p class="text-sm font-semibold" x-text="type === 'error' ? 'Something went wrong' : (type === 'info' ? 'Notice' : 'Success')"></p>
            <p x-text="message" class="mt-1 text-sm text-stone-600"></p>
        </div>
        <button type="button" x-on:click="visible = false; clearTimeout(timeout)" aria-label="Dismiss notification" class="text-xl leading-none text-stone-500 hover:text-stone-900">&times;</button>
    </div>
</div>