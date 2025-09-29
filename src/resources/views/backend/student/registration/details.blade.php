@extends('admin.main')
@section('admin')
<div class="content-wrapper">
    <div class="container-full">
        <section id="printSection" class="content">
            <div class="box">

                <div class="box-header with-border">
                    <div class="flex sm:flex-col md:flex-row gap-8 mb-8">
                        {{-- Avatar --}}
                        <div class="shrink-0">
                            <div class="relative flex size-8 shrink-0 overflow-hidden rounded-full w-32 h-32 border-4 border-accent">
                                @if($docs->student->imagePath)

                                <img src="{{ asset($docs->student->imagePath) }}" alt="{{ $docs->student->name }}" class="aspect-square size-full">
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-blue-500 text-white text-2xl font-semibold">
                                    @php
                                    $words = explode(' ', trim($docs->student->name));
                                    $initials = '';
                                    foreach ($words as $word) {
                                    if ($word !== '') {
                                    $initials .= strtoupper(substr($word, 0, 1));
                                    }
                                    }
                                    echo substr($initials, 0, 2);
                                    @endphp
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Student information --}}
                        <div class="flex-1 space-y-4">
                            <div>
                                <h1 class="text-3xl font-bold text-[#8a99b5] mb-2">{{ $docs->student->name }}</h1>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-[#bdd1f8]">
                                @if($docs->student->mobile)
                                <div class="flex items-center gap-2">
                                    {{-- Ícono de teléfono (SVG) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                    <span>{{ $docs->student->mobile }}</span>
                                </div>
                                @endif

                                @if($docs->student->address)
                                <div class="flex items-center gap-2">
                                    {{-- Ícono de ubicación (MapPin) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <span>{{ $docs->student->address }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="no-print" >
                            <a
                                href="#"
                                class="btn btn-primary pull-right flex items-center gap-1"
                                onClick="printDiv('printSection')"
                            >

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-printer-icon lucide-printer"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                                Print PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Personal Information--}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-[#bdd1f8] border-b border-[rgba(255,255,255,0.12)] pb-2">Personal information</h3>

                            @if($docs->student->gender)
                            <div class="flex items-start gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <div>
                                    <p class="text-sm text-[#bdd1f8]">Gender</p>
                                    <p class="font-medium">{{ $docs->student->gender }}</p>
                                </div>
                            </div>
                            @endif

                            @if($docs->student->religion)
                            <div class="flex items-start gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <div>
                                    <p class="text-sm text-[#bdd1f8]">Religion</p>
                                    <p class="font-medium">{{ $docs->student->religion }}</p>
                                </div>
                            </div>
                            @endif

                            @if($docs->student->dateBirth)
                            <div class="flex items-start gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                <div>
                                    <p class="text-sm text-[#bdd1f8]">Date of birth</p>
                                    <p class="font-medium">
                                        {{ \Carbon\Carbon::parse($docs->student->dateBirth)->locale('en')->isoFormat('MMMM D, YYYY') }}
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Familiar Information--}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-[rgba(255,255,255,0.12)] pb-2">Familiar information</h3>

                            @if($docs->student->fatherName)
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <div>
                                    <p class="text-sm text-[#bdd1f8]">Father's name</p>
                                    <p class="font-medium">{{ $docs->student->fatherName }}</p>
                                </div>
                            </div>
                            @endif

                            @if($docs->student->motherName)
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <div>
                                    <p class="text-sm text-[#bdd1f8]">Mother's name</p>
                                    <p class="font-medium">{{ $docs->student->motherName }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Grade information --}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-[rgba(255,255,255,0.12)] pb-2">Grade information</h3>

                            @if($docs->student->classId)
                            <div class="flex items-start gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                </svg>
                                <div>
                                    <p class="text-sm text-[#bdd1f8]">Class</p>
                                    <p class="font-medium"> {{ $docs->student->className }}</p>
                                </div>
                            </div>
                            @endif

                            @if($docs->student->groupId)
                            <div class="flex items-start gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <div>
                                    <p class="text-sm text-[#bdd1f8]">Group</p>
                                    <p class="font-medium"> {{ $docs->student->groupName }}</p>
                                </div>
                            </div>
                            @endif

                            @if($docs->student->shiftId)
                            <div class="flex items-start gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                                </svg>
                                <div>
                                    <p class="text-sm text-[#bdd1f8]">Shift</p>
                                    <p class="font-medium"> {{ $docs->student->shiftName }}</p>
                                </div>
                            </div>
                            @endif
                        </div> <!-- space-y-4-->
                    </div>

                    {{-- Footer --}}
                    <div class="mt-8 pt-6 border-t border-[rgba(255,255,255,0.12)]">
                        <p class="text-sm text-[#bdd1f8] text-center">
                            Document generated
                            {{ \Carbon\Carbon::now()->locale('en')->isoFormat('MMMM D, YYYY  HH:mm') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div><!-- /.container-full -->
</div><!-- /.content-wrapper -->

<script>
function printDiv(divId) {
    const printContents = document.getElementById(divId).innerHTML;
    const originalTitle = document.title;
    const printWindow = window.open('', '_blank');

    // Estilos básicos para impresión (ajusta según tu diseño)
    const styles = `
        <style>
            @media print {
                .no-print {
                    display: none !important;
                }
            }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                color: #333;
                line-height: 1.6;
                padding: 20px;
            }
            img {
                max-width: 100%;
                height: auto;
            }
            .box, .box-header, .box-body {
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
            }
            /* Copia aquí cualquier clase crítica de Tailwind o CSS que uses */
            /* Por ejemplo, si usas clases como 'text-blue-500', asegúrate de incluir los estilos */
        </style>
        <!-- Si usas Tailwind en modo JIT, es mejor incluir un CDN para impresión -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    `;

    printWindow.document.write(`
        <html>
            <head>
                <title>Print - ${originalTitle}</title>
                ${styles}
            </head>
            <body>
                ${printContents}
            </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();

    // Pequeño retraso para asegurar que el contenido se cargue antes de imprimir
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}
</script>
@endsection
