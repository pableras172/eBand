@php
    $subscription = Auth::user()->subscription();
@endphp

<div class="bg-white p-4 rounded-lg shadow text-sm text-center text-gray-700">
    @if ($subscription && $subscription->valid())
        <p class="font-semibold text-green-600 mb-2">✅ Suscripción activa</p>
        <p><strong>Inicio:</strong> {{ $subscription->created_at->format('d/m/Y') }}</p>
        <p><strong>Próxima renovación:</strong> {{ optional($subscription->asStripeSubscription()->current_period_end)->format('d/m/Y') }}</p>

        <a href="/billing-portal"
           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded transition">
            Gestionar suscripción
        </a>
    @else
        <x-subscription/>
    @endif
</div>
