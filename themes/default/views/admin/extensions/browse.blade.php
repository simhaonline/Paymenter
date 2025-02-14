<x-admin-layout title="{{ __('Browse extensions') }}">
    <div class="flex justify-between">
        <h1 class="text-2xl font-bold">{{ __('Browse extensions') }}</h1>
        <input type="text" class="form-input w-1/5 h-2/3" placeholder="{{ __('Search') }}" id="extensionSearch">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
        @foreach ($extensions as $extension)
            @php $extension = (object) $extension; @endphp
            <div class="max-h-md extension" data-title="{{ $extension->name }}" data-slogan="{{ $extension->slogan }}">
                <div class="!bg-secondary-200 content-box w-full h-full flex flex-col justify-center">
                    <div class="flex flex-row gap-x-3">
                        <img src="{{ config('app.marketplace') . '../../storage/' . $extension->icon }}" alt="{{ $extension->name }}" class="w-[135px] mx-auto rounded-md drop-shadow-lg">
                        <div class="flex flex-col relative">
                            <h1 class="text-xl font-bold">{{ $extension->name }}</h1>
                            <span>{{ $extension->slogan }}</span>
                            <div class="absolute bottom-0 w-full">
                                <div class="flex flex-row justify-between items-center relative w-full">
                                    <div>
                                        <div class="block">
                                            <span class="font-semibold">{{ __('Price') }}: </span>
                                            {{ $extension->price == 0?"Free":$extension->price . "$" }}
                                        </div>
                                        <div>
                                            <span class="font-semibold">{{ __('Type') }}: </span>
                                            {{ ucFirst($extension->type) }}
                                        </div>
                                    </div>
                                    @if ($extension->price == 0)
                                        <div class="flex h-full">
                                            <form action="{{ route('admin.extensions.install', $extension->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="button button-primary">
                                                    <i class="ri-download-2-line text-xs"></i>
                                                    {{ __('Download') }}
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="flex h-full">
                                            <a href="{{ config('app.marketplace') . '/extension/' . $extension->id  . '/' . $extension->name }}" class="button button-primary">
                                                <i class="ri-wallet-3-fill text-xs"></i> {{ __('Buy') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        const searchInput = document.getElementById('extensionSearch');
        const extensionTitles = document.querySelectorAll('.extension');
        const extensionSlogans = document.querySelectorAll('[data-slogan]');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();

            extensionTitles.forEach(title => {
                const titleText = title.getAttribute('data-title').toLowerCase();
                const sloganText = title.getAttribute('data-slogan').toLowerCase();

                if (titleText.includes(searchTerm) || sloganText.includes(searchTerm)) {
                    title.closest('.max-h-md').style.display = 'block';
                } else {
                    title.closest('.max-h-md').style.display = 'none';
                }
            });
        });
    </script>


</x-admin-layout>
