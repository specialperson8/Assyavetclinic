<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($booking as $item)
            const jasaDokterSelect{{ $item->id }} = document.getElementById('jasaDokterSelect-{{ $item->id }}');
            const jumlahJasaDokter{{ $item->id }} = document.getElementById('jumlahJasaDokter-{{ $item->id }}');
            const hargaPerJasaDokter{{ $item->id }} = document.getElementById('hargaPerJasaDokter-{{ $item->id }}');
            const totalBiayaJasaDokter{{ $item->id }} = document.getElementById('totalBiayaJasaDokter-{{ $item->id }}');
    
            // Mengatur harga saat halaman pertama kali dimuat
            const selectedOption{{ $item->id }} = jasaDokterSelect{{ $item->id }}.options[jasaDokterSelect{{ $item->id }}.selectedIndex];
            if (selectedOption{{ $item->id }}.value !== "Tidak menggunakan layanan ini") {
                const hargaAwal = selectedOption{{ $item->id }}.getAttribute('data-harga');
                hargaPerJasaDokter{{ $item->id }}.value = hargaAwal;
                calculateTotalJasaDokter{{ $item->id }}();
            }
    
            jasaDokterSelect{{ $item->id }}.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                hargaPerJasaDokter{{ $item->id }}.value = harga;
                calculateTotalJasaDokter{{ $item->id }}();
            });
    
            jumlahJasaDokter{{ $item->id }}.addEventListener('input', calculateTotalJasaDokter{{ $item->id }});
    
            function calculateTotalJasaDokter{{ $item->id }}() {
                const jumlah = jumlahJasaDokter{{ $item->id }}.value;
                const harga = hargaPerJasaDokter{{ $item->id }}.value;
                const total = jumlah * harga;
                totalBiayaJasaDokter{{ $item->id }}.value = total;
            }
        @endforeach
    });
    </script>