<script>
    let currentStep = 1;
    const totalSteps = 5;

    function updateVehicleUI(type) {
        const specCar = document.getElementById('spec_car');
        const specMotor = document.getElementById('spec_motor');
        const transSelect = document.getElementById('transmission_select');

        if (!specCar || !specMotor) return;

        const carInputs = specCar.querySelectorAll('input, select');
        const motorInputs = specMotor.querySelectorAll('input, select');

        if (type === 'car') {
            specCar.classList.remove('d-none');
            specMotor.classList.add('d-none');
            carInputs.forEach(i => i.disabled = false);
            motorInputs.forEach(i => i.disabled = true);

            transSelect.innerHTML = `
                <option value="" selected disabled>Pilih Transmisi Mobil</option>
                <option value="Manual">Manual</option>
                <option value="Automatic">Automatic</option>
            `;
        } else {
            specCar.classList.add('d-none');
            specMotor.classList.remove('d-none');
            carInputs.forEach(i => i.disabled = true);
            motorInputs.forEach(i => i.disabled = false);

            transSelect.innerHTML = `
                <option value="" selected disabled>Pilih Transmisi Motor</option>
                <option value="Matic">Matic</option>
                <option value="Manual">Manual</option>
            `;
        }

        const savedTrans =
            "{{ old('transmission', $vehicle->car->transmission ?? ($vehicle->motorcycle->transmission ?? '')) }}";
        if (savedTrans) {
            transSelect.value = savedTrans;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const checkedInput = document.querySelector('input[name="vehicle_type"]:checked');
        if (checkedInput) {
            updateVehicleUI(checkedInput.value);
        }

        document.querySelectorAll('input[name="vehicle_type"]').forEach((elem) => {
            elem.addEventListener("change", function() {
                updateVehicleUI(this.value);
            });
        });

        const rateInput = document.getElementById('daily_rate');
        if (rateInput && rateInput.value) {
            rateInput.dispatchEvent(new Event('input'));
        }

        toggleButtons();
    });

    function validateStep(step) {
        const activeStep = document.getElementById(`step-${step}`);
        const inputs = activeStep.querySelectorAll(
            'input[required]:not(:disabled), select[required]:not(:disabled), #daily_rate_display[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        return isValid;
    }

    document.getElementById('nextBtn').addEventListener('click', () => {
        if (!validateStep(currentStep)) return;

        if (currentStep < totalSteps) {
            document.getElementById(`step-${currentStep}`).classList.add('d-none');
            currentStep++;
            document.getElementById(`step-${currentStep}`).classList.remove('d-none');
            updateStepper(currentStep);
            toggleButtons();
        }
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentStep > 1) {
            document.getElementById(`step-${currentStep}`).classList.add('d-none');
            currentStep--;
            document.getElementById(`step-${currentStep}`).classList.remove('d-none');
            updateStepper(currentStep);
            toggleButtons();
        }
    });

    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }
    const displayInput = document.getElementById('daily_rate_display');
    const realInput = document.getElementById('daily_rate_real');

    if (displayInput) {
        displayInput.addEventListener('input', function(e) {
            let rawValue = this.value.replace(/[^0-9]/g, '');
            realInput.value = rawValue;
            this.value = formatRupiah(rawValue);
            const preview = document.getElementById('formatted_price_preview');
            if (rawValue) {
                preview.innerText = "Terbaca: Rp " + new Intl.NumberFormat('id-ID').format(rawValue);
            } else {
                preview.innerText = "";
            }
        });
    }

    function toggleButtons() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        if (prevBtn) prevBtn.classList.toggle('d-none', currentStep === 1);
        if (nextBtn) nextBtn.classList.toggle('d-none', currentStep === totalSteps);
        if (submitBtn) submitBtn.classList.toggle('d-none', currentStep !== totalSteps);
    }

    function updateStepper(step) {
        document.querySelectorAll('.step-item').forEach((item, index) => {
            const icon = item.querySelector('.step-icon');
            const text = item.querySelector('span:last-child');
            const number = icon.querySelector('span');

            if (index + 1 < step) {
                icon.classList.replace('bg-dark', 'bg-success');
                icon.classList.replace('bg-primary', 'bg-success');
                text.classList.add('text-success');
                text.classList.remove('text-primary', 'text-secondary');
                number.classList.replace('text-secondary', 'text-white');
            } else if (index + 1 === step) {
                icon.classList.replace('bg-dark', 'bg-primary');
                icon.classList.replace('bg-success', 'bg-primary');
                text.classList.add('text-primary', 'fw-bold');
                text.classList.remove('text-secondary', 'text-success');
                number.classList.replace('text-secondary', 'text-white');
            } else {
                icon.classList.replace('bg-primary', 'bg-dark');
                icon.classList.replace('bg-success', 'bg-dark');
                text.classList.add('text-secondary');
                text.classList.remove('text-primary', 'text-success', 'fw-bold');
                number.classList.replace('text-white', 'text-secondary');
            }
        });
    }
</script>

<style>
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.2);
    }

    .form-control:focus,
    .form-select:focus {
        background-color: #1a1b1e !important;
        border: 1px solid #0d6efd !important;
    }

    .btn-outline-secondary:hover {
        background-color: rgba(13, 110, 253, 0.1);
        border-color: #0d6efd;
        color: #fff;
    }

    .btn-check:checked+.btn-outline-secondary {
        background-color: rgba(13, 110, 253, 0.1);
        border-color: #0d6efd;
        color: #0d6efd;
        font-weight: bold;
    }

    .custom-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    }

    .border-dashed {
        border-style: dashed !important;
    }
</style>
