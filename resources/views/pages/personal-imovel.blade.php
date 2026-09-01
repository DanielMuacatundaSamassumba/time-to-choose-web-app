<x-layouts.app :title="$property->title" :description="$property->description">

    <x-slot name="styles">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox/fancybox.css" />
        <style>
            .swiper-button-next,
            .swiper-button-prev {
                color: #F97316;
            }
        </style>
    </x-slot>

    @php
        $images = [];
        if ($property->image) {
            $images[] = $property->image;
        }
        if (is_array($property->gallery)) {
            $images = array_merge($images, $property->gallery);
        }
        if (empty($images)) {
            $images[] = '1.jpeg';
        }
    @endphp

    <section class="max-w-7xl mx-auto px-4 lg:px-6 py-8 mt-6">

        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#F97316]">Início</a> /
            <a href="{{ url('/imoveis') }}" class="hover:text-[#F97316]">Imóveis</a> /
            <span class="text-gray-800">{{ $property->title }}</span>
        </nav>

        <div class="relative">
            <!-- Slider Principal -->
            <div class="swiper propertyGallery rounded-sm overflow-hidden shadow-md">
                <div class="swiper-wrapper">
                    @foreach($images as $img)
                        @php
                            $url = (file_exists(public_path('assets/' . $img))) ? asset('assets/' . $img) : (str_starts_with($img, 'properties/') ? Storage::url($img) : asset('assets/1.jpeg'));
                        @endphp
                        <div class="swiper-slide">
                            <a data-fancybox="gallery" href="{{ $url }}">
                                <img src="{{ $url }}" class="w-full h-[250px] sm:h-[400px] lg:h-[600px] object-cover">
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

            <!-- Miniaturas (só mostra se houver mais de 1 imagem) -->
            @if(count($images) > 1)
                <div class="swiper propertyThumbs mt-4">
                    <div class="swiper-wrapper">
                        @foreach($images as $img)
                            @php
                                $url = (file_exists(public_path('assets/' . $img))) ? asset('assets/' . $img) : (str_starts_with($img, 'properties/') ? Storage::url($img) : asset('assets/1.jpeg'));
                            @endphp
                            <div class="swiper-slide">
                                <img src="{{ $url }}"
                                    class="rounded-sm h-20 w-full object-cover cursor-pointer hover:opacity-85 transition">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="grid lg:grid-cols-3 gap-10 mt-10">
            <div class="lg:col-span-2">
                <div class="flex flex-wrap items-center gap-3 mb-3">
                    <span class="px-4 py-2 rounded-sm text-xs font-bold uppercase tracking-wider shadow-sm"
                        style="background-color: {{ $property->business_badge['bg'] }}; color: {{ $property->business_badge['color'] }}">
                        {{ $property->business_badge['label'] }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $property->status_badge['class'] }}">
                        {{ $property->status_badge['label'] }}
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $property->title }}</h1>
                <p class="text-gray-500 mt-3 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]" translate="no">location_on</span>
                    {{ $property->location }}
                </p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                    @if($property->bedrooms > 0)
                        <div class="bg-white rounded-sm p-4 text-center shadow-sm border border-gray-100">
                            <span class="material-symbols-outlined text-zinc-500" translate="no">bed</span>
                            <br><b>{{ $property->bedrooms }} Quarto{{ $property->bedrooms > 1 ? 's' : '' }}</b>
                        </div>
                    @endif
                    @if($property->bathrooms > 0)
                        <div class="bg-white rounded-sm p-4 text-center shadow-sm border border-gray-100">
                            <span class="material-symbols-outlined text-zinc-500" translate="no">shower</span>
                            <br><b>{{ $property->bathrooms }} Casa{{ $property->bathrooms > 1 ? 's' : '' }} de Banho</b>
                        </div>
                    @endif
                    @if($property->garages > 0)
                        <div class="bg-white rounded-sm p-4 text-center shadow-sm border border-gray-100">
                            <span class="material-symbols-outlined text-zinc-500" translate="no">directions_car</span>
                            <br><b>{{ $property->garages }} Garagem</b>
                        </div>
                    @endif
                    @if($property->area)
                        <div class="bg-white rounded-sm p-4 text-center shadow-sm border border-gray-100">
                            <span class="material-symbols-outlined text-zinc-500" translate="no">square_foot</span>
                            <br><b>{{ $property->area }}</b>
                        </div>
                    @endif
                </div>

                <section class="mt-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Descrição</h2>
                    <p class="text-gray-600 leading-8 text-[17px] whitespace-pre-line">
                        {{ $property->description }}
                    </p>

                    <div
                        class="flex flex-wrap items-center gap-6 mt-6 text-sm text-gray-600 border-t border-dashed pt-4">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#F97316] text-[20px]"
                                translate="no">movie</span>
                            <span class="font-semibold text-gray-700">Vídeo Disponível:</span>
                            <span>{{ $property->video_url ? 'Sim' : 'Não' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#F97316] text-[20px] "
                                translate="no">3d_rotation</span>
                            <span class="font-semibold text-gray-700">Visita 3D:</span>
                            <span>{{ $property->tour_3d_url ? 'Sim' : 'Não' }}</span>
                        </div>
                    </div>
                </section>

                @if($property->amenities && count($property->amenities) > 0)
                    <section class="mt-10">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Comodidades</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($property->amenities as $comodidade)
                                <div
                                    class="bg-white p-4 rounded-sm shadow-sm border border-gray-100 text-gray-700 font-medium flex items-center gap-2">
                                    <span class="h-3 w-3 bg-[#F97316]"></span>
                                    {{ $comodidade }}
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Vídeo do Imóvel --}}
                @if($property->video_url)
                    @php
                        $isYoutube = false;
                        $embedUrl = $property->video_url;
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $property->video_url, $match)) {
                            $isYoutube = true;
                            $embedUrl = 'https://www.youtube.com/embed/' . $match[1];
                        }
                    @endphp
                    <section class="mt-10">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Vídeo do Imóvel</h2>
                        <div class="aspect-video rounded-sm overflow-hidden shadow-md bg-black">
                            @if($isYoutube)
                                <iframe class="w-full h-full" src="{{ $embedUrl }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            @else
                                <video class="w-full h-full" controls>
                                    <source src="{{ $property->video_url }}" type="video/mp4">
                                    O seu browser não suporta a reprodução deste vídeo.
                                </video>
                            @endif
                        </div>
                    </section>
                @endif

                {{-- Visita 3D --}}
                @if($property->tour_3d_url)
                    <section class="mt-10">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Visita Virtual 3D</h2>
                        <div class="aspect-video rounded-sm overflow-hidden shadow-md bg-gray-100 border border-gray-200">
                            <iframe class="w-full h-full border-0" src="{{ $property->tour_3d_url }}" allowfullscreen
                                allow="xr-spatial-tracking"></iframe>
                        </div>
                    </section>
                @endif

                {{-- Localização no Mapa --}}
                <section class="mt-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Localização</h2>
                    <div
                        class="rounded-sm h-96 flex items-center justify-center overflow-hidden shadow-md border border-gray-100">
                        @if($property->latitude && $property->longitude)
                            <iframe
                                src="https://maps.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                class="w-full h-full border-0" loading="lazy">
                            </iframe>
                        @else
                            <iframe
                                src="https://maps.google.com/maps?q={{ urlencode($property->location . ', ' . $property->city . ', ' . $property->country) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                class="w-full h-full border-0" loading="lazy">
                            </iframe>
                        @endif
                    </div>
                </section>
            </div>

            <!-- Sidebar Form & Contact -->
            <aside>
                <div class="lg:sticky lg:top-24 bg-white rounded-sm shadow-xl p-6 border border-gray-100">
                    <p class="text-gray-500 text-sm">Valor</p>
                    <h2 class="text-4xl font-bold text-[#F97316] mt-2">
                        {{ $property->price }}
                        @if($property->price_period)
                            <span class="text-lg text-gray-400 font-normal">{{ $property->price_period }}</span>
                        @endif
                    </h2>

                    <a href="tel:+244923000000"
                        class="w-full bg-[#F97316] text-center text-white py-4 rounded-sm mt-8 font-bold hover:bg-[#F97316]/90 transition flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined" translate="no">call</span>
                        Ligar para o Consultor
                    </a>

                    <a href="https://wa.me/244923000000?text=Olá,%20tenho%20interesse%20no%20imóvel%20{{ urlencode($property->title) }}"
                        target="_blank"
                        class="w-full border border-green-200 py-4 rounded-sm mt-3 flex items-center justify-center gap-2 font-semibold text-green-700 hover:bg-green-50 transition">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>WhatsApp</span>
                    </a>

                    <hr class="my-8">

                    <h3 class="font-bold text-xl mb-4 text-gray-900">Contactar Consultor</h3>

                    @if(session('contact_success'))
                        <div
                            class="mb-4 bg-green-50 border border-green-200 text-green-700 p-4 rounded-sm text-sm font-medium">
                            {{ session('contact_success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 p-4 rounded-sm text-xs">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->id }}">

                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-200 rounded-sm p-3 text-sm outline-none focus:border-[#F97316] focus:ring-1 focus:ring-[#F97316] transition"
                            placeholder="Seu Nome *">

                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border border-gray-200 rounded-sm p-3 text-sm outline-none focus:border-[#F97316] focus:ring-1 focus:ring-[#F97316] transition"
                            placeholder="Seu Email *">

                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full border border-gray-200 rounded-sm p-3 text-sm outline-none focus:border-[#F97316] focus:ring-1 focus:ring-[#F97316] transition"
                            placeholder="Seu Telefone">

                        <textarea name="message" required
                            class="w-full border border-gray-200 rounded-sm p-3 h-32 text-sm outline-none focus:border-[#F97316] focus:ring-1 focus:ring-[#F97316] transition resize-none"
                            placeholder="Tenho interesse neste imóvel. Por favor, contacte-me. *">{{ old('message', 'Tenho interesse neste imóvel. Gostaria de agendar uma visita.') }}</textarea>

                        @error('g-recaptcha-response')
                            <p class="text-red-500 text-xs mt-1 font-medium">
                                {{ $message }}
                            </p>
                        @enderror

                        <button type="submit"
                            class="w-full bg-[#F97316] text-white py-4 rounded-sm mt-4 font-bold hover:bg-[#F97316]/90 transition">
                            Enviar Pedido
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </section>

    {{-- Imóveis Relacionados --}}
    @if(count($related) > 0)
        <section class="max-w-7xl mx-auto px-4 lg:px-6 py-12 border-t border-gray-100">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 mt-6">Imóveis Relacionados</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($related as $item)
                    <article
                        class="property-card cursor-pointer bg-white rounded-sm overflow-hidden border border-[#E5E5E5] shadow-lg flex flex-col h-full hover:shadow-2xl transition duration-300"
                        onclick="window.location.href='{{ route('properties.show', $property) }}'">
                        <div class="relative overflow-hidden group">
                            @if($item->image && file_exists(public_path('assets/' . $item->image)))
                                <img src="{{ asset('assets/' . $item->image) }}" alt="{{ $item->title }}"
                                    class="w-full h-[260px] object-cover group-hover:scale-105 transition duration-500">
                            @elseif($item->image && str_starts_with($item->image, 'properties/'))
                                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                                    class="w-full h-[260px] object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <img src="{{ asset('assets/1.jpeg') }}" alt="{{ $item->title }}"
                                    class="w-full h-[260px] object-cover group-hover:scale-105 transition duration-500">
                            @endif
                            <span class="absolute top-4 left-4 text-xs font-bold px-3 py-2 rounded-sm shadow-sm"
                                style="background-color: {{ $item->business_badge['bg'] }}; color: {{ $item->business_badge['color'] }}">
                                {{ mb_strtoupper($item->business_badge['label']) }}
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-lg font-bold leading-tight text-gray-900">{{ $item->title }}</h3>
                            <p class="text-[#999] mt-2 flex items-center gap-1 text-sm">
                                <span class="material-symbols-outlined text-[16px]" translate="no">location_on</span>
                                {{ $item->location }}
                            </p>
                            <div class="py-4 mt-4 border-t border-b border-gray-100 flex-1">
                                <div class="grid grid-cols-2 gap-3 text-xs text-gray-500">
                                    @if($item->bedrooms > 0)
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-zinc-500 text-[18px]"
                                                translate="no">domain</span>
                                            <span>{{ $item->bedrooms }} Quartos</span>
                                        </div>
                                    @endif
                                    @if($item->bathrooms > 0)
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-zinc-500 text-[18px]"
                                                translate="no">shower</span>
                                            <span>{{ $item->bathrooms }} WC</span>
                                        </div>
                                    @endif
                                    @if($item->garages > 0)
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-zinc-500 text-[18px] "
                                                translate="no">directions_car</span>
                                            <span>{{ $item->garages }} Garagem</span>
                                        </div>
                                    @endif
                                    @if($item->area)
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-zinc-500 text-[18px]"
                                                translate="no">square_foot</span>
                                            <span>{{ $item->area }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <h4 class="text-[#F97316] text-base font-bold">{{ $item->price }}</h4>
                                <a href="{{ route('properties.show', $item) }}"
                                    class="bg-[#F97316] text-center text-white text-[12px] px-4 py-2.5 rounded-sm uppercase tracking-wider font-semibold hover:bg-[#e65100] transition">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @push('scripts')
        @if(config('services.recaptcha.site_key'))
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const form = document.querySelector('form[action="{{ route('contact.store') }}"]');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            if (form.dataset.recaptchaPassed === 'true') return;
                            if (typeof grecaptcha === 'undefined') return;

                            e.preventDefault();
                            grecaptcha.ready(function() {
                                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'contact_submit'})
                                    .then(function(token) {
                                        let input = form.querySelector('input[name="g-recaptcha-response"]');
                                        if (!input) {
                                            input = document.createElement('input');
                                            input.type = 'hidden';
                                            input.name = 'g-recaptcha-response';
                                            form.appendChild(input);
                                        }
                                        input.value = token;
                                        form.dataset.recaptchaPassed = 'true';
                                        form.submit();
                                    })
                                    .catch(function() {
                                        form.dataset.recaptchaPassed = 'true';
                                        form.submit();
                                    });
                            });
                        });
                    }
                });
            </script>
        @endif
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox/fancybox.umd.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const thumbs = new Swiper(".propertyThumbs", {
                    spaceBetween: 10,
                    slidesPerView: 4,
                    watchSlidesProgress: true,
                    breakpoints: {
                        640: { slidesPerView: 5 },
                        1024: { slidesPerView: 6 }
                    }
                });

                const gallery = new Swiper(".propertyGallery", {
                    spaceBetween: 15,
                    loop: true,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    thumbs: {
                        swiper: thumbs
                    }
                });

                Fancybox.bind("[data-fancybox='gallery']", {
                    Toolbar: {
                        display: ["zoom", "fullscreen", "slideshow", "download", "close"]
                    }
                });
            });
        </script>
    @endpush

</x-layouts.app>