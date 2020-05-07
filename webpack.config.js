const path = require("path");
const webpack = require("webpack");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const VuetifyLoaderPlugin = require("vuetify-loader/lib/plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const RemovePlugin = require("remove-files-webpack-plugin");

module.exports = {
  mode: "development",
  entry: {
    "admin/assets/js": "./admin/assets/vue/wp-admin-vue.js",
    "wp-public/assets/js": "./wp-public/assets/vue/wp-admin-vue.js",
    admin: "./admin/assets/scss/wp-admin-vue-admin.scss",
    "wp-public": "./wp-public/assets/scss/wp-admin-vue-public.scss",
  },
  resolve: {
    alias: {
      vue$: "vue/dist/vue.esm.js", // Use the full build
    },
  },
  output: {
    filename: "[name]/wp-admin-vue.build.js",
    path: path.resolve(__dirname),
  },
  plugins: [
    new FixStyleOnlyEntriesPlugin(),
    new MiniCssExtractPlugin({
      filename: "[name]/assets/css/wp-admin-vue.build.css",
    }),
    new VueLoaderPlugin(),
    new VuetifyLoaderPlugin(),
  ],
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: "vue-loader",
      },

      {
        test: /\.js$/,
        use: "babel-loader",
        exclude: /node_modules/,
      },
      {
        test: /\.s(c|a)ss$/,
        use: [
          "vue-style-loader",
          {
            loader: "postcss-loader",
            options: {
              sourceMap: true,
              config: {
                path: "postcss.config.js",
              },
            },
          },
          {
            loader: "sass-loader",
            // Requires sass-loader@^7.0.0
            options: {
              implementation: require("sass"),
              fiber: require("fibers"),
              indentedSyntax: true, // optional
            },
            // Requires sass-loader@^8.0.0
            options: {
              implementation: require("sass"),
              sassOptions: {
                fiber: require("fibers"),
                indentedSyntax: true, // optional
              },
            },
          },
        ],
      },
    ],
  },
};
