@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center">
        
        <div class="animate-pulse mb-6">
            <svg class="w-16 h-16 text-brand-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Redirecting to Payment...</h2>
        <p class="text-slate-500 mb-8">Please do not close or refresh this window.</p>

        <!-- Razorpay Payment Form -->
        <form action="{{ route('checkout.callback') }}" method="POST" id="razorpayForm">
            @csrf
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        </form>

    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ $razorpayId }}", 
        "amount": "{{ $amount }}", 
        "currency": "INR",
        "name": "Musheeda Solutions",
        "description": "Kids Learning E-Book",
        "image": "{{ asset('img/logo.png') }}",
        "order_id": "{{ $razorpayOrderId }}",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpayForm').submit();
        },
        "prefill": {
            "name": "{{ $name }}",
            "email": "{{ $email }}",
            "contact": "{{ $phone }}"
        },
        "theme": {
            "color": "#4F46E5"
        },
        "modal": {
            "ondismiss": function(){
                window.location.href = "{{ route('checkout.index', 'kids-learning-ebook') }}";
            }
        }
    };
    var rzp1 = new Razorpay(options);
    window.onload = function() {
        rzp1.open();
    };
</script>
@endsection
