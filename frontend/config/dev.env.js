'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  BASE_API: '"http://127.0.0.1:8010"'
  // BASE_API: '"https://www.easy-mock.com/mock/5a901b3baad80a47eaa237e8"',
})
