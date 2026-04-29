<script>
    let currentStep = 1;
    const totalSteps = 5;

    document.getElementById('nextBtn').addEventListener('click', () => {
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

    function toggleButtons() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        prevBtn.classList.toggle('d-none', currentStep === 1);
        nextBtn.classList.toggle('d-none', currentStep === totalSteps);
        submitBtn.classList.toggle('d-none', currentStep !== totalSteps);
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
