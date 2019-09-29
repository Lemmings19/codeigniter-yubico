<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-4">
            <h1>Successfully logged in!</h1>
            <?php if (isset($name)): ?>
                <p class="lead">
                    Welcome, <?php echo $name; ?>.
                </p>
            <?php else: ?>
                <small class="text-muted">(not really)</small>
            <?php endif; ?>
        </div>
    </div>
</div>
