import Axios from 'axios'

export default {
  name: 'Strava',
  mounted () {
    const url = window.location.search
    const params = new URLSearchParams(url)
    if (params.get('error') === 'access_denied') {
      this.$router.push('/')
    }

    Axios.post(`${process.env.VUE_APP_API_URL}/exchange_token`, {
      fu_id: localStorage.getItem('user_id'),
      auth_code: params.get('code')
    }).then(res => {
      console.log(res)
      localStorage.setItem('isConnected', true)
      this.$router.push('/')
    }).catch(err => {
      console.log(err)
    })
    // localStorage.setItem('authCode', params.get('code'))
    // this.$router.push('/')
  }
}
