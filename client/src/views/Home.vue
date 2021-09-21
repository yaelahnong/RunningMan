<template>
  <div>
    <Header :title="title" />
    <Statistics :athlete="athlete" :stats="stats" :isLoading="isLoading" />
  </div>
</template>

<script>
// @ is an alias to /src
import Axios from 'axios'
import Header from '../components/Header.vue'
import Statistics from '../components/Statistics.vue'

export default {
  name: 'Home',
  components: {
    Statistics,
    Header
  },
  data () {
    return {
      title: ['Running', 'Man'],
      athlete: [],
      stats: [],
      isLoading: false
    }
  },
  async mounted () {
    await this.onGetAthlete()
    await this.onGetAthleteStats()
  },
  methods: {
    onGetAthlete () {
      this.isLoading = true
      Axios.get(`${process.env.VUE_APP_API_URL}/${localStorage.getItem('user_id')}/athlete?fu_token=${localStorage.getItem('token')}`)
        .then(res => {
          this.isLoading = false
          this.athlete.push(res.data)
        })
        .then(console.log(this.athlete))
    },
    onGetAthleteStats () {
      this.isLoading = true
      Axios.get(`${process.env.VUE_APP_API_URL}/${localStorage.getItem('user_id')}/athlete/stats?fu_token=${localStorage.getItem('token')}`)
        .then(res => {
          this.isLoading = false
          this.stats.push(res.data)
        })
        .then(console.log(this.stats))
    }
  }
}
</script>
