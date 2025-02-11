<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookingItems = @json($booking);

        bookingItems.forEach(item => {
            const selectKaryawan = document.querySelector(#karyawanSelect-${item.id});
            const inputKaryawan1 = document.querySelector(.karyawan1-${item.id});
            const inputKaryawan2 = document.querySelector(.karyawan2-${item.id});
            const inputKaryawan3 = document.querySelector(.karyawan3-${item.id});

            function hideAllInputs() {
                inputKaryawan1.style.display = 'none';
                inputKaryawan2.style.display = 'none';
                inputKaryawan3.style.display = 'none';
            }

            function showInputBasedOnSelection() {
                const selectedValue = selectKaryawan.value;
                hideAllInputs();
                if (selectedValue === "1") {
                    inputKaryawan1.style.display = 'block';
                } else if (selectedValue === "2") {
                    inputKaryawan1.style.display = 'block';
                    inputKaryawan2.style.display = 'block';
                } else if (selectedValue === "3") {
                    inputKaryawan1.style.display = 'block';
                    inputKaryawan2.style.display = 'block';
                    inputKaryawan3.style.display = 'block';
                }
            }

            hideAllInputs(); // Sembunyikan semua input pada awal
            showInputBasedOnSelection(); // Tampilkan input berdasarkan nilai yang sudah ada
            selectKaryawan.addEventListener('change', showInputBasedOnSelection);
        });
    });
</script>