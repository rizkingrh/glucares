<x-filament-panels::page>
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                QR Code for Patient: {{ $this->record->id }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                This QR code contains the patient ID and can be scanned for quick access.
            </p>
        </div>
        
        <div class="flex justify-center">
            <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-center">
                    {!! $this->getQrCodeSvg() !!}
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Patient ID: <span class="font-mono font-medium">{{ $this->record->id }}</span>
            </p>
        </div>
    </div>
</x-filament-panels::page>
