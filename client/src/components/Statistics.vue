<template>
  <div>
    <section class="jumbo">
      <div class="profile text-center">
        <div v-if="isLoading && isConnected" class="avatar skeleton rounded-circle"></div>
        <img v-if="!isLoading && isConnected" :src='athlete[0]?.profile' class="avatar rounded-circle" alt="">
        <img v-if="!isConnected" src="https://via.placeholder.com/160" class="avatar rounded-circle" alt="Profile">
        <h3 class="mt-3">{{ name }}</h3>
        <!-- <h3 class="mt-3">{{item.firstname}} {{ item.lastname }}</h3> -->
        <!-- <img src="https://dgalywyr863hv.cloudfront.net/pictures/athletes/87759690/20981543/1/large.jpg" class="rounded-circle" alt="Profile"> -->
        <!-- <h3 class="mt-3">Marino imola</h3> -->
        <button v-if="isConnected" @click="disconnect" class="btn btn-warning mt-2">Connected</button>
        <button v-else @click="connect" class="btn btn-warning mt-2">Connect to Strava</button>
      </div>
    </section>
    <section class="statistics">
      <div class="container-fluid">
        <div class="row pt-5">
          <div v-if="isConnected" class="col-2">
            <div v-if="stats[0]" class="card">
              <div class="card-body">
                <h3 class="fw-bold">{{ stats[0]?.all_run_totals?.distance / 1000 }}</h3>
                <p v-if="stats[0]">Distance</p>
              </div>
            </div>
            <div v-else class="card">
              <div class="card-body">
                <h3 class="skeleton"></h3>
                <p class="skeleton"></p>
              </div>
            </div>
          </div>
          <div v-if="isConnected" class="col-2">
            <div v-if="stats[0]" class="card">
              <div class="card-body">
                <h3 class="fw-bold">{{ stats[0]?.all_run_totals?.moving_time }}</h3>
                <p v-if="stats[0]">Moving Time</p>
              </div>
            </div>
            <div v-else class="card">
              <div class="card-body">
                <h3 class="skeleton"></h3>
                <p class="skeleton"></p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
</template>

<script>
import Axios from 'axios'
export default {

  name: 'HelloWorld',
  props: ['athlete', 'stats', 'isLoading'],
  data () {
    return {
      name: localStorage.getItem('name'),
      isConnected: localStorage.getItem('isConnected')
    }
  },
  methods: {
    connect () {
      window.location.href = `http://www.strava.com/oauth/authorize?client_id=67713&response_type=code&redirect_uri=${process.env.VUE_APP_BASE_URL}/exchange_token&approval_prompt=force&scope=read,activity:read,activity:write`
    },
    disconnect () {
      Axios.delete(`${process.env.VUE_APP_API_URL}/strava/${localStorage.getItem('user_id')}`)
        .then(res => {
          console.log(res)
          localStorage.removeItem('isConnected')
          this.isConnected = false
        })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .jumbo {
    background: url('../assets/bg.jpeg') no-repeat;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
  }

  .profile {
    h3 {
      color: #fff;
      text-shadow: 1px 1px 12px rgba(0,0,0,0.8);
    }
    img.avatar {
      width: 10rem;
    }
  }

  .skeleton {
    min-width: 100%;
    background-color: #eee;
  }

  h3.skeleton {
    height: 33px;
  }

  p.skeleton {
    height: 24px;
  }

  .avatar.skeleton {
    width: 160px;
    height: 160px;
    background-color: #eee;
  }
</style>
