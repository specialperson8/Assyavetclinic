<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($booking as $item)
            const operasiSelect{{ $item->id }} = document.getElementById('operasiSelect-{{ $item->id }}');
            const jumlahOperasi{{ $item->id }} = document.getElementById('jumlahOperasi-{{ $item->id }}');
            const hargaPerOperasi{{ $item->id }} = document.getElementById('hargaPerOperasi-{{ $item->id }}');
            const totalBiayaOperasi{{ $item->id }} = document.getElementById('totalBiayaOperasi-{{ $item->id }}');
    
            // Mengatur harga saat halaman pertama kali dimuat
            const selectedOption{{ $item->id }} = operasiSelect{{ $item->id }}.options[operasiSelect{{ $item->id }}.selectedIndex];
            if (selectedOption{{ $item->id }}.value !== "Tidak menggunakan layanan ini") {
                const hargaAwal = selectedOption{{ $item->id }}.getAttribute('data-harga');
                hargaPerOperasi{{ $item->id }}.value = hargaAwal;
                calculateTotalOperasi{{ $item->id }}();
            }
    
            operasiSelect{{ $item->id }}.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                hargaPerOperasi{{ $item->id }}.value = harga;
                calculateTotalOperasi{{ $item->id }}();
            });
    
            jumlahOperasi{{ $item->id }}.addEventListener('input', calculateTotalOperasi{{ $item->id }});
    
            function calculateTotalOperasi{{ $item->id }}() {
                const jumlah = jumlahOperasi{{ $item->id }}.value;
                const harga = hargaPerOperasi{{ $item->id }}.value;
                const total = jumlah * harga;
                totalBiayaOperasi{{ $item->id }}.value = total;
            }
        @endforeach
    });
    </script>