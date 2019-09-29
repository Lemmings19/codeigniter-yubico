<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-4">
            <h1>Register</h1>

            <?php $this->load->helper('form'); ?>

            <div class="text-danger">
                <?php echo validation_errors(); ?>
            </div>

            <?php echo form_open('users/register'); ?>

                <div id="basicInfo">
                    <div class="form-group">
                        <label for="name" class="control-label">
                            <span class="text-grey fal fa-fw fa-id-card"></span>
                            Name
                        </label>

                        <input required maxlength="100" type="text" class="form-control" name="name" value="" placeholder="Your name" title="3 to 100 characters" />
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">
                            <span class="text-grey fal fa-fw fa-at"></span>
                            Email
                        </label>

                        <input required type="email" maxlength="255" data-max-length="255" class="form-control" name="email" value="" placeholder="Your email" minlength="5" />
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label">
                            <span class="text-grey fal fa-fw fa-key"></span>
                            Password
                        </label>

                        <input required type="password" class="form-control" name="password" placeholder="8 or more characters" title="8 or more characters" />
                    </div>

                    <!--
                    <div class="margin-bottom">
                        <label for="password-confirm" class="control-label"></label>

                        <input required type="password" class="form-control" name="password_confirmation" placeholder="password (again)">
                    </div>
                    -->

                    <div class="form-group">
                        <span id="showAuthTypes" class="disabled btn btn-primary">
                            Next
                            <span class="fas fa-arrow-right"></span>
                        </span>
                    </div>
                </div>

                <div id="authTypes" class="form-group" style="display:none;">
                    <div class="">
                        <label>
                            <input type="checkbox" name="use_tfa" value="1" class="" /> Use Two-Factor Autentication
                        </label>
                    </div>

                    <div class="">
                        <label>
                            <input type="checkbox" name="use_sns" value="1" class="" /> Use Simple Notification Services
                        </label>
                    </div>

                    <div class="">
                        <label>
                            <input checked type="checkbox" name="use_physical_key" value="1" class="" /> Use Physical Key
                        </label>
                    </div>

                    <div class="form-group">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <span id="submitAuthTypes" class="btn btn-primary">
                                    Next
                                    <span class="fas fa-arrow-right"></span>
                                </span>
                            </li>
                            <li class="list-inline-item">
                                <span id="showBasicInfo" class="btn btn-link">
                                    Back
                                </span>
                            </li>

                            <li class="list-inline-item">
                                <button class="btn btn-primary">
                                    (testing) Submit
                                </button>
                            </li>
                    </div>
                </div>

                <div id="physKeyModal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Insert phyiscal key</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ol>
                                    <li>
                                        Insert your physical key into your computer's USB port or connect it with a USB cable.
                                    </li>
                                    <li>
                                        Once connected, tap the button or gold disk if your key has one.
                                    </li>
                                </ol>

                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Back</button>
                                <button type="button" class="btn btn-primary">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#basicInfo").change(function () {
            if ($("[name=name]").val() && $("[name=email]").val() && $("[name=password]").val()) {
                $("#showAuthTypes").removeClass("disabled");
            }
        });

        $("#showAuthTypes").click(function () {
            if (!$(this).hasClass("disabled")) {
                $("#basicInfo").hide();
                $("#authTypes").show();
            }
        });

        $("#showBasicInfo").click(function () {
            $("#authTypes").hide();
            $("#basicInfo").show();
        });

        $("#submitAuthTypes").click(function () {
            if ($("[name=use_physical_key]").is(":checked")) {
                $('#physKeyModal').modal('show');
            }
        });
    });
</script>
