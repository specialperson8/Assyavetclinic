<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($booking as $item)
            const jumlahTransportasi{{ $item->id }} = document.getElementById('jumlahTransportasi-{{ $item->id }}');
            const hargaPerTransportasi{{ $item->id }} = document.getElementById('hargaPerTransportasi-{{ $item->id }}');
            const totalBiayaTransportasi{{ $item->id }} = document.getElementById('totalBiayaTransportasi-{{ $item->id }}');
    
            function calculateTotalTransportasi{{ $item->id }}() {
                const jumlah = parseFloat(jumlahTransportasi{{ $item->id }}.value) || 0;
                const harga = parseFloat(hargaPerTransportasi{{ $item->id }}.value) || 0;
                const total = jumlah * harga;
                totalBiayaTransportasi{{ $item->id }}.value = total.toFixed(0); // Menampilkan hasil tanpa angka di belakang koma
            }
    
            jumlahTransportasi{{ $item->id }}.addEventListener('input', calculateTotalTransportasi{{ $item->id }});
            hargaPerTransportasi{{ $item->id }}.addEventListener('input', calculateTotalTransportasi{{ $item->id }});
    
            // Menghitung total saat halaman pertama kali dimuat
            calculateTotalTransportasi{{ $item->id }}();
        @endforeach
    });
    </script>