<template>
  <div id="LeverJobListing">
    <div class="job-container">
      <div v-for="job in jobList" class="job-row">
        <div class="job-description">
          <h3>{{job.text}}</h3>
          <p>{{job.additionalPlain.split("\n")[0]}}</p>
        </div>
        <a class="btn-job-application" :href="job.hostedUrl">See more
        </a>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from "axios"
  export default {
    name: 'LeverJobListing',
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
        })
        .catch(function (error) {
          // handle error
          console.error(error);
        })
      }
    }
  }

</script>

<style lang="scss" scoped>
.job-container {
  max-width: 600px;
  margin: 0 auto;
  h3 {
    font-family: TTHoves-DemiBold, sans-serif;
    font-size: 20px;
  }
  p {
    font-family: TTHoves-Regular, sans-serif;
    font-size: 16px;
  }
}
.job-row {
  background-color: #fff;
  display: flex;
  padding: 20px 30px;
  justify-content: space-between;
  align-items: center;
  margin: 25px 0;
}
.btn-job-application {
  color: #56DCAC;
  background-color: #fff;
  border: 3px solid #56DCAC;
  padding: 10px 15px;
  font-family: TTHoves-DemiBold, sans-serif;
  text-decoration: none;
  font-size: 16px;
  border-radius: 2px;
}
.btn-job-application:hover {
  background-color: #56DCAC;
  color: #000;
}
</style>
