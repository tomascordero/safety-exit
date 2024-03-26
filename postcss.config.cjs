const postcssPresetEnv = require('postcss-preset-env');
const postcssMinify = require('postcss-minify');
const autoprefixer = require('autoprefixer');


module.exports = {
  plugins: [
    postcssPresetEnv({
      stage: 0,
      browsers: 'cover 99.5%',
      autoprefixer: { grid: true }
    }),
    postcssMinify(),
  ]
}
