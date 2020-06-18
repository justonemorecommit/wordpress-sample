import Vue from 'vue'
import LeverJobListing from './LeverJobListing.vue'

Vue.config.productionTip = false

new Vue({
  render: h => h(LeverJobListing),
}).$mount('#LeverJobListing')
