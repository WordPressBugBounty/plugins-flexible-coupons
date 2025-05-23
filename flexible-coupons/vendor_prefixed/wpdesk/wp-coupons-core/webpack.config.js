const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
	mode: 'development', // Use 'production' for optimized builds
	entry: {
		index: './assets-src/js/index.tsx',
	},
	output: {
		path: path.resolve(__dirname, 'assets/js'),
		filename: '[name].js',
	},
	module: {
		rules: [
			{
				test: /\.tsx?$/,
				use: 'ts-loader',
				exclude: /node_modules/,
			},
			{
				test: /\.css$/,
				use: ['style-loader', 'css-loader'],
			},
			{
				test: /\.(png|svg|jpg|jpeg|gif)$/i,
				type: 'asset/resource',
			},
		],
	},
	resolve: {
		extensions: ['.tsx', '.ts', '.js'],
		modules: [path.resolve(__dirname, 'node_modules')],
	},
	plugins: [
		new HtmlWebpackPlugin({
			template: './assets-src/js/components/FileUploadTest.html', // Path to your HTML template
		}),
	],
	devServer: {
		static: path.join(__dirname, 'assets/js'),
		compress: true,
		port: 9000,
		open: true,
	},
	devtool: 'inline-source-map',
};
