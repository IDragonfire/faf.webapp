var webpack = require('webpack');
var path = require('path');

var BUILD_DIR = path.resolve(__dirname, 'www');
var APP_DIR = path.resolve(__dirname, 'src');

const babelLoader = {
  test: /\.jsx?$/,
  loader: 'babel-loader',
  exclude: /node_modules/,
  query: {
    presets: ['es2015', 'react']
  }
};

const sassLoader = {
  test: /\.scss$/,
  loaders: ['style', 'css', 'sass']
};

var config = {
  entry: APP_DIR + '/app.jsx',
  output: {
    path: BUILD_DIR,
    filename: 'bundle.js'
  },
  module: {
    loaders: [babelLoader, sassLoader]
  }
};

module.exports = config;
