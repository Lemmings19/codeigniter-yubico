# codeigniter-yubico
For user registration and sign-in with Yubico One Time Password

## Gotchas!
Stuff that isn't obvious gets documented here.

### Yubico? U2F? More like Webauthn!

Documentation for Yubico is **terrible** and unreliable. Links that go nowhere, documentation that's been deprecated, citations that lead you in circles and are ultimately self-referrential, and so on. Things are clearly still a work in progress, so take everything you read with a giant grain of salt.

### Libraries? What libraries!

There's dozens of potential libraries to use for Yubico integration. Who can say which you should be using? I've chosen [davidearl/webauthn/](https://github.com/davidearl/webauthn/) because it has a working example, is written in PHP, and looks relatively readable and straightforward.

### Composer? In CodeIgniter3?!

`composer.json` needs to live in the `application` folder, not the root folder. Add `application/vendor` to your gitignore.

You'll also need to update a `composer` related variable in `config.php`...

### GET vs POST requests?!

I'm not yet sure how to make POST requests function properly. So I'm just using GET requests for now. Ouch.

### How do I execute that migration I just made?

According to various online sources, you'll need to create your own code to execute the migration...

### .htaccess

You'll probably need to add one of these to the root directory for Apache to work with the project.

### Why is my app working locally, but not remotely? Or why is it just not working at all?

`config.php` requires you to enter the URL of the app. If it's `localhost`, it's only gonna work locally. To get it to work on a remote connection, you'll need to provide the local ip (and now it no longer works on localhost)...

### Why is `index.php` on every page?

`config.php` default, of course...

### Why is the key login not working on my browser?

Are you using Linux? Some stuff just works on Windows, but not linux. Or maybe you're using Chrome and it works on Firefox. Or the other way around. Who knows! This stuff isn't 100% supported everywhere yet.