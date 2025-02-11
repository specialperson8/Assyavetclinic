<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($booking as $item)
            const groomingSelect{{ $item->id }} = document.getElementById('groomingSelect-{{ $item->id }}');
            const jumlahGrooming{{ $item->id }} = document.getElementById('jumlahGrooming-{{ $item->id }}');
            const hargaPerGrooming{{ $item->id }} = document.getElementById('hargaPerGrooming-{{ $item->id }}');
            const totalBiayaGrooming{{ $item->id }} = document.getElementById('totalBiayaGrooming-{{ $item->id }}');
    
            // Mengatur harga saat halaman pertama kali dimuat
            const selectedOption{{ $item->id }} = groomingSelect{{ $item->id }}.options[groomingSelect{{ $item->id }}.selectedIndex];
            if (selectedOption{{ $item->id }}.value !== "Tidak menggunakan layanan ini") {
                const hargaAwal = selectedOption{{ $item->id }}.getAttribute('data-harga');
                hargaPerGrooming{{ $item->id }}.value = hargaAwal;
                calculateTotalGrooming{{ $item->id }}();
            }
    
            groomingSelect{{ $item->id }}.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                hargaPerGrooming{{ $item->id }}.value = harga;
                calculateTotalGrooming{{ $item->id }}();
            });
    
            jumlahGrooming{{ $item->id }}.addEventListener('input', calculateTotalGrooming{{ $item->id }});
    
            function calculateTotalGrooming{{ $item->id }}() {
                const jumlah = jumlahGrooming{{ $item->id }}.value;
                const harga = hargaPerGrooming{{ $item->id }}.value;
                const total = jumlah * harga;
                totalBiayaGrooming{{ $item->id }}.value = total;
            }
        @endforeach
    });
    </script>