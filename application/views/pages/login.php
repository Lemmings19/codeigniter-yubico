<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 col-lg-4">
            <h1>Login</h1>

            <?php $this->load->helper('form'); ?>

            <div class="text-danger">
                <?php echo validation_errors(); ?>
                <?php if (isset($error)){
                    echo $error;
                } ?>
            </div>

            <div class="js-error alert alert-danger" style="display:none;">
            </div>

            <div id="done" class="alert alert-success" style="display:none;">
            </div>

            <?php echo form_open('users/login', ['id' => 'loginForm']); ?>

                <div id="basicInfo">
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

                        <input required type="password" class="form-control" name="password" placeholder="Your password" title="Enter your password" />
                    </div>

                    <!--
                    <div class="margin-bottom">
                        <label for="password-confirm" class="control-label"></label>

                        <input required type="password" class="form-control" name="password_confirmation" placeholder="password (again)" />
                    </div>
                    -->

                    <div class="form-group">
                        <span id="login" class="btn btn-primary">
                            Login
                            <span class="fas fa-sign-in-alt"></span>
                        </span>
                        <button class="btn btn-success">
                            (testing) Submit
                        </button>
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
                                <div class="js-error alert alert-danger" style="display:none;">
                                </div>

                                <ol>
                                    <li>
                                        Insert your physical key into your computer's USB port or connect it with a USB cable.
                                    </li>
                                    <li>
                                        Once connected, tap the button or gold disk if your key has one.
                                    </li>
                                </ol>

                                <div id="loginKey">
                                    Do your thing: press button on key, swipe fingerprint or whatever
                                </div>

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
        $("#login").click(function () {
            if (true) {
                $('#physKeyModal').modal('show');
            }
        });

        $("#loginForm").submit(function(e){
            var self = $(this);
            e.preventDefault();
            $(".js-error").empty().hide();
            $.ajax({url: "/",
                method: "POST",
                data: {loginusername: self.find("[name=loginusername]").val()},
                dataType: "json",
                success: function(result){
                    $("#loginForm,#loginKey").toggle();
                    /* activate the key and get the response */
                    webauthnAuthenticate(result.challenge, function(success, info){
                        if (success) {
                            $.ajax({url: "/",
                                method: "POST",
                                data: {login: info},
                                dataType: "json",
                                success: function(result){
                                    $("#loginForm,#loginKey").toggle();
                                    $("#done").text("login completed successfully").show();
                                    setTimeout(function(){ $("#done").hide(300); }, 2000);
                                },
                                error: function(xhr, status, error){
                                    $(".js-error").text("login failed: " + error + ": " + xhr.responseText).show();
                                }
                            });
                        } else {
                            $(".js-error").text(info).show();
                        }
                    });
                },
                error: function(xhr, status, error){
                    $("#loginForm").show();
                    $("#loginKey").hide();
                    $(".js-error").text("couldn't initiate login: " + error + ": " + xhr.responseText).show();
                }
            });
        });
    });
</script>
