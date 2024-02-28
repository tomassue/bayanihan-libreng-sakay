<!-- dataPrivacyModal -->
<div class="modal fade" id="dataPrivacyModal" tabindex="-1" aria-labelledby="dataPrivacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                <h1 class="modal-title fs-5 fw-bolder" id="dataPrivacyModalLabel">Privacy Info</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row fw-bolder" style="color: #0A335D;">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="flexCheckDefault" id="flexCheckDefault" required>
                                <label class="form-check-label" for="flexCheckDefault" style="text-align: justify; text-justify: inter-word;">
                                    <p>By submitting the data required, YOU consent to the collection, generation, use, processing, storage and retention of your personal information to the CDO Volunteerism for the purpose of Bayanihan Libreng Sakay program.</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fw-bolder justify-content-center">
                    <!-- <button type="submit" class="btn btn-danger fw-bolder mt-2" style="width: 100px;">PROCEED</button> -->

                    <!-- Form submit button, including reCAPTCHA V3 attributes -->
                    <button class="g-recaptcha btn btn-primary fw-bolder mt-2" id="myButton" data-sitekey="{{ config('services.recaptcha_v3.siteKey') }}" data-callback="onSubmit" data-action="submitRegistration" style="width: 100px;" disabled>PROCEED</button>
                </div>
            </div>
        </div>
    </div>
</div>