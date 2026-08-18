@props([
    'source' => 'contact', 
    'landingPage' => null, 
    'productService' => null, 
    'buttonText' => 'Submit',
    'title' => 'Contact Us'
])

<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
    @if($title)
        <h3 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">{{ $title }}</h3>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('leads.store') }}" method="POST">
        @csrf
        
        <!-- Honeypot -->
        <div style="display: none;">
            <label for="website_url">Website URL</label>
            <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
        </div>

        <input type="hidden" name="source" value="{{ $source }}">
        @if($landingPage)
            <input type="hidden" name="landing_page" value="{{ $landingPage }}">
        @endif
        @if($productService)
            <input type="hidden" name="product_service" value="{{ $productService }}">
        @endif

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                   @error('name') aria-describedby="name-error" @enderror
                   class="mt-1 block w-full px-4 py-3 sm:py-2 rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400" id="name-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                       @error('email') aria-describedby="email-error" @enderror
                       class="mt-1 block w-full px-4 py-3 sm:py-2 rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400" id="email-error">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                       aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                       @error('phone') aria-describedby="phone-error" @enderror
                       class="mt-1 block w-full px-4 py-3 sm:py-2 rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400" id="phone-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company (Optional)</label>
            <input type="text" name="company" id="company" value="{{ old('company') }}"
                   aria-invalid="{{ $errors->has('company') ? 'true' : 'false' }}"
                   @error('company') aria-describedby="company-error" @enderror
                   class="mt-1 block w-full px-4 py-3 sm:py-2 rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('company')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400" id="company-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
            <textarea name="message" id="message" rows="4"
                      aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}"
                      @error('message') aria-describedby="message-error" @enderror
                      class="mt-1 block w-full px-4 py-3 sm:py-2 rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('message') }}</textarea>
            @error('message')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400" id="message-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit"
                    class="w-full flex justify-center py-3 sm:py-2 px-4 border border-transparent rounded-md shadow-sm text-base sm:text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                {{ $buttonText }}
            </button>
        </div>
    </form>
</div>
