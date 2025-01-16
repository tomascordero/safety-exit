import postcssPresetEnv from 'postcss-preset-env';
import postcssMinify from 'postcss-minify';

export default {
  plugins: [
    postcssPresetEnv({
      stage: 0,
      browsers: 'cover 99.5%',
      autoprefixer: { grid: true }
    }),
    postcssMinify(),
  ]
}
