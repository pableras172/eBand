@php
    $subscription = Auth::user()->subscription();
@endphp

<div class="w-full mx-auto bg-white p-2 rounded-lg shadow text-sm text-center text-gray-700">
    @if ($subscription && $subscription->valid())
        <p class="font-semibold text-green-600 mb-2">✅ {{ __('Suscripción activa') }}</p>
        <p><strong>{{ __('Inicio') }}:</strong> {{ $subscription->created_at->format('d/m/Y') }}</p>
        <p><strong>{{ __('Próxima renovación') }}:</strong> {{ optional($subscription->asStripeSubscription()->current_period_end)->format('d/m/Y') }}</p>

        <a href="/billing-portal"
           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded transition">
            {{ __('Gestionar suscripción') }}
        </a>
    @else
        <x-subscription/>
    @endif
</div>
