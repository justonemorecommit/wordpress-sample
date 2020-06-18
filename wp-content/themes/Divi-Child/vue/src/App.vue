<template>
  <div id="app">
    <div class="job-container">
      <div v-for="job in jobList" class="job-row">
        <div class="job-description">
          <h3>{{job.text}}</h3>
          <p>{{job.additionalPlain.split("\n")[0]}}</p>
        </div>
        <a class="btn-job-application" :href="job.applyUrl">Apply now
        </a>
      </div>           
    </div>
  </div>
</template>

<script>
import axios from "axios"
export default {
  name: 'App',
  data () {
    return {
      jobList: [] 
    }

  },
  mounted () {
    this.getData()
  },
  methods: {
    getData() {
      axios.get('https://api.lever.co/v0/postings/laserhub-2?mode=json')
        .then( (response) => {
      // handle success
          this.jobList = response.data;
          console.log(response);
  })  
        .catch(function (error) {
      // handle error
          console.log(error);
  })
    }
  }
  }

</script>

<style lang="scss">

</style>
