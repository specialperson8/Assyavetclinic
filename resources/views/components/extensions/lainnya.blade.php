<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($booking as $item)
            const lainnyaSelect{{ $item->id }} = document.getElementById('lainnyaSelect-{{ $item->id }}');
            const jumlahTindakan{{ $item->id }} = document.getElementById('jumlahTindakan-{{ $item->id }}');
            const hargaPerTindakan{{ $item->id }} = document.getElementById('hargaPerTindakan-{{ $item->id }}');
            const totalBiayaTindakan{{ $item->id }} = document.getElementById('totalBiayaTindakan-{{ $item->id }}');
        
            lainnyaSelect{{ $item->id }}.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-tindakanlain');
                hargaPerTindakan{{ $item->id }}.value = harga;
                calculateTotalTindakan{{ $item->id }}();
            });
        
            jumlahTindakan{{ $item->id }}.addEventListener('input', calculateTotalTindakan{{ $item->id }});
        
            function calculateTotalTindakan{{ $item->id }}() {
                const jumlah = jumlahTindakan{{ $item->id }}.value;
                const harga = hargaPerTindakan{{ $item->id }}.value;
                const total = jumlah * harga;
                totalBiayaTindakan{{ $item->id }}.value = total;
            }
        @endforeach
    });
</script>