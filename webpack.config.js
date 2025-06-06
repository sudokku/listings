const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');
const CopyPlugin = require('copy-webpack-plugin');

// Get all block.json files
const glob = require('glob');
const blockFiles = glob.sync('./blocks/*/block.json');

// Create entry points for each block
const entries = {};
blockFiles.forEach(blockFile => {
    const blockDir = path.dirname(blockFile);
    const blockName = path.basename(blockDir);
    entries[blockName] = path.resolve(blockDir, 'index.js');
});

module.exports = {
    ...defaultConfig,
    entry: entries,
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: '[name]/index.js',
    },
    optimization: {
        ...defaultConfig.optimization,
        splitChunks: {
            cacheGroups: {
                default: false,
                vendors: false,
                // Vendor chunk
                vendor: {
                    name: 'vendor',
                    chunks: 'all',
                    test: /[\\/]node_modules[\\/]/,
                    priority: 20,
                },
                // Common chunk
                common: {
                    name: 'common',
                    minChunks: 2,
                    chunks: 'all',
                    priority: 10,
                    reuseExistingChunk: true,
                    enforce: true,
                },
            },
        },
    },
    module: {
        ...defaultConfig.module,
        rules: [
            ...defaultConfig.module.rules,
            {
                test: /\.(png|jpe?g|gif|svg)$/i,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: 'images/',
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        ...defaultConfig.plugins,
        new CopyPlugin({
            patterns: blockFiles.map(blockFile => {
                const blockName = path.basename(path.dirname(blockFile));
                return {
                    from: blockFile,
                    to: `${blockName}/block.json`
                };
            })
        }),
    ],
}; 