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
      Axios.post('http://localhost:8000/login', this.formLogin)
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
    }
  }
}
</script>

<style scoped>
  /*----------------------------------------*/
  /*  16. Login & Resister CSS
  /*----------------------------------------*/
  /*Login & Resister Wrapper*/
  .login-register-wrap {
    /* padding: 0 15px; */
    overflow-x: hidden;
  }

  /*Login & Resister BG*/
  .login-register-bg {
    /* background-image: url(../../assets/login-register-bg.jpg); */
    background-image: url(../../assets/bg.jpeg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    min-height: 100vh;
    height: 100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
        -ms-flex-pack: center;
            justify-content: center;
    -webkit-box-align: center;
    -webkit-align-items: center;
        -ms-flex-align: center;
            align-items: center;
  }

  .login-register-bg .content {
    display: none;
    max-width: 420px;
    padding: 100px 30px;
  }

  .login-register-bg .content h1 {
    font-weight: 300;
    line-height: 1;
    margin-bottom: 15px;
    color: #ffffff;
  }

  .login-register-bg .content p {
    margin-bottom: 0;
    color: #ffffff;
  }

  @media only screen and (min-width: 768px) and (max-width: 991px), only screen and (max-width: 767px) {
    .login-register-bg {
      min-height: auto;
    }
    .login-register-bg .content {
      display: block;
    }
  }

  @media only screen and (max-width: 767px) {
    .login-register-bg .content {
      padding-top: 50px;
      padding-bottom: 50px;
    }
    .login-register-bg .content h1 {
      font-size: 30px;
    }
  }

  /*Login & Resister Form Wrapper*/
  .login-register-form-wrap {
    max-width: 420px;
    padding: 50px 15px;
  }

  .login-register-form-wrap .content h1 {
    font-weight: 300;
    line-height: 1;
    margin-bottom: 15px;
  }

  .login-register-form-wrap .content p {
    margin-bottom: 30px;
  }

  @media only screen and (min-width: 768px) and (max-width: 991px), only screen and (max-width: 767px) {
    .login-register-form-wrap .content {
      display: none;
    }
  }

  @media only screen and (max-width: 767px) {
    .login-register-form-wrap .content h1 {
      font-size: 30px;
    }
  }

  /*Login & Resister Form*/
  .login-register-form {
    max-width: 370px;
  }

  .login-register-form a {
    color: #428bfa;
  }

  .login-register-form a:hover {
    text-decoration: underline;
  }
</style>
