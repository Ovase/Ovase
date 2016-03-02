
var passport = require('passport');
var bcrypt = require('bcrypt-nodejs');

var Model = require('./../model');

// Sign in GET (go to login page)
var signIn = function(req, res, next) {
    if (req.isAuthenticated()) res.redirect('/');
    res.render('signin', {
        title: 'Sign In'
    });
};

// Sign in POST (try to log in)
var signInPost = function(req, res, next) {
    passport.authenticate('local', {
        successRedirect: '/',
        failureRedirect: '/signin'
    }, function(err, user, info) {
        if (err) {
            return res.render('signin', {
                title: 'Sign In',
                errorMessage: err.message
            });
        }

        if (!user) {
            return res.render('signin', {
                title: 'Sign In',
                errorMessage: info.message
            });
        }
        return req.logIn(user, function(err) {
            if (err) {
                return res.render('signin', {
                    title: 'Sign In',
                    errorMessage: err.message
                });
            } else {
                return res.redirect('/');
            }
        });
    })(req, res, next);
};

// Sign up GET (go to sign up page)
var signUp = function(req, res, next) {
    if (req.isAuthenticated()) {
        res.redirect('/');
    } else {
        res.render('signup', {
            title: 'Sign Up'
        });
    }
};

// Sign up POST (try to create user)
var signUpPost = function(req, res, next) {
    var user = req.body;
    var usernamePromise = null;
    usernamePromise = new Model.User({
        username: user.username
    }).fetch();

    return usernamePromise.then(function(model) {
        if (model) {
            res.render('signup', {
                title: 'signup',
                errorMessage: 'username already exists'
            });
        } else {
            //****************************************************//
            // MORE VALIDATION GOES HERE(E.G. PASSWORD VALIDATION)
            //****************************************************//
            var password = user.password;
            var hash = bcrypt.hashSync(password);

            var signUpUser = new Model.User({
                username: user.username,
                password: hash
            });

            signUpUser.save().then(function(model) {
                // sign in the newly registered user
                signInPost(req, res, next);
            });
        }
    });
};

var signOut = function(req, res, next) {
    if (!req.isAuthenticated()) {
        notFound404(req, res, next);
    } else {
        req.logout();
        res.redirect('/signin');
    }
};

// Exports
module.exports.signIn = signIn;
module.exports.signInPost = signInPost;
module.exports.signUp = signUp;
module.exports.signUpPost = signUpPost;
module.exports.signOut = signOut;