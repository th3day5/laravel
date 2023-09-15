@extends('layouts.app')

@section('content');
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="multi-step-form" action="{{ route('generate-pdf') }}" method="POST">
                @csrf
                <input type="hidden" name="form_data" id="form_data" value="">
                <input type="hidden" name="token" id="token" value="">

                <!-- Step 1: Personal Information -->

                <div class="step" data-page="1">
                    <h2>Step 1: Personal Information</h2>
                    <!-- Personal information fields here -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" class="form-control" name="first_name" id="first_name">
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname:</label>
                                <input type="text" class="form-control" name="surname" id="surname">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" name="address" id="address">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address-2">Address 2:</label>
                                <input type="text" class="form-control" name="address-2" id="address-2">
                            </div>
                            <div class="form-group">
                                <label for="address-3">Address 3:</label>
                                <input type="text" class="form-control" name="address-3" id="address-3">
                            </div>
                            <div class="form-group">
                                <label for="dob-day">Date of Birth Day:</label>
                                <input type="text" class="form-control" name="dob-day" id="dob-day">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dob-month">Date of Birth Month:</label>
                                <input type="text" class="form-control" name="dob-month" id="dob-month">
                            </div>
                            <div class="form-group">
                                <label for="dob-year">Date of Birth Year:</label>
                                <input type="text" class="form-control" name="dob-year" id="dob-year">
                            </div>
                            <div class="form-group">
                                <label for="ni-number">NI Number:</label>
                                <input type="text" class="form-control" name="ni-number" id="ni-number">
                            </div>
                        </div>
                        <div class="mt-5"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone-number-home">Phone:</label>
                                <input type="text" class="form-control" name="phone-number-home" id="phone-number-home">
                            </div>
                            <div class="form-group">
                                <label for="phone-number-mobile">Mobile:</label>
                                <input type="text" class="form-control" name="phone-number-mobile" id="phone-number-mobile">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" id="email">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency-name">Emergency Contact Name:</label>
                                <input type="text" class="form-control" name="emergency-name" id="emergency-name">
                            </div>
                            <div class="form-group">
                                <label for="emergency-number-work">Emergency Contact Work:</label>
                                <input type="text" class="form-control" name="emergency-number-work" id="emergency-number-work">
                            </div>
                            <div class="form-group">
                                <label for="emergency-number-home">Emergency Contact Home:</label>
                                <input type="text" class="form-control" name="emergency-number-home" id="emergency-number-home">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency-number-mobile">Emergency Contact Mobile:</label>
                                <input type="text" class="form-control" name="emergency-number-mobile" id="emergency-number-mobile">
                            </div>
                            <div class="form-group">
                                <label for="start-date-day">Start Date Day:</label>
                                <input type="text" class="form-control" name="start-date-day" id="start-date-day">
                            </div>
                            <div class="form-group">
                                <label for="start-date-month">Start Date Month:</label>
                                <input type="text" class="form-control" name="start-date-month" id="start-date-month">
                            </div>
                        </div>
                        <div class="mt-5"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start-date-year">Start Date Year:</label>
                                <input type="text" class="form-control" name="start-date-year" id="start-date-year">
                            </div>
                            <div class="form-group">
                                <label for="limited-company-name">Limited Company Name:</label>
                                <input type="text" class="form-control" name="limited-company-name" id="limited-company-name">
                            </div>
                            <div class="form-group">
                                <label for="whats_the_company_name">What's the company name?:</label>
                                <input type="text" class="form-control" name="whats-the-company-name" id="whats-the-company-name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="company-address">Company Address:</label>
                                <input type="text" class="form-control" name="company-address" id="company-address">
                            </div>
                            <div class="form-group">
                                <label for="company-reg-number">Company Registration Number:</label>
                                <input type="text" class="form-control" name="company-reg-number" id="company-reg-number">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Contact Information -->
                <div class="step" data-page="3">
                    <h2>Step 2: Contact Information</h2>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_email">Email:</label>
                            <input type="email" class="form-control" name="contact_email" id="contact_email" required>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Company Information -->
                <div class="step" data-page="4">
                    <h2>Step 3: Company Information</h2>
                    <div class="form-group">
                        <label for="company_name">Company Name:</label>
                        <input type="text" class="form-control" name="company_name" id="company_name">
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="button" class="btn btn-secondary prev-step" onclick="prevStep()">Previous</button>
                    <button type="button" class="btn btn-primary next-step" onclick="nextStep()">Next</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const form = document.getElementById("multi-step-form");
    const steps = Array.from(form.querySelectorAll(".step"));
    let currentStep = 1;
    let formData = {};

    function updateFormData() {
        const currentFormData = {};
        const inputs = Array.from(steps[currentStep - 1].querySelectorAll("input"));

        inputs.forEach(input => {
            currentFormData[input.name] = input.value;
        });

        const stepNumber = steps[currentStep - 1].getAttribute("data-page");
        formData[stepNumber] = currentFormData;

        localStorage.setItem("formData", JSON.stringify(formData));
    }


    function showStep(stepIndex) {
        const stepElement = steps[stepIndex - 1];

        if (currentStep === steps.length + 1) {
            document.querySelector('.text-center button[type="submit"]').removeAttribute('disabled');
        } else {
            document.querySelector('.text-center button[type="submit"]').setAttribute('disabled', true);
        }

        if (stepElement) {
            steps.forEach(step => {
                step.style.display = "none";
            });

            stepElement.style.display = "block";
        }
    }

    function nextStep() {
        updateFormData();
        if (currentStep < steps.length) {
            currentStep++;
            showStep(currentStep);
        }

        if (currentStep === steps.length) {
            document.querySelector('.text-center button[type="submit"]').removeAttribute('disabled');
            document.querySelector('.next-step').setAttribute('disabled', true);
        } else {
            document.querySelector('.text-center button[type="submit"]').setAttribute('disabled', true);
        }

        const stepNumber = steps[currentStep - 1].getAttribute("data-page");

        if (formData[stepNumber]) {
            const stepElement = steps[currentStep - 1];

            if (stepElement) {
                const inputs = Array.from(stepElement.querySelectorAll("input"));
                inputs.forEach(input => {
                    input.value = formData[stepNumber][input.name] || '';
                });
            }
        }
    }

    function prevStep() {
        updateFormData();
        currentStep--;
        showStep(currentStep);

        if (formData[currentStep]) {
            const stepElement = steps[currentStep - 1];

            if (stepElement) {
                const inputs = Array.from(stepElement.querySelectorAll("input"));
                inputs.forEach(input => {
                    input.value = formData[currentStep][input.name] || '';
                });
            }
        }
    }

    window.addEventListener("load", () => {
        const savedFormData = localStorage.getItem("formData");

        if (savedFormData) {
            formData = JSON.parse(savedFormData);

            for (let i = 0; i < steps.length; i++) {
                const stepNumber = steps[i].getAttribute("data-page");
                const inputs = Array.from(steps[i].querySelectorAll("input"));

                if (formData[stepNumber]) {
                    inputs.forEach(input => {
                        input.value = formData[stepNumber][input.name] || '';
                    });
                }
            }

            showStep(currentStep);
        } else {
            showStep(currentStep);
        }
    });


    form.addEventListener("submit", event => {
        event.preventDefault();
        updateFormData();

        const formDataInput = document.getElementById("form_data");
        formDataInput.value = JSON.stringify(formData);

        form.submit();
    });
</script>
@endsection
