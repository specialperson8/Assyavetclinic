<script>
document.addEventListener('DOMContentLoaded', function () {
    @foreach ($booking as $item)
        const vaksinSelect{{ $item->id }} = document.getElementById('vaksinSelect-{{ $item->id }}');
        const jumlahVaksin{{ $item->id }} = document.getElementById('jumlahVaksin-{{ $item->id }}');
        const hargaPerItem{{ $item->id }} = document.getElementById('hargaPerItem-{{ $item->id }}');
        const totalBiaya{{ $item->id }} = document.getElementById('totalBiaya-{{ $item->id }}');

        // Mengatur harga saat halaman pertama kali dimuat
        const selectedOption{{ $item->id }} = vaksinSelect{{ $item->id }}.options[vaksinSelect{{ $item->id }}.selectedIndex];
        if (selectedOption{{ $item->id }}.value !== "Tidak menggunakan layanan ini") {
            const hargaAwal = selectedOption{{ $item->id }}.getAttribute('data-price');
            hargaPerItem{{ $item->id }}.value = hargaAwal;
            calculateTotal{{ $item->id }}();
        }

        vaksinSelect{{ $item->id }}.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-price');
            hargaPerItem{{ $item->id }}.value = harga;
            calculateTotal{{ $item->id }}();
        });

        jumlahVaksin{{ $item->id }}.addEventListener('input', calculateTotal{{ $item->id }});

        function calculateTotal{{ $item->id }}() {
            const jumlah = jumlahVaksin{{ $item->id }}.value;
            const harga = hargaPerItem{{ $item->id }}.value;
            const total = jumlah * harga;
            totalBiaya{{ $item->id }}.value = total;
        }
    @endforeach
});

</script><script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($booking as $item)
            const vaksinSelect{{ $item->id }} = document.getElementById('vaksinSelect-{{ $item->id }}');
            const jumlahVaksin{{ $item->id }} = document.getElementById('jumlahVaksin-{{ $item->id }}');
            const hargaPerItem{{ $item->id }} = document.getElementById('hargaPerItem-{{ $item->id }}');
            const totalBiaya{{ $item->id }} = document.getElementById('totalBiaya-{{ $item->id }}');
        
            vaksinSelect{{ $item->id }}.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-price');
                hargaPerItem{{ $item->id }}.value = harga;
                calculateTotal{{ $item->id }}();
            });
        
            jumlahVaksin{{ $item->id }}.addEventListener('input', calculateTotal{{ $item->id }});
        
            function calculateTotal{{ $item->id }}() {
                const jumlah = jumlahVaksin{{ $item->id }}.value;
                const harga = hargaPerItem{{ $item->id }}.value;
                const total = jumlah * harga;
                totalBiaya{{ $item->id }}.value = total;
            }
        @endforeach
    });
</script>