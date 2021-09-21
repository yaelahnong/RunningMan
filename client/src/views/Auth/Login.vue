<template>
  <div class="main-wrapper">

        <!-- Content Body Start -->
        <div class="content-body m-0 p-0">

            <div class="login-register-wrap">
                <div class="row">

                    <div class="d-flex align-self-center justify-content-center order-2 order-lg-1 col-lg-5 col-12">
                        <div class="login-register-form-wrap">

                            <div class="content">
                                <h1>Sign in</h1>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            </div>

                            <div class="login-register-form">
                                <form action="#">
                                    <div class="row">
                                        <div class="col-12 mb-3"><input v-model="formLogin.email" class="form-control" type="text" placeholder="User ID / Email"></div>
                                        <div class="col-12 mb-3"><input v-model="formLogin.password" class="form-control" type="password" placeholder="Password"></div>
                                        <div class="col-12 mb-3"><label for="remember" class="adomx-checkbox-2"><input id="remember" type="checkbox"><i class="icon"></i>Remember.</label></div>
                                        <div class="col-12">
                                            <div class="row justify-content-between">
                                                <div class="col-auto mb-3"><a href="#">Forgot Password?</a></div>
                                                <div class="col-auto mb-3">Dont have account? <a href="register.html">Create Now.</a></div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2"><button @click="onHandleLogin()" v-on:click.prevent class="btn btn-outline-primary">sign in</button></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="login-register-bg order-1 order-lg-2 col-lg-7 col-12">
                        <div class="content">
                            <h1>Sign in</h1>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>

                </div>
            </div>

        </div><!-- Content Body End -->

    </div>
</template>

<script>
import Axios from 'axios'

export default {
  name: 'Login',
  data () {
    return {
      formLogin: {
        email: '',
        password: ''
      },
      isLoading: false
    }
  },
  mounted () {
    // if (localStorage.getItem('isLoggedIn')) {
    //   this.$router.push('/')
    // }
  },
  methods: {
    onHandleLogin () {
      this.isLoading = true
      Axios.post(`${process.env.VUE_APP_API_URL}/login`, this.formLogin)
        .then(async (res) => {
          this.isLoading = false
          const data = res.data.user
          localStorage.setItem('user_id', data.fu_id)
          localStorage.setItem('name', data.fu_full_name)
          localStorage.setItem('email', data.fu_email_address)
          localStorage.setItem('token', res.data.token)
          localStorage.setItem('isLoggedIn', true)
          if (data.fu_fsa_id) {
            localStorage.setItem('isConnected', true)
          }
          alert('Login succeed')
          this.$router.go('/')
        })
        .catch(() => {
          alert('Oops. Something wrong!')
        })
    }
  }
}
</script>


