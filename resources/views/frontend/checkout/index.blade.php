@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">Secure Checkout</h1>
            <p class="mt-4 text-lg text-slate-500">You are about to purchase the Kids Learning E-Book.</p>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-slate-100">
            <div class="flex flex-col md:flex-row">
                <!-- Order Summary -->
                <div class="md:w-1/3 bg-slate-900 text-white p-8">
                    <h3 class="text-lg font-medium mb-6 text-slate-200">Order Summary</h3>
                    
                    <div class="flex items-start gap-4 mb-6 pb-6 border-b border-slate-700">
                        <div class="w-16 h-20 bg-slate-800 rounded-lg flex items-center justify-center overflow-hidden shrink-0">
                            <img src="{{ asset('storage/kids_ebook_hero.jpg') }}" class="object-cover h-full" alt="E-Book Cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-sm">Kids Learning E-Book</h4>
                            <p class="text-slate-400 text-xs mt-1">Digital PDF Download</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center font-bold text-lg">
                        <span>Total:</span>
                        <span>₹{{ $price }}</span>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="md:w-2/3 p-8">
                    @if (session('error'))
                        <div class="mb-6 bg-red-50 p-4 rounded-lg border border-red-200 text-red-600 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product" value="{{ $product }}">
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name *</label>
                                <input type="text" name="name" required class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email Address *</label>
                                <input type="email" name="email" required class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                <p class="text-xs text-slate-500 mt-1">We will send the eBook PDF to this email.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number (Optional)</label>
                                <input type="text" name="phone" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center text-slate-500 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Secure payment via Razorpay
                            </div>
                            <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-brand-700 transition-colors shadow-lg shadow-brand-600/30">
                                Continue to Pay ₹{{ $price }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
