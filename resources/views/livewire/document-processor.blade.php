<div>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Process Document</h1>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Upload a PDF and extract structured data using AI.</p>
            </div>
        </div>

        <div class="mt-8">
            <form wire:submit.prevent="processDocument">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="customer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                        <select wire:model="selectedCustomerId" id="customer" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-slate-700 dark:border-slate-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select a customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedCustomerId') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="pdfFile" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PDF Document</label>
                        <input wire:model="pdfFile" type="file" id="pdfFile" class="block w-full mt-1 text-sm text-gray-500 border border-gray-300 rounded-md cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400">
                        @error('pdfFile') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold leading-6 text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" wire:loading.attr="disabled" wire:target="processDocument">
                        <span wire:loading.remove wire:target="processDocument">Submit</span>
                        <span wire:loading wire:target="processDocument">Processing...</span>
                    </button>
                </div>
            </form>
        </div>

        <div wire:loading wire:target="processDocument" class="mt-8">
            <div class="flex items-center justify-center">
                <svg class="w-8 h-8 text-indigo-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="ml-3 text-gray-700 dark:text-gray-300">Analyzing document, please wait...</span>
            </div>
        </div>

        @if($error)
            <div class="p-4 mt-8 rounded-md bg-red-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Error</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>{{ $error }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($extractedText || $jsonResponse)
            <div class="mt-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Results</h3>
                    <div class="grid grid-cols-1 gap-6 mt-5 md:grid-cols-2">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Raw Text</h4>
                            <div class="p-4 mt-2 overflow-auto bg-gray-100 rounded-md dark:bg-slate-700" style="max-height: 400px;">
                                <pre class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ $extractedText }}</pre>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">AI JSON Response</h4>
                            <div class="p-4 mt-2 overflow-auto bg-gray-100 rounded-md dark:bg-slate-700" style="max-height: 400px;">
                                <pre class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ json_encode($jsonResponse, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
