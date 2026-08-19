@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-success-500">
        
        <div class="w-16 h-16 bg-success-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Payment Successful!</h2>
        
        <p class="text-slate-600 mb-8 text-lg">
            Thank you for your purchase. We have sent the Kids Learning E-Book PDF directly to your email address.
        </p>

        <div class="bg-slate-50 p-4 rounded-xl text-left border border-slate-100 mb-8">
            <p class="text-sm text-slate-500 font-medium mb-1">What's next?</p>
            <ul class="text-sm text-slate-700 space-y-2 list-disc pl-4">
                <li>Check your inbox (and spam folder) for the email.</li>
                <li>Download the attached PDF file.</li>
                <li>Enjoy reading with your child!</li>
            </ul>
        </div>

        <a href="{{ url('/') }}" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-800 transition-colors w-full">
            Back to Home
        </a>

    </div>
</div>
@endsection
