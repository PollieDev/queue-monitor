const mix = require("laravel-mix");

mix
    .setPublicPath("public")
    .js("resources/js/app.js", "public/js")
    .vue({ version: 2 })
    .postCss("resources/css/app.css", "public/css");

if (mix.inProduction()) {
    mix.version();
} else {
    mix
        .copy(
            "public",
            "../example/public/vendor/queue_monitor"
        );
}