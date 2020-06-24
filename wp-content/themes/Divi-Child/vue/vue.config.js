// vue.config.js
module.exports = {
  filenameHashing: false,
  chainWebpack: function (config) {
    config.optimization.delete('splitChunks')
  }
}
