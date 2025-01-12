const mix = require('laravel-mix');

let styles = {
    main: {
        input: './assets/src/scss/app.scss',
        dest: 'css/'
    },
    submission: {
        input: './assets/src/scss/submission.scss',
        dest: 'css/'
    },
    admin: {
        input: './assets/src/scss/admin/app.scss',
        dest: 'css/admin/'
    },
    dark: {
        input: './assets/src/scss/dark.scss',
        dest: 'css/'
    },
    rtl: {
        input: './assets/src/scss/rtl.scss',
        dest: 'css/'
    }
};

let scripts = {
    main: {
        input: './assets/src/scripts/main.js',
        dest: 'js/'
    },
    admin: {
        input: './assets/src/scripts/admin/admin.js',
        dest: 'js/admin/'
    },
};

let input, output;

/*
 * styles
 *
 */
Object.keys( styles ).forEach(function( key ) {

    input = `${ styles[ key ].input }`;
    output = `${ styles[ key ].dest }${ key }.css`;

    mix
        .setPublicPath('./assets/dist')
        .options({ processCssUrls: false })
        .sass( input, output );

    // source
    if( process.env.npm_lifecycle_event == 'build' ) {
        mix.copy( `./assets/dist/${output}`, `./assets/dist/${ styles[ key ].dest }${ key }.source.css` );
    }

    if ( ! mix.config.production ) {

        /*mix
            .webpackConfig({ devtool: 'source-map' })
            .sourceMaps();*/

    }

});

/*
 * scripts
 *
 */
Object.keys( scripts ).forEach(function( key ) {

    input = `${ scripts[ key ].input }`;
    output = `${ scripts[ key ].dest }${ key }.js`;

    mix
        .setPublicPath('./assets/dist')
        .js( input, output );

    // source
    if( process.env.npm_lifecycle_event == 'build' ) {
        mix.copy( `./assets/dist/${output}`, `./assets/dist/${ scripts[ key ].dest }${ key }.source.js` );
    }

});
