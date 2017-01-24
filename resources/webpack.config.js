module.exports = {
    // This is the "main" file which should include all other modules
    entry: {
        stock: './assets/js/portfolio/stock/index.js',
    },
    // Where should the compiled file go?
    output: {
        // To the `dist` folder
        path: '../public/assets/nsm/member/portfolio',
        // With the filename `build.js` so it's dist/build.js
        filename: '[name].js'
    },
    resolve: {
        extensions: ['', '.js', '.vue'],
        fallback: './node_modules',
    },
    module: {
        // Special compilation rules
        loaders: [
            {
                // Ask webpack to check: If this file ends with .js, then apply some transforms
                test: /\.js$/,
                // Transform it with babel
                loader: 'babel',
                // don't transform node_modules folder (which don't need to be compiled)
                exclude: /node_modules/
            },
            {
                test: /\.vue$/,
                loader: 'vue'
            }
        ]
    },
    vue: {
        loaders: {
            js: 'babel'
        }
    }
}