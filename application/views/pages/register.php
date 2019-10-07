<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 col-lg-4">
            <h1>Register</h1>

            <?php $this->load->helper('form'); ?>

            <div class="text-danger">
                <?php echo validation_errors(); ?>
            </div>

            <div class="js-error alert alert-danger" style="display:none">
            </div>

            <div id="done" class="alert alert-success" style="display:none">
            </div>

            <?php echo form_open('users/register', ['id' => 'registerForm']); ?>
                <fieldset id="registerFormFieldset">

                    <div id="basicInfo">
                        <div class="form-group">
                            <label for="name" class="control-label">
                                <span class="text-grey fas fa-fw fa-id-card"></span>
                                Name
                            </label>

                            <input required maxlength="100" type="text" class="form-control" name="name" value="" placeholder="Your name" title="3 to 100 characters" />
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">
                                <span class="text-grey fas fa-fw fa-at"></span>
                                Email
                            </label>

                            <input required type="email" maxlength="255" data-max-length="255" class="form-control" name="email" value="" placeholder="Your email" minlength="5" />
                        </div>

                        <div class="form-group">
                            <label for="password" class="control-label">
                                <span class="text-grey fas fa-fw fa-key"></span>
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
                            <button id="showAuthTypes" type="button" class="disabled btn btn-primary">
                                Next
                                <span class="fas fa-arrow-right"></span>
                            </button>
                        </div>
                    </div>

                    <div id="authTypes" class="form-group" style="display:none;">
                        <div class="">
                            <label>
                                <input type="checkbox" name="use_tfa" value="1" class="" />
                                <span class="fas fa-fw fa-shield-check"></span>
                                Use Two-Factor Autentication
                            </label>
                        </div>

                        <div class="">
                            <label>
                                <input type="checkbox" name="use_sns" value="1" class="" />
                                <span class="fas fa-fw fa-envelope"></span>
                                Use Simple Notification Services
                            </label>
                        </div>

                        <div class="">
                            <label>
                                <input checked type="checkbox" name="use_physical_key" value="1" class="" />
                                <span class="fas fa-fw fa-usb-drive"></span>
                                Use Physical Key
                            </label>
                        </div>

                        <div class="form-group">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <button id="submitAuthTypes" type="button" class="btn btn-primary">
                                        Next
                                        <span class="fas fa-arrow-right"></span>
                                    </button>
                                </li>
                                <li class="list-inline-item">
                                    <button id="showBasicInfo" type="button" class="btn btn-link">
                                        Back
                                    </button>
                                </li>

                                <li class="list-inline-item">
                                    <button class="btn btn-success">
                                        (testing) Submit
                                    </button>
                                </li>
                        </div>
                    </div>

                    <div id="authTypesLoading" class="form-group" style="display:none;">
                        <div class="text-primary">
                            <span class="display-4 fad fa-spinner fa-pulse"></span>
                        </div>
                    </div>

                    <div id="physKeyModal" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <span class="fas fa-fw fa-usb-drive"></span>
                                        Insert physical key
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="js-error alert alert-danger">
                                    </div>

                                    <ol>
                                        <li>
                                            Insert your physical key into your computer's USB port or connect it with a USB cable.
                                        </li>
                                        <li>
                                            Once connected, tap the button or gold disk if your key has one.
                                        </li>
                                    </ol>

                                    <!--
                                    <div class="form-group">
                                        <input autocomplete="off" type="text" name="physical_key" maxlength="12" class="form-control">
                                    </div>
                                    -->

                                    <div class="d-flex justify-content-center form-group">
                                        <div id="physKeyLoading" class="text-primary">
                                            <span class="display-4 fad fa-spinner fa-pulse"></span>
                                        </div>

                                        <div id="physKeyLoaded" class="text-primary" style="display:none;">
                                            <span class="display-4 fas fa-check-circle"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Back</button>
                                    <!-- <button id="physKeySubmit" type="button" autocomplete="off" disabled class="btn btn-primary">
                                        Continue
                                        <span class="fas fa-arrow-right"></span>
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo public_url(); ?>js/register.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {

        /**
         * View manipulation
         */

        // Prevent form submission when Enter is pressed
        $(":text").on("keypress keyup", function (e) {
            if (e.which == 13) {
                return false;
            }
        });
        $(":checkbox, :radio").on("keypress keyup", function (e) {
            if (e.which == 13) {
                return false;
            }
        });

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
                // Do pre-check

                // Show modal
                // $("#physKeyModal").modal("show");

                // Prompt for key

                // $("[name=physical_key]").focus();



                // var self = $(this);
                // e.preventDefault();

                /**
                // For toggling whether we want to authenticate with a key or a platform (eg. the PC itself)
                var crossPlatform = $("select[name=cross_platform]").val();
                if (crossPlatform == "") {
                    $(".js-error").show().text("Please choose cross-platform setting - see note below about what this means");
                    return;
                }
                */


                var crossPlatform = true;

                $("#authTypes,#authTypesLoading").toggle();

                $(".js-error").empty().hide();

                $.ajax({
                    url: "/api/register_username",
                    method: "GET",
                    data: {
                        name :             $("[name=name]").val(),
                        email :            $("[name=email]").val(),
                        password :         $("[name=password]").val(),
                        use_tfa :          $("[name=use_tfa]").val(),
                        use_sns :          $("[name=use_sns]").val(),
                        use_physical_key : $("[name=use_physical_key]").val(),
                        crossplatform :    crossPlatform},
                    dataType: "json",
                    success: function(result) {
                        $("#authTypes,#authTypesLoading").toggle();
                        $("#physKeyModal").modal("show");

                        /* activate the key and get the response */
                        webauthnRegister(result.challenge, function(success, info) {
                            if (success) {
                                $.ajax({
                                    url: "/api/register",
                                    method: "GET",
                                    data: {
                                        name :     $("[name=name]").val(),
                                        email :    $("[name=email]").val(),
                                        password : $("[name=password]").val(),
                                        register : info
                                    },
                                    dataType: "json",
                                    success: function(result){
                                        $("#physKeyLoading").hide();
                                        $("#physKeyLoaded").show();
                                        $("#physKeyModal").modal("hide");
                                        $("#done").text("Registration completed successfully").show();
                                        $("#registerFormFieldset").prop("disabled", true);

                                        // TODO: Redirect to login?
                                    },
                                    error: function(xhr, status, error){
                                        $("#physKeyModal").modal("hide");
                                        $(".js-error").html("Registration failed: " + error + ": " + xhr.responseText).show();
                                    }
                                });
                            } else {
                                $(".js-error").text(info).show();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        $("#authTypes,#authTypesLoading").toggle();
                        $(".js-error").html("Couldn't initiate registration: " + error + ": " + xhr.responseText).show();
                    }
                });
            }
        });

        // $("[name=physical_key]").change(function () {
        //     if ($(this).val().length == 12) {
        //         $("#physKeyLoading").hide();
        //         $("#physKeyLoaded").show();
        //         $("[name=physical_key]").blur();
        //         $("#physKeySubmit").prop("disabled", false);
        //     } else {
        //         $("#physKeyLoading").show();
        //         $("#physKeyLoaded").hide();
        //         $("[name=physical_key]").focus();
        //         $("#physKeySubmit").prop("disabled", true);
        //     }
        // });

        $("#physKeySubmit").click(function() {
            if (!$(this).is(":disabled")) {
                console.log('submitting');
                document.getElementById("registerForm").submit();
            }
        });

        /**
         * Key stuff
         */

        $("#registerForm").submit(function(e){

        });
    });
</script>
