<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($booking as $item)
            const diagnosaPenunjangSelect{{ $item->id }} = document.getElementById('diagnosaPenunjangSelect-{{ $item->id }}');
            const jumlahDiagnosaPenunjang{{ $item->id }} = document.getElementById('jumlahDiagnosaPenunjang-{{ $item->id }}');
            const hargaPerDiagnosaPenunjang{{ $item->id }} = document.getElementById('hargaPerDiagnosaPenunjang-{{ $item->id }}');
            const totalBiayaDiagnosaPenunjang{{ $item->id }} = document.getElementById('totalBiayaDiagnosaPenunjang-{{ $item->id }}');
    
            // Mengatur harga saat halaman pertama kali dimuat
            const selectedOption{{ $item->id }} = diagnosaPenunjangSelect{{ $item->id }}.options[diagnosaPenunjangSelect{{ $item->id }}.selectedIndex];
            if (selectedOption{{ $item->id }}.value !== "Tidak menggunakan layanan ini") {
                const hargaAwal = selectedOption{{ $item->id }}.getAttribute('data-harga');
                hargaPerDiagnosaPenunjang{{ $item->id }}.value = hargaAwal;
                calculateTotalDiagnosaPenunjang{{ $item->id }}();
            }
    
            diagnosaPenunjangSelect{{ $item->id }}.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                hargaPerDiagnosaPenunjang{{ $item->id }}.value = harga;
                calculateTotalDiagnosaPenunjang{{ $item->id }}();
            });
    
            jumlahDiagnosaPenunjang{{ $item->id }}.addEventListener('input', calculateTotalDiagnosaPenunjang{{ $item->id }});
    
            function calculateTotalDiagnosaPenunjang{{ $item->id }}() {
                const jumlah = jumlahDiagnosaPenunjang{{ $item->id }}.value;
                const harga = hargaPerDiagnosaPenunjang{{ $item->id }}.value;
                const total = jumlah * harga;
                totalBiayaDiagnosaPenunjang{{ $item->id }}.value = total;
            }
        @endforeach
    });
    </script>