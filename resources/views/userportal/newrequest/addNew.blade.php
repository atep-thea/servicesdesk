<script type="text/javascript">
    function terms_changed(termsCheckBox) {
        //If the checkbox has been checked
        if (termsCheckBox.checked) {
            //Set the disabled property to FALSE and enable the button.
            document.getElementById("submit_button").disabled = false;
        } else {
            //Otherwise, disable the submit button.
            document.getElementById("submit_button").disabled = true;
        }
    }
</script>
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="orgDetailLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="padding:0px;width: 1075px;">
        <div class="modal-content">
            <div class="modal-header" style="background: #4f715a;color: #fff;font-size: 15px;">
                <h5 class="modal-title" id="orgDetailLabel">Form Input Layanan</h5>
                <button style="margin-top:-20px !important;" type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true" style="color:#fff">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 6px 3px;">

                <form name="form22" action="{{ route('new_tiket.formPage') }}" onSubmit="return formValidation(this);">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" style="margin-bottom:10px;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h1 class="text-center">Persyaratan</h1>
                                        <div id="syarat" class="form-group" style="margin-left: 2vw;margin-right: 2vw;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <input type="checkbox" id="terms_and_conditions" value="1"
                                        onclick="terms_changed(this)" /> <span class="redSmall">Persyaratan Sudah
                                        Lengkap</span>
                                    <input name="jns_pelayanan" id="jns_pelayanan" type="hidden" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <button id="submit_button" type="submit" class="btn btn-primary"
                                        disabled>Submit</button>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
            </form>

            </body>

            </html>
        </div>
    </div>
</div>
